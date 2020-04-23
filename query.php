<form>
    <h4>Поиск по резюме и навыкам</h4>
    <input type="search" name="text" value="" placeholder="Поиск по резюме и навыкам" autocomplete="off" class="bloko-input
                      HH-QueryLength-Observed                       HH-SearchFromSuggest-Suggest
                                  HH-FirstPageTabs-Vacancies-Keyword
                                      HH-KeySkillsObserver-PositionInput" data-qa="resumes-search-wizard-item-keyword">




    <h4>Зарплата</h4>
    <span>От </span>
    <input  data-name="salary_from" name="salary_from" value="" class="Bloko-FormattedNumericInput-Hidden
    HH-Search-MoneyInput-Input">
    <span>До </span>
    <input  data-name="salary_to" name="salary_to" value="" class="Bloko-FormattedNumericInput-Hidden
    HH-Search-MoneyInput-Input">

    <h4>Требуемый опыт работы</h4>
    <span>Нет опыта </span>
    <input data-qa="resumesearch__experience-item resumesearch__experience-item_noExperience" type="checkbox"
           value="noExperience" name="experience" class="bloko-checkbox__input ">
    <span>От 1 года до 3 лет </span>
    <input data-qa="resumesearch__experience-item resumesearch__experience-item_between1And3" type="checkbox"
           value="between1And3" name="experience" class="bloko-checkbox__input ">
    <span>От 3 до 6 лет</span>
    <input data-qa="resumesearch__experience-item resumesearch__experience-item_between3And6" type="checkbox"
           value="between3And6" name="experience" class="bloko-checkbox__input ">
    <span>Более 6 лет </span>
    <input data-qa="resumesearch__experience-item resumesearch__experience-item_moreThan6" type="checkbox"
           value="moreThan6" name="experience" class="bloko-checkbox__input ">






    <h4>Образование</h4>
    <select class="bloko-select HH-InstitutionSelector-Select"
            name="education" data-qa="resumesearch__select-edu"><option value="none">Не имеет значения</option>
        <option value="higher">Высшее</option><option value="bachelor">Бакалавр</option><option value="master">Магистр</option>
        <option value="candidate">Кандидат наук</option><option value="doctor">Доктор наук</option>
        <option value="unfinished_higher">Незаконченное высшее</option><option value="secondary">Среднее</option>
        <option value="special_secondary">Среднее специальное</option></select>


    <h4>Возраст</h4>
    <span>От </span>
    <input name="age_from" value="" class="bloko-input                           bloko-input_sized
    HH-AgeSelect-From" size="5" type="text" data-qa="resumes-search-age_from">
    <span>До </span>
    <input name="age_to" value="" class="bloko-input                           bloko-input_sized
    HH-AgeSelect-To" size="5" type="text" data-qa="resumes-search-age_to">


    <h4>Пол</h4>
    <span>Не имеет значения </span>
    <input data-qa="resumesearch__gender-item resumesearch__gender-item_unknown" type="radio"
                           value="unknown" name="gender" class="bloko-radio__input HH-GenderInputs-Field" checked="">
    <span>Мужской </span>
    <input data-qa="resumesearch__gender-item resumesearch__gender-item_male" type="radio"
                           value="male" name="gender" class="bloko-radio__input HH-GenderInputs-Field">
    <span>Женский </span>
    <input data-qa="resumesearch__gender-item resumesearch__gender-item_female" type="radio"
                           value="female" name="gender" class="bloko-radio__input HH-GenderInputs-Field">



    <h4>Тип занятости</h4>
    <span>Полная занятость </span>
    <input data-qa="resumesearch__employment-item resumesearch__employment-item_full" type="checkbox"
           value="full" name="employment" class="bloko-checkbox__input ">
    <span>Частичная занятость </span>
    <input data-qa="resumesearch__employment-item resumesearch__employment-item_part" type="checkbox"
           value="part" name="employment" class="bloko-checkbox__input ">
    <span>Проектная/Временная работа </span>
    <input data-qa="resumesearch__employment-item resumesearch__employment-item_project" type="checkbox"
           value="project" name="employment" class="bloko-checkbox__input ">
    <span>Волонтерство </span>
    <input data-qa="resumesearch__employment-item resumesearch__employment-item_volunteer" type="checkbox"
           value="volunteer" name="employment" class="bloko-checkbox__input ">
    <span>Стажировка </span>
    <input data-qa="resumesearch__employment-item resumesearch__employment-item_probation" type="checkbox"
           value="probation" name="employment" class="bloko-checkbox__input ">






    <h4>График работы</h4>
    <span>Полный день </span>
    <input data-qa="resumesearch__schedule-item resumesearch__schedule-item_fullDay" type="checkbox"
           value="fullDay" name="schedule" class="bloko-checkbox__input ">
    <span>Сменный график </span>
    <input data-qa="resumesearch__schedule-item resumesearch__schedule-item_shift" type="checkbox"
           value="shift" name="schedule" class="bloko-checkbox__input ">
    <span>Гибкий график </span>
    <input data-qa="resumesearch__schedule-item resumesearch__schedule-item_flexible" type="checkbox"
           value="flexible" name="schedule" class="bloko-checkbox__input ">
    <span>Удаленная работа </span>
    <input data-qa="resumesearch__schedule-item resumesearch__schedule-item_remote" type="checkbox"
           value="remote" name="schedule" class="bloko-checkbox__input ">
    <span>Вахтовый метод </span>
    <input data-qa="resumesearch__schedule-item resumesearch__schedule-item_flyInFlyOut" type="checkbox"
           value="flyInFlyOut" name="schedule" class="bloko-checkbox__input ">


    <h4>Личный автомобиль</h4>
    <input data-qa="resumesearch__label resumesearch__label_only_with_vehicle" type="checkbox"
           value="only_with_vehicle" name="label" class="bloko-checkbox__input ">


    <h4>Категория прав</h4>
    <span>A </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_A" type="checkbox"
           value="A" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-A">
    <span>B </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_B" type="checkbox"
           value="B" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-B">
    <span>C </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_C" type="checkbox"
           value="C" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-C">
    <span>D </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_D" type="checkbox"
           value="D" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-D">
    <span>E </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_E" type="checkbox"
           value="E" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-E">
    <span>BE </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_BE" type="checkbox"
           value="BE" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-BE">
    <span>CE </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_CE" type="checkbox"
           value="CE" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-CE">
    <span>DE </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_DE" type="checkbox"
           value="DE" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-DE">
    <span>TM </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_TM" type="checkbox"
           value="TM" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-TM">
    <span>TB </span>
    <input data-qa="resumesearch__driver-license-types-item resumesearch__driver-license-types-item_TB" type="checkbox"
           value="TB" name="driver_license_types" class="bloko-button-check-helper" id="driver_license_types-TB">





<!--    <select class="bloko-select-->
<!--    HH-LanguageSelect-Select" data-qa="resumesearch__select-language-name">-->
<!--        <option value="eng">Английский</option><option value="deu">Немецкий</option>-->
<!--        <option value="fra">Французский</option><option value="" disabled=""></option>-->
<!--        <option value="abq">Абазинский</option><option value="abk">Абхазский</option>-->
<!--        <option value="ava">Аварский</option><option value="aze">Азербайджанский</option>-->
<!--        <option value="sqi">Албанский</option><option value="amh">Амхарский</option>-->
<!--        <option value="ara">Арабский</option><option value="hye">Армянский</option>-->
<!--        <option value="afr">Африкаанс</option><option value="eus">Баскский</option>-->
<!--        <option value="bak">Башкирский</option><option value="bel">Белорусский</option>-->
<!--        <option value="ben">Бенгальский</option><option value="mya">Бирманский</option>-->
<!--        <option value="bul">Болгарский</option><option value="bos">Боснийский</option>-->
<!--        <option value="bua">Бурятский</option><option value="hun">Венгерский</option>-->
<!--        <option value="vie">Вьетнамский</option><option value="nld">Голландский</option>-->
<!--        <option value="ell">Греческий</option><option value="kat">Грузинский</option>-->
<!--        <option value="dag">Дагестанский</option><option value="dar">Даргинский</option>-->
<!--        <option value="dan">Датский</option><option value="heb">Иврит</option>-->
<!--        <option value="inh">Ингушский</option><option value="ind">Индонезийский</option>-->
<!--        <option value="gle">Ирландский</option><option value="isl">Исландский</option>-->
<!--        <option value="spa">Испанский</option><option value="ita">Итальянский</option>-->
<!--        <option value="kbd">Кабардино-черкесский</option><option value="kaz">Казахский</option>-->
<!--        <option value="krc">Карачаево-балкарский</option><option value="krl">Карельский</option>-->
<!--        <option value="cat">Каталанский</option><option value="kas">Кашмирский</option>-->
<!--        <option value="zho">Китайский</option><option value="kom">Коми</option>-->
<!--        <option value="kor">Корейский</option><option value="crs">Креольский (Сейшельские острова)</option>-->
<!--        <option value="kum">Кумыкский</option><option value="kur">Курдский</option>-->
<!--        <option value="khm">Кхмерский (Камбоджийский)</option><option value="kir">Кыргызский</option>-->
<!--        <option value="lbe">Лакский</option><option value="lao">Лаосский</option>-->
<!--        <option value="lat">Латинский</option><option value="lav">Латышский</option>-->
<!--        <option value="lez">Лезгинский</option><option value="lit">Литовский</option>-->
<!--        <option value="mke">Македонский</option><option value="zlm">Малазийский</option>-->
<!--        <option value="mns">Мансийский</option><option value="chm">Марийский</option>-->
<!--        <option value="mon">Монгольский</option><option value="nep">Непальский</option>-->
<!--        <option value="nog">Ногайский</option><option value="nor">Норвежский</option>-->
<!--        <option value="oss">Осетинский</option><option value="pan">Панджаби</option>-->
<!--        <option value="fas">Персидский</option><option value="pol">Польский</option>-->
<!--        <option value="por">Португальский</option><option value="pus">Пушту</option>-->
<!--        <option value="ron">Румынский</option><option value="rus">Русский</option>-->
<!--        <option value="san">Санскрит</option><option value="srp">Сербский</option>-->
<!--        <option value="slk">Словацкий</option><option value="slv">Словенский</option>-->
<!--        <option value="som">Сомалийский</option><option value="swa">Суахили</option>-->
<!--        <option value="tgl">Тагальский</option><option value="tgk">Таджикский</option>-->
<!--        <option value="tha">Тайский</option><option value="tly">Талышский</option>-->
<!--        <option value="tam">Тамильский</option><option value="tat">Татарский</option>-->
<!--        <option value="bod">Тибетский</option><option value="tyv">Тувинский</option>-->
<!--        <option value="tur">Турецкий</option><option value="tuk">Туркменский</option>-->
<!--        <option value="udm">Удмуртский</option><option value="uzb">Узбекский</option>-->
<!--        <option value="uig">Уйгурский</option><option value="ukr">Украинский</option>-->
<!--        <option value="urd">Урду</option><option value="fin">Финский</option>-->
<!--        <option value="vls">Фламандский</option><option value="hin">Хинди</option>-->
<!--        <option value="hrv">Хорватский</option><option value="che">Чеченский</option>-->
<!--        <option value="ces">Чешский</option><option value="chv">Чувашский</option>-->
<!--        <option value="swe">Шведский</option><option value="epo">Эсперанто</option>-->
<!--        <option value="est">Эстонский</option><option value="sah">Якутский</option>-->
<!--        <option value="jpn">Японский</option></select>-->
<!---->
<!---->
<!---->
<!--    <select class="bloko-select-->
<!--    HH-LanguageSelect-DegreeSelect" data-qa="resumesearch__select-language-level">-->
<!--        <option value="does_not_matter">Не имеет значения</option>-->
<!--        <option value="a1">A1 — Начальный</option>-->
<!--        <option value="a2">A2 — Элементарный</option>-->
<!--        <option value="b1">B1 — Средний</option>-->
<!--        <option value="b2">B2 — Средне-продвинутый</option>-->
<!--        <option value="c1">C1 — Продвинутый</option>-->
<!--        <option value="c2">C2 — В совершенстве</option>-->
<!--        <option value="l1">Родной</option></select>-->
<!---->
<!---->
<!--    <input type="hidden" name="language" class="HH-LanguageSelect-Value" value="eng.does_not_matter" >-->





    <p><input type="submit" class="bloko-button bloko-button_large bloko-button_primary bloko-button_stretched"
           value="Найти" data-qa="resumes-search-submit">
    </p>

</form>

<?php
require "vendor/autoload.php";
require "Common.php";
require "CommonBot.php";
require "SeleniumBot.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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

$request_text = $_REQUEST;
foreach ($request_text as $key=>$value) {
    if (empty($value)) {
        unset($request_text[$key]);
    }
}
$request_text = json_encode($request_text);

$request_url = 'https://hh.ru/search/resume?';
foreach ($_REQUEST as $key=>$value) {
    $request_url .= $key . '=' . $value . '&';
}

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

$request_url = 'https://hh.ru/search/resume?';
foreach ($_REQUEST as $key=>$value) {
    $request_url .= $key . '=' . $value . '&';
}
$request_url = $request_url . 'area=1&items_on_page=100';
//var_dump($request_url);

$fld=date('Y-m-d-H-i-s');
mkdir('files/query/'.$fld,  0777, true);
$dir = 'files/query/'.$fld;

$z = new SeleniumBot($params);
$fn=$z->hh_query($request_url, $fld, $dir, $new_id);
//$fn='files/query/2020-04-23-15-06-46/hh_query_1.txt';
//$ar=$z->hh_query_parse($dir);
