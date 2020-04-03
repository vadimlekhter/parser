<?php

use Facebook\Proxy;
use Facebook\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\JavaScriptExecutor;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\LocalFileDetector;
//require_once $path1."/config.php"; //в нем определаена path1
class SeleniumBot extends CommonBot
{
    //public $db;
    public $host;
    public $cap;
    public $driver;
    public $ip;
    public $cookies;
    public $nom_screen;
    public $nom_part;
    public $data;
    public $simsms_apikey;
    public $fld;
    
    
    public function init()
    {
        // parent::init();

        $fld=date('Y-m-d-H-i-s');
        $this->fld=$fld;
        mkdir('files/'.$fld,  0777, true);

//        $LT_USERNAME = "origamiv";
//
//        # accessKey:  AccessKey can be generated from automation dashboard or profile section
//        $LT_APPKEY = "srdAxh1UwHK8E3YPFQA7iNaJ4D82ZQcB6fjmvChnNy0ZP142P9";
//
//        $LT_BROWSER = "chrome";
//        $LT_BROWSER_VERSION ="63.0";
//        $LT_PLATFORM = "windows 10";

        # URL: https://{username}:{accessToken}@hub.lambdatest.com/wd/hub
//        $url = "https://". $LT_USERNAME .":" . $LT_APPKEY ."@hub.lambdatest.com/wd/hub";

        $this->simsms_apikey='fuIqftmRjmmEFmvAafz5rUxdB4gE5F';
        $this->nom_screen=1;
        $this->host = 'http://172.16.10.46:4444/wd/hub';
        //$this->host = $url;

        // phpinfo();
        
        //print_r($this->proxy);
        // Если мы управляем Firefox, то инициализируем web драйвер (5000 - время ожидания ответа от Selenium) и запускаем Firefox
        //$driver = RemoteWebDriver::create($host, DesiredCapabilities::firefox(), 5000);


        //$this->proxy=false;

        if ($this->proxy!=false)
        {
            $this->cap = [
                WebDriverCapabilityType::BROWSER_NAME => 'chrome',
                WebDriverCapabilityType::PLATFORM => 'ANY',
//                WebDriverCapabilityType::ENABLE_VIDEO => TRUE,
//                WebDriverCapabilityType::ENABLE_VNC => TRUE,


                WebDriverCapabilityType::PROXY => [
                    'proxyType' => 'manual',
                    'httpProxy' => $this->proxy['nam'],
                    'sslProxy' => $this->proxy['nam']
                    ],
            ];
        }
        else
        {
            $this->cap = [
                WebDriverCapabilityType::BROWSER_NAME => 'chrome',  //chrome
                WebDriverCapabilityType::PLATFORM => 'ANY',
            //    WebDriverCapabilityType::ENABLE_VIDEO => TRUE,


        //        WebDriverCapabilityType::PROXY => [
        //            'proxyType' => 'manual',
        //            'httpProxy' => '37.203.243.217:43662',
        //            'sslProxy' => '37.203.243.217:43662'
        //        ],
            ];
        }



        //$cap=DesiredCapabilities::chrome();


        //print_r($cap);
              /*
        $options=['proxyType' => 'manual',
                'httpProxy' => '91.218.246.82:43661',
                'sslProxy' => '91.218.246.82:43661'];

        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
                              */


        //$driver = ChromeDriver::start($caps);
        //$driver->get('https://old-linux.com/ip/');
             
//        $this->driver = RemoteWebDriver::create($this->host, $this->cap, 12000);

        $this->driver = RemoteWebDriver::create("http://172.16.10.46:4444/wd/hub",
                                              array("version"=>"79.0", "browserName"=>"chrome", "enableVNC"=> true)
        );
        //$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        
        //$this->prepare();
    }
    
    
    
    public function getip()
    {
        
//        $z=5;
//        $x=0;
//        $d=$z/$x; 

       $this->driver->get('https://whoer.net/ru');
       $this->screenshot('ip');
       
       //$this->driver->get('http://koto.ourcrm.ru/check_ip.php');
       //$this->screenshot('ip_koto');
       $this->ip=$this->driver->getPageSource();               
    }
    
    public function screenshot($prefix='screen')
    {
       $this->nom_screen++;
       $fmt=sprintf("%'.03d", $this->nom_screen);
       $fn="files/".$this->fld."/r".$fmt."_e".$this->nom_part."_".$prefix."_".date('Y_m_d_H_i_s').'.jpg';
       //$fn="files/".$prefix."_".date('Y_m_d_H_i_s').'.jpg';
       $this->driver->takeScreenshot($fn); 
       return "<img src='$fn' />";
    }
    
    public function prepare($method)
    {
        
       if ($method=='yandex_reg')
        {
         $sql="select * from fake_users where id not in
(
select distinct id_fakeuser from fake_pass where id_service=103
)
and std_login is not null
ORDER BY RAND()
LIMIT 1";
       $rows=$this->db->query($sql, PDO::FETCH_ASSOC)->fetchAll();

       print_r($rows);
       $row=$rows[0];
       

       $params['firstname']=$row['firstname'];
       $params['lastname']=$row['lastname'];
       $params['login']=$row['std_login'];
       $params['password']=$row['std_pass'];  
       
       return $params;
       } 
       
       if ($method=='yandex_auth')
       {
         $sql="select a.id, a.id_fakeuser,a.username as login,a.pass as 'password', b.firstname,b.lastname 
from fake_pass a 
LEFT JOIN fake_users b on b.id=a.id_fakeuser
where a.id_service=103 and a.status1=1
ORDER BY a.cnt_used ASC
LIMIT 1";
//echo $sql;
       $rows=$this->db->query($sql, PDO::FETCH_ASSOC)->fetchAll();
       
       $row=$rows[0];
       
       //print_r($row);
       $params['id_row']=$row['id'];
       $params['firstname']=$row['firstname'];
       $params['lastname']=$row['lastname'];
       $params['login']=$row['login'];
       $params['password']=$row['password'];  

       $this->fake['id_pass']=$row['id'];
       //print_r($params);
       
       return $params;
       }
       
       return false;



    }
    
    public function run_method($method='getip', $params='', $prefix_screen='')
    {
        $this->nom_part++;
        try
        {
            // echo "$method";            print_r($params); exit;
            if ($params['data']=='fake')
            {
                $p2=$this->prepare($method);
                print_r($p2);
                //exit;
                $params =array_merge($params, $p2);
                
                //print_r($params);
                //exit;
            }
           // echo "PARAMS";
            print_r($params);

           // exit;

            if ($params=='')
            {
                 $result1=$this->$method();
            }
            else
            {
                 $result1=$this->$method($params);
            }   
            sleep(1);
            $this->screenshot($method, $prefix_screen); 
            echo "$method OK.";
            $nam='step'.$this->nom_part.'_'.$method;
            
            if ($result1['status']=='') {$result1['status']=2;}
            if ($result1['data']=='')
            {
                $result1['data']=json_encode($params, JSON_PRETTY_PRINT && JSON_UNESCAPED_UNICODE);
            }
            
            $sql="INSERT INTO `bots_results` (`id_bot`, `id_job`, `id_run`, `nam`, `descr`, `val`, `dat`, `status1`) ".
             "VALUES ('{$this->id_bot}', '{$this->id_job}', '{$this->id_run}', '$nam', '{$result1['descr']}', '{$result1['data']}', NOW(), '{$result1['status']}')";
             //echo $sql;
             $this->db->query($sql);

             if ($params['data']=='fake')
             {
                 $sql="UPDATE fake_pass SET is_used=1,cnt_used=cnt_used+1,dat_last=NOW() WHERE id=".$this->fake['id_pass'];
                 $this->db->query($sql);
             }
             if (($params['data']=='fake') && ($result1['status']==2))
             {
                 $sql="UPDATE fake_pass SET status1=2,dat_last=NOW() WHERE id=".$this->fake['id_pass'];
                 $this->db->query($sql);
             }
             
        }
        catch(Exception $e)
        {
            
             $nam='step'.$this->nom_part.'_'.$method;
            
            $result1['status']=2;
            if ($result1['data']=='')
            {
                $result1['data']=json_encode($params, JSON_PRETTY_PRINT && JSON_UNESCAPED_UNICODE);
            }
            
            $sql="INSERT INTO `bots_results` (`id_bot`, `id_job`, `id_run`, `nam`, `descr`, `val`, `dat`, `status1`) ".
             "VALUES ('{$this->id_bot}', '{$this->id_job}', '{$this->id_run}', '$nam', '{$result1['descr']}', '{$result1['data']}', NOW(), '{$result1['status']}')";
             //echo $sql;
             $this->db->query($sql);
             
             echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
        
        return $result1;       
    }
    
    public function execute()
    {
        
        // print_r($this->config);// exit;
               
         //exec('rm -rf files/*.*');

         $fld=$this->fld;

         $options=$this->config;
         unset($options['url']);

         //print_r($options); exit;
        
        // $this->getip();
        // $this->screenshot();
         $st=1;
         foreach($this->config['steps'] as $step)
         {
             $method=$step['task'];
             unset($step['task']);
             
             $r1=$this->run_method($method, $step);
             print_r($r1);
             $st=$st*$r1['status'];
             
             if ($r1['status']==2) {break;}
             //
         } 
         
         if($st==1) {$r['status']=1;} else {$r['status']=2;}
        /*
         foreach($this->config['url'] as $url)        
         {
             $options['url']=$url;
             $r=$this->get_page($options);
             $nam=$url;
             $this->results[$nam]['data']=addslashes($r['page']);
             $this->results[$nam]['status']=$r['status'];
             
             $sql="INSERT INTO `bots_results` (`id_bot`, `id_job`, `id_run`, `nam`, `descr`, `val`, `dat`, `status1`) ".
             "VALUES ('{$this->id_bot}', '{$this->id_job}', '{$this->id_run}', '$nam', 'Получен HTML страницы', '{$this->results[$nam]['data']}', NOW(), '{$this->results[$nam]['status']}')";
             //echo $sql;
             $this->db->query($sql);         
         }
          /**/
          
          
         //$r['status']=1;
         return $r;
         
    }
    
    public function simsms_getphone($params='')
    {
    
        $apikey=$this->simsms_apikey;  //$params['apikey'];
        $url="http://simsms.org/priemnik.php?metod=get_balance&service=opt4&apikey=$apikey&operator=MTS_RU";
        $json=file_get_contents($url);
        $r=json_decode($json);
        //print_r($r);
        $balance=$r->balance;
        
        $url="http://simsms.org/priemnik.php?metod=get_number&country=RU&service=opt23&apikey=$apikey";
        $json=file_get_contents($url);
        $r=json_decode($json);
        //print_r($r);
        $number=$r->number;
        $id_req=$r->id;
        //$number=$r->number;
        //$id=$r->id;

        $my['balance']=$balance;
        $my['id_req']=$id_req;
        $my['number']=$number;
        
        return $my;
    }
    
    public function simsms_getsms($params='')
    {
    
        $apikey=$this->simsms_apikey; //$params['apikey'];
//        $url="http://simsms.org/priemnik.php?metod=get_balance&service=opt4&apikey=$apikey&operator=MTS_RU";
//        $json=file_get_contents($url);
//        $r=json_decode($json);
//        //print_r($r);
//        $balance=$r->balance;
        
        $id_req=$params['id_req'];
        //$id_req='17572301';
        $url="http://simsms.org/priemnik.php?metod=get_sms&country=RU&service=opt23&apikey=$apikey&id=".$id_req;
        $json=file_get_contents($url);
        $r=json_decode($json);
        print_r($r);
        
        return $r;        
    }
    
    
    public function yandex_reg($params='')
    {
        
    $result1['descr']='Регистрация на Яндексе';    
    $result1['data']=json_encode($params, JSON_PRETTY_PRINT && JSON_UNESCAPED_UNICODE);    
    $reg_with_phone=0;   
    if ($reg_with_phone==1)
    {    
    $r=$this->simsms_getphone(array('apikey'=>$this->simsms_apikey));
    print_r($r);
    $params['phone']='+7'.$r['number'];
    $params['simsms_id_req']=$r['id_req'];
    }
        
    $this->driver->get('https://passport.yandex.ru/registration/');
    $this->driver->wait(5,300);
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=firstname]'));
    //$element->click();
    $element->sendKeys($params['firstname']);
    $this->driver->wait(5,300); 
     
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=lastname]'));
    //$element->click();
    $element->sendKeys($params['lastname']);     
      
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=login]'));
    //$element->click();
    $element->sendKeys($params['login']);
     
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=password]'));
    //$element->click();
    $element->sendKeys($params['password']); 
        
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=password_confirm]'));
    //$element->click();
    $element->sendKeys($params['password']);  
    
    if ($reg_with_phone==1)
    {
        
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=phone]'));
    //$element->click();
    $element->sendKeys($params['phone']);    

    
    $this->driver->wait(5,300);
    $element=$this->driver->findElement(WebDriverBy::cssSelector('button.button2'));
    $element->click();
    $this->driver->wait(5,300);
    
        sleep(3);
        $k=0;
        $smsok=0;
        while(($r->response!=1) && ($k<5))
        {
            $r=$this->simsms_getsms(array('id_req'=>$params['simsms_id_req']));
            if ($r->response==1)
            {
            $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=phoneCode]'));
            //$element->click();
            $element->sendKeys($r->sms);
            $this->driver->wait(5,300);
            $this->screenshot('yareg1');
            $smsok=1;
            break; 
            }
            else
            {
                $k++;
                echo "sleep $k<br>";
                sleep(30);
                
            }
        }
        
        if ($smsok==1)
        {
        $this->driver->wait(5,300);
        $this->screenshot('yareg2');
        
        /*
    $js="var scriptElt = document.createElement('script');
    scriptElt.type = 'text/javascript';
    scriptElt.src = 'https://yastatic.net/jquery/3.3.1/jquery.min.js';
    document.getElementsByTagName('head')[0].appendChild(scriptElt);";
             $this->driver->executeScript($js);                   
             */
             
             $this->driver->executeScript('$("button.button2").click();');    
        
        
    //    $element=$this->driver->findElement(WebDriverBy::cssSelector('.phone__code-btn>button'));
    //    $element->click();
        $this->driver->wait(30,300);    
        $this->screenshot('yareg3');
        }
    }
    else
    {
        // link_has-no-phone
        $element=$this->driver->findElement(WebDriverBy::cssSelector('.link_has-no-phone'));
        $element->click();
        $this->driver->wait(5,300)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('img.captcha__image'))
        );
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=hint_answer]'));
        //$element->click();
        $element->sendKeys($params['answer']);         
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('img.captcha__image'));
        $src=$element->getAttribute('src');
        
        $file=file_get_contents($src);
        file_put_contents('files/'.$this->fld.'/captcha.gif',$file);
        echo $src;                
        
        //$this->recognize('files/captcha.gif');
        $text=$this->yandex_captcha('files/'.$this->fld.'/captcha.gif');
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=captcha]'));
        //$element->click();
        $element->sendKeys($text);  
        $this->driver->wait(5,300);
        
        $this->screenshot('yandexreg');
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('button[type=submit]'));
        $element->click();

        //$this->driver->executeScript('$("iframe.kp2-authapi-iframe").attr("id", "frame")');
        $this->driver->wait(5,300);
        
    }
   
   
    $this->driver->get('https://mail.yandex.ru/');
    $this->driver->wait(5,300);
    echo "ok";
    $result1['status']=1;
    
    return $result1;
    //phoneCode
    //Получить код
    }
    
    
    public function yandex_captcha($file)
    {        
        $client = new \Anticaptcha\Client('e6341737bca2f5e84b9a4e8feb108c6f', ['languagePool' => 'en']);

        $taskId = $client->createTaskByImage(__DIR__.'/files/'.$this->fld.'/'.$file);
        $result = $client->getTaskResult($taskId);
        $result->await(); // Waiting for completion of solution.

        return $result->getSolution()->getText(); // string(14) "замочка"        
    }
    
    public function yandex_captcha_old()
    {
        $api = new ImageToText();
        $api->setVerboseMode(true);
                
        //your anti-captcha.com account key
        $api->setKey("e6341737bca2f5e84b9a4e8feb108c6f");

        //setting file
        $api->setFile("files/captcha.gif");

        if (!$api->createTask()) {
            $api->debout("API v2 send failed - ".$api->getErrorMessage(), "red");
            return false;
        }

        $taskId = $api->getTaskId();


        if (!$api->waitForResult()) {
            $api->debout("could not solve captcha", "red");
            $api->debout($api->getErrorMessage());
        } else {
            $captchaText    =   $api->getTaskSolution();
            echo "\nresult: $captchaText\n\n";
        }
    }
    
    public function yandex_add_info($params='')
    {
        $result1['descr']='Добавление информации к аккаунту на Яндексе';    
        //$result1['data']=json_encode($params, JSON_PRETTY_PRINT && JSON_UNESCAPED_UNICODE);  
        $url="https://passport.yandex.ru/profile/personal-info";
        $this->driver->get($url);
        $this->driver->wait(5,300);
        /*
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=birthday-day]'));
        //$element->click();
        $element->sendKeys($params['birth_day']);
        $this->driver->wait(5,300);
        
        
        // personal-info-birthday-month
        
        //$element=$this->driver->findElement(WebDriverBy::cssSelector('.personal-info-birthday-month > .button2__text'));
        // $element=$this->driver->executeScript('$(\'.personal-info-birthday-month > .button2__text\').val(\'Июль\');');
        //$element->click();
        //$element->endKeys('Июль');
                
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=birthday-year]'));
        //$element->click();
        $element->sendKeys($params['birth_year']);
        $this->driver->wait(5,300);
        
        /**/
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=city]'));
        //$element->click();
        $element->sendKeys($params['city']);
        
        $result1['status']=1;
        return $result1;
    }
    
    public function yandex_add_avatar($params='')
    {
        $result1['descr']='Добавление аватара к аккаунту на Яндексе'; 
    $url="https://passport.yandex.ru/profile";
    $this->driver->get($url);
    $this->driver->wait(5,300);
    
    
    $js='$(\'span.avatar-change\').click();';
    $this->driver->executeScript($js);
    //$element=$this->driver->findElement(WebDriverBy::cssSelector('span.avatar-change'));
    //$element->click();
    $this->driver->wait(5,300);
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=attachment]'));     
    // set the file detector
    $element->setFileDetector(new LocalFileDetector());
    // upload the file and submit the form
    $element->sendKeys($params['avatar']); //->submit();
    $this->driver->wait(6);
    
    $this->driver->executeScript('$("#profile_page_save_avatar>button").click();');    
//    $element=$this->driver->findElement(WebDriverBy::cssSelector('.phone__code-btn>button'));
//    $element->click();
    $this->driver->wait(30,300); 
    
    $url="https://passport.yandex.ru/profile";
    $this->driver->get($url);
    $this->driver->wait(5,300);
    // profile_page_save_avatar >button
    $result1['status']=1;
    return $result1;
            
    }
    
    public function yandex_add_phone($params='')
    {
    $result1['descr']='Добавление телефона к аккаунту на Яндексе';     
    $url="https://passport.yandex.ru/profile/phones?origin=passport_profile";
    $this->driver->get($url);
    $this->driver->wait(5,300);
    
    $r=$this->simsms_getphone(array('apikey'=>$this->simsms_apikey));
    print_r($r);
    $params['phone']='+7'.$r['number'];
    $params['simsms_id_req']=$r['id_req'];
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=phone]'));
    //$element->click();
    $element->sendKeys($params['phone']);  
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('button#nb-2'));
    $element->click();
    $this->driver->wait(5,300);
    
    while(($r->response!=1) && ($k<5))
    {
        $r=$this->simsms_getsms(array('id_req'=>$params['simsms_id_req']));
        if ($r->response==1)
        {
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=code]'));
        //$element->click();
        $element->sendKeys($r->sms);
        $this->driver->wait(5,300);
        
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=password]'));
        //$element->click();
        $element->sendKeys($params['password']);
        
        $this->screenshot('ya_phone');
        $smsok=1;
        break; 
        }
        else
        {
            $k++;
            echo "sleep $k<br>";
            sleep(30);
            
        }
    }
    
    if ($smsok==1)
    {
    $this->driver->wait(5,300);
    //$this->screenshot('yareg2');
    
    /*
$js="var scriptElt = document.createElement('script');
scriptElt.type = 'text/javascript';
scriptElt.src = 'https://yastatic.net/jquery/3.3.1/jquery.min.js';
document.getElementsByTagName('head')[0].appendChild(scriptElt);";
         $this->driver->executeScript($js);                   
         */
         
         $this->driver->executeScript('$("button.js-yasms-confirm").click();');    
    
    
//    $element=$this->driver->findElement(WebDriverBy::cssSelector('.phone__code-btn>button'));
//    $element->click();
    $this->driver->wait(30,300); 
    $url="https://passport.yandex.ru/profile/phones?origin=passport_profile";
    $this->driver->get($url);
    $this->driver->wait(5,300);   
//    $this->screenshot('yareg3');
    }
    
    $result1['status']=1;
        return $result1;
    }
    
    
    public function yandex_auth($params='')
    {
       
    $login=$params['login'];
    $password=$params['password'];
    $result1['descr']='Авторизация на Яндексе';    
    $result1['data']="Логин: $login, пароль $password"; 
    
    if (isset($params['is_open_pass']))
    {
    $is_open_pass=$params['is_open_pass'];
    }
    else
    {
        $is_open_pass=false;
    }
    
    $jsMetrika='<!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(52103718, "init", {
            id:52103718,
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/52103718" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->';


  
    $this->driver->get('https://passport.yandex.ru/');
    $this->driver->wait(5,300);
    $this->screenshot('yandex1');
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=login]'));
    $element->click();
    $element->sendKeys($login);
    $this->screenshot('yandex2');
    $btn=$this->driver->findElement(WebDriverBy::cssSelector('button[type=submit]'));
    $btn->click();    
    $this->driver->wait(5,300)->until(                           
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('input[name=passwd]'))
    );
   
    $this->screenshot('yandex3');
    $element2=$this->driver->findElement(WebDriverBy::cssSelector('input[name=passwd]'));
    $element2->click();
    $element2->sendKeys($password);
    $this->driver->wait(5,300)->until(                           
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('button[type=submit]'))
    );   
    
    //if ($is_open_pass==true)
    {
        $btn2=$this->driver->findElement(WebDriverBy::cssSelector('span.passp-password-field__eye_closed'));
        $btn2->click();
    }

    $this->screenshot('yandex4');
    
    $this->driver->wait(5,300)->until(                           
        WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('button[type=submit]'))
    ); 
    
    $btn3=$this->driver->findElement(WebDriverBy::cssSelector('button[type=submit]'));
    $btn3->click();
    $this->driver->wait(10); 
    sleep(2);
    
//    $cookies = $this->driver->manage()->getCookies();
//    foreach($cookies as $item)
//    {
//        $m[]=$this->saveobj($item)['cookie'];
//    }
//    $this->cookies=$m;
//    $m2=json_encode($m);
//    file_put_contents('files/cookies.txt', $m2);
    
    $this->driver->get('https://passport.yandex.ru/profile');
    $this->driver->wait(5,300);
    $src=$this->driver->getPageSource();
    
    $this->screenshot('yandex5');
    $z=explode('body',$src);
    $m=$z[1];
    $z=explode('>',$m);
    $m=str_replace('"','',$z[0]);
    $z=explode(' ',$m);
    foreach($z as $item)
    {
        $item=trim($item);
        $n=explode('=',$item);
        $nn=trim($n[0]);
        $n[1]=html_entity_decode($n[1]);
        $n2=trim(str_replace('"','',$n[1]));
        
        $ar[$nn]=$n2;
    }
    
    //print_r($ar);
    //exit;
     
     if ($ar['data-login']!='null')
     {    
     $result1['status']=1;
     }
     else
     {
         $result1['status']=2;
     }
    return $result1;
    
}

    public function restore_cookies()
    {
        $json=file_get_contents('files/cookies.txt');
        $this->cookies=json_decode($json);
        
        foreach($this->cookies as $item)
        {
          
//          print_r($item);  
            
        $this->driver->manage()->addCookie(['name' => $item->name, 
                                            'value' => $item->value,
                                            'path' => $item->path,
                                            'domain' => $item->domain,
                                            'expiry' => $item->expiry,
                                            'secure' => $item->secure,
                                            'httpOnly' => $item->httpOnly
                                            ]);
        }
        //exit;
        
        $cookies = $this->driver->manage()->getCookies();
        foreach($cookies as $item)
        {
            $m[]=$this->saveobj($item)['cookie'];
        }
        $m2=json_encode($m);
        file_put_contents('files/cookies_restored.txt', $m2);
    }

    public function saveobj($object) {
        $reflectionClass = new \ReflectionClass(get_class($object));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }
        return $array;
    }


    public function hhauth($params=[])
    {
//        $params['is_open_pass']=true;

        $login='Hr@cleversales.ru'; //'d.ivanova@klienti.ru'; //$params['login'];
        $password='zxergh67'; //'9030404'; //$params['password'];
//        if (isset($params['is_open_pass']))
//        {
//        $is_open_pass=$params['is_open_pass'];
//        }
//        else
//        {
//            $is_open_pass=false;
//        }
       
        $this->driver->get('https://hh.ru/account/login');
        $this->screenshot('hh_1');
        $element=$this->driver->findElement(WebDriverBy::cssSelector('input[name=username]'));
        $element->click();
        $element->sendKeys($login);
        $this->screenshot('hh_2');
        //$btn=$this->driver->findElement(WebDriverBy::cssSelector('button[type=submit]'));
        //$btn->click();
//        $this->driver->wait(5,300)->until(                           
//            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('input[name=password]'))
//        );
       
        $element2=$this->driver->findElement(WebDriverBy::cssSelector('input[name=password]'));
        $element2->click();
        $element2->sendKeys($password);
        $this->screenshot('hh_3');
        
        $btn3=$this->driver->findElement(WebDriverBy::cssSelector('input[type=submit]'));
        $btn3->click();

        $this->screenshot('hh_4');
        //sleep(1);
       
        
    }

    public function hh_resume_parse($file)
    {
        $f=file_get_contents($file);
        //$f2=iconv("UTF-8", "WINDOWS-1251", $f);
        //file_put_contents()

        $z=explode('<div class="resume-header">',$f);
        $body=$z[1];
        $z=explode('</h2>',$body);
        $ar['fio']=trim(strip_tags($z[0]));
        $body=str_replace('>',">\r\n",$z[1]);

        $z=explode('<span itemprop="gender" data-qa="resume-personal-gender">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        $ar['gender']=trim(strip_tags($z[0]));


        $z=explode('<span data-qa="resume-personal-age">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['age']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<meta itemprop="birthDate" data-qa="resume-personal-birthday" content="',$body);
        $body=$z[1];
        $z=explode('>',$body);
        //$body=$z[1];
        $ar['birth']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<span itemprop="addressLocality" data-qa="resume-personal-address">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //print_r($z);
        //$body=$z[1];
        $ar['city']=trim(strip_tags(trim(html_entity_decode($z[0]))));
        $ar['pereezd']=trim(strip_tags(trim(html_entity_decode($z[1]))));
        $z2=explode('</p>',$z[2]);
        $ar['comand']=trim(strip_tags(trim(html_entity_decode($z2[0]))));

//        $z=explode('<span itemprop="telephone" data-qa="resume-contact-preferred">',$body);
        $z=explode('<span itemprop="telephone">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['phone']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<a href="mailto:',$body);
        $body=$z[1];
        $z=explode('" itemprop="email"',$body);
        //$body=$z[1];
        $ar['email']=trim(strip_tags(trim(html_entity_decode($z[0]))));


        $z=explode('<span class="resume-header-contact" data-qa="resume-personalsite-skype">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['skype']=trim(strip_tags(trim(html_entity_decode($z[1]))));


//        $z=explode('<div class="resume-header-print-update-date">',$body);
        $z=explode('<div class="resume-header-additional__update-date">',$f);
        $body=$z[1];
        $z=explode('</div>',$body);
        //$body=$z[1];
        $ar['dat_update']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<span class="resume-block__title-text" data-qa="resume-block-title-position">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['position']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<span class="resume-block__salary resume-block__title-text_salary" data-qa="resume-block-salary">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['cost']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<span data-qa="resume-block-specialization-category">',$body);
        $body=$z[1];
        $z=explode('</span>',$body);
        //$body=$z[1];
        $ar['activity_field']=trim(strip_tags(trim(html_entity_decode($z[0]))));

        $z=explode('<ul>',$body);
        $body=$z[1];
        $z=explode('</ul>',$body);
        $z=explode('<li>',$z[0]);
        $z=explode('</li>',$z[0]);
        $x='';
        foreach ($z as $y) {
            $y=trim(strip_tags(trim(html_entity_decode($y))));
            $x=$x.$y.' ';
        }
        $ar['specialization']=trim(strip_tags(trim(html_entity_decode($x))));

        $z=explode('<p>',$body);
        $body1=$z[1];
        $body2=$z[2];
        $z=explode('</p>',$body1);
        $ar['occupation']=str_replace('Занятость: ', '', trim(strip_tags(trim(html_entity_decode($z[0])))));
        $z=explode('</p>',$body2);
        $ar['shedule']=str_replace('График работы: ', '', trim(strip_tags(trim(html_entity_decode($z[0])))));


///-----------------------
///
        //$z=explode('<div class="resume-block-item-gap">', $f);
        $z=explode('<h2 data-qa="bloko-header-2" class="bloko-header-2 bloko-header-2_lite">', $f);
        $op=$z[1];
        $op=str_replace('<!-- -->','',$op);
        $op=str_replace('&nbsp;',' ',$op);

        $z=explode('<div class="bloko-column bloko-column_xs-4 bloko-column_s-2 bloko-column_m-2 bloko-column_l-2">', $op);
        $ar['opit_all']=trim(strip_tags(trim(html_entity_decode($z[0]))));
        unset($z[0]);

        foreach($z as $k=>$v)
        {
            $z[$k]=str_replace("</div>","</div>\r\n", $v);

            $m=explode('<div class="resume-block__experience-timeinterval">',$v);
            $last=strip_tags(trim($m[0]));
            $opit1=$m[1];
            $op1=explode('</div>',$opit1);
            $period=trim($op1[0]);

            //----------

            $m=explode('<div itemprop="name" class="resume-block__sub-title">',$v);
            $opit1=$m[1];
            $op1=explode('</span>',$opit1);
            $nam=trim($op1[0]);
            //----------

            $m=explode('<div class="resume-block__experience-industries">',$v);
            $opit1=$m[1];
            $op1=explode('</div>',$opit1);
            $op2=explode('</span>',$op1[0]);
            $ind=$op2[0];
            //----------

            $m=explode('<div class="resume-block__experience-industries">',$v);
            $opit1=$m[1];
            $op1=explode('</div>',$opit1);
            $op2=explode('<span>',$op1[0]);
            $op3=explode('</span', $op2[2]);
            $pod_ind=$op3[0];

            //----------

            $m=explode('<span itemprop="addressLocality">',$v);
            $opit1=$m[1];
            $op1=explode('</span>',$opit1);
            $adres=trim($op1[0]);

            //----------
            $m=explode('<div class="resume-block__sub-title" data-qa="resume-block-experience-position">',$v);
            $opit1=$m[1];
            $op1=explode('</span>',$opit1);
            $pos1=trim($op1[0]);
            //----------
            $m=explode('<div data-qa="resume-block-experience-description">',$v);
            $opit1=$m[1];
            $op1=explode('</span>',$opit1);
            $descr=trim($op1[0]);




            $ar['opit'][$k]['last']=$last;
            $ar['opit'][$k]['period']=trim($period);
            $ar['opit'][$k]['nam']=trim(strip_tags($nam));
            $ar['opit'][$k]['ind']=trim(strip_tags($ind));
            $ar['opit'][$k]['pod_ind']=trim(strip_tags($pod_ind));
            $ar['opit'][$k]['adres']=trim(strip_tags($adres));
            $ar['opit'][$k]['position']=trim(strip_tags($pos1));
            $ar['opit'][$k]['descr']=trim(strip_tags($descr));

        }

        $z=explode('<div class="resume-block-container" data-qa="resume-block-skills-content">', $f);
        $zzz=$z[1];
        $z=explode('</div>',$zzz);
        $op=$z[0];
        $op=str_replace('<!-- -->','',$op);
        $op=str_replace('&nbsp;',' ',$op);
        $op=str_replace('>',">\r\n",$op);

        $ar['about']=trim(strip_tags(trim(html_entity_decode($op))));
        unset($z[0]);




        $z=explode('<div class="bloko-tag-list">', $f);
        $body=$z[1];
        $z=explode('data-qa="resume-block-driver-experience"', $body);
        $kl=$z[0];
        $z=explode('data-qa="bloko-tag__text"', $kl);
        $y='';
        foreach ($z as $x) {
            $y=$y.trim(strip_tags(trim(html_entity_decode($x))));
        }
        $y=str_replace('>', ', ', $y);
        $ar['skills']=substr_replace($y,'', 0, 2);


        $z=explode('data-qa="resume-block-driver-experience"', $f);
        $body=$z[1];
        $z=explode('data-qa="resume-block-skills"', $body);
        $body=$z[0];
        $ar['driving']=trim(strip_tags(trim(html_entity_decode($body))));
        $ar['driving']=str_replace('class="resume-block">Опыт вождения', '', $ar['driving']);



        $z=explode('data-qa="resume-block-education"', $f);
        $body=$z[1];
        $z=explode('data-qa="resume-block-languages"', $body);
        $body=$z[0];
        $z=explode('data-qa="resume-block-education-name"', $body);
        $body1=trim(strip_tags(trim(html_entity_decode($z[0]))));
        $body1=str_replace('class="resume-block">Высшее образование', '', $body1);
        $ar['high_ed']['year'] = $body1;
        $body2=$z[1];
        $z=explode('/span', $body2);
        $ar['high_ed']['inst']=str_replace('>','', trim(strip_tags(trim(html_entity_decode($z[0])))));
        $ar['high_ed']['spez']=str_replace('>','', trim(strip_tags(trim(html_entity_decode($z[1])))));


//        $z=explode('data-qa="resume-block-languages"', $f);
        $z=explode('data-qa="resume-block-language-item"', $f);
        $body=$z[1];
        $z=explode('data-qa="resume-block-additional"', $body);
        $ar['lang']=str_replace('>','', trim(strip_tags(trim(html_entity_decode($z[0])))));



        $z=explode('data-qa="resume-block-additional', $f);
        $body=$z[1];
        $z=explode('data-qa="similar-resumes-block"', $body);
        $body=$z[0];
        $z=explode('<p>', $body);
        $ar['citizen'] = trim(strip_tags(trim(html_entity_decode($z[1]))));
        $ar['work_perm'] = trim(strip_tags(trim(html_entity_decode($z[2]))));
        $ar['time_to_work'] = trim(strip_tags(trim(html_entity_decode($z[3]))));



        //$body=$z[1];

        //unset($z[0]);

//        print_r($z);
        //print_r($ar);


        //echo $fio; exit;
        //echo $f;
//        var_dump($ar);
        return $ar;
    }

    public function hh_resume($url)
    {
        $this->driver->get($url);
        $this->screenshot('hh_resume_1');

        try {
            $btn3 = $this->driver->findElement(WebDriverBy::cssSelector('span.bloko-link-switch'));
            $btn3->click();
            $this->driver->wait(10);
            $this->screenshot('hh_resume_2');
            sleep(2);
        }
        catch(\Exception $e)
        {
            echo "$btn3";
        }
        // Показать все контакты

        for ($i = 0; $i <= 2; $i++) {
            $this->driver->executeScript('window.scrollTo(0,document.body.scrollHeight);');

            try {
                $btn4 = $this->driver->findElements(WebDriverBy::cssSelector('span.resume-industries__open'));
                foreach ($btn4 as $btn) {
                    $btn->click();
                    $this->driver->wait(5);
                }
                $this->driver->wait(10);
                $this->screenshot('hh_resume_3');
                sleep(2);
            } catch (\Exception $e) {
                echo "btn4";
            }
        }

        // Показать полностью сферу деятельности компании в опыте работы

        $s=$this->driver->getPageSource();
            //findElement(WebDriverBy::tagName('body')).getAttribute('innerHTML');
        //echo $s;
        $fn="files/".$this->fld.'/hh_resume_1.txt';
        //$s=$this->driver->getPageSource();
        file_put_contents($fn, $s);

        return $fn;
    }


    public function hh_response($params='')
    {
        if ($params['page']==0)
        {
            $this->driver->get('https://hh.ru/applicant/negotiations?filter=all');
        }
        else
        {
            $this->driver->get('https://hh.ru/applicant/negotiations?filter=all&page='.$params['page']);            
        } // &page=1   начинанется с 0
        //$this->driver->get('https://hh.ru/applicant/resumes');                 
        
        $s=$this->driver->findElement(WebDriverBy::tagName('body')).getAttribute('innerHTML');
        //$s=$this->driver->getPageSource();
        file_put_contents('hh_'.$params['page'].'.txt', $s);
        
        
    }
    
    public function get_hh_otklik()
    {
    $db=$this->db;    
    $f=file_get_contents('hh_0.txt');
    $f=str_replace(">",">\r\n",$f);

    $z=explode('<tr class="responses-table-row"',$f);
    unset($z[0]);
    foreach($z as $k=>$item)
    {
        $r=explode('</tr>',$item);
        $n=$r[0];
        
        $z=explode('<span class="responses-table-status"',$n);
        $nn=explode('</span>',$z[1]);
        //$m['status']=trim($nn[0]);
        $n2=trim(strip_tags($n));
        $n3=explode("\n",$n2);
        unset($n3[0]);
        unset($n4);
        foreach($n3 as $mm)
        {
            if (trim($mm)!='') {$n4[]=trim($mm);}
        }
        
        $r=explode('href="',$item);
        $nnn=$r[1];
        $xx=explode('"',$nnn);
        
        unset($n4[2]);
        unset($n4[4]);
        unset($n4[7]);
        unset($m1);
        $m1['status']=$n4[0];
        if ($m1['status']=='Резюме не просмотрено') {$m1['status1']=0;}
        if ($m1['status']=='Приглашение') {$m1['status1']=1;}
        if ($m1['status']=='Отказ') {$m1['status1']=2;}
        $m1['vak']=$n4[3];
        $m1['percent']=$n4[1];
        $m1['company']=$n4[5];
        $m1['dat']=$n4[6];
        if ($m1['dat']=='сегодня') {$m1['dat']=date('Y-m-d');}
        if ($m1['dat']=='вчера') {$m1['dat']=date('Y-m-d',strtotime('yesterday'));}
        $m1['href']=str_replace('/applicant/negotiations/item?topicId=','',$xx[0]);
        
        $m[]=$m1;
        //print_r($n4);
        //echo "\r\n==============================\r\n";
        
    }



    foreach($m as $item)
    {
        $sql="INSERT INTO `hh_resp` (`dat`, `firm`, `vak`, `status1`, `percent`, `topic`) ".
        "VALUES ( '{$item['dat']}', '{$item['company']}', '{$item['vak']}', '{$item['status1']}', '{$item['percent']}', '{$item['href']}');";
        $db->query($sql);
    }
    }
    
    public function kinopoisk_auth($params='')
    {
        $result1['descr']='Авторизация на Кинопоиске'; 
        $this->driver->get('https://kinopoisk.ru/');  
        $this->driver->wait(5);
        
        //$this->screenshot('kino0'); 
        //$this->restore_cookies();
        
        //$this->driver->get('https://kinopoisk.ru/');  
        //$this->driver->wait(5);        
        $this->screenshot('kino1'); 
        
        if ($params['without_before_yandex_auth']==1)
        {
        // Кликнуть по кнопке Войти
        $element=$this->driver->findElement(WebDriverBy::cssSelector('button.header-fresh-user-partial-component__login-button'));
        //$element=$this->driver->findElement(WebDriverBy::cssSelector('div.kp2-authapi-overlay'));
        $element->click();  
        }
        
        
//        $btn3=$this->driver->findElement(WebDriverBy::className('passp-account-list-item'));
//        $btn3->click();
        
        $zzz=0;
        if ($zzz==21)
        {
        // Найти фрейм Яндекса           
         $js="var scriptElt = document.createElement('script');
scriptElt.type = 'text/javascript';
scriptElt.src = 'https://yastatic.net/jquery/3.3.1/jquery.min.js';
document.getElementsByTagName('head')[0].appendChild(scriptElt);";
         $this->driver->executeScript($js);                   
         $this->driver->executeScript('$("iframe.kp2-authapi-iframe").attr("id", "frame")');
   
         //$this->screenshot('kino2');    
         $this->driver->switchTo()->frame('frame');   // $driver->switchTo()->defaultContent();      
         $this->driver->wait(10);
             
        // Войти через Яндекс
        
        //$handles = $this->driver->getWindowHandles();
        //print_r($handles);     
        //$this->driver->wait(5);
        //$btn3=$this->driver->findElement(WebDriverBy::tagName('form'));
        //$btn3=$this->driver->findElement(WebDriverBy::linkText('Войти через Яндекс'));
        //$btn3=$this->driver->findElement(WebDriverBy::className('auth__button_type_submit'));
        //$btn3->click();        
        //$this->driver->wait(5);
        
        $this->driver->executeScript('$("button[type=submit]").click();');
        //$this->driver->executeScript('document.forms[0].submit();');
        $this->driver->wait(5);
                
        $this->driver->switchTo()->defaultContent();
        //$this->driver->wait(15);
        $this->driver->executeScript("document.body.style.zoom = '50%';");          
        sleep(5);
        }
        $this->screenshot('kino3');        
       
         
//----------- Разрешить или отклонить -------------         
//      Переключение на окно Oauth с подтверждением 
//        $handles = $this->driver->getWindowHandles();
//        print_r($handles);
//        $this->driver->switchTo()->window(end($handles));         
//        $this->driver->wait(10);         

        //$this->driver->executeScript($js);          
         //$this->driver->executeScript('$("iframe").addClass("fr1")');
        
//        $this->driver->executeScript('$("#nb-2").click()');
//        $this->driver->wait(10);
         /**/
         
         // Зарегистрироваться при первом входе 
        if ($params['first']==1)         
        {
             $this->driver->executeScript('$("iframe.kp2-authapi-iframe").attr("id", "frame1")');        
             $this->driver->switchTo()->frame('frame1');   // $driver->switchTo()->defaultContent();     
             $this->driver->wait(10);         
             $btn4=$this->driver->findElement(WebDriverBy::className('auth__button_type_submit'));
             $btn4->click();
             $this->driver->switchTo()->defaultContent();
             $this->driver->wait(3);
        }
//----------------------------         
         
         //
         $f=$this->driver->getPageSource();
         preg_match_all('{href="/user/(.*)/}',$f,$matches);
         
         foreach($matches[1] as $k=>$v)
         {
             $z=explode('/go/',$v);
             $c=count($z);
             if ($c==2)
             {
                 $user=$z[0];break;
             }
         }
         
         $this->data['kinopoisk']['user']=trim($user);
         $this->driver->get('https://kinopoisk.ru/user/'.$user.'/go/'); 
       // exit;
        
//        $this->driver->wait(5,300)->until(                           
//            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('nb-2'))
//        ); 
        
//        $btn3=$this->driver->findElement(WebDriverBy::id('nb-2'));
//        $btn3->click();
//        
//        $this->driver->wait(5);  
          
        
        //$this->driver->get('https://kinopoisk.ru/');
        // nb-2
        
//        $Variable='Войти через Яндекс';
//        $elementXpath= "xpath=//span[text()=".$Variable."]/";
//        $webElement= $this->driver->findElement(WebDriverBy::xpath($elementXpath));
//        $webElement->click();
        
//        $this->driver->wait(5,300)->until(                           
//            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('button[type=submit]'))
//        ); 
//        
//        $cc=$this->driver->findElement( WebDriverBy::className('auth__row') )->findElement( WebDriverBy::className('auth__button_type_submit'));
//        $cc->click();
        // Войти через Яндекс
        
//        $this->driver->wait(5,300)->until(                           
//            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('button[type=submit]'))
//        ); 
        

        
        //$this->screenshot('kino_9');
        
        
        
//        $this->driver->wait()->until(
//            WebDriverExpectedCondition::alertIsPresent(),
//            'I am expecting an alert!',
//        );
//        
//        $driver->switchTo()->alert()->accept();
        
        //
        
        $result1['status']=1;
        return $result1;
    }
    
    
    
    public function kinopoisk_setprofile($params='')
    {
    //$url='';    
    // $this->data['kinopoisk']['user']=trim($user);
    $this->driver->get('https://www.kinopoisk.ru/mykp/edit_main/');    
    $this->driver->wait(7); 
    $this->screenshot('edit');
    //-------------- avatar 
    $element=$this->driver->findElement(WebDriverBy::cssSelector('input.userpic-input-file'));       
    // set the file detector
    $element->setFileDetector(new LocalFileDetector());
    // upload the file and submit the form
    $element->sendKeys($params['avatar'])->submit();
    $this->driver->wait(6);
    //-------------- city  
    
    //$element=$this->driver->findElement(WebDriverBy::name('edit[main][city]'));
    //$element->sendKeys($params['city']);
    //$element->setAttribute("value", $params['city']);
    //$element->setAttribute("id", 'city222');
    
    //$this->driver->wait(6);
    $this->driver->executeScript('$(\'[name="edit[main][city]"]\').val(\''.$params['city'].'\');');
    //-------------- date_birth
    /*
    $element=$this->driver->findElement(WebDriverBy::name('edit[birth][day]'));
    $ide=$element->getID();
    //echo "ide=$ide";
    
    //$element->sendKeys($params['city']);
    //$element->setAttribute("value", $params['city']);
    $element->setAttribute("value", '12');
    //$this->driver->wait(6);
    //$this->screenshot('edit2');
    /**/
    $this->driver->executeScript('$(\'[name="edit[birth][day]"]\').val(\''.$params['birth_day'].'\');');
    $this->driver->executeScript('$(\'[name="edit[birth][month]"]\').val(\''.$params['birth_month'].'\');');
    $this->driver->executeScript('$(\'[name="edit[birth][year]"]\').val(\''.$params['birth_year'].'\');');
    //--------------- strana
    $params['strana']=62;
    $this->driver->executeScript('$(\'[name="edit[main][id_country]"]\').val(\''.$params['strana'].'\');');
    $this->driver->executeScript('$(\'[name="edit[main][about]"]\').val(\''.$params['about'].'\');');
    
    $this->driver->executeScript('$(\'[name="edit[main][social][vkontakte]"]\').val(\''.$params['vkontakte'].'\');');
    $this->driver->executeScript('$(\'[name="edit[main][social][facebook]"]\').val(\''.$params['facebook'].'\');');
    $this->driver->executeScript('$(\'[name="edit[main][social][twitter]"]\').val(\''.$params['twitter'].'\');');
    
    $this->driver->executeScript('$(\'[name="edit[main][interes]"]\').val(\'\');');
    $element=$this->driver->findElement(WebDriverBy::name('edit[main][interes]'));
    $element->sendKeys($params['interes']);
    //$this->driver->executeScript('$(\'[name="edit[main][interes]"]\').val(\''.$params['interes'].'\');');
    
    //$this->driver->executeScript('$("select.mykp").val(2);');
    $this->driver->wait(6);
    $this->screenshot('edit2');
    
    //exit;
    /*
    # get the select element    
    $select = $this->driver->findElement(WebDriverBy::name('edit[main][id_country]')); 
    //WebDriverBy::tagName('select'));
    # get all the options for this element
    $allOptions = $select->findElement(WebDriverBy::tagName('option'));
    # select the options
    foreach ($allOptions as $option) {
      //echo "Value is:" . $option->getAttribute('value);
      if ($option->getAttribute('value')=='2')
      {
        $option->click();
      }
    }
    $this->driver->wait(4);
    //$element->sendKeys('c:\00\Desert.png');
    */
    
    $element=$this->driver->findElement(WebDriverBy::cssSelector('#js-save-edit-form'));
    $element->click(); 
    $this->driver->wait(4);
    //$this->driver->get('https://www.kinopoisk.ru/mykp/edit_main/');    
    //$this->driver->wait(7); 
    
    $user=$this->data['kinopoisk']['user'];
    $this->driver->get('https://kinopoisk.ru/user/'.$user.'/go/'); 
    
    }
    
    
    public function kinopoisk_top($params='')
    {
    
    // заход на рейтинг
    $this->driver->get('https://kinopoisk.ru/top/');  
    $this->driver->wait(5);    
//    $scroll=rand(300,2000);    
//    $js_scroll="window.scrollBy(0,$scroll);";
//    $this->driver->executeScript($js_scroll); 
    
    $this->screenshot('filmtop');
    //===== Получаем список топовых фильмов
    //$f=file_get_contents('1.txt');
    $f=$this->driver->getPageSource();
    preg_match_all('{href="/film/(.*)/".*</a>}',$f,$matches);
    foreach($matches[1] as $k=>$item)
    {
        $s1=str_replace('votes','',$item);
        if ($s1!=$item) 
        {
            unset($matches[0][$k]);
            unset($matches[1][$k]);
        }
    }

    $j=0;
    foreach($matches[0] as $k=>$item)
    {
        $j++;
        $z=explode('>',$item);
        $item2=str_replace('</a','',$z[1]);
        $m[$j]['nam']=trim($item2);
        $m[$j]['ind']=$matches[1][$k];
    }
    
    $this->data['kinopoisk']['top']=$m;
    $c=count($m);
    /*
    
    print_r($m);
    //echo $f;
    // ---- Заходим на рандомный фильм ----------
    $ind=rand(1, $c);
    $ind2=$m[$ind]['ind'];
    
    print_r($m[$ind]);
    
    $this->driver->get("https://www.kinopoisk.ru/film/$ind2/");  
    $this->driver->wait(5); 
    $this->screenshot('film_'.$ind2);
    */
    
    
    $result1['status']=1;
    return $result1;  
    }
    
    public function kinopoisk_film($params='')
    {
        
    $m=$this->data['kinopoisk']['top'];
    $c=count($m);
    //print_r($m);
    //echo $f;
    // ---- Заходим на рандомный фильм ----------
    if ($params['film']=='rand')
    {
    $ind=rand(1, $c);
    $ind2=$m[$ind]['ind'];
    }
    else
    {
        $ind2=$params['film'];
    }
    //print_r($m[$ind]);
    
    $this->driver->get("https://www.kinopoisk.ru/film/$ind2/");  
    $this->driver->wait(5); 
     
    if ($params['like']==1)
    {
        $element=$this->driver->findElement(WebDriverBy::cssSelector('a.s5'));
        $element->click();  
    }    
    
    $result1['status']=1;
    return $result1;    
    }
    
}

?>