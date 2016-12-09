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

<script>
var a;
a = $.parseJSON(data);
alert a;

</script>

<script>


function funcBefore(){								 //функция ожидания ответа от обработчика через ajax, выводит "Loading..." пока идет обработка данных
$("#loading").text("Идет загрузка...");
}

function funcSucces(data) {                          //функция вывода результата обработчика через ajax
$("#information").html(data);				
}


   $(document).ready( function(){  						//привязка к событию на клик по #getLinks
   $("#getanswer").bind("click",function(){               
   $.ajax({
       url: "function.php",                           //обработчик
	   type: "POST",                                
	   data: {
			action : 'magic'
				},            //что посылаем через ajax                        
	   beforeSend: funcBefore,                      //вызов ф-ции ожидания ответа    
       success: funcSucces                          //вызов ф-ции вывода результата
   });
   
   
      });                                
   });
   
     
</script>
<div class="container-fluid content">
<div class="row">
<div class="wrapper">
<div class="col-lg-12" style="font-size: 15px; color: green; padding: 22px 0 0 22px;">
Открыт файл (проект):
<?php 
SetCookie("Test","Value");

if (isset($_FILES['userfile'])) {
$namefile = basename($_FILES['userfile']['name']);
setcookie("filename", $namefile);

}
?>

</div>
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
  <tbody id="information">

<!--<pre id="information" ></pre>-->
<?php
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.

include_once 'function.php';
if (isset($_FILES['userfile'])) {
$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
$site = file($uploadfile);
$i =0;
foreach ($site as $key){
		echo '<tr>';
		$explode = explode(";", $key);
		foreach ($explode as $keys) {
			echo '<td>'.$keys.'</td>';
		}
		
		echo '<td class="td'.$i++.'"> </td>';
		echo '<td class="td'.$i++.'"> </td>';
		echo '<td class="td'.$i++.'"> </td>';
		echo '<td class="td'.$i++.'"> </td>';
		
		
}

			}
}



?>
</tbody>
</table>
<div class="sidebar col-lg-3">
<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
<form enctype="multipart/form-data" action="new.php" method="POST" style="padding:20px;">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    <input name="userfile" type="file" />
    <input type="submit" value="Загрузить данные" />
</form>
<form action="new.php" method="post" style="padding:20px;">
  <input type="submit" name="getIndex" value="Проверить индексацию"/>
</form>
<form>
<input type="button" id="getanswer" class="btn" value="Проверка" />
<span id="loading" style="color: green; font-weight: bolder;"></span>
</form>

</div>
</div>
</div>	
</div><!-- container-fluid -->
</body>
</html>