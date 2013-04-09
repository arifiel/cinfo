<?php
require '../config.php';

require_once('../'.$conf['dir']['inc'].'mysql.php');
require_once('../'.$conf['dir']['inc'].'output.php');
require_once('../'.$conf['dir']['inc'].'functions.php');

require_once('../'.$conf['dir']['inc'].'class.phpmailer.php');

$mail = new PHPMailer;
$output = new Output;
$DB = new db_driver;
$DB->connect();
$DB->query('SET NAMES utf8');

$DB->query("INSERT INTO `b118468_sci`.`log` (`id`, `added`, `title`, `user_id`, `target_id`, `target_type`, `target_slug`, `where_id`, `where_type`, `where_slug`, `ip`) VALUES (NULL, '".time()."', 'digest_week', '', '', '', '', '', '', '', '".GetUserIP()."');");

?>
<html>
<head>
<title>Отправка дайджеста в соц.сети ...</title>
<link href="<?=$docroot?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$docroot?>/css/datepicker.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="padding:100px">
<?php

	require 'config.php';
	$vkontakteAccessToken = file_get_contents('token.txt');

	
	$string2out="";
	
	$fromdate=time();
	if((int)date("w",$fromdate)>1)
	{
		$fromdate +=  (6-(int)date("w",$fromdate))*60*60*24;
	} else
	if((int)date("w",$fromdate)<1)
	{
		$fromdate = strtotime(date('d.m.Y', $fromdate))+60*60*24;
	}

	$title_msg="Еженедельный дайджест Rock/Metal вечеринок\n"."(".date('d.m.Y', $fromdate).'-'.date('d.m.Y', $fromdate+7*60*60*24-1).')'."\n";
	$string2out.=$title_msg;
		
	
	$DB->query('SELECT active, `events`.`id`, 
				`events`.added, `events`.`title`, 
				`begin`, `place`.`title` as `place`, 
				`events`.`place` as `place_id` 
				FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`end` > '.$fromdate.' AND `events`.`begin` < '.($fromdate+7*60*60*24-1).'  AND active=1 ORDER BY `begin` LIMIT 500');
	
			
	if($DB->get_num_rows())
	{
	
	while($a=$DB->fetch_row())
	{
		$events[ (int)date("w", $a['begin'])  ][] = $a;
	}
	}


foreach(array_keys($events) as $d)
{


$string2out.='----------------------------------'."\n";
$string2out.=mb_convert_case($conf['weekdays_full'][$d], MB_CASE_UPPER, "UTF-8")."\n";

	foreach($events[$d] as $gig)
	{
		$string2out.=date("H:i",$gig['begin']).', '.$gig['title'].' ('.$gig['place'].')'."\n".'http://concertinfo.ru/gig/'.$gig['id']."\n\n";
	}
	
$string2out.="\n";

}

$DB->close_db();
	
	
	
$string2out=strip_tags($string2out);	
SendLiveJournal($title_msg, $string2out);

$string2mail=nl2br($string2out);

$output->send_mail($title_msg,$string2mail,'concert-info-ru@googlegroups.com');


$string2out=rawurlencode($string2out);

	
	
	// строка запроса к серверу Вконтакте
	$sRequest = "https://api.vkontakte.ru/method/wall.post?owner_id=-29098428=&access_token=$vkontakteAccessToken&message=".$string2out;
	
	
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
		
		echo "Отправлено вконтакте <br />";
		?>
		<script> 
		  window.location.href = "/";
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
	
	
?>
</div>

</body>
</html>
