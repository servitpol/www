<?php
$advert_url = "http://api.mainlink.ru/advert.asmx?WSDL"; 
$login_url = "http://api.mainlink.ru/start.asmx?WSDL";
$login = new nusoap_client($login_url, true); 
$advert = new nusoap_client($advert_url, true); 
$login->setUseCurl(1); 
$login->call('sys_LogIn', array('Login' => 'smartinetseo', 'Password' => 'Dfnheirf', 'PrivateKey' => 'bb99405f-92a5-4dd9-8bb8-96b6153c13e5')); 
$balance = $login->call('sys_Balance', array()); 
$cookies = $login->getCookies(); 
foreach ($cookies as $cookie) 
{ 
    $advert->setCookie($cookie['name'], $cookie['value']); 
} 
$res = $advert->call('mlapi_AddProject', array());
?>