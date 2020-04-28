<?php
require "vendor/autoload.php";
require "Common.php";
require "CommonBot.php";
require "SeleniumBot.php";

set_time_limit(0);
error_reporting(1 );

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$charset = getenv('DB_CHARSET');

$request_text = $_REQUEST;
foreach ($request_text as $key => $value) {
    if ($value == '') {
        unset($request_text[$key]);
    }
    if (is_array($value)) {
        if ($key == 'pos') {
            if (in_array('workplace_organization', $value) && in_array('workplace_position', $value) &&
                in_array('workplace_description', $value)) {
                unset($request_text[$key][array_search('workplace_organization', $value)]);
                unset($request_text[$key][array_search('workplace_position', $value)]);
                unset($request_text[$key][array_search('workplace_description', $value)]);
            } elseif (in_array('workplace_organization', $value) || in_array('workplace_position', $value)
                || in_array('workplace_description', $value)) {
                unset($request_text[$key][array_search('workplaces', $value)]);
            }
            $request_text[$key] = implode('%2C', $request_text[$key]);
        }
        if ($key == 'label') {
            $temp = $value[0];
            foreach ($value as $index => $item) {
                if ($index != 0) {
                    $temp .= '&label=' . $item;
                }
            }
            $request_text[$key] = $temp;
        }
        if ($key == 'exp_industry') {
            $a = [];
            foreach ($value as $item) {
                if (strpos($item, '.')) {
                    $b = explode('.', $item);
                    array_push($a, $b[0]);
                }
            }
            foreach ($a as $item) {
                if (array_search($item, $value) !== false) {
                    unset($request_text[$key][array_search($item, $value)]);
                }
            }
            $request_text[$key] = implode('%2C', $request_text[$key]);
        }
        if ($key == 'specialization') {
            $a = [];
            foreach ($value as $item) {
                if (strpos($item, '.')) {
                    $b = explode('.', $item);
                    array_push($a, $b[0]);
                }
            }
            foreach ($a as $item) {
                if (array_search($item, $value) !== false) {
                    unset($request_text[$key][array_search($item, $value)]);
                }
            }
            $temp = $value[0];
            foreach ($request_text[$key] as $index => $item) {
                if ($index != 0) {
                    $temp .= '&specialization=' . $item;
                }
            }
            $request_text[$key] = $temp;
        }
        if ($key == 'area') {
            $temp = $value[0];
            foreach ($value as $index => $item) {
                if ($index != 0) {
                    $temp .= '&area=' . $item;
                }
            }
            $request_text[$key] = $temp;
        }
    }
}
if (!array_key_exists('exp_industry', $request_text)) {
    $request_text['exp_industry'] = 'any';
}

$request_url = 'https://hh.ru/search/resume?';

foreach ($request_text as $key=>$value) {
    $request_url .= $key . '=' . $value . '&';
}

$request_url = $request_url . 'items_on_page=100';

$request_text = json_encode($request_text);


$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$stmt = $pdo->prepare(
    'INSERT INTO hh_query 
(text, url, date)  
VALUES (:text, :url, :date)'
);
$stmt->execute(
    array(
        'text' => $request_text,
        'url' => $request_url,
        'date' => date("Y-m-d H:i:s"),
    )
);

$new_id = $pdo->lastInsertId();

$db= 1;
$params['db']=$db;
$params['id_bot']=1;

$fld=date('Y-m-d-H-i-s');
mkdir('files/query/'.$fld,  0777, true);
$dir = 'files/query/'.$fld;
//var_dump($request_url);exit();
$z = new SeleniumBot($params);
$fn=$z->hh_query($request_url, $fld, $dir, $new_id);
//$fn='files/query/2020-04-23-15-06-46/hh_query_1.txt';
//$ar=$z->hh_query_parse($dir);

