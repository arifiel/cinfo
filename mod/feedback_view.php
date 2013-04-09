<?php

$output->post_check();
$output->get_check();
ob_start();
global $page, $output, $data, $cat, $mod,$docroot;
$title = 'Сообщения обратной связи';

if(!$output->AuthCheck('admin'))
{
	error(401);
}

?>

<h1>Сообщения обратной связи</h1>

<?if (isset($get['send']) && $get['send']=='reply'){
	
	
	if(isset($post['email']) && isset($post['review']) && isset($post['title'])){
	echo '<strong>"'.$post['title'].'" отправлено на < '.$post['email'].' ></strong><br />';
	echo ''.nl2br($post['review']).'<br />';
	
	$output->send_mail($post['title'],nl2br($post['review']),$post['email']);
	echo '<a href="../">На главную</a>';
	} else {
	echo'Сообщение не отправлено :(';
	}

	} else {

$DB->query('SELECT * FROM feedback ORDER BY added DESC LIMIT 30');
if($DB->get_num_rows())
{
	while($comment=$DB->fetch_row())
	{?>
	<div style="background-color:#eee; font-size:0.8em; border:4px solid gray; padding:5px; margin:5px; width:95%">	
	<?
		echo '<strong>'.$comment['name'].' '.'<a hfef="mailto:'.$comment['email'].'">'.$comment['email'].'</a>, '.date('d.m.Y, H:i',$comment['added']).'</strong><br />';
		echo htmlspecialchars_decode($output->message_show($comment['review']));
	?>
	<br />[ <a href="#" onclick="$('#reply<?=$comment['id']?>').toggle('quick')">Ответить</a> ]
	<form action="?send=reply" method="post" style="display:none; padding:1em; border: 1px dotted silver" id="reply<?=$comment['id']?>">
		Кому: <input name="email" id="email" value="<?=$comment['email']?>" /><br />
		Тема: <input name="title" id="title" value="Re: Отзыв на Conertinfo.Ru" /><br />
		
		Ответ: <textarea style="height:150px" name="review" id="review"><?='>'.strip_tags(str_replace("\n","\n>",($output->message_show($comment['review']))));?></textarea><br />		
		<input type="submit" value="Отправить ответ на Email" />
	</form>
	
	
	</div>
	<?}

}
}

$page[] = ob_get_contents();
ob_end_clean();
?>
