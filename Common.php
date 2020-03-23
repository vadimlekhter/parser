<?
class Common 
{
    public $db;
    public $db_params;
	public $dbs;
    public $db_item;
    public $params;
    public $request;
    public $session;
    public $log_table;
    
    public function __construct($params=false)
    {
       
        $this->params=$params;
        $this->request=$_REQUEST;
        $this->session=$_SESSION;
        $this->log_table=false;
        
        //print_r($_REQUEST);
        //print_r($this->request);
        //exit;
        if (isset($params['db'])) 
        {
            $this->db=$params['db'];
            $this->db_params=$params['db_params'];
            $this->dbs=$params['dbs'];
            $this->db_item=$params['db_item'];
            $this->schema=$params['schema'];
            $this->table=$params['table'];    
        } 
        else 
        {
            $this->db=false;
        }
    }
    
	public function convert_date($dat, $format='d.m.Y',$pr_int=0)
	{
		if ($dat!='')
		{
		if ($pr_int==0) $d=strtotime($dat);
		if ($pr_int==1) $d=$dat;
		
		$res=date($format,$d);
		return $res;    
		}
		else
		{
			return $dat;
		}
	}
    
    public function writelog($msg, $status=0)
    {    
        if ($this->log_table!=false)
        {
            $sql="INSERT INTO `{$this->log_table}` (`nam`, `dat`, `status`) VALUES ('$msg', NOW(), '$status')";
            $this->db->query($sql);
        }                               
    }
        
    public function send_email($email, $fio, $subj, $msg)
    {
    global $SETTINGS;
    //$login=$SETTINGS['smsc_login'];
    // $pass=$SETTINGS['smsc_pass'];


    foreach($SETTINGS as $k=>$v)
    {
    $msg=str_replace("{".$k."}",$v,$msg);
    }


    //print_r($SETTINGS);
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    //$mail->SMTPDebug = 1;  
    $mail->SMTPSecure = 'ssl';
    $mail->CharSet='utf-8';
    $mail->Host = $SETTINGS['mail_host'];
    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = $SETTINGS['mail_port'];
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication
    $mail->Username = $SETTINGS['mail_login'];
    //Password to use for SMTP authentication
    $mail->Password = $SETTINGS['mail_pass'];
    //Set who the message is to be sent from
    $mail->setFrom($SETTINGS['mail_from'], $SETTINGS['mail_from_name']);
    //Set an alternative reply-to address
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //Set who the message is to be sent to
    $mail->addAddress($email, $fio);
    //Set the subject line
    $mail->Subject = $subj;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($msg); //file_get_contents('contents.html'), dirname(__FILE__));
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');


    //print_r($mail);
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;exit;
    } else {
        //echo "Message sent!";
    }

    //$url="https://smsc.ru/sys/send.php?login=$login&psw=$pass&phones=$phone&mes=$msg";
    //file_get_contents($url);
    }

    public function send_sms($phone, $msg, $flash=0)
    {
        $msg=iconv('utf8','windows-1251',$msg);
        $url="https://smsc.ru/sys/send.php?login=origamiv2&flash=$flash&psw=9030404&phones=$phone&mes=$msg";
        file_get_contents($url);
    }

    public function randomPassword($len,$pr_nom=0) 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        if ($pr_nom==1) {$alphabet = '1234567890';}
        
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    function transliterate($string) 
    {
    $replace=array(
        "'"=>"",
        "`"=>"",
        " "=>"_",
        "а"=>"a","А"=>"a",
        "б"=>"b","Б"=>"b",
        "в"=>"v","В"=>"v",
        "г"=>"g","Г"=>"g",
        "д"=>"d","Д"=>"d",
        "е"=>"e","Е"=>"e",
        "ж"=>"zh","Ж"=>"zh",
        "з"=>"z","З"=>"z",
        "и"=>"i","И"=>"i",
        "й"=>"y","Й"=>"y",
        "к"=>"k","К"=>"k",
        "л"=>"l","Л"=>"l",
        "м"=>"m","М"=>"m",
        "н"=>"n","Н"=>"n",
        "о"=>"o","О"=>"o",
        "п"=>"p","П"=>"p",
        "р"=>"r","Р"=>"r",
        "с"=>"s","С"=>"s",
        "т"=>"t","Т"=>"t",
        "у"=>"u","У"=>"u",
        "ф"=>"f","Ф"=>"f",
        "х"=>"h","Х"=>"h",
        "ц"=>"c","Ц"=>"c",
        "ч"=>"ch","Ч"=>"ch",
        "ш"=>"sh","Ш"=>"sh",
        "щ"=>"sch","Щ"=>"sch",
        "ъ"=>"","Ъ"=>"",
        "ы"=>"y","Ы"=>"y",
        "ь"=>"","Ь"=>"",
        "э"=>"e","Э"=>"e",
        "ю"=>"yu","Ю"=>"yu",
        "я"=>"ya","Я"=>"ya",
        "і"=>"i","І"=>"i",
        "ї"=>"yi","Ї"=>"yi",
        "є"=>"e","Є"=>"e"
    );
    return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    }
	
}