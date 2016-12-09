<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Парсер обратных ссылок</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </head>

<body>

<div class="container-fluid content">
<div class="row">
<div class="wrapper">
<table class="table col-lg-9" style="max-width: 800px; margin: 20px;">
  <thead>
  
      <th>Название проекта</th>
	  <th>Кол-во ссылок</th>
	  <th>Дата создания</th>
	  <th>Последняя проверка</th>
	  <th>Процесс проверки</th>
		
  </thead>
<tbody>
<?php 
SetCookie("Test","Value");

if (isset($_FILES['userfile'])) {
$namefile = basename($_FILES['userfile']['name']);
setcookie("filename", $namefile);
echo $namefile;
}
?>
<?php 
if(isset($_POST['project']) && ($_POST['project']) != NULL) {
	$projectname = basename($_POST['project']);
	setcookie("project", $projectname);
	
	echo $_COOKIE["project"];
	echo '<tr>';
	echo '<td><a href="?project='.$_POST['project'].'">'.$_POST['project'].'</a></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td></td>';
	echo '</tr>';

}
?>

</tbody>
</table>
<div class="sidebar col-lg-3">
<form action="project.php" method="post">
   <input type="text" name="project" placeholder="Введите название проекта" size="30"> 
   <p><input type="submit" value="Добавить проект"></p>
</form>
</div>
</div>
</div>
</div><!-- container-fluid -->
</body>
</html>