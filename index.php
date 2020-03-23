<?
require "vendor/autoload.php";
require "Common.php";
require "CommonBot.php";
require "SeleniumBot.php";

$item['db_host']='localhost';
$item['db_name']='mycrm';
$item['db_user']='root';
$item['db_pass']='';


$db= 1; //new PDO("mysql:host={$item['db_host']};dbname={$item['db_name']};", $item['db_user'], $item['db_pass']);

$params['db']=$db;
$params['id_bot']=1;

$z=new SeleniumBot($params);
//$z->getip();
//$z->hhauth();
//$z->hh_resume('https://hh.ru/resume/fa2ff3960007c47e2000437fd47a4176797333');
//$z->hh_resume('https://hh.ru/resume/5e5d21900005042bca00437fd4577674775372');

 $z->hh_resume_parse('files/2020-03-22-22-25-04/hh_resume_1.txt');


// $host = 'http://172.16.10.46:4444/wd/hub';

