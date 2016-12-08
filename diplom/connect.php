<?php
function connectdb() {
	$db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
   	$db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
	mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
	echo "work";
}
?>