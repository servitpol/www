<?php include_once('header.php'); ?>
<?php 

session_start();
$login = ($_SESSION['login']);
if($login != NULL) {
	include_once('connect.php');
	
} else {
	header("Location: index.php"); exit;
}	
?>
<header class="col-lg-12">
<div class="col-lg-9">Сервис проверки индексации ссылок</div>
<div class="col-lg-3"><?php echo ' '.$login.' '; ?><span class="glyphicon glyphicon-user"></span><a href="?exits"> Выход </a><a href="project.php">| Назад</a></div>
</header>
<?php 
if (isset($_GET['exits'])) {
     session_destroy();
	 header("Location: index.php"); exit;
}
?>
<div class="content col-lg-12">
<div class="project-name">Проверки проекта: <?php echo $_GET['project']; ?></div>
<table class="table col-lg-9" style="max-width: 800px; margin: 20px;">
  <thead>
	  <th>id</th>
      <th>Файл</th>
	  <th style="text-align: center;">Кол-во ссылок</th>
	  <th>Дата проверки</th>
	  <th>Действия</th>
  </thead>
<tbody>
<?php
	$db_table = "cheks";
	echo '<tr>';
	$q = mysql_query("SELECT * FROM ".$db_table." where (project) IN ('".$_GET['project']."')",$db) or die(mysql_error()); //в $a записывается запрос к бд
	for($c=0; $c < mysql_num_rows($q); $c++) {
	$f = mysql_fetch_assoc($q);
		echo '<td>'.$f['id'].'</td>';
		echo '<td><a href="history.php?project='.$f['project'].'&id='.$f['id'].'">'.$f['filename'].'</a></td>';
		echo '<td style="text-align: center;">'.$f['count'].'</td>';
		echo '<td>'.$f['date'].'</td>';
		echo '<td><a href="function.php?delete='.$f['id'].'&project='.$f['project'].'" style="color:red;">Удалить</a></td>';
		echo '</tr>';
}
?>
</tbody>
</table>
<div class="sidebar col-lg-3">
<form action="test.php?project=<?php echo $_GET['project']; ?>&id=1" method="POST">
    <input type="submit" class="btn btn-primary btn-success" name="save" value="Запустить новую"/></p>
</form>
<?php 
if(isset($_POST['project']) && ($_POST['project']) != NULL) {

	date_default_timezone_set('Europe/Helsinki');
	$script_tz = date_default_timezone_get();
	echo 'Сейчас: '. date('Y-m-d');
	$projectname = basename($_POST['project']);
	$result = mysql_query("SELECT * FROM ".$db_table." WHERE `project` = '$projectname'",$db);
	$row = mysql_fetch_array($result);

	//Условие: если $row[0] пустое, т.е. его нет в БД, то происходит создание проекта. Если есть, то возвращает ответ 1
	if ($row[0] == ''){
	$result = mysql_query ("INSERT INTO ".$db_table." (login,project, date) VALUES ('$login','$projectname', NOW())");
    
			if ($result = 'true'){
				echo '<div class="project-status">'; 
				echo "Проект успешно создан!";
				header("Location: project.php");
			}else{
				echo '<div class="project-status">'; 
				echo "Ошибка!";
			}
		} else {
			echo "Придумайте другое название для проекта!"; //ответ 1
		}
	echo '</div>'; 
}
	

?>
</div>
</div>
<?php include_once('footer.php'); ?>