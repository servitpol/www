<?php
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.
if (isset($_POST['site'])) {
		
		$site = ($_POST['site']);
		$param = ($_POST['param']);
		$text = ($_POST['content']);
		$cena = ($_POST['cena']);
		$vremya = ($_POST['vremya']);
		getAllIndex ($site, $param, $text, $cena, $vremya);

}

function getAllIndex ($site, $param, $text, $cena, $vremya) {
		//первая часть ф-ции вызывает ф-ции обращения к api и рисует необрабатываемые данные этим скриптом
		$myarr = array();
		$myarr[0] = '</tr><td>'.$site.'</td>';
		$myarr[1] = '<td>'.$param.'</td>';
		$myarr[2] = '<td>'.$text.'</td>';
		$myarr[3] = '<td>'.$cena.'</td>';
		$myarr[4] = '<td>'.$vremya.'</td>';
		echo '<tr>';
		writeRow ($site, $param, $text, $cena, $vremya);
		$myarr[5] = getYAP($site, $text);
		$myarr[6] = getYAL($site, $text);
		$myarr[7] = getGP($site, $text);
		$myarr[8] = getGL($site, $text).'</tr>';
		//echo '</tr>';
		
		//вторая часть ф-ции записывает полученные данные в файл

		$fp = fopen('counter.txt', 'a+');
		foreach ($myarr as $output)
		{
		fwrite($fp, $output."\r\n");
		}
		
}

function writeRow ($site, $param, $text, $cena, $vremya) {
		$wert = ('<td>'.$site.'</td><td>'.$param.'</td><td>'.$text.'</td><td>'.$cena.'</td><td>'.$vremya.'</td>');
		echo $wert;
}

function getYAP($site, $text) {
	
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$aaaaa = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 1;
		$content = @file_get_contents("http://api.megaindex.ru/scan_yandex_page_index?".http_build_query($array));    //запрос индексации страницы в яндексе
        $json = json_decode($content);
         if( !is_object($json) ){
            return '<td>Не удалось разобрать данные</td>';
			ob_flush();
			flush();
        } else if ($json->status != 0) {
        return $json->err_msg;
		ob_flush();
		flush();
	    } else {
			return ($json->data) ? "<td>+</td>" : "<td>-</td>";
		ob_flush();
		flush();
		}
		
}

function getYAL($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 1;
		$content = @file_get_contents("http://api.megaindex.ru/scan_yandex_link_index?".http_build_query($array));    //запрос индексации ссылки в яндексе
        $json = json_decode($content);
         if( !is_object($json) ){
            return '<td>Не удалось разобрать данные</td>';
			ob_flush();
			flush();
        } else if ($json->status != 0) {
        return $json->err_msg;
		ob_flush();
		flush();
	    } else {
			return ($json->data) ? "<td>+</td>" : "<td>-</td>";
		ob_flush();
		flush();
		}
}		

function getGP($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$aaaaa = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 1;
		$content = @file_get_contents("http://api.megaindex.ru/scan_google_page_index?".http_build_query($array));    //запрос индексации страницы в гугле
		$json = json_decode($content);
         if( !is_object($json) ){
            return '<td>Не удалось разобрать данные</td>';
			ob_flush();
			flush();
        } else if ($json->status != 0) {
        return $json->err_msg;
		ob_flush();
		flush();
	    } else {
			return ($json->data) ? "<td>+</td>" : "<td>-</td>";
		ob_flush();
		flush();
		}
}
		
function getGL($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 1;
		$content = @file_get_contents("http://api.megaindex.ru/scan_google_link_index?".http_build_query($array));    //запрос индексации ссылки в гугле
		$json = json_decode($content);
         if( !is_object($json) ){
            return '<td>Не удалось разобрать данные</td>';
			ob_flush();
			flush();
        } else if ($json->status != 0) {
        return $json->err_msg;
		ob_flush();
		flush();
	    } else {
			return ($json->data) ? "<td>+</td>" : "<td>-</td>";
		ob_flush();
		flush();
		}
}

if(isset($_GET['projectchek'])) {
	$filename = ($_GET['file']);
	$projectname = ($_GET['projectchek']);
	echo $projectname.'</br>';

	
	$fpa = 'counter.txt';
	$site = file($fpa);
	$site = array_diff($site, array("\r\n")); //удаляем пустые строки
	$content = implode(";", $site);
	$countfile = ($_GET['count']);

	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "cheks";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	
	$result = mysql_query ("INSERT INTO ".$db_table." (project, filename, count, date, content) VALUES ('$projectname', '$filename', '$countfile', NOW(), '$content')");
	if ($result = 'true'){
				echo '<div class="project-status">'; 
				echo "Проект успешно создан!";
				header('Location: cheks.php?project='.$projectname.'');
			}else{
				echo '<div class="project-status">'; 
				echo "Ошибка!";
			}
}

if(isset($_GET['delete'])) {
	$iddelete = $_GET['delete'];
	$projectname = ($_GET['project']);
	
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "cheks";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	
	$result = mysql_query ("DELETE FROM ".$db_table." WHERE `id` = $iddelete");
	//DELETE FROM ".$db_table." WHERE `id` = $iddelete
	if ($result = 'true'){
				header('Location: cheks.php?project='.$projectname.'');
			}else{
				echo '<div class="project-status">'; 
				echo "Ошибка!";
			}
}

if(isset($_GET['del'])) {
	$iddelete = $_GET['del'];
	$projectname = ($_GET['project']);
	
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "projects";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	
	$result = mysql_query ("DELETE FROM ".$db_table." WHERE `id` = $iddelete");
	//DELETE FROM ".$db_table." WHERE `id` = $iddelete
	if ($result = 'true'){
				echo '<div class="project-status">'; 
				echo "Проект успешно создан!";
				header('Location: project.php');
			}else{
				echo '<div class="project-status">'; 
				echo "Ошибка!";
			}
}

?>
<?php
include "lib/nusoap.php";
		
//echo "<pre>";

$advert_url = "http://api.mainlink.ru/seo.asmx?WSDL"; 
$login_url = "http://api.mainlink.ru/start.asmx?WSDL";
$login = new nusoap_client($login_url, true); 
$advert = new nusoap_client($advert_url, true); 
$login->setUseCurl(1); 
$login->call('sys_LogIn', array('Login' => 'smartinetseo', 'Password' => 'Dfnheirf', 'PrivateKey' => 'bb99405f-92a5-4dd9-8bb8-96b6153c13e5')); 

$cookies = $login->getCookies(); 
foreach ($cookies as $cookie) 
{ 
$advert->setCookie($cookie['name'], $cookie['value']); 
}
/* 
POST /seo.asmx HTTP/1.1
Host: api.mainlink.ru
Content-Type: text/xml; charset=utf-8
Content-Length: length
SOAPAction: "http://api.mainlink.ru/LinkGet"

<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <LinkGet xmlns="http://api.mainlink.ru/">
      <id>int</id>
    </LinkGet>
  </soap:Body>
</soap:Envelope>
*/
//$projects = $advert->call('LinksGet', array('page' => 4231715));
//var_dump($projects);

?>