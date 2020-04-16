<?
require "vendor/autoload.php";
require "Common.php";
require "CommonBot.php";
require "SeleniumBot.php";

function render($ar)
{
    foreach($ar as $k=>$v)
    {
        if (is_string($v)) {
            $v = str_replace("\r", '', $v);
            $v = str_replace("\n", '', $v);
            $v = str_replace(">", '', $v);
            $v = str_replace("<", '', $v);
            $v = str_replace("\"", '', $v);
            $v = str_replace("'", '', $v);
            $v = str_replace("Резюме обновлено", '', $v);

            $v = trim($v);

//            if (($k == 'phone') || ($k == 'email')) {
//                $v=str_replace('6','1',$v);
//                $v=str_replace('7','3',$v);
//                $v=str_replace('3','9',$v);
//                $v=str_replace('k','g',$v);
//                $v=str_replace('a','7',$v);
//                $v=str_replace('8','4',$v);
//            }
            if (($k != 'opit') && ($k != 'about')) {
                $ar[$k] = $v;
            }
        }
    }

    echo "<h2>{$ar['fio']}</h2>";

    echo '<table>';
    echo "<tr bgcolor='#a9a9a9'><td>Пол</td><td>{$ar["gender"]}</td></tr>";
    echo "<tr><td>Возраст</td><td>{$ar["age"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Город</td><td>{$ar["city"]} {$ar["pereezd"]} {$ar["comand"]}</td></tr>";
    echo "<tr><td>Дата рождения</td><td>{$ar["birth"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Резюме обновлено</td><td>{$ar["dat_update"]}</td></tr>";
    echo "<tr><td>Телефон</td><td>{$ar["phone"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>E-mail</td><td>{$ar["email"]}</td></tr>";
    echo "<tr><td>Skype</td><td>{$ar["skype"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Сайт</td><td>{$ar["site"]}</td></tr>";
    echo "<tr><td>Предпочтительный способ связи</td><td>{$ar["pref_conn"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Опыт</td><td>{$ar["opit_all"]}</td></tr>";
    echo "<tr><td>Позиция</td><td>{$ar["position"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Сфера деятельности</td><td>{$ar["activity_field"]}</td></tr>";
    echo "<tr><td>Специализация</td><td>{$ar["specialization"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Желаемая зарплата</td><td>{$ar["cost"]}</td></tr>";
    echo "<tr><td>Занятость</td><td>{$ar["occupation"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>График работы</td><td>{$ar["shedule"]}</td></tr>";

    echo "<tr><td>Гражданство</td><td>{$ar["citizen"]}</td></tr>";
    echo "<tr bgcolor='#a9a9a9'><td>Разрешение на работу</td><td>{$ar["work_perm"]}</td></tr>";
    echo "<tr><td>Желательное время в пути до работы</td><td>{$ar["time_to_work"]}</td></tr>";
    echo '</table>';

//    echo '<br>';
//    echo '<br>';
//    echo $ar['citizen'];
//    echo '<br>';
//    echo '<br>';
//    echo $ar['work_perm'];
//    echo '<br>';
//    echo '<br>';
//    echo $ar['time_to_work'];
//    echo '<br>';

    echo '<br>';
    echo '<b>'.'Обо мне:'.'</b>';
    echo '<br>';
    echo '<br>';
    echo str_replace("\n","<br>",$ar["about"]);
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Опыт работы'.'</b>';
    echo '<br>';

    echo '<table>';

    foreach($ar['opit'] as $item)
    {

        echo "<tr bgcolor='#ffe4c4'><td><nobr>{$item['last']}</nobr><br>{$item['period']}</td>";
        echo "<td>";
        echo "<b>".$item['nam']."</b><br>";
        echo $item['adres']."<br>";
        echo $item['ind']."<br>";
        echo $item['pod_ind']."<br>";
        echo $item['position']."<br>";
        echo $item['descr']."<br>";
        echo "</td></tr>";
    }
    echo '</table>';
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Ключевые навыки'.'</b>';
    echo '<br>';
    echo $ar['skills'];
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Опыт вождения'.'</b>';
    echo '<br>';
    echo $ar['driving'];
    echo '<br>';
    echo '<br>';

//    echo '<b>'.'Высшее образование'.'</b>';
//    echo '<br>';
//    echo 'Год - ';
//    echo $ar['high_ed']['year'];
//    echo '<br>';
//    echo 'Заведение - ';
//    echo $ar['high_ed']['inst'];
//    echo '<br>';
//    echo 'Специальность - ';
//    echo $ar['high_ed']['spez'];
//    echo '<br>';
//    echo '<br>';


    echo '<b>'.'Портфолио'.'</b>';
    echo '<br>';
    foreach ($ar['portfolio'] as $item) {
        echo $item;
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.$ar['educ_title'].'</b>';
    echo '<br>';
//    foreach ($ar['educ'] as $item) {
//        echo $item;
//        echo '<br>';
//    }

    foreach ($ar['educ'] as $item) {
        echo 'Год - ' . $item[0];
        echo '<br>';
        echo 'Заведение - ' . $item[1];
        echo '<br>';
        echo 'Отделение - ' . $item[2];
        echo '<br>';
        echo 'Специальность - ' . $item[3];
        echo '<br>';
        echo '<br>';
    }

    echo '<br>';
    echo '<br>';

    echo '<b>'.'Знание языков'.'</b>';
    echo '<br>';
    foreach ($ar['lang'] as $item) {
        echo $item;
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Повышение квалификации, курсы'.'</b>';
    echo '<br>';
    foreach ($ar['add_ed'] as $item) {
        echo 'Год - ' . $item[0];
        echo '<br>';
        echo 'Курс - ' . $item[1];
        echo '<br>';
        echo 'Компания - ' . $item[2];
        echo '<br>';
        echo 'Специальность - ' . $item[3];
        echo '<br>';
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Тесты, экзамены'.'</b>';
    echo '<br>';
    foreach ($ar['tests'] as $item) { echo 'Год - ' . $item[0];
        echo '<br>';
        echo 'Компания - ' . $item[1];
        echo '<br>';
        echo 'Отделение - ' . $item[2];
        echo '<br>';
        echo 'Предмет - ' . $item[3];
        echo '<br>';
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Электронные сертификаты'.'</b>';
    echo '<br>';
    foreach ($ar['certs'] as $item) {
        echo 'Сертификат - ' . $item[0];
        echo '<br>';
        echo 'Название - ' . $item[1];
        echo '<br>';
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.'Комментарии'.'</b>';
    echo '<br>';
    foreach ($ar['comments'] as $item) {
        echo $item[0];
        echo '<br>';
        echo 'Автор - ' . $item[1];
        echo '<br>';
        echo 'Дата - ' . $item[2];
        echo '<br>';
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';

    echo '<b>'.'История'.'</b>';
    echo '<br>';
    foreach ($ar['history'] as $item) {
        echo $item[0];
        echo '<br>';
        echo 'URL: ' . $item[1];
        echo '<br>';
        echo $item[2];
        echo '<br>';
        echo 'Дата - ' . $item[3];
        echo '<br>';
        echo '<br>';
    }
    echo '<br>';
    echo '<br>';


    exit;
}

$item['db_host']='localhost';
$item['db_name']='mycrm';
$item['db_user']='root';
$item['db_pass']='';


$db= 1; //new PDO("mysql:host={$item['db_host']};dbname={$item['db_name']};", $item['db_user'], $item['db_pass']);

$params['db']=$db;
$params['id_bot']=1;

if (isset($_REQUEST['url']))
{
    $z = new SeleniumBot($params);

    //echo "asd";

$z->getip();
$z->hhauth();
$fn=$z->hh_resume($_REQUEST['url']);
//    $fn='files/2020-04-15-19-54-54/hh_resume_1.txt';
$ar=$z->hh_resume_parse($fn);
render($ar);

//$z->hh_resume('https://hh.ru/resume/fa2ff3960007c47e2000437fd47a4176797333');
}
//$z->hh_resume('https://hh.ru/resume/5e5d21900005042bca00437fd4577674775372');

//$z->hh_resume_parse('files/2020-03-22-22-25-04/hh_resume_1.txt');


// $host = 'http://172.16.10.46:4444/wd/hub';

?>

<form>
    <h2>Введите URL резюме</h2>
    <input type="text" name="url">
    <input type="submit">
</form>
