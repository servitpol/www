<?php
//http://savvateev.org/blog/31/ - обход огрнаичения одновременного кол-ва запросов

if (isset($_POST['site'])) {  //перехватывает аякс
		$name = $_POST['name'];
		$site = 'http://'.$_POST['site'];
		$param = ($_POST['param']);
		$text = ($_POST['content']);
		$cena = ($_POST['cena']);
		$vremya = ($_POST['vremya']);
		$i = ($_POST['iter']);
		$yap = getYAP($site, $text);
		//$yal = getYAL($site, $text);
		$gp = getGP($site, $text);
		$gl = getGL($site, $text);
		
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		writeRow ($site, $param, $cena, $vremya);
		echo '<td>'.$yap.'</td>';
		//echo '<td>'.$yap.'D</td>';
		echo '<td>D</td>';
		echo '<td>'.$gp.'</td>';
		echo '<td>'.$gl.'</td>';
		echo '<td><input type="checkbox" value='.$value['Id'].' form="delurl" /></td>';
		echo '</tr>';

		$res = array($site.';'.$param.';'.$text.';'.$cena.';'.$yap.';'.$gp.';'.$gl);
		$fp = fopen('file'.$name.'.csv', 'a+');
		fwrite($fp,b"\xEF\xBB\xBF" );
		fputcsv($fp, $res, ";", " ");
		fclose($fp);
}




function writeRow ($site, $param, $cena, $vremya) { //рисует колонки в таблице
		$wert = ('<td>'.$site.'</td><td>'.$param.'</td><td>'.$cena.'</td><td>'.$vremya.'</td>');
		echo $wert;
}

function getYAP($site, $text) {  //яндекс страницы
	
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
            $res = 'Не удалось разобрать данные';
			return $res;
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        return $res;
		} else {
			if($json->data) {
			$res =	'1';
			return $res;
			} else {				
			$res = '0';
			return $res;
		}
		
}
}

function getYAL($site, $text) {		//яндекс ссылка
		
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
            $res = 'Не удалось разобрать данные';
			return $res;
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        return $res;
		} else {
			if($json->data) {
			$res =	'1';
			return $res;
			} else {				
			$res = '0';
			return $res;
		}
}
}		

function getGP($site, $text) {		//гугл страница
		
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
            $res = 'Не удалось разобрать данные';
			return $res;
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        return $res;
		} else {
			if($json->data) {
			$res =	'1';
			return $res;
			} else {				
			$res = '0';
			return $res;
		}
}
}
	
function getGL($site, $text) {		//гугл ссылка
		
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
            $res = 'Не удалось разобрать данные';
			return $res;
		} else if ($json->status != 0) {
        $res = $json->err_msg;
        return $res;
		} else {
			if($json->data) {
			$res =	'1';
			return $res;
			} else {				
			$res = '0';
			return $res;
		}
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