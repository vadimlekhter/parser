<?
include "common.php";
date_default_timezone_set('Europe/Moscow'); 
session_name('our_crm');
session_start();

//require_once 'vendor/autoload.php';

//phpinfo(); exit;
//$DB_HOST='localhost';
//$DB_NAME='our_parser';
//$DB_USER='root';
//$DB_PASS='9030404';
//$schema=$DB_NAME;
//$rel_path='';
//
//@define(DB_DRIVER, "mysql");
//@define(DB_HOST, $DB_HOST);
//@define(DB_NAME, $DB_NAME);
//@define(DB_USER, $DB_USER);
//@define(DB_PASS, $DB_PASS);

$db_driver='mysql';
$dbs['our_koto']=array('db_driver'=>$db_driver,'db_name'=>'our_koto','db_schema'=>'our_koto','db_host'=>'localhost','db_user'=>'root','db_pass'=>'9030404');

//$db_driver='pgsql';
//$dbs['adm']  =array('db_driver'=>$db_driver,'db_name'=>'adm',  'db_schema'=>'public','db_host'=>'localhost','db_user'=>'postgres','db_pass'=>'');
//$dbs['anti2']=array('db_driver'=>$db_driver,'db_name'=>'anti2','db_schema'=>'public','db_host'=>'localhost','db_user'=>'postgres','db_pass'=>'');

foreach($dbs as $db_name=>$item)
{
    if($db_driver=='mysql') {$dbs[$db_name]['pdo']= new PDO("$db_driver:host={$item['db_host']};dbname={$item['db_name']};", $item['db_user'], $item['db_pass']);}
    if($db_driver=='pgsql') {$dbs[$db_name]['pdo']= new PDO("pgsql:host={$item['db_host']};port=5432;dbname={$item['db_name']};user={$item['db_user']};password={$item['db_pass']};");}
}
        
$db_active='our_koto';                
//$db_active='adm';                
$db  = $dbs[$db_active]['pdo']; 
$db_params  = $dbs[$db_active]; 
if ($db_params['db_driver']=='mysql') {$schema=$db_params['db_name'];}
if ($db_params['db_driver']=='pgsql') {$schema='public';}

//new PDO("mysql:host=localhost;dbname=our_parser;", 'root', ''); //, 
                //array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;SET CHARACTER SET utf8"));
//$db->query('SET NAMES utf-8;');
//$db->query('SET CHARACTER SET utf-8;');
$sql="SELECT * FROM settings WHERE 1=1";
$rows=$db->query($sql,PDO::FETCH_ASSOC)->fetchAll();
foreach($rows as $row)
{
    $nam=$row['nam'];
    $val=$row['val'];
    $SETTINGS[$nam]=$val;
}                

//print_r($_SERVER);

//$path1="/var/www/ourcrm/data/www/parser.ourcrm.ru/";
//echo $_SERVER['PHP_SELF']."\r\n";
$n=pathinfo($_SERVER['SCRIPT_FILENAME']); //."\r\n";
$basename='/'.$n['basename'];
//print_r($n);
//print_r($_SERVER);
//$path1=str_replace($_SERVER['PHP_SELF'],'',$_SERVER['SCRIPT_FILENAME']).'/';
$path1=trim($_SERVER['PWD'].'/');
//echo $path1;exit;
if (($path1=='/') || ($path1=='/root/'))
{
$path1=str_replace($basename,'',$_SERVER['SCRIPT_FILENAME']).'/';
}
//$path1=str_replace($basename,'',$_SERVER['PHP_SELF']).'/';

//echo $path1; 
include_once $path1.'core/Common.php';

$sql="SELECT * FROM modules WHERE status1=1 ORDER BY nom,id";
$rows=$db->query($sql,PDO::FETCH_ASSOC)->fetchAll();
foreach($rows as $row)
{
    //print_r($row);
    $fn_module=$path1.'core/modules/'.$row['shortnam'].'/load.php'; //."<br>";
    //echo $fn_module."<br>";
    require_once $fn_module; //."<br>";
}

$css_modules=implode("\r\n",$css);
$js_modules=implode("\r\n",$js);

//require_once $path1.'core/modules/crud/load.php';
//require_once $path1.'core/modules/controls/load.php';

//require_once $path1.'core/controls/CommonControl.php';
//require_once $path1.'core/parser/CommonParser.php';
//require_once $path1.'core/parser/Regger.php';
//exit;


//exit;
?>