<?
require "vendor/autoload.php";
require "Common.php";
require "CommonBot.php";
require "SeleniumBot.php";

function render($ar)
{
//    var_dump($ar);exit();

    foreach ($ar as $k => $v) {
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


    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $charset = getenv('DB_CHARSET');

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $opt);

    $pdo->beginTransaction();
    try {

        //----------------------------------------------------------

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


        echo '<br>';
        echo '<b>' . 'Обо мне:' . '</b>';
        echo '<br>';
        echo '<br>';
        echo str_replace("\n", "<br>", $ar["about"]);
        echo '<br>';
        echo '<br>';


        $stmt = $pdo->prepare(
            'INSERT INTO hh_ankets 
(fio, gender, age, birth, city, phone, email, pref_conn, skype, site, position, activity_field, specialization, cost, 
occupation, shedule, opit_all, pereezd, comand, dat_update, about, skills, driving, citizen, work_perm, time_to_work)  
VALUES (:fio, :gender, :age, :birth, :city, :phone, :email, :pref_conn, :skype, :site, :position, :activity_field, 
:specialization, :cost, :occupation, :shedule, :opit_all, :pereezd, :comand, :dat_update, :about, :skills, :driving,
:citizen, :work_perm, :time_to_work)'
        );
        $stmt->execute(
            array(
                'fio' => $ar['fio'],
                'gender' => $ar['gender'],
                'age' => $ar['age'],
                'birth' => $ar['birth'],
                'city' => $ar['city'],
                'phone' => $ar['phone'],
                'email' => $ar['email'],
                'pref_conn' => $ar['pref_conn'],
                'skype' => $ar['skype'],
                'site' => $ar['site'],
                'position' => $ar['position'],
                'activity_field' => $ar['activity_field'],
                'specialization' => $ar['specialization'],
                'cost' => $ar['cost'],
                'occupation' => $ar['occupation'],
                'shedule' => $ar['shedule'],
                'opit_all' => $ar['opit_all'],
                'pereezd' => $ar['pereezd'],
                'comand' => $ar['comand'],
                'dat_update' => $ar['dat_update'],
                'about' => $ar['about'],
                'skills' => $ar['skills'],
                'driving' => $ar['driving'],
                'citizen' => $ar['citizen'],
                'work_perm' => $ar['work_perm'],
                'time_to_work' => $ar['time_to_work'],
            )
        );

        $new_id = $pdo->lastInsertId();

        //----------------------------------------------------------

        echo '<b>' . 'Опыт работы' . '</b>';
        echo '<br>';

        echo '<table>';

        foreach ($ar['opit'] as $item) {
            echo "<tr bgcolor='#ffe4c4'><td><nobr>{$item['last']}</nobr><br>{$item['period']}</td>";
            echo "<td>";
            echo "<b>" . $item['nam'] . "</b><br>";
            echo $item['adres'] . "<br>";
            echo $item['ind'] . "<br>";
            echo $item['pod_ind'] . "<br>";
            echo $item['position'] . "<br>";
            echo $item['descr'] . "<br>";
            echo "</td></tr>";

            $stmt = $pdo->prepare(
                'INSERT INTO hh_opit 
(id_ank, last, period, nam, ind, pod_ind, adres, position, descr)  
VALUES (:id_ank, :last, :period, :nam, :ind, :pod_ind, :adres, :position, :descr)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'last' => $item['last'],
                    'period' => $item['period'],
                    'nam' => $item['nam'],
                    'ind' => $item['ind'],
                    'pod_ind' => $item['pod_ind'],
                    'adres' => $item['adres'],
                    'position' => $item['position'],
                    'descr' => $item['descr'],
                )
            );
        }
        echo '</table>';
        echo '<br>';
        echo '<br>';


        //----------------------------------------------------------


        echo '<b>' . 'Ключевые навыки' . '</b>';
        echo '<br>';
        echo $ar['skills'];
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Опыт вождения' . '</b>';
        echo '<br>';
        echo $ar['driving'];
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Портфолио' . '</b>';
        echo '<br>';
        foreach ($ar['portfolio'] as $item) {
            echo $item;
            echo '<br>';

            $stmt = $pdo->prepare(
                'INSERT INTO hh_portfolio 
(id_ank, name)  
VALUES (:id_ank, :name)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'name' => $item,
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . $ar['educ_title'] . '</b>';
        echo '<br>';
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

            $stmt = $pdo->prepare(
                'INSERT INTO hh_educ 
(id_ank, year, name, org, spec)  
VALUES (:id_ank, :year, :name, :org, :spec)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'year' => $item[0],
                    'name' => $item[1],
                    'org' => $item[2],
                    'spec' => $item[3],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Знание языков' . '</b>';
        echo '<br>';
        foreach ($ar['lang'] as $item) {
            echo $item;
            echo '<br>';

            $stmt = $pdo->prepare(
                'INSERT INTO hh_lang 
(id_ank, lang)  
VALUES (:id_ank, :lang)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'lang' => $item,
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Повышение квалификации, курсы' . '</b>';
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

            $stmt = $pdo->prepare(
                'INSERT INTO hh_added 
(id_ank, year, name, org, spec)  
VALUES (:id_ank, :year, :name, :org, :spec)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'year' => $item[0],
                    'name' => $item[1],
                    'org' => $item[2],
                    'spec' => $item[3],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Тесты, экзамены' . '</b>';
        echo '<br>';
        foreach ($ar['tests'] as $item) {
            echo 'Год - ' . $item[0];
            echo '<br>';
            echo 'Компания - ' . $item[1];
            echo '<br>';
            echo 'Отделение - ' . $item[2];
            echo '<br>';
            echo 'Предмет - ' . $item[3];
            echo '<br>';
            echo '<br>';


            $stmt = $pdo->prepare(
                'INSERT INTO hh_tests 
(id_ank, year, name, otdel, spec)  
VALUES (:id_ank, :year, :name, :otdel, :spec)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'year' => $item[0],
                    'name' => $item[1],
                    'otdel' => $item[2],
                    'spec' => $item[3],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Электронные сертификаты' . '</b>';
        echo '<br>';
        foreach ($ar['certs'] as $item) {
            echo 'Сертификат - ' . $item[0];
            echo '<br>';
            echo 'Название - ' . $item[1];
            echo '<br>';
            echo '<br>';

            $stmt = $pdo->prepare(
                'INSERT INTO hh_certs 
(id_ank, link, name)  
VALUES (:id_ank, :link, :name)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'link' => $item[0],
                    'name' => $item[1],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'Комментарии' . '</b>';
        echo '<br>';
        foreach ($ar['comments'] as $item) {
            echo $item[0];
            echo '<br>';
            echo 'Автор - ' . $item[1];
            echo '<br>';
            echo 'Дата - ' . $item[2];
            echo '<br>';
            echo '<br>';

            $stmt = $pdo->prepare(
                'INSERT INTO hh_comments 
(id_ank, text, comm_author, comm_date)  
VALUES (:id_ank, :text, :comm_author, :comm_date)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'text' => $item[0],
                    'comm_author' => $item[1],
                    'comm_date' => $item[2],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        //----------------------------------------------------------

        echo '<b>' . 'История' . '</b>';
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

            $stmt = $pdo->prepare(
                'INSERT INTO hh_history 
(id_ank, text, href, hist_type, hist_date)  
VALUES (:id_ank, :text, :href, :hist_type, :hist_date)'
            );
            $stmt->execute(
                array(
                    'id_ank' => $new_id,
                    'text' => $item[0],
                    'href' => $item[1],
                    'hist_type' => $item[2],
                    'hist_date' => $item[3],
                )
            );
        }
        echo '<br>';
        echo '<br>';

        $pdo->commit();

        exit;

    } catch (\Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


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

//$z->getip();
//$z->hhauth();
//$fn=$z->hh_resume($_REQUEST['url']);
//    $fn='files/2020-04-09-13-32-11/hh_resume_1.txt';
    $fn='files/2020-04-16-12-17-58/hh_resume_1.txt';
$ar=$z->hh_resume_parse($fn);
render($ar);
}

// $host = 'http://172.16.10.46:4444/wd/hub';

?>

<form>
    <h2>Введите URL резюме</h2>
    <input type="text" name="url">
    <input type="submit">
</form>
