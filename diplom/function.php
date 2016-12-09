<?php
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.

if (isset($_POST['site'])) {
		
		$site = ($_POST['site']);
		$param = ($_POST['param']);
		$text = ($_POST['content']);
		$cena = ($_POST['cena']);
		$vremya = ($_POST['vremya']);
		$i = ($_POST['iter']);
		//getAllIndex ($site, $param, $text, $cena, $vremya);
		
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		writeRow ($site, $param, $cena, $vremya);
		getYAP($site, $text);
		echo '<td>D</td>';
		//getYAL($site, $text);
		getGP($site, $text);
		getGL($site, $text);
		echo '<td><input type="checkbox" value='.$value['Id'].' form="delurl" /></td>';
		echo '</tr>';
}


function getAllIndex ($site, $param, $text, $cena, $vremya) {
		echo '<tr>';
		writeRow ($site, $param, $text, $cena, $vremya);
		getYAP($site, $text);
		getYAL($site, $text);
		getGP($site, $text);
		getGL($site, $text);
		echo '</tr>';
}

function writeRow ($site, $param, $cena, $vremya) {
		$wert = ('<td>'.$site.'</td><td>'.$param.'</td><td>'.$cena.'</td><td>'.$vremya.'</td>');
		echo $wert;
}

function getYAP($site, $text) {
	
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 0;
		$content = @file_get_contents("http://api.megaindex.ru/scan_yandex_page_index?".http_build_query($array));    //запрос индексации страницы в яндексе
        $json = json_decode($content);
         if( !is_object($json) ){
            echo '<td>Не удалось разобрать данные</td>';
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        echo '<td>'.$res.'</td>';
		} else {
			echo ($json->data) ? "<td>+</td>" : "<td>-</td>";
		}
		
}

function getYAL($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 0;
		$content = @file_get_contents("http://api.megaindex.ru/scan_yandex_link_index?".http_build_query($array));    //запрос индексации ссылки в яндексе
        $json = json_decode($content);
         if( !is_object($json) ){
            echo '<td>Не удалось разобрать данные</td>';
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        echo '<td>'.$res.'</td>';
		} else {
			echo ($json->data) ? "<td>+</td>" : "<td>-</td>";
		}
}		

function getGP($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 0;
		$content = @file_get_contents("http://api.megaindex.ru/scan_google_page_index?".http_build_query($array));    //запрос индексации страницы в гугле
		$json = json_decode($content);
         if( !is_object($json) ){
            echo '<td>Не удалось разобрать данные</td>';
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        echo '<td>'.$res.'</td>';
		} else {
			echo ($json->data) ? "<td>+</td>" : "<td>-</td>";
		}
}
		
function getGL($site, $text) {
		
		$array = array();
        $array["user"] = 'smartinetseo@gmail.com';
        $array["password"] = 'Dfnheirf';
        $array["lr"] = "213"; //регион
		$array["request"] = $text; //проверяемый запрос на индекс
        $array["url"] = $site;	
        $array["imp"] = 0;
		$content = @file_get_contents("http://api.megaindex.ru/scan_google_link_index?".http_build_query($array));    //запрос индексации ссылки в гугле
		$json = json_decode($content);
         if( !is_object($json) ){
            echo '<td>Не удалось разобрать данные</td>';
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        echo '<td>'.$res.'</td>';
		} else {
			echo ($json->data) ? "<td>+</td>" : "<td>-</td>";
		}
}


function getLinksJson ($arra) {
		$json = json_encode($arra);	
		return $json;
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