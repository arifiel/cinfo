<?php
$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;

if(isset($pathname[1]) && isset($pathname[2]) && $pathname[1]=='gig' && is_numeric($pathname[2]))
{
	$DB->query('SELECT * FROM events WHERE id ='.$pathname[2].' LIMIT 1');
	if($DB->get_num_rows())
	{
		$ev=$DB->fetch_row();
		$title = 'Рассказать об ошибке в концерте '.date('d.m.Y', $ev['begin']).', '.$ev['title'];
			?><h2><?=$title?></h2><?

	}
	else
	{
		$title = 'Обратная связь';
		?><h2>Обратная связь</h2><?
	}

}
else
{
	$title = 'Обратная связь';
	?><h2>Обратная связь</h2><?
}
?>

<script type="text/javascript">
//Функция, которая добавляет форму в конец страницы
function appendForm(){

var form = '<form action="#" method="post" enctype="multipart/form-data">'+
'<label for="name">Ваше имя:&nbsp;&nbsp;</label>'+
'<input placeholder="Введите своё имя или псевдоним" type="text" name="name" value="<?=$post['name']?>" id="name" /><br /><br />'+
'<label for="email">Ваш email:&nbsp;&nbsp;</label>'+
'<input placeholder="Введите свой email для обратной связи" type="text" name="email" value="<?=$post['email']?>" id="email" /><br /><br />'+
'<label for="review">Ваше сообщение:&nbsp;&nbsp;</label>'+
'<textarea name="review" style="min-height:170px; width:80%" id="review" placeholder="Введите своё сообщение нам"><?=$post['review']?></textarea>'+
'<p style="text-align:center">'+
'<input style="margin:0 auto;font-size:1em; margin-top:1em; padding: 0.5em 2em 0.5em 2em" type="submit" value="Оправить!" />'+
'</p>'+
'</form>';

$('#feedbackform').append(form);
}
//Запустить функцию после загрузки документа
window.onload = appendForm;
</script>
<?
if (isset($post))
{
	$flag=1;	

	if(!isset($post['name']) || !strlen($post['name']) ||
		!isset($post['email']) || !strlen($post['email']) ||
		!isset($post['review']) || !strlen($post['review'])){
	echo '<div class="tooltip" style="color:red"">';
	}
	
	if(!isset($post['name']) || !strlen($post['name']))
	{?>
	Вы не ввели имя!<br />
	<?
	$flag=0;
	}

	if(!isset($post['email']) || !strlen($post['email']))
	{?>
	Вы не ввели Email!<br />
	<?
	$flag=0;
	}

	if(!isset($post['review']) || !strlen($post['review']))
	{?>
	Вы не ввели текст!<br />
	<?
	$flag=0;
	}
	
	if(!isset($post['name']) || !strlen($post['name']) ||
		!isset($post['email']) || !strlen($post['email']) ||
		!isset($post['review']) || !strlen($post['review'])){
		echo '</div>';
	}
	
	
	if($flag){
	 $DB->query('SELECT max(added) as max FROM feedback LIMIT 1');
	 if($DB->get_num_rows())
	 {
		$last_msg=$DB->fetch_row();
		$last_msg=$last_msg['max'];
		$now=time();
		if($now - $last_msg < 60*3 )
		{
		$flag=0;
		?>
			<div class="tooltip">
			<p style="color:red">Сработал АНТИСПАМ-фильтр.<br />Попробуйте отправить сообщение через <?=(3-round((($now-$last_msg)/60))+1)?> мин. </p>
				</div>
		<?
		}
	 }
	
	}
	
	
	$post['name']=htmlspecialchars($post['name']);
	$post['email']=htmlspecialchars($post['email']);
	$post['review']=htmlspecialchars($post['review']);

	if($flag)
	{
		$DB->query('INSERT INTO `feedback` (`name` ,`email` ,`review`, `added`)
		VALUES ("'.$post['name'].'", "'.$post['email'].'", "'.htmlspecialchars($post['review']).((isset($pathname[1])&&($pathname[1])=='gig')?htmlspecialchars('<br /><br />Ошибка в концерте <a href="/gig/'.$pathname[2].'">#'.$pathname[2].'</a>'):('')).'", "'.time().'")');
		
		?>
		<h3 style="color:green">Сообщение отослано! Спасибо!</h3>
		<p>В ближайшее время мы постараемся Вам ответить на указанный Email.</p>
		<?
	}

	unset($_SESSION['captcha_keystring']);
	
	$post['name']=stripslashes($post['name']);
	$post['email']=stripslashes($post['email']);
	$post['review']=stripslashes($post['review']);

	
	}
	if(!isset($flag) || !$flag ){
?>
<p>Нам очень важно Ваше мнение, вероятно оно поможет нам сделать сервис концертов ConcertInfo лучше!</p>
<div id="feedbackform" style="margin:0 auto; width:70%; padding:1em">

</div>

<?
}
?>
<a href="<?=$docroot?>/">На главную страницу</a>
<?
$page[] = ob_get_contents();
ob_end_clean();
?>