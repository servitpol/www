<?php
// Дата последней редакции: 01.12.2016 17:20


/* функции вывода кол-ва вхождений на экран */ 
function getstrlenght($text) {
	$text = preg_replace("/('|\"|\r?\n)/", '', $text); 
	$text = preg_replace("/\n/", '', $text); 
	//$text = strip_tags($text);
	$space = explode(" ", $text); 								//получаем массив слов с разделителем "пробел"
	foreach($space as $key) {
			$keys += iconv_strlen($key,'UTF-8'); 					//кол-во символов
	}
	
	return $keys;
}	

/* функция разбирает полученные данные на массив и сортирует по новым массив прямые вхождения, разбавленные и сколоняемые */
function allVhodToArr($zaprosy)	{
	$pryamievhoj = array();
	$razbvhoj = array();
	$sklon = array();
	$i = 0;
	$c = 0;
	$stars = ' ** ';
	$star = '*';
	$text = $_POST['text'];
	$vhodArray = explode("\r", $zaprosy); 			//разбиваем запросы на массив с разделителем "новая строка"
	$countText = $vhodArray[0];
	$vhodArray = array_slice($vhodArray, 1);
	$lenghtText = getstrlenght($text);
	if(($lenghtText <($countText + 500) && $lenghtText > $countText) || ($lenghtText > ($countText - 500) && $lenghtText < $countText)) {
	echo '<span style="color:green;">'.$lenghtText.'<span></br>'; 
	} else {
	echo '<span style="color:red;">'.$lenghtText.'<span></br>';
	}

	foreach($vhodArray as $zapros){
		$clean = cleanZapros($zapros);				//получаем массив из значений "запрос => кол-во вхождений"
		foreach($clean as $key => $value) {
		if(strripos($key, $stars)){					//ищем " ** "
		
			$sentences = explode(". ", $text);
			$slova = explode(" ** ", $key);
			$pos = array();
			$z = 0;
			$i = 0;
			$lastpos = 0;
			foreach($slova as $slovo) {
					$pos[$i] = trim($slovo);
					$i++;
				}
						//'~\bdolor\b.*\bsit\b.*\belit\b~'
			$pattern = '~\b'.$pos[0].'\b.*[а-я]{3}.*\b'.$pos[1].'\b.*[а-я]{3}.*\b'.$pos[2].'\b~u'; //это регулярное выражение для шаблона	
			foreach($sentences as $sentence) {
				
				$sentence = mb_strtolower($sentence, 'utf-8');
				if (preg_match_all($pattern, $sentence))	//проверяем, совпадает ли предложение с шаблоном
				{	
					$z++;
				}
			}
			if($z != $value) {
			echo '<span style="color:red;">'.$key.' - '.$z.'</span></br>';
			} else {
			echo '<span style="color:green;">'.$key.' - '.$z.'</span></br>';
			}
		//если есть *, значит вхождение нужно склонять
		} else if(strripos($key, $star)){												//ищем "*"
			$keys = cutZapros($key);													//обрезаем написанной ф-цией окончания
			$countpv = searchZapros(trim($keys), $_POST['text']);						//ищем запрос в тексте и удаляем пробелы в начале и в конце
			if($countpv < $value) {
				echo '<span style="color:red;">'.$key.' - '.$countpv.'</span></br>';
				$sklon[$i] = array(cutZapros($key) => $value);
				$i++;
			} else if($countpv > ($value + 2)) {
				echo '<span style="color:red;">'.$key.' - '.$countpv.'</span></br>';
				$sklon[$i] = array(cutZapros($key) => $value);
				$i++;
			} else {
				echo '<span style="color:#3F51B5;">'.$key.' - '.$countpv.'</span></br>';
				$sklon[$i] = array(cutZapros($key) => $value);
				$i++;
			}
		//если нет звезд, значит вхождение прямое делает проверку и выводит на экран кол-во вхождений
		} else {
			$countpv = searchZapros(trim($key), $_POST['text']);
			if(($countpv != $value)) {
				echo '<span style="color:red;">'.$key.' - '.$countpv.'</span></br>';
				$pryamievhoj[$i] = array($key => $value);
				$i++;
			} else if(($countpv == $value)) {
				echo '<span style="color:green;">'.$key.' - '.$countpv.'</span></br>';
				$pryamievhoj[$i] = array($key => $value);
				$i++;
			} 
		}
	}
}
}
/* функция формирующая массив вида "запрос => кол-во вхождений" */
function cleanZapros($pv) {
	$howpv = substr($pv, -1); 					//в howpw будет цифра с кол-вом вхождений
	$vhod = substr($pv, 0, -4); 				//получаем чистый запрос
	return array($vhod => $howpv);
}
/* функция поиска запроса в тексте */
function searchZapros ($vhoj, $text) {
	$res = substr_count(mb_strtolower($text, 'utf-8'), mb_strtolower($vhoj, 'utf-8')); // 2
	return $res;
}

/*
	Функция "отсекания" окончания...
	У склоняемых слов могут быть такие свойства:
	1. Если слово 5-6 букв, то в окончании нужно убрать 2 символа, а искомая конструкция должна быть до count + 4;
	2. Если слово больше или равно 7 букв, то нужно убрать 3 символа, а искомая конструкция должна быть до count + 5;
	3. Если слово до или равно 4 буквы, то нужно убрать 1 символ, а искомая конструкция до count + 3;
*/
function cutZapros ($zapros) {
	if(iconv_strlen($zapros,'UTF-8') <= 4) {
		return mb_substr($zapros, 0, -1,'UTF-8');
	} else if(iconv_strlen($zapros,'UTF-8') >= 7) {
		return mb_substr($zapros, 0, -3,'UTF-8');
	} else {
		return mb_substr($zapros, 0, -2,'UTF-8');
	}
}

?>