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
	<tbody id="ajaxinput">
	</tbody>
</table>


<script>
	function getAjax() {
	for (var i = 0; i < arr.length; i++) {
	var url = arr[i][0];
	var tic = arr[i][1];
	var text = arr[i][2];
	var cost = arr[i][3];
	var dates = arr[i][4];
	var c = '#ajaxinput' + i;
	var time = countarr - i;
	$.ajax({
		url: "function.php",                           //обработчик
		type: "POST",
		data: {
			site : url,
			param : tic,
			content : text,
			cena : cost,
			vremya : dates
				},

		beforeSend: function (){$("#loading").text("Идет проверка индексации...");},                      
		success: function (data) {$('#ajaxinput').append(data);}
                                               
   });
 
}
}
   
     
</script>
<div class="sidebar col-lg-3">
<form enctype="multipart/form-data" action="test.php?project=<?php echo $proj; ?>" method="POST">
   <legend>Добавление файла на проверку</legend>
    <input name="userfile" type="file" title="Выберите файл" class="btn" />
    <input type="submit" class="btn btn-primary btn-success" value="Загрузить"/></p>
</form>
<form>
<legend>Запуск проверки индексации</legend>
<input type="button" id="getanswer" onclick="getAjax()" class="btn btn-primary" value="Запустить проверку" style="margin-bottom: 20px;"/>
</form>
<legend>Служебная информация</legend>
<span id="loading" style="color: green; font-weight: bolder;"></span>
<div id="loading1" style="color: green; font-weight: bolder;"></div>
<script src="js/bootstrap.file-input.js"></script> 
<script>
$('input[type=file]').bootstrapFileInput(); 			// преобразует кнопку "Выберите файл для обработки" в стиль bootstrap
$('.file-inputs').bootstrapFileInput();
</script>
<?php 

echo '</br>Проект: '.$proj.'</br>';

if (isset($_FILES['userfile'])) {
$namefile = basename($_FILES['userfile']['name']);
echo 'Загружен файл: <span style="font-weight: bolder;">'.$namefile.'</span>';
}
?>
<?php

include_once 'function.php';
if (isset($_FILES['userfile'])) {
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
$site = file($uploadfile);
$i =0;

function getLinksJson ($site) {
		$arra = array(); 										//пустой массив
		$i = 0;
		foreach ($site as $key){ 								//получаем массив состоящий из строк, с данными разделенными запятой
			$explode = explode(";", $key); 						//получаем одномерный массив $explode с данными
			$arra[$i] = $explode;
			$i++;
				}
		$json = json_encode($arra);								//преобразуем полученный массив в JSON формат
		return $json;
}
$js = getLinksJson ($site);


foreach ($site as $key){
		echo '<tr>';
		$explode = explode(";", $key);
	}	
			$a = count($site);
			echo '</br>'.' Ссылок в файле: <span style="font-weight: bolder;">'.$a.'</span>';
}
}
?>
<script>
var countarr = <?php echo $a;?>; //создание javascript массива из массива php
var arr = <?php echo $js;?>; //создание javascript массива из массива php
</script>
<form action="function.php?projectchek=<?php echo $proj.'&file='.$namefile.'&count='.$a; ?>" method="POST">
   <legend>Сохранить результат</legend>
   <button type="submit" class="btn btn-primary btn-success" >Сохранить</button>
</form>
</div>
</div>
<?php include_once('footer.php'); ?>