<?php
header('Content-Type: text/html; charset=utf-8');
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
<div class="col-lg-12">
<?php 
if (isset($_GET['exits'])) {
     session_destroy();
	 header("Location: index.php"); exit;
}
?>
<div class="content col-lg-9">
<?php if(isset($_GET['name'])) echo 'Ссылки сайта: '.$_GET['name']; ?>
<form id="delurl">
<table class="table">
  <thead>
	  <th>id</th> 
      <th>Название проекта</th>
      <th>ТИЦ</th>
      <th>Цена</th>
	  <th>Дата создания проекта</th>
	  <th>YAP</th>
      <th>YAL</th>
	  <th>GP</th>
	  <th>GL</th>
	  <th>Действие</th>
  </thead>
<tbody id="ajaxinput">
<?php
if(isset($_GET['project'])){
	$stack = array();
	$idpro	= $_GET['project'];
	$pro = $advert->call('PagesGetByProject', array('project' => $idpro));
	//echo '<pre>';
	//var_dump($pro);
	$i = 1;
	foreach($pro as $key => $project){
		foreach($project as $keys) {
			foreach($keys as $value) {
				
				$idpage = $value['Id'];
				$projects = $advert->call('LinksGet', array('page' => $idpage));
				/*
				<Link>
				  <Id>int</Id>
				  <Anchor>string</Anchor>
				  <Comment>string</Comment>
				  <Expired>dateTime</Expired>
				  <Created>dateTime</Created>
				  <LastProlong>dateTime</LastProlong>
				  <Project>int</Project>
				  <Page>int</Page>
				  <Cy>int</Cy>
				  <Pr>int</Pr>
				  <YaCa>boolean</YaCa>
				  <OldCy>int</OldCy>
				  <OldPr>int</OldPr>
				  <Cost>double</Cost>
				  <Currency>Usd or Rur</Currency>
				  <Site>int</Site>
				  <PageSite>long</PageSite>
				  <PageSiteUri>string</PageSiteUri>
				  <Type>int</Type>
				  <Status>Unknown or Placed or Unmoderated or Archived or Wait or Sleep</Status>
				  <Indexed>int</Indexed>
				  <IndexedDate>string</IndexedDate>
				  <PageLevel>int</PageLevel>
				</Link>
				*/
				foreach($projects as $key => $project){
					if($project) {
					foreach($project as $keys) {
						foreach($keys as $value) {
							//echo '<pre>';
							//var_dump($value);
							$url = iconv("UTF-8", "windows-1251", $value['PageSiteUri']);
							$date = explode('T', $value['Created']);
							echo '<tr>'; 	
							echo '<td>'.$i.'</td>';	//id
							echo '<td><a href="'.$url.'" target="_blank">'.$url.'</a></td>'; //name
							if($value['Cy'] == 0){
								echo '<td><span style="color:red;">'.$value['Cy'].'</span></td>'; //tic
								} else {
								echo '<td><span style="color:green;">'.$value['Cy'].'</span></td>';
							}
							echo '<td>'.$value['Cost'].' р.</td>'; //cost
							echo '<td>'.$date[0].'</td>'; //date
							echo '<td></td>'; //date
							echo '<td></td>'; //date
							echo '<td></td>'; //date
							echo '<td></td>'; //date
							echo '<td><input type="checkbox" value='.$value['Id'].' form="delurl" /></td>';
							echo '</tr>';
							$i++;
							ob_flush();
							flush();
							
							array_push($stack, $value);
						}
						ob_flush();
						flush();
					}
					}
				}
				
			}
		}
	}
	
}
//echo '<pre>';
//var_dump($stack);
$js = getLinksJson ($stack);
//echo $js;
?>

</tbody>
</table>
</form>
<script>

var arr = <?php echo $js; ?>;

</script>

<script>
	function getAjax() {
	for (var i = 0; i < arr.length; i++) {
	var url = arr[i]["PageSiteUri"];
	var tic = arr[i]["Cy"];
	var text = arr[i]["Anchor"];
	var cost = arr[i]["Cost"];
	var dates = arr[i]["Created"];
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
	$('#ajaxinput').replaceWith(data);				
	}                          //вызов ф-ции вывода результата
   });
 
}
	}
   
     
</script>
</div>
<div class="sidebar col-lg-3">
<form method=""><button type="submit" class="btn btn-warning" form="delurl">Удалить</button>
<form>
<input type="button" id="getanswer" onclick="getAjax()" class="btn" value="Запустить проверку" />
<div id="information"></div>
</form>

</div>
</div>
<?php include_once('footer.php'); ?>