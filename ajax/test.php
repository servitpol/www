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
<div class="col-lg-12" style="font-size: 15px; color: green; padding: 22px 0 0 22px;">
Загружен файл (проект):
<?php 
SetCookie("Test","Value");

if (isset($_FILES['userfile'])) {
$namefile = basename($_FILES['userfile']['name']);
setcookie("filename", $namefile);
echo $namefile;
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
		$json = json_encode($arra);	
		return $json;
}
$js = getLinksJson ($site);
//echo '<pre>';
//var_dump($js);

foreach ($site as $key){
		echo '<tr>';
		$explode = explode(";", $key);
	}	
			$a = count($site);
			echo '</br>'.' Содержит в себе список из '.$a.' закупленных ссылок';
}
}
echo $js;
?>
</div>
<table class="table col-lg-9" style="max-width: 800px; margin: 20px;">
  <thead>
		<th>№</th>
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

var arr = <?php echo $js;?>;

</script>

<script>
	function getAjax() {
	for (var i = 0; i < arr.length; i++) {
	var url = arr[i][0];
	var tic = arr[i][1];
	var text = arr[i][2];
	var cost = arr[i][3];
	var dates = arr[i][4];
	var c = '#ajaxinput' + i;
   $.ajax({
       url: "function.php",                           //обработчик
	   type: "POST",                                
	   data: {
		    iter : i,
			site : url,
			param : tic,
			content : text,
			cena : cost,
			vremya : dates
				},            //что посылаем через ajax                        
	   beforeSend: function (){								 //функция ожидания ответа от обработчика через ajax, выводит "Loading..." пока идет обработка данных
	$("#information").text("Идет проверка индексации...");
	},                      //вызов ф-ции ожидания ответа    
       success: function (data) {                          //функция вывода результата обработчика через ajax
	$('#ajaxinput').append(data);				
	}                          //вызов ф-ции вывода результата
   });
 
}
	}
   
     
</script>
<div class="sidebar col-lg-3">
<form enctype="multipart/form-data" action="test.php" method="POST" style="padding:20px;">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    <input name="userfile" type="file" />
    <input type="submit" value="Загрузить файл" />
</form>
<form>
<input type="button" id="getanswer" onclick="getAjax()" class="btn" value="Запустить проверку" />
<span id="loading" style="color: green; font-weight: bolder;"></span>
</form>
<div id="information"></div>
</div>
</div>
</div><!-- container-fluid -->
</body>
</html>