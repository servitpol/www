<?php 
session_start();
$login = $_SESSION['login'];
if($login == NULL || $login != 'smartinetseo') {
	header("Location: richeditor.php");
}
include_once('header.php'); 
include_once('funcrich.php'); 
include_once('writedb.php'); 
?>

<header class="col-lg-12">
	<div class="col-lg-8">Сервис проверки текстов про дипломы</div>
	<div class="col-lg-4"><?php echo ' '.$login.' '; ?><?php if($login == 'smartinetseo') { echo '<a href="project.php"> Назад | </a>'; }?><a href="/richeditor.php">Версия редактора</a><span class="glyphicon glyphicon-user"></span><a href="?exits"> Выход </a></div>
</header>

<?php if (isset($_GET['exits'])) {session_destroy(); header("Location: index.php"); exit;} ?>

<div class="container-fluid content">
<div class="row">
<div class="col-lg-4">
<span style="font-size: 18px; font-weight: bolder;">Список ТЗ: </span> <span><?php echo $_SESSION['lasttz']; ?></span>
<?php
if(isset($_POST['save']) && isset($_POST['vhod']) && isset($_POST['name']) && isset($_POST['cat'])) {
	$vhod = trim($_POST['vhod']);
	addNewTz($_POST['vhod'], $_POST['name'], $_POST['cat']);
	$_SESSION['lasttz'] = $_POST['name'];
}
?>
<ul>
<li class="category">Высшее образование
<?php $result = showAllTz('Высшее образование');?>
</li>
<li class="category">Города
<?php $result = showAllTz('Города');?>
</li>
<li class="category">Начальное образование
<?php $result = showAllTz('Начальное образование'); ?>
</li>
<li class="category">Последипломное образование
<?php $result = showAllTz('Последипломное образование'); ?>
</li>
<li class="category">Профессии
<?php $result = showAllTz('Профессии'); ?>
</li>
<li class="category">Справки и свидетельства
<?php $result = showAllTz('Справки и свидетельства'); ?>
</li>
<li class="category">Статьи
<?php $result = showAllTz('Статьи'); ?>
</li>
<li class="category">Тестовое задание
<?php $result = showAllTz('Тест'); ?>
</li>
</ul>
</div>

<div class="col-lg-3" style="padding:20px;">
<form method="post" id="one">
<select size="7" name="cat" form="one" required>
    <option value="Высшее образование">Высшее образование</option>
    <option value="Города">Города</option>
    <option value="Начальное образование">Начальное образование</option>
    <option value="Последипломное образование">Последипломное образование</option>
    <option value="Профессии">Профессии</option>
    <option value="Справки и свидетельства">Справки и свидетельства</option>
    <option value="Статьи">Статьи</option>
	<option value="Тест">Тест</option>
</select>
	
</div>
<div class="col-lg-3" style="padding:20px;">
<textarea name="vhod" form="one" type="text" cols="40" rows="16" placeholder="Вхождения" required>
<?php 


if(isset($_GET['event'])) {
	$tz = showOneTz($_GET['event']);
	echo '</textarea>';
	echo '</br>';
	echo '<input type="text" name="name" form="one" value="'.$_GET['event'].'" readonly></input>';
	echo '<button type="submit" name="resave" form="one"/>Перезаписать</button></br>';
	echo '<a href="rich.php">Добавить новое тз</a>';
} else {
	//echo $_POST['vhod'];
	echo '</textarea>';
	echo '</br>';
	echo '<input type="text" name="name" form="one" placeholder="Название проекта" required></input></br>';
	echo '<button type="submit" name="save" form="one" placeholder="Сохранить"/>Сохранить</button>';
}

if(isset($_POST['resave'])) {
	echo  '</br><span style="color:green; font-weight: bolder; font-size: 15px;">Успешно перезаписанно</span>';
	editTz($_POST['vhod'], $_POST['name'], $_POST['cat']);
}
?>


</div>


</div>
</div><!-- container-fluid -->

<?php include_once('footer.php'); ?>