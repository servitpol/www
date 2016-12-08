<?php include_once('header.php'); ?>
<?php 
session_start();

// РЕГИСТРАЦИЯ

if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['pass_r']) && isset($_POST['code'])){
	if ((($_POST['pass']) == ($_POST['pass_r'])) && (($_POST['code']) == 'Dfnheirf')) {
	//рабочий пример к бд http://daruse.ru/zapis-v-bazu-dannyix-mysql-php-formu
    // Переменные с формы
    $login = $_POST['login'];
    $pass = $_POST['pass'];
     
    // Параметры для подключения
    $db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
    $db_table = "users"; // Имя Таблицы БД
     
    // Подключение к базе данных
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение ");
     
    // Выборка базы
    mysql_select_db("servitsj_test",$db);
     
    // Установка кодировки соединения
    mysql_query("SET NAMES 'utf8'",$db);
	
	//Запрос к БД на проверку существования логина 
	$result = mysql_query("SELECT * FROM ".$db_table." WHERE `login` = '$login'",$db);
	$row = mysql_fetch_array($result);

	//Условие: если $row[0] пустое, т.е. его нет в БД, то происходит регистрация. Если есть, то возвращает ответ 1
	if ($row[0] == ''){
	$result = mysql_query ("INSERT INTO ".$db_table." (login,pass) VALUES ('$login','$pass')");
    
			if ($result = 'true'){
				echo '<div class="request">'; 
				echo "Вы успешно зарегистрированы";   
			}else{
				echo '<div class="request">'; 
				echo "Регистрация не прошла! Информация не занесена в базу данных";
			}
		} else {
			echo '<div class="request">'; 
			echo 'Такой логин уже есть в системе';  //ответ 1
		}
	} else {
		echo '<div class="request">'; 
		echo "Пароли не совпадают или неправильно введен код";
	}
	echo '</div>'; 
}

?>

<div class="container">
 <div class="row">
 <div class="col-xs-12 col-sm-12 col-lg-12">
 <div class="panel panel-primary">
 <div class="panel-heading">
 <h3 class="panel-title">
 Регистрация на сайте</h3>
 </div>
 <div class="panel-body">
 <div class="row">

 <div class="col-xs-12 col-sm-12 col-md-12 login-box">
 <form role="form" method="post" input="registr.php" id="data">
 <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
 <input type="text" name="login" class="form-control" placeholder="Имя пользователя" required autofocus />
 </div>
 <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
 <input type="password" name="pass" class="form-control" placeholder="Ваш пароль" required />
 </div>
  <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
 <input type="password" name="pass_r" class="form-control" placeholder="Пароль повторно" required />
 </div>
 <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-gift"></span></span>
 <input type="password" name="code" class="form-control" placeholder="Код регистрации*" required />
 </div>
 </form>
 </div>
 </div>
 </div>
 <div class="panel-footer">
 <div class="row">
 <div class="col-xs-12 col-sm-12 col-md-12">

 </div>
 <div class="col-xs-12 col-sm-12 col-md-12">
 <button type="submit" class="btn btn-labeled btn-primary" form="data" >
 <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Зарегистрироваться</button>
 <button type="submit" class="btn btn-labeled btn-success" onClick='location.href="index.php"'> 
 <span class="btn-label"><i class="glyphicon glyphicon-home"></i></span>Авторизироваться</button>
 </div>
 </div>
 </div>
 </div>
 </div>
  <div class="col-xs-12 col-sm-12 col-lg-12"><p style="color:grey; font-size:16px;">*Это закрытый сервис. Регистрация возможна только с наличием кода регистрации.</p></div>
 </div>
</div>
<style>
.wrapper {
    width: 390px;
    margin: auto;
}
.container {
    width: 400px;
	margin-top: 25%;
}
</style>
<?php include_once('footer.php'); ?>