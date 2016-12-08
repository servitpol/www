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
<tbody>
<?php
if(isset($_GET['project'])){
	
	$idpro	= $_GET['project'];
	$pro = $advert->call('PagesGetByProject', array('project' => $idpro));

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
							
							$date = explode('T', $value['Created']);
							$resYAP = getYAP($value['PageSiteUri'], $value['Anchor']);
							$resYAL = getYAL($value['PageSiteUri'], $value['Anchor']);
							$resGP = getGP($value['PageSiteUri'], $value['Anchor']);
							$resGL = getGL($value['PageSiteUri'], $value['Anchor']);
							echo '<tr>'; 	
							echo '<td>'.$i.'</td>';	//id
							echo '<td><a href="'.$value['PageSiteUri'].'" target="_blank">'.$value['PageSiteUri'].'</a></td>'; //name
							if($value['Cy'] == 0){
								echo '<td><span style="color:red;">'.$value['Cy'].'</span></td>'; //tic
								} else {
								echo '<td><span style="color:green;">'.$value['Cy'].'</span></td>';
							}
							echo '<td>'.$value['Cost'].' р.</td>'; //cost
							echo '<td>'.$date[0].'</td>'; //date
							echo $resYAP; //yap
							echo $resYAL; //yal
							echo $resGP; //gp
							echo $resGL; //gl
							echo '<td><input type="checkbox" value='.$value['Id'].' form="delurl" /></td>'; //deystvie
							echo '</tr>';
							ob_flush();
							flush();
							$i++;
						
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


?>

</tbody>
</table>
</form>
</div>
<div class="sidebar col-lg-3">
<form method=""><button type="submit" class="btn btn-warning" form="delurl">Удалить</button>
</div>
</div>
<?php include_once('footer.php'); ?>