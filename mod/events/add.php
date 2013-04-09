<?php

$output->post_check();
$output->get_check();
ob_start();
global $page, $user, $output, $data, $cat, $mod,$docroot;
$title = 'Добавить концерт';
$post = $output->post_check();

if(!$output->AuthCheck() || isset($user) && $user['usertype']<2)
{
?>
	<div class="tooltip">
	Концерт будет добавлен в список мероприятий только после одобрения модератором.<br />
	Советуем указывать ссылки на встречу вконтакте\facebook\myspace, а также на сайт самого 
	мероприятия. Только для Санкт-Петербурга.
	</div>
<?}

if(sizeof($_POST))
{
    $post = $_POST;
}

?>

<h2>Добавить концерт</h2>

<?
	if(isset($get['please_check'])){?>
		<div class="tooltip">
			<p style="color:red">Ошибка ввода данных.<br />Попробуйте отправить информацию, заранее проверив дату начала и окончания, пустоту заголовка и описания.</p>
				</div>
	<?}
	
	if(isset($post)){

	if(!$output->AuthCheck() || isset($user) && $user['usertype']<2)
	{
	$active=0;
	}else{
	$active=1;
	}
	
	if(!isset($post['date_begin']) || empty($post['date_begin']) ||
		!isset($post['date_end']) || empty($post['date_end']) ||
		!isset($post['title']) || empty($post['title']) ){
			$output->redirect('/events/add?please_check');
	}
    
    $post['begin'] = strtotime($post['date_begin'].' '.$post['time_begin']);
    $post['end'] = strtotime($post['date_end'].' '.$post['time_end']);
    $post['added'] = time();
	$post['user_id'] = $user['id'];
	
	
	 $DB->query('SELECT max(added) as max FROM events LIMIT 1');
	 if($DB->get_num_rows())
	 {
		
		$last_msg=$DB->fetch_row();
		$last_msg=$last_msg['max'];
		$now=$post['added'];
		if(($now - $last_msg < 60*3) && $user['usertype']<2)
		{
		$flag=0;
		?>
			<div class="tooltip">
			<p style="color:red">Сработал АНТИСПАМ-фильтр.<br />Попробуйте отправить информацию через <?=(3-round((($now-$last_msg)/60))+1)?> мин. </p>
				</div>
		<?
		}
	 
	 else

	{
	
	if(isset($post['title'])){
	$post['title'] = htmlspecialchars(addslashes($post['title']));
	}	
	if(isset($post['review'])){
	$post['review'] = htmlspecialchars(addslashes($post['review']));
	}
	if(isset($post['price'])){
	$post['price'] = htmlspecialchars(addslashes($post['price']));
	}
	
	if(isset($post['url'])){
	$post['url'] = htmlspecialchars(addslashes($post['url']));
	}
	
	if(isset($post['vkontakte'])){
	$post['vkontakte'] = htmlspecialchars(addslashes($post['vkontakte']));
	}

	if(isset($post['myspace'])){
	$post['myspace'] = htmlspecialchars(addslashes($post['myspace']));
	}

	if(isset($post['facebook'])){
	$post['facebook'] = htmlspecialchars(addslashes($post['facebook']));
	}
	
    unset($post['time_begin'],$post['time_end'],$post['date_begin'],$post['date_end']);

	
	foreach(array_keys($post) as $index)
	{
		if(strstr($index,'tag'))
		{
			$post['tags'][]=$post[$index];
			unset($post[$index]);
		}
	}
	
	array_unique($post['tags']);
	
	$post['tags'] = implode(',', $post['tags']);

		echo '<pre>';
    echo"<br />";
    print_r($post);
    echo '</pre>';
	
    $query = $DB->compile_db_insert_string($post);
	print_r($query);

	
	$DB->query('INSERT INTO '.$pathname[0].'
		('.$query['FIELD_NAMES'].')
		VALUES
    	('.$query['FIELD_VALUES'].')');
	$item_id = $DB->get_insert_id();
	
    add_foto($item_id);
	
	
    echo 'INSERT INTO '.$pathname[0].'
		('.$query['FIELD_NAMES'].')
		VALUES
    	('.$query['FIELD_VALUES'].')';


   echo"<br />";
    
	?>
<img src="<?=$docroot?>/data/events/preview/<?=$item_id?>.jpg" alt="photo"/>
<img src="<?=$docroot?>/data/events/m/<?=$item_id?>.jpg" alt="photo"/>
<img src="<?=$docroot?>/data/events/covers/<?=$item_id?>.jpg" alt="photo"/>


<?

if( $output->AuthCheck() && isset($user) && $user['usertype']<2 ){
	//Экспортируем
	$output->redirect($docroot.'/export/export.php?gig='.$item_id);
}
else
{
	//На главную.
	$output->redirect($docroot.'/?added='.$item_id);
}

}
}
}


?>

<form action="<?=$docroot?>/events/add" method="post" enctype="multipart/form-data">
    <table style="width:100%">
       <thead></thead>
        <tbody>
           <tr>
           <td style="text-align:center; width: 40%; vertical-align:top">

    <p>Название концерта</p>
    <input type="text" name="title" id="title" placeholder="Введите название мероприятия" autofocus required/>


    <p>Описание концерта</p>
    <textarea name="review" placeholder="Введите описание концерта" id="review" cols="48" rows="8" required></textarea>
    <p>Информация о ценах</p>
    <textarea name="price" placeholder="Введите информацию о ценах" id="price" cols="48" rows="3"></textarea>
    </td>

    <td style="text-align:center; width: 40%">

   <p>Клуб</p>
   <select id="place" name="place">
   <?
    $DB->query('SELECT id, title FROM place ORDER BY title');
    if($DB->get_num_rows())
    {
        while ($place=$DB->fetch_row())
        {?>
       <option value="<?=$place['id']?>"><?=$place['title']?></option>  
        <?}
    }
    
   ?>
   </select>
  
    <p>Организатор</p>
   <select id="agency" name="agency">
       <option value="0">- Неизвестно -</option>
   <?
    $DB->query('SELECT id, title FROM agency ORDER BY title');
    if($DB->get_num_rows())
    {
        while ($place=$DB->fetch_row())
        {?>
       <option value="<?=$place['id']?>"><?=$place['title']?></option>
        <?}
    }

   ?>
   </select>


    <table style="text-align:center">
        <tr>
         <td>
    <p>Дата начала</p>
    <input type="text" name="date_begin" id="date_begin" required/>
    </td>
    <td>
    <p>Время начала</p>
   <select id="time_begin" name="time_begin">
    <option value="10:00">10:00</option>
    <option value="10:30">10:30</option>
    <option value="11:00">11:00</option>
    <option value="11:30">11:30</option>
    <option value="12:00">12:00</option>
    <option value="12:30">12:30</option>
    <option value="13:00">13:00</option>
    <option value="13:30">13:30</option>
    <option value="14:00">14:00</option>
    <option value="14:30">14:30</option>
    <option value="15:00">15:00</option>
    <option value="15:30">15:30</option>
    <option value="16:00">16:00</option>
    <option value="16:30">16:30</option>
    <option value="17:00">17:00</option>
    <option value="17:30">17:30</option>
    <option value="18:00" selected="selected">18:00</option>
    <option value="18:30">18:30</option>
    <option value="19:00">19:00</option>
    <option value="19:30">19:30</option>
    <option value="20:00">20:00</option>
    <option value="20:30">20:30</option>
    <option value="21:00">21:00</option>
    <option value="21:30">21:30</option>
    <option value="22:00">22:00</option>
    <option value="22:30">22:30</option>
    <option value="23:00">23:00</option>
    <option value="23:30">23:30</option>
    <option value="00:00">00:00</option>
    </select>
    </td></tr>
	<tr>
	<td>
	    <p>Дата окончания</p>
    <input type="text" name="date_end" id="date_end" required/>
	</td>
    <td>
    <p>Время окончания</p>
   <select id="time_end" name="time_end">
    <option value="10:00">10:00</option>
    <option value="10:30">10:30</option>
    <option value="11:00">11:00</option>
    <option value="11:30">11:30</option>
    <option value="12:00">12:00</option>
    <option value="12:30">12:30</option>
    <option value="13:00">13:00</option>
    <option value="13:30">13:30</option>
    <option value="14:00">14:00</option>
    <option value="14:30">14:30</option>
    <option value="15:00">15:00</option>
    <option value="15:
	30">15:30</option>
    <option value="16:00">16:00</option>
    <option value="16:30">16:30</option>
    <option value="17:00">17:00</option>
    <option value="17:30">17:30</option>
    <option value="18:00">18:00</option>
    <option value="18:30">18:30</option>
    <option value="19:00">19:00</option>
    <option value="19:30">19:30</option>
    <option value="20:00">20:00</option>
    <option value="20:30">20:30</option>
    <option value="21:00">21:00</option>
    <option value="21:30">21:30</option>
    <option value="22:00">22:00</option>
    <option value="22:30">22:30</option>
    <option value="23:00" selected="selected">23:00</option>
    <option value="23:30">23:30</option>
    <option value="00:00">00:00</option>
    <option value="00:30">00:30</option>
    <option value="01:00">01:00</option>
    <option value="01:30">01:30</option>
    <option value="02:00">02:00</option>
    <option value="02:30">02:30</option>
    <option value="03:00">03:00</option>
    <option value="03:30">03:30</option>
    <option value="04:00">04:00</option>
    <option value="04:30">04:30</option>
    <option value="05:00">05:00</option>
    <option value="05:30">05:30</option>
    <option value="06:00">06:00</option>
    <option value="06:30">06:30</option>
    <option value="07:00">07:00</option>
    <option value="07:30">07:30</option>
    <option value="08:00">08:00</option>
    <option value="08:30">08:30</option>
    <option value="09:00">09:00</option>
    <option value="09:30">09:30</option>
   </select>
    </td>
    </tr>
    </table>



    <p>Изображение с нашим лого (jpg/png, 3:4, не более 5Mb )</p>
    <input name="upload_file" id="upload_file" type="file" />
    </td>
    </tr>
        </tbody>

    </table>
	<br style="clear:both"/>
	
	<div style="float:left; width:48%">
      <p>Страница мероприятия в интернете</p>
    <input type="text" name="url" id="url" value="" placeholder="Официальная страница в Интернете" />

      <p>ВКонтакте</p>
    <input type="text" name="vkontakte" id="vkontakte" value="" placeholder="Встреча ВКонтакте" />

      <p>MySpace</p>
    <input type="text" name="myspace" id="myspace" value="" placeholder="Встреча MySpace" />

      <p>Facebook</p>
    <input type="text" name="facebook" id="facebook" value="" placeholder="Встреча Facebook" />
	</div>
	
	
	<div style="float:left; width:48%; text-align:left">
	<p>Выберите категорию:</p>
	<?
		$DB->query('SELECT id,title FROM tags');
		if($DB->get_num_rows())
		{
			while($tag=$DB->fetch_row())
			{
				?>
				
				   <p>
				   <label for="tag<?=$tag['id']?>">
				  <input type="checkbox" id="tag<?=$tag['id']?>" name="tag<?=$tag['id']?>" value="<?=$tag['id']?>" />
				   <?=$tag['title']."\n"?>
				   </label>
				   </p>
				
				
				<?
			}
			
		}
	
	?>
	
	</div>
	<br style="clear:both"/>
    <p style="text-align: center">
    <input type="submit" value="Отправить" />
    </p>

</form>

<script type="text/javascript">
$(document).ready(function(){
  $('#date_begin').attachDatepicker({
  	yearRange: '<?=date('Y',time())?>:<?=((int)date('Y',time())+2)?>',
  	firstDay: 1
  });
  
  $('#date_end').attachDatepicker({
  	yearRange: '<?=date('Y',time())?>:<?=((int)date('Y',time())+2)?>',
  	firstDay: 1
  });
});

$('#date_begin').change(function() {
  var $value = $(this).val();
  $('#date_end').val($value);
});
</script>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>
