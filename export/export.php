<?php
require '../config.php';

require_once('../'.$conf['dir']['inc'].'mysql.php');
require_once('../'.$conf['dir']['inc'].'output.php');
require_once('../'.$conf['dir']['inc'].'functions.php');
$output = new Output;
$DB = new db_driver;
$DB->connect();
$DB->query('SET NAMES utf8');

?>
<html>
<head>
<title>Отправка вконтакте...</title>
<link href="<?=$docroot?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$docroot?>/css/datepicker.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div style="padding:100px">
<?php

if (isset($_GET['gig']) && is_numeric($_GET['gig']))
{
	require 'config.php';
	$vkontakteAccessToken = file_get_contents('token.txt');

	$DB->query('SELECT `events`.`id`, 
                   `events`.`title`,
                   `events`.`review`,
                   `events`.`begin`,
                   `events`.`end`,
                   `events`.`review`,
                   `events`.`price`,				   
                   `events`.`url`,
                   `events`.`vkontakte`,
                   `events`.`myspace`,
                   `events`.`facebook`,
                   `place`.`title` as `place`,
	           `place`.`yandex_x` as `x`,
	           `place`.`yandex_y` as `y`,
	           `place`.`address` as `address`
                    FROM `events`
                    LEFT JOIN `place` ON `place`.`id` = `events`.`place`
                    WHERE
                        `events`.`id` = "'.(int)$_GET['gig'].'" AND `active`=1
                            ORDER BY `begin` LIMIT 1');


	if($DB->get_num_rows())
	{
	 $event = $DB->fetch_row();
	 $text = (int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1].', '.$event['title'].' ('.$event['place'].')';
		
		
	$link = "http://conertinfo.ru/gig/".((int)$_GET['gig']);

	
	//Посылаем в ЖЖ
	
	SendLiveJournal("Концерт ".$text, '<a href="'.$link.'"><img src="http://concertinfo.ru/data/events/covers/'.(int)$_GET['gig'].'.jpg"></a>
	<lj-cut text="Читать описание...">
	<cut>'.htmlspecialchars(str_replace("<br />", "", $output->message_show($event['review']))).'<br /><br /><a href="'.$link.'">Полное описание этого концерта...</a></cut></lj-cut>');
	
	
	//Посылаем subscribe.ru
	echo "123";
	
	
	$text = str_replace(" ","%20",$text);
	
	// строка запроса к серверу Вконтакте
	$sRequest = "https://api.vkontakte.ru/method/wall.post?owner_id=29098428&access_token=$vkontakteAccessToken&message=$text%20$link";

	if(isset($_POST['captcha_key']) && isset($_POST['captcha_sid']))
	{
		$sRequest.='&captcha_key='.$_POST['captcha_key'].'&captcha_sid='.$_POST['captcha_sid'];
	}
	
	// ответ от Вконтакте
	$oResponce = json_decode(file_get_contents($sRequest));
	$oResponce=get_object_vars($oResponce);
	
	if(isset($oResponce['error']))
	{
		$oResponce['error']=get_object_vars($oResponce['error']);
		echo "<strong>Запрос</strong>: ".$sRequest."<br /><hr />";

	}
	
	if(isset($oResponce['response']))
	{
		//print_r($oResponce);
		
		echo "Отправлено вконтакте: <br />".str_replace("%20","",$text).'<br />'.$link.'<br />';
		echo '<a href="/gig/'.$event['id'].'">Вернуться к концерту</a>';
		?>
		<script> 
		  window.location.href = "/gig/<?=$event['id']?>";
		</script>
		<?
	}
	
	
	
	if(isset($oResponce['error']['error_msg']) && strstr($oResponce['error']['error_msg'],"Captcha"))
	{
	  echo '<img src="'.$oResponce['error']['captcha_img'].'" /><br />';
	  ?>
	  <form action="" method="post">
	    Введите капчу: <input type="text" value="" name="captcha_key" /><br />
		SID капчи<input type="text" value="<?=$oResponce['error']['captcha_sid']?>" name="captcha_sid" /><br />
		<input type="submit" value="Переотправить" />
		
	  </form>
	  <?
	}
	else
	{
	if(isset($oResponce['error'])){
	echo "<br />Ответ: <pre>";
	print_r($oResponce);
	echo '</pre>';
	}
	}
	
	
	
	
	
	
	//В группу
	// строка запроса к серверу Вконтакте
	$sRequest = "https://api.vkontakte.ru/method/wall.post?from_group=1&owner_id=1931&access_token=$vkontakteAccessToken&message=$text%20$link";

	if(isset($_POST['captcha_key']) && isset($_POST['captcha_sid']))
	{
		$sRequest.='&captcha_key='.$_POST['captcha_key'].'&captcha_sid='.$_POST['captcha_sid'];
	}
	
	// ответ от Вконтакте
	$oResponce = json_decode(file_get_contents($sRequest));
	$oResponce=get_object_vars($oResponce);
	
	if(isset($oResponce['error']))
	{
		$oResponce['error']=get_object_vars($oResponce['error']);
		echo "<strong>Запрос</strong>: ".$sRequest."<br /><hr />";

	}
	
	if(isset($oResponce['response']))
	{
		//print_r($oResponce);
		
		echo "Отправлено вконтакте: <br />".str_replace("%20","",$text).'<br />'.$link.'<br />';
		echo '<a href="/gig/'.$event['id'].'">Вернуться к концерту</a>';
		?>
		<script> 
		  window.location.href = "/gig/<?=$event['id']?>";
		</script>
		<?
	}
	
	
	
	if(isset($oResponce['error']['error_msg']) && strstr($oResponce['error']['error_msg'],"Captcha"))
	{
	  echo '<img src="'.$oResponce['error']['captcha_img'].'" /><br />';
	  ?>
	  <form action="" method="post">
	    Введите капчу: <input type="text" value="" name="captcha_key" /><br />
		SID капчи<input type="text" value="<?=$oResponce['error']['captcha_sid']?>" name="captcha_sid" /><br />
		<input type="submit" value="Переотправить" />
		
	  </form>
	  <?
	}
	else
	{
	if(isset($oResponce['error'])){
	echo "<br />Ответ: <pre>";
	print_r($oResponce);
	echo '</pre>';
	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		if(!isset($oResponce['error'])){
		//$output->redirect('http://concertinfo.ru/gig/'.$_GET['gig'])
		}

		
	}

}
else
{
//$output->redirect('../../');

}
 
 $DB->close_db();

?>
</div>
</body>
</html>
