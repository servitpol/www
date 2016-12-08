<?php 
// Дата последней редакции: 01.12.2016 17:20
function addNewTz($tz, $n, $cat) {
	
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "tz";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	
	//$tz = nl2br($tz);
	$result = mysql_query ("INSERT INTO ".$db_table." (category, name, texttz) VALUES ('$cat', '$n', '$tz')");
	if ($result = 'true'){
				echo " ";
			}else{
				echo '<span style="color:red">Ошибка при сохранении проекта: </span>';
			}
}

function editTz($tz, $n, $cat) {
	
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "tz";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	
	//$tz = nl2br($tz);
	//UPDATE `tz` SET `texttz` = '13872 ' WHERE `tz`.`id` = 17
	$result = mysql_query ("UPDATE ".$db_table." SET `texttz`='$tz', `category`='$cat' WHERE `name`='$n'");
	if ($result = 'true'){
				echo " ";
			}else{
				echo '<span style="color:red">Ошибка при сохранении проекта: </span>';
			}
}


function showAllTz ($cat){
	
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "tz";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	$query = mysql_query("SELECT * FROM ".$db_table." where category='".$cat."'",$db) or die(mysql_error()); //в $a записывается запрос к бд
	while ($row = mysql_fetch_array($query)) { 
		echo '<li><a href="?event='.$row['name'].'">'.$row['name'].'</a></li>';	
    } 	
}

function showOneTz($name){
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db_table = "tz";
	
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	$query = mysql_query("SELECT * FROM ".$db_table." where name='".$name."'",$db) or die(mysql_error()); //в $a записывается запрос к бд
	$result = mysql_fetch_array($query);
	//header('Location: rich.php');
	echo $result['texttz'];
}
?>