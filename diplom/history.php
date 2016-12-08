<?php include_once('header.php'); ?>
<?php 
$fp = fopen('counter.txt', 'w');
session_start();
$login = ($_SESSION['login']);
$_SESSION['project'] = ($_GET['project']);
$proj = $_SESSION['project'];
if($login != NULL) {
	include_once('connect.php');
	
} else {
	header("Location: index.php"); exit;
}	
?>
<?php 
if(isset($_GET['procsv'])) {
$db_table = "cheks";
$q = mysql_query("SELECT * FROM ".$db_table." where (id) IN ('".$_GET['id']."')",$db) or die(mysql_error()); //в $a записывается запрос к бд
$f = mysql_fetch_assoc($q);
$con = $f['content'];
foreach($con as $cont) {
$file_name = 'export.csv'; // название файла
$file = fopen($file_name,"w"); // открываем файл для записи, если его нет, то создаем его в текущей папке, где расположен скрипт
fwrite($file,trim($con)); // записываем в файл строки
fclose($file); // закрываем файл
}
// задаем заголовки. то есть задаем всплывающее окошко, которое позволяет нам сохранить файл.
header('Content-type: application/csv'); // указываем, что это csv документ
header("Content-Disposition: inline; filename=".$file_name); // указываем файл, с которым будем работать
readfile($file_name); // считываем файл
unlink($file_name); // удаляем файл. то есть когда вы сохраните файл на локальном компе, то после он удалится с сервера
}
?>
<header class="col-lg-12">
<div class="col-lg-9">Сервис проверки индексации ссылок</div>
<div class="col-lg-3"><?php echo ' '.$login.' '; ?><span class="glyphicon glyphicon-user"></span><a href="?exits"> Выход </a><a href="cheks.php?project=<?php echo $_GET['project']; ?>">| Назад</a></div>
</header>
<?php 
if (isset($_GET['exits'])) {
     session_destroy();
	 header("Location: index.php"); exit;
}
?>
<div class="content col-lg-12">
<table class="table col-lg-9" style="max-width: 800px; margin: 20px;">
	<thead>
  
		<th>URL донора</th>
		<th>ТИЦ</th>
		<th>Текст</th>
		<th>Цена</th>
		<th>Дата</th>
		<th>YAP</th>
		<th>YAL</th>
		<th>GP</th>
		<th>GL</th>
    
	</thead>
	<tbody>
<?php 
$db_table = "cheks";
$q = mysql_query("SELECT * FROM ".$db_table." where (id) IN ('".$_GET['id']."')",$db) or die(mysql_error()); //в $a записывается запрос к бд
$f = mysql_fetch_assoc($q);
echo '<div class="history-info">Проект: '.$f['project'].'; Обработан файл: '.$f['filename'].'; Дата обработки: '.$f['date'].';</div>';
$history = explode(";", $f['content']);
		echo '<tr>';
	foreach($history as $key){
		echo $key;
	}
	/*echo $history[$i];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];
	echo $history[$i++];*/



?>
	
	</tbody>
</table>
<div class="sidebar col-lg-3">
<form action="history.php?project=<?php echo $f['project']; ?>&id=<?php echo $f['id']; ?>&procsv=<?php echo $f['filename']; ?>" method="POST">
    <input type="submit" class="btn btn-primary btn-success" name="save" value="Сохранить в *.csv"/></p>
</form>


</div>
</div>
<?php include_once('footer.php'); ?>