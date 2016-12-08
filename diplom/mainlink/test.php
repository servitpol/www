<?php
include_once('mainlink/Lib/nusoap.php');
$login_url = "http://api.mainlink.ru/seo.asmx?WSDL";
$login = new nusoap_client($login_url, true); 
 
$login->call('sys_LogIn', array('Login' => 'smartinetseo', 'Password' => 'Dfnheirf', 'PrivateKey' => 'bb99405f-92a5-4dd9-8bb8-96b6153c13e5')); 
var_dump ($login);
/*
$an_array = (array) $login;

foreach($an_array as $key) {
	echo $key.'</br>';
}*/
?>