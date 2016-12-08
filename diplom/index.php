<?php include_once('header.php'); ?>
<?php 
session_start();

//АВТОРИЗАЦИЯ

if (isset($_POST['auth_login']) && isset($_POST['auth_pass'])){
	
	$login = $_POST['auth_login'];
    $pass = $_POST['auth_pass'];
     
    // Параметры для подключения
    $db_host = "servitsj.beget.tech"; //соединение с apache
    $db_user = "servitsj_test"; // Логин БД
    $db_password = "622756"; // Пароль БД
    $db_table = "users"; // Имя Таблицы БД
    $db = mysql_connect($db_host,$db_user,$db_password) OR DIE("Не могу создать соединение "); // Подключение к базе данных
    mysql_select_db("servitsj_test",$db); // Выборка базы
    mysql_query("SET NAMES 'utf8'",$db); // Установка кодировки соединения
    
	//рабочий пример авторизации
	$result = mysql_query("SELECT * FROM ".$db_table." WHERE `login` = '$login' AND `pass` = '$pass'",$db);
	$row = mysql_fetch_array($result);

	if ($row[0] == ''){
	echo '<div class="request">';	
	echo 'Пары логин/пароль не существует. Пройдите регистрацию';
	} else {
	echo '<div class="request">';	
	echo 'Вы успешно авторизированы!';
	$_SESSION['login'] = $login;                    //запись в сессию логина авторизированого пользователя
	header("Location: project.php"); exit;
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
 Авторизация на сайте</h3>
 </div>
 <div class="panel-body">
 <div class="row">

 <div class="col-xs-12 col-sm-12 col-md-12 login-box">
 <form role="form" method="post" input="index.php" id="data">
 <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
 <input type="text" name="auth_login" class="form-control" placeholder="Имя пользователя" required autofocus />
 </div>
 <div class="input-group">
 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
 <input type="password" name="auth_pass" class="form-control" placeholder="Ваш пароль" required />
 </div>
 </form>
  <div class="checkbox">
 <label>
 <input type="checkbox" name="remember" value="Remember">
 Запомнить меня
 </label>
 </div>
 </div>
 </div>
 </div>
 <div class="panel-footer">
 <div class="row">
 <div class="col-xs-12 col-sm-12 col-md-12">

 </div>
 <div class="col-xs-12 col-sm-12 col-md-12">
 <button type="submit" class="btn btn-labeled btn-success" form="data"> 
 <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Войти</button>
 <button type="button" class="btn btn-labeled btn-primary" onClick='location.href="registr.php"'>
 <span class="btn-label"><i class="glyphicon glyphicon-home"></i></span>Регистрация</button>
 </div>
 </div>
 </div>
 </div>
 </div>
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
