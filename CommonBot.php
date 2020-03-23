<?php
//require_once $path1."/config.php"; //в нем определаена path1
class CommonBot extends Common
{
    
      public $id_bot;
      public $id_run;
      public $id_plan;
      public $id_cron;
      public $config;  // загруженные из БД параметры задания
      public $ip_real;
      public $ip_bot;
      public $results;
      
      public $apikey;
//    public $status=0;  //0-новая запись, 1-парсинг прошел удачно, 2- ошибка, 3- в процессе
//    public $stage=0;   //0-нет, 1-парсинг html страницы, 2-обработка HTML   
//    public $db_obj;
//    public $db;
//    public $params;   
//    public $pid;
//    public $id_thread;
//    public $id_client;
//    public $id_parser;
//    public $id_func;
//    public $id_se;
//    public $proxy;
//    public $useragent;

      public $fake=[];
//    

    public function writelog($msg, $status=0, $pr_echo=1)
    {    
        if ($this->log_table!=false)
        {
            $sql="INSERT INTO `{$this->log_table}` (`id_bot`,`id_run`, `id_job`, `nam`, `dat`, `status`) VALUES ('{$this->id_bot}','{$this->id_run}','{$this->config['id']}', '$msg', NOW(), '$status')";
            //echo $sql;
            $this->db->query($sql);
        }                  
        
        if ($pr_echo==1)             
        {
            echo date('d.m.Y H:i:s').' '.$msg.'<br>'."\r\n";
        }
    }
    
    public function __construct($params=array("id_client"=>1))
    {
        
        
        $this->apikey['simsms']='fuIqftmRjmmEFmvAafz5rUxdB4gE5F';
        //$this->db_obj=new Db();        
        $this->log_table='bots_logs';
        $this->id_bot=(int)$params['id_bot'];
        $this->id_job=(int)$params['id_job'];
        $this->id_plan=(int)$params['id_plan'];
        $this->id_cron=(int)$params['id_cron'];

        
        if ($this->id_bot==false) {echo "Не указан id бота."; return false;}
        
        $this->db=$params['db'];  //$this->db_obj->db;
        if ($this->db==false) {echo "БД не инициализирована"; return false;}
        $this->params=$params;
        $this->pid=$params['pid'];
        /*
        
        $sql="INSERT INTO `bots_runs` (`id_bot`, `id_job`, `dat_start`, `status1`) ".
             "VALUES ('{$this->id_bot}', '{$this->id_job}',  NOW(), '3')";
        $this->db->query($sql);
        $this->id_run=$this->db->lastInsertId();

        $sql="UPDATE cron_jobs SET id_run=".$this->id_run." WHERE id=".$this->id_cron;
        //echo $sql;
        $this->db->query($sql);

*/


        //exit;
//        $sql="SELECT max(id) as mx FROM bots_runs";
//        $row=$this->db->query($sql, PDO:: FETCH_ASSOC)->fetch();
//        $this->id_run=1+$row['mx'];
        
        
        
//        $this->id_thread=$params['id_thread'];
//        $this->id_client=$params['id_client'];
//        $this->id_parser=$params['id_parser'];
//        $this->id_func=$params['id_func'];        
        
        if (empty($this->pid)) {$this->pid=getmypid();}
        
        $this->init();      
    }
    
    
    
    public function ___init()
    {
        $id_client=$this->params['id_client'];
        $this->proxy=false;
        $this->useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0";
        /*
        if ($id_client>0)
        {
        $sql="SELECT * FROM proxy_clients WHERE id_client=$id_client and status1=1 ORDER BY RAND() LIMIT 1";
        //echo $sql;
        $rows      =  $this->db->query($sql,PDO::FETCH_ASSOC)->fetchAll();
        $proxy=$rows[0];               
        $this->proxy=$proxy;
        
        $sql="UPDATE proxy_clients SET dat_last=NOW(),cnt=cnt+1 WHERE id=".$proxy['id'];
        $this->db->query($sql);
        
        $sql="SELECT * FROM useragents_clients WHERE id_client=$id_client ORDER BY RAND() LIMIT 1";
        $rows      =  $this->db->query($sql,PDO::FETCH_ASSOC)->fetchAll();
        $useragent=$rows[0];
        
        
        
        $this->useragent=$useragent;        
        //$this->useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0";
        
        }

        */
        
        /**
        * modes
        * 
        * 0 = file_getcontents без прокси
        * 1 = curl_get         без прокси или через прокси, поддерживает прокси с авторизацией
        * 2 = curl_post        без прокси или через прокси, поддерживает прокси с авторизацией
        * 3 - Human Emulator   без проси или через прокси, не поддерживает прокси с авторизацией
        * 
        */
        $this->params['mode']=1;
        //$this->params['id_client']=$params['id_client'];
        $this->params['proxy']=$this->proxy;  // nam, host, port, login, pass, tip_auth
        $this->params['useragent']=$useragent;
    }
    
    public function get_proxy()
    {
        //$sql="SELECT * FROM proxy_clients WHERE id_client=$id_client and status1=1 ORDER BY RAND() LIMIT 1";
        $sql="SELECT min(cnt) as m FROM proxy WHERE status1=1";
        $r=$this->db->query($sql,PDO::FETCH_ASSOC)->fetch();
        $min_cnt=0+$r['m'];
        
        
        $sql="SELECT * FROM proxy WHERE status1=1 and cnt=$min_cnt ORDER BY RAND() LIMIT 1";
        // echo $sql;
        $this->proxy =  $this->db->query($sql,PDO::FETCH_ASSOC)->fetch();
        if ($this->proxy['tip_auth']==1) 
        {
            $this->proxy['tip_auth_str']='c авторизацией по логину и паролю';
        } 
        else 
        {
            $this->proxy['tip_auth_str']='без авторизации';
        }
        $this->params['proxy']=$this->proxy;
        
        $sql="UPDATE proxy SET dat_last=NOW(),cnt=cnt+1 WHERE id=".$this->proxy['id'];
        $this->db->query($sql);
        
        $this->writelog('Выбранная прокси <b>'.$this->proxy['nam'].', '.$this->proxy['tip_auth_str'].'</b>');
        
        //print_r($this->proxy);
    }
    
    public function get_useragent()
    {
        //$sql="SELECT * FROM proxy_clients WHERE id_client=$id_client and status1=1 ORDER BY RAND() LIMIT 1";
        $sql="SELECT min(cnt) as m FROM useragents WHERE 1=1";
        $r=$this->db->query($sql,PDO::FETCH_ASSOC)->fetch();
        $min_cnt=$r['m'];
        
        $sql="SELECT * FROM useragents WHERE cnt=$min_cnt ORDER BY RAND() LIMIT 1";
        //echo $sql;
        $r=  $this->db->query($sql,PDO::FETCH_ASSOC)->fetch();
        $this->useragent = $r['nam'];
        
        
        $this->params['useragent']=$this->useragent;
        
        $sql="UPDATE useragents SET dat_last=NOW(),cnt=cnt+1 WHERE id=".$r['id'];
        $this->db->query($sql);
        
        //$this->writelog('Выбранная прокси <b>'.$this->proxy['nam'].', '.$this->proxy['tip_auth_str'].'</b>');
        
        //print_r($this->proxy);
    }
    
    public function init()
    {
        
        if ($this->params['from_cron']==1) {$this->writelog("Запуск из cron");}
        $this->writelog('Бот с id='.$this->id_bot.' готовиться к запуску.');
        
        
        if ($this->id_job==0)
        {
            $this->writelog("Получаю активные задания");
            $sql="SELECT * FROM bots_jobs WHERE id_bot={$this->id_bot} and active1=1";
            $r=$this->db->query($sql,PDO::FETCH_ASSOC)->fetch();           
        }
        elseif ($this->id_job>0)
        {
            $this->writelog("Ищу задание с  id={$this->id_job}");
            $sql="SELECT * FROM bots_jobs WHERE id_bot={$this->id_bot} and id={$this->id_job}";
            echo $sql;
            $r=$this->db->query($sql,PDO::FETCH_ASSOC)->fetch();
            //print_r($r) ;
        }
        
        if (($r==false) && ($this->id_job>0)) 
        {
            $this->is_run=2;
            $this->writelog("Нет активных заданий");return false;
        }
        else
        {
            
            
            
            $this->is_run=1;

            $sql="UPDATE cron_jobs SET status1=3 WHERE id=".$this->id_cron;
            //echo $sql;
            $this->db->query($sql);
        }
        
        //print_r($r['params']);
        //echo "====================\r\n";
        $params=json_decode($r['params'], true);
        //print_r($params);
        //exit;
        //eval($r['params']);        
        $this->config=$params;
        $this->config['id']=$r['id'];
        $this->config['cnt']=$r['cnt'];
        
        $this->writelog("Получено задание <b>{$r['id']}</b>");
        
        $this->ip_real=$_SERVER['REMOTE_ADDR'];
        $this->writelog('Реальный IP <b>'.$this->ip_real.'</b>');
        

        //print_r($params);

        $this->config['useragent_mode']=0;
        if ($this->config['useragent_mode']==0) 
        {
        $this->useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0";
        $this->writelog('Установлен режим useragent <b>по умолчанию</b>');                        
        }
        
        if ($this->config['useragent_mode']==1) 
        {
            $this->writelog('Установлен режим useragent <b>случайный выбор из базы</b>'); 
            $this->get_useragent();
        }

        if ($this->config['proxy_mode']==0)
        {
            $this->writelog('Установлен режим <b>без прокси</b>');
            $this->proxy=false;
        }
        if ($this->config['proxy_mode']==1)
        {
            $this->writelog('Установлен режим <b>с прокси</b> случайный выбор из базы');
            $this->get_proxy();
            $r=$this->get_page(array('url'=>'http://koto.ourcrm.ru/check_ip.php'));
            $this->ip_bot=trim($r['page']);
            $this->writelog('IP бота <b>'.$this->ip_bot.'</b>');
            if (trim($this->ip_bot)=='')
            {
                $this->writelog('Плохая прокси.');
                $this->writelog('Завершено с ошибкой');
                $this->is_run=2;
                return false;
            }
        }
        
        $this->writelog('Установлен useragent <b>'.$this->useragent.'</b>');                
    }
           
    /**
    * put your comment there...
    * 
    * @param mixed $params
    * 
    * url
    * xhe   = '62.152.58.87:7010'
    * proxy[nam] = "37.203.246.8:45681"    
    * proxy[host] - не поддерживаются
    * proxy[port] - не поддерживаются
    * proxy[login] - не поддерживаются
    * proxy[pass] - не поддерживаются
    * 
    */
    public function get_src_by_xhe($params)
    {
        global $path1, $browser, $webpage;  
        
        //print_r($params);exit;
        $xhe_host=$params['xhe']; //'62.152.58.87:7010'
        require_once $path1."/core/parser/Templates/xweb_human_emulator.php";        
        
        $this->xhe['browser']=$browser;
        $this->xhe['webpage']=$webpage;
        
        $url=$params['url'];
        //$params['proxy'] = "37.203.246.8:45681";
        
        //echo "1. Получим текущий IP : ";
        $connection->get_real_ip(); //."<br>";
        if ($params['proxy']['val']!='')
        {
            $browser->enable_proxy("all connections",$params['proxy']); //."<br>";
        }
        //echo "3. Получим заново текущий IP : ";
        $connection->get_real_ip(); //."<br>";
        //$time_start = microtime_float();   

        $browser->navigate($url);
        $html=$webpage->get_body();
        
        //
        //$time_end = microtime_float();
        //$time = $time_end - $time_start;

        //echo "time=$time \n"; 
        // конец
        //echo "<hr><br>";

        // navigate to google

        return $html;
        // Quit
        //$app->quit();
        //echo $html;
        
    }
               
    public function curl_get($params)
    {
        echo "curl_get UA: ".$this->useragent;
        $header = array(
            'User-Agent: ' . $this->useragent,
            'Accept: text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/webp, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
            'Accept-Language: ru-RU,ru;q=0.9,en;q=0.8',
            //'Accept-Encoding: gzip, deflate',
            'Connection: Keep-Alive'
        );
        
        $ch = curl_init($params['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        
        if ($this->proxy!=false)
        {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy['nam']);        
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy['login'] . ":" . $this->proxy['pass']);   
        }
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 200); //timeout in seconds
        
        $result     = curl_exec($ch);
        $this->html = $result;
        curl_close($ch);
        
        //echo $result;exit;
        
        return $result;
    }
    
    public function curl_post($params, $post_arr)
    {
        echo "curl_post";

        $header = array(
            'User-Agent: '.$this->useragent['nam'],
            'Accept: text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/webp, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
            'Accept-Language: ru-RU,ru;q=0.9,en;q=0.8',
            //'Accept-Encoding: gzip, deflate',
            'Connection: Keep-Alive',
        );

        $ch = curl_init($params['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
        
        if ($this->proxy!=false)
        {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy['nam']);        
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy['login'] . ":" . $this->proxy['pass']);   
        }
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
        curl_setopt($ch, CURLOPT_TIMEOUT,500);

        $result = curl_exec($ch);
        $this->html = $result;
        curl_close($ch);

        return $result;
    }
    
    public function command($id_thread=0)
    {
        
    }
    
    /**
    * получает html одной страницы по УРЛ
    * 
    * @param mixed $url
    * @param mixed $id
    */
    public function get_page($params) //$url, $id=0)
    {            
        try 
        {              
            $url=$params['url'];
            
            $page = $this->curl_get($params);
            if ($page!='')
            {
            
            }
            //Если ничего не спарсилось
            if ($page == "")
            {
                //$this->db_obj->update("words", "SET queue = $word_queue WHERE id = $word_id");
                $res['status'] = 2;
                $res['msg']    = "Страница не получена";
                $res['page'] = false;                                
                //return json_encode($error['msg']);
            }
            else
            {
                $res['status'] = 1;
                $res['msg']    = "Страница <b>$url</b> получена успешно";    
                $res['page']    = $page;                
            }                           
            
            $this->writelog($res['msg'],$res['status'],1);
        }
        catch (Exception $e)              
        {
            $res['status'] = 2;
            $res['msg']    = "Неизвестная ошибка";
            $this->writelog($res['msg'],$res['status'],1);
        }
        
        return $res;
    }
    
    
    
    
    public function get_sms_number($service='opt4', $operator='MTS_RU')
    {
        $method='get_balance';
        $url="http://simsms.org/priemnik.php?metod=$method&service=$service&apikey={$this->apikey['simsms']}&operator=$operator";
        $json=file_get_contents($url);
        $p=json_decode($json);
        $bal=$p->balance;
        
        $method='get_number';
        $url="http://simsms.org/priemnik.php?metod=$method&country=ru&service=$service&apikey={$this->apikey['simsms']}";
        $json=file_get_contents($url);
        $p=json_decode($json);
        $number=$p->number; 
        $resp_id=$p->id; 
        
        return $p;                
    }
    
    public function get_sms_text($resp_id, $service='opt4')
    {
        $method='get_sms';
        $url="http://simsms.org/priemnik.php?metod=$method&id=$resp_id&country=ru&service=$service&apikey={$this->apikey['simsms']}";
        
        $json=file_get_contents($url);
        $p=json_decode($json);
        
        return $p;
    }
    
    public function start()
    {
        $this->writelog('Бот с id='.$this->id_bot.' запущен. ID запуска = '.$this->id_run);
    }
    
    public function execute()
    {
         $r=$this->get_page($this->params);
         $nam=$this->params['url'];
         $this->results[$nam]['data']=$r['page'];
         $this->results[$nam]['status']=$r['status'];
         
         $sql="INSERT INTO `bots_results` (`id_bot`, `id_job`, `id_run`, `nam`, `descr`, `val`, `dat`, `status1`) ".
         "VALUES ('{$this->id_bot}', '{$this->id_job}', '{$this->id_run}', '$nam', '', '{$this->results[$nam]['data']}', NOW(), '{$this->results[$nam]['status']}')";
         //echo $sql;
         $this->db->query($sql);
         return $r;
    }
    
    public function finish($r)
    {
        
        $sql="UPDATE `bots_runs` SET `status1`='{$r['status']}',dat_end=NOW() WHERE id=".$this->id_run;                       
        $this->db->query($sql);
        
        if ($r['status']==1)
        {
            $this->writelog('Завершено успешно', $r['status'],0);
            
            $sql="UPDATE bots_jobs SET cnt=cnt+1 WHERE id={$this->config['id']}";
            $this->db->query($sql);
            $this->config['cnt']++;

            $sql="UPDATE cron_jobs SET status1=1 WHERE id=".$this->id_cron;
            //echo $sql;
            $this->db->query($sql);

            $sql="UPDATE botoplan SET cnt_ok=cnt_ok+1 WHERE id=".$this->id_plan;
            $this->db->query($sql);

            $sql="UPDATE botoplan SET percent=ROUND(100*cnt_ok/cnt_need) WHERE id=".$this->id_plan;
            $this->db->query($sql);
        }
        elseif ($r['status']==2)
        {
            $this->writelog('Завершено с ошибкой', $r['status'],0);


            $sql="UPDATE cron_jobs SET status1=2 WHERE id=".$this->id_cron;
            //echo $sql;
            $this->db->query($sql);
//            $sql="UPDATE botoplan SET cnt_ok=cnt_ok+1 WHERE id=".$this->id_plan;
//            $this->db->query($sql);
//
//            $sql="UPDATE botoplan SET percent=ROUND(100*cnt_ok/cnt_need) WHERE id=".$this->id_plan;
//            $this->db->query($sql);

        }
        else
        {
            $this->writelog(' Завершено со статусом '.$r['status'], $r['status'], 0);
            $sql="UPDATE bots_jobs SET cnt=cnt+1 WHERE id={$this->config['id']}";
            $this->db->query($sql);
            $this->config['cnt']++; 
        }
        
        if (($this->config['count_run']>0) && ($this->config['cnt']>=$this->config['count_run']))
        {
            $sql="UPDATE bots_jobs SET active1=2 WHERE id={$this->config['id']}";
            $this->db->query($sql);    
        }
        
        return $r;
    }
    
    
    public function run()
    {
        if ($this->is_run==1)
        {
        $this->start();
        $r=$this->execute();
        $r2=$this->finish($r);
        }
        else
        {
            $r2['status']=2;
        }
        return $r2;
    }
    
}

?>