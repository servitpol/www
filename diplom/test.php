<?php
// Дата последней редакции: 02.12.2016 10:20
 
session_start();
$login = ($_SESSION['login']);
if($login == NULL) {
	header("Location: index.php"); exit;
}
include_once('header.php'); 
include_once('funcrich.php'); 
include_once('writedb.php'); 
?>

<header class="col-lg-12">
	<div class="col-lg-9"><div class="logo">Rich Editor 1.0</div></div>
	<div class="col-lg-3">
		<button class="btn-info" type="button" data-toggle="modal" data-target="#myModal">Инструкция</button>
		<?php echo ' '.$login.' '; ?><span class="glyphicon glyphicon-user"></span>
		<?php if($login == 'smartinetseo') { echo '<a href="rich.php"> Назад | </a>'; }?><a href="?exits"> Выход </a>
	</div>
</header>

<?php if (isset($_GET['exits'])) {session_destroy(); header("Location: index.php"); exit;} ?>


<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><button class="close" type="button" data-dismiss="modal">?</button>
				<h4 class="modal-title">Инструкция</h4>
			</div>
			<div class="modal-body">
					<ul class="list-group">
						<li class="list-group-item active">Текст должен быть:</li>
						<li class="list-group-item">Качественным, легко читаемым, полностью решать проблему пользователя, не переспамлен;</li>
						<li class="list-group-item">Структурированным (заголовки, абзацы, списки и т.д.);</li>
						<li class="list-group-item">Уникальность текста по <a href="http://text.ru" target="_blank">text.ru</a> от 90%;</li>
						<li class="list-group-item">Тошнота по слову в сервисе <a href="https://advego.ru/text/seo/top/" target="_blank">advego</a> не больше 3%;</li>
						<li class="list-group-item">Академическая тошнота по advego не больше 8%;</li>
						<li class="list-group-item">Основной (первый в списке) ключ вписывайте в первом и последнем абзаце. Если вхождение одно - вписывайте только в первом абзаце.</li>
					</ul>
					<ul class="list-group">	
						<li class="list-group-item active">Информация необходимая для работы с сервисом:</li>
						<li class="list-group-item">Кол-во символов варьируется в диапазоне от написанного в ТЗ +-500</li>
						<li class="list-group-item">Прямое вхождение: "купить диплом в москве - 3" - это вхождение нужно использовать в тексте 3 раза. Фраза 
						"купить диплом<span style="color:red">ы</span> в москве" уже не будет считаться за прямое вхождение;</li>
						<li class="list-group-item">Разбавленное вхождение: "купить ** диплом ** белгород - 4" - это означает, что вместо ** должно быть любое слово(а), любые знаки препинания, кроме (.!?;). 
						Пример: "купить недорого диплом в городе Белгород";</li>
						<li class="list-group-item">Склоняемое вхождение: "диплом* - 11" - это означает что в тексте нужно использовать минимум 11 раз 
						слово "диплом" в разных падежах (диплом, дипломы, дипломом, дипломов, диплома и т.д.);</li>
						<li class="list-group-item">При проверке, красным цветом подсвечивается недостаточное или избыточное кол-во вхождений;</li>
						<li class="list-group-item">Синим - избыточное, но в рамках допустимого, кол-во вхождений;</li>
						<li class="list-group-item">Зеленым - необходимое кол-во вхождений.</li>
					</ul>
				<span class="achtung">Текст считается готовым, когда в результатах проверки все вхождения подсвечиваются только зеленым или зеленым и синим.</span>
			</div>
			<div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>
		</div>
	</div>
</div>
<div class="col-lg-12 info">
<?php
echo '<div style="font-weight: bolder; font-size: 16px; padding: 15px;">Тема: '.$_GET['event'].'</div>';
?>
</div>
<div class="container-fluid content">
	<div class="row">
		<!-- текстовое поле -->
		<div class="col-lg-6 text">
			<form method="POST" id="one">
				<textarea class="area" name="text" type="text" placeholder="Вставьте сюда текст который необходимо проверить"><?php if(isset($_POST['text'])) {echo $_POST['text']; }?></textarea>
				<!--<script type="text/javascript">
				CKEDITOR.replace( 'text');
				</script>-->
			</form>
		</div>
		<!-- поле с тз из бд -->
		<div class="col-lg-3">  
			<textarea name="vhod" form="one" type="text" class="area" placeholder="ТЗ" readonly><?php if(isset($_GET['event'])) {$tz = showOneTz($_GET['event']);} ?></textarea>
			</br>
			<button type="submit" name="sub" form="one" class="btn" />Проверить</button>
		</div>
		<!-- результат обработки тз и текста -->
		<div class="col-lg-3"> 
			<div class="result tz">
			<?php if(isset($_POST['sub'])) {allVhodToArr($_POST['vhod']);} else { echo '<span style="color:rgb(169, 169, 169);">Здесь будет отображаться результат проверки</span>';}?>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12" style="margin-top:20px;">
			
			<div class="notebook">
				<input type="radio" name="notebook1" id="notebook1_1" checked>
				<label class="label label-info" for="notebook1_1">Тестовые задание</label>
				<div>
				   <?php $result = showAllTz('Тест');?>
				</div>
			</div>
		</div>
	</div>
</div><!-- container-fluid -->




<script type="text/javascript">
		// Persist the form's data into localStorage, but ignore
// the country select.
// Persist the data every 10 seconds unless an immediate control
// like checkbox is triggered
$( function() {
$( "#one" ).sisyphus( {
locationBased: true,
excludeFields: $( "#one" ),
timeout: 10
} );
} );
</script>

<?php include_once('footer.php'); ?>