<?php 
include_once('header.php'); 
include_once('function.php'); 
include_once('connect.php'); 

session_start();
$login = ($_SESSION['login']);
if($login == 'smartinetseo') {
	
} else if($login == 'test') {
	header("Location: test.php");
} else if($login != NULL) {
	header("Location: richeditor.php");
}
?>
<header class="col-lg-12">
<div class="col-lg-9">Сервис проверки индексации ссылок</div>
<div class="col-lg-3"><?php echo ' '.$login.' '; ?><a href="rich.php">Ричэдитор</a><span class="glyphicon glyphicon-user"></span><a href="?exits"> Выход </a></div>
</header>
<?php 
if (isset($_GET['exits'])) {
     session_destroy();
	 header("Location: index.php"); exit;
}
?>
<div class="content col-lg-12">
<div class="content col-lg-6">
<table class="table">
  <thead>
	  <th>id</th>
      <th>Название проекта</th>
	  <th>Дата создания проекта</th>
  </thead>
<tbody>
<?php
$projects = $advert->call('ProjectsGetByCompany', array('company' => 217139, 'archive' => true));
$i = 1;
foreach($projects as $key){
	foreach($key as $value) {
			
			echo '<tr>'; 	
			echo '<td>'.$i.'</td>';	
			echo '<td><a href="links.php?project='.$value['Id'].'" target="_blank">'.$value['Www'].'</a></td>';
			echo '<td>'.$value['Created'].'</td>';
			echo '</tr>';
			$i++;

		}
	}

?>
</tbody>
</table>
</div>
<div class="sidebar col-lg-3">
<form action="project.php" method="post">
   <legend>Добавление нового проекта</legend>
   <input type="text" class="form-control" name="project" placeholder="Название проекта"> 
   <input type="submit" value="Добавить" class="btn btn-success">
</form>
<?php 
if(isset($_POST['project']) && ($_POST['project']) != NULL) {

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
			echo "Такой проект уже есть!"; //ответ 1
		}
	echo '</div>'; 
}
?>
</div>
</div>
<?php include_once('footer.php'); ?>