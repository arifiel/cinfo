<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod,$docroot;
$title = 'Редактировать концерт';
$post = $output->post_check();

if(!$output->AuthCheck())
{
	error(401);
}

if(sizeof($_POST))
{
    $post = $_POST;
}

?>

<h1>Редактировать концерт</h1>

<?
	$DB->query('SELECT * FROM events WHERE id ='.$pathname[2]);
    if($DB->get_num_rows())
    {
        $event = $DB->fetch_row();
	
		
	if(isset($post)){
    
    $post['begin'] = strtotime($post['date_begin'].' '.$post['time_begin']);
    $post['end'] = strtotime($post['date_end'].' '.$post['time_end']);
    $post['edited'] = time();
	$post['user_id'] = $user['id'];

	//Защищаем от спецсимволов
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
	
    $query = $DB->compile_db_update_string($post);
	$DB->query('UPDATE '.$pathname[0].'
		SET '.$query.'
	WHERE
		`id` = "'.$pathname[2].'"
	LIMIT 1
         ');
		 
		 
    add_foto($pathname[2]);
   echo"<br />";
    
	?>


<?

$output->redirect($docroot.'/gig/'.$pathname[2]);
	
}


?>

<form action="#" method="post" enctype="multipart/form-data">
    <table style="width:100%">
       <thead></thead>
        <tbody>
           <tr>
           <td style="text-align:center; width: 40%; vertical-align:top">

    <p>Название концерта</p>
    <input type="text" name="title" id="title" value="<?=stripslashes(($event['title']))?>" placeholder="Название" />

    <p>Описание концерта</p>
    <textarea name="review" id="review"  cols="48" rows="8"><?=stripslashes(htmlspecialchars_decode($event['review']))?></textarea>
    <p>Информация о ценах</p>
    <textarea name="price" id="price" cols="48" rows="3"><?=stripslashes(htmlspecialchars_decode($event['price']))?></textarea>
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
       <option value="<?=$place['id']?>" <?if($place['id']==$event['place']){echo ' selected="selected" ';}?>><?=$place['title']?> </option>
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
        while ($agency=$DB->fetch_row())
        {?>
       <option value="<?=$place['id']?>" <?if($agency['id']==$event['agency']){echo ' selected="selected" ';}?> ><?=$agency['title']?></option>
        <?}
    }

   ?>
   </select>


    <table style="text-align:center">
        <tr>
         <td>
    <p>Дата начала</p>
    <input type="text" name="date_begin" id="date_begin" value="<?=date("d.m.Y",$event['begin'])?>" />
    </td>
    <td>
    <p>Время начала</p>
   <select id="time_begin" name="time_begin">
    <option value="10:00" <?=date("H:i",$event['begin'])=='10:00'?'selected="selected"':""?>>10:00</option>
    <option value="10:30" <?=date("H:i",$event['begin'])=='10:30'?'selected="selected"':""?>>10:30</option>
    <option value="11:00" <?=date("H:i",$event['begin'])=='11:00'?'selected="selected"':""?>>11:00</option>
    <option value="11:30" <?=date("H:i",$event['begin'])=='11:30'?'selected="selected"':""?>>11:30</option>
    <option value="12:00" <?=date("H:i",$event['begin'])=='12:00'?'selected="selected"':""?>>12:00</option>
    <option value="12:30" <?=date("H:i",$event['begin'])=='12:30'?'selected="selected"':""?>>12:30</option>
    <option value="13:00" <?=date("H:i",$event['begin'])=='13:00'?'selected="selected"':""?>>13:00</option>
    <option value="13:30" <?=date("H:i",$event['begin'])=='13:30'?'selected="selected"':""?>>13:30</option>
    <option value="14:00" <?=date("H:i",$event['begin'])=='14:00'?'selected="selected"':""?>>14:00</option>
    <option value="14:30" <?=date("H:i",$event['begin'])=='14:30'?'selected="selected"':""?>>14:30</option>
    <option value="15:00" <?=date("H:i",$event['begin'])=='15:00'?'selected="selected"':""?>>15:00</option>
    <option value="15:30" <?=date("H:i",$event['begin'])=='15:30'?'selected="selected"':""?>>15:30</option>
    <option value="16:00" <?=date("H:i",$event['begin'])=='16:00'?'selected="selected"':""?>>16:00</option>
    <option value="16:30" <?=date("H:i",$event['begin'])=='16:30'?'selected="selected"':""?>>16:30</option>
    <option value="17:00" <?=date("H:i",$event['begin'])=='17:00'?'selected="selected"':""?>>17:00</option>
    <option value="17:30" <?=date("H:i",$event['begin'])=='17:30'?'selected="selected"':""?>>17:30</option>
    <option value="18:00" <?=date("H:i",$event['begin'])=='18:00'?'selected="selected"':""?>>18:00</option>
    <option value="18:30" <?=date("H:i",$event['begin'])=='18:30'?'selected="selected"':""?>>18:30</option>
    <option value="19:00" <?=date("H:i",$event['begin'])=='19:00'?'selected="selected"':""?>>19:00</option>
    <option value="19:30" <?=date("H:i",$event['begin'])=='19:30'?'selected="selected"':""?>>19:30</option>
    <option value="20:00" <?=date("H:i",$event['begin'])=='20:00'?'selected="selected"':""?>>20:00</option>
    <option value="20:30" <?=date("H:i",$event['begin'])=='20:30'?'selected="selected"':""?>>20:30</option>
    <option value="21:00" <?=date("H:i",$event['begin'])=='21:00'?'selected="selected"':""?>>21:00</option>
    <option value="21:30" <?=date("H:i",$event['begin'])=='21:30'?'selected="selected"':""?>>21:30</option>
    <option value="22:00" <?=date("H:i",$event['begin'])=='22:00'?'selected="selected"':""?>>22:00</option>
    <option value="22:30" <?=date("H:i",$event['begin'])=='22:30'?'selected="selected"':""?>>22:30</option>
    <option value="23:00" <?=date("H:i",$event['begin'])=='23:00'?'selected="selected"':""?>>23:00</option>
    <option value="23:30" <?=date("H:i",$event['begin'])=='23:30'?'selected="selected"':""?>>23:30</option>
    <option value="00:00" <?=date("H:i",$event['begin'])=='00:00'?'selected="selected"':""?>>00:00</option>
    </select>
    </td></tr>
	<tr>
	<td>
	    <p>Дата окончания</p>
    <input type="text" name="date_end" id="date_end" value="<?=date("d.m.Y",$event['end'])?>" />
	</td>
    <td>
    <p>Время окончания</p>
  <select id="time_end" name="time_end">
    <option value="10:00" <?=date("H:i",$event['end'])=='10:00'?'selected="selected"':""?>>10:00</option>
    <option value="10:30" <?=date("H:i",$event['end'])=='10:30'?'selected="selected"':""?>>10:30</option>
    <option value="11:00" <?=date("H:i",$event['end'])=='11:00'?'selected="selected"':""?>>11:00</option>
    <option value="11:30" <?=date("H:i",$event['end'])=='11:30'?'selected="selected"':""?>>11:30</option>
    <option value="12:00" <?=date("H:i",$event['end'])=='12:00'?'selected="selected"':""?>>12:00</option>
    <option value="12:30" <?=date("H:i",$event['end'])=='12:30'?'selected="selected"':""?>>12:30</option>
    <option value="13:00" <?=date("H:i",$event['end'])=='13:00'?'selected="selected"':""?>>13:00</option>
    <option value="13:30" <?=date("H:i",$event['end'])=='13:30'?'selected="selected"':""?>>13:30</option>
    <option value="14:00" <?=date("H:i",$event['end'])=='14:00'?'selected="selected"':""?>>14:00</option>
    <option value="14:30" <?=date("H:i",$event['end'])=='14:30'?'selected="selected"':""?>>14:30</option>
    <option value="15:00" <?=date("H:i",$event['end'])=='15:00'?'selected="selected"':""?>>15:00</option>
    <option value="15:30" <?=date("H:i",$event['end'])=='15:30'?'selected="selected"':""?>>15:30</option>
    <option value="16:00" <?=date("H:i",$event['end'])=='16:00'?'selected="selected"':""?>>16:00</option>
    <option value="16:30" <?=date("H:i",$event['end'])=='16:30'?'selected="selected"':""?>>16:30</option>
    <option value="17:00" <?=date("H:i",$event['end'])=='17:00'?'selected="selected"':""?>>17:00</option>
    <option value="17:30" <?=date("H:i",$event['end'])=='17:30'?'selected="selected"':""?>>17:30</option>
    <option value="18:00" <?=date("H:i",$event['end'])=='18:00'?'selected="selected"':""?>>18:00</option>
    <option value="18:30" <?=date("H:i",$event['end'])=='18:30'?'selected="selected"':""?>>18:30</option>
    <option value="19:00" <?=date("H:i",$event['end'])=='19:00'?'selected="selected"':""?>>19:00</option>
    <option value="19:30" <?=date("H:i",$event['end'])=='19:30'?'selected="selected"':""?>>19:30</option>
    <option value="20:00" <?=date("H:i",$event['end'])=='20:00'?'selected="selected"':""?>>20:00</option>
    <option value="20:30" <?=date("H:i",$event['end'])=='20:30'?'selected="selected"':""?>>20:30</option>
    <option value="21:00" <?=date("H:i",$event['end'])=='21:00'?'selected="selected"':""?>>21:00</option>
    <option value="21:30" <?=date("H:i",$event['end'])=='21:30'?'selected="selected"':""?>>21:30</option>
    <option value="22:00" <?=date("H:i",$event['end'])=='22:00'?'selected="selected"':""?>>22:00</option>
    <option value="22:30" <?=date("H:i",$event['end'])=='22:30'?'selected="selected"':""?>>22:30</option>
    <option value="23:00" <?=date("H:i",$event['end'])=='23:00'?'selected="selected"':""?>>23:00</option>
    <option value="23:30" <?=date("H:i",$event['end'])=='23:30'?'selected="selected"':""?>>23:30</option>
    <option value="00:00" <?=date("H:i",$event['end'])=='00:00'?'selected="selected"':""?>>00:00</option>
    <option value="00:30" <?=date("H:i",$event['end'])=='00:30'?'selected="selected"':""?>>00:30</option>
    <option value="01:00" <?=date("H:i",$event['end'])=='01:00'?'selected="selected"':""?>>01:00</option>
    <option value="01:30" <?=date("H:i",$event['end'])=='01:30'?'selected="selected"':""?>>01:30</option>
    <option value="02:00" <?=date("H:i",$event['end'])=='02:00'?'selected="selected"':""?>>02:00</option>
    <option value="02:30" <?=date("H:i",$event['end'])=='02:30'?'selected="selected"':""?>>02:30</option>
    <option value="03:00" <?=date("H:i",$event['end'])=='03:00'?'selected="selected"':""?>>03:00</option>
    <option value="03:30" <?=date("H:i",$event['end'])=='03:30'?'selected="selected"':""?>>03:30</option>
    <option value="04:00" <?=date("H:i",$event['end'])=='04:00'?'selected="selected"':""?>>04:00</option>
    <option value="04:30" <?=date("H:i",$event['end'])=='04:30'?'selected="selected"':""?>>04:30</option>
    <option value="05:00" <?=date("H:i",$event['end'])=='05:00'?'selected="selected"':""?>>05:00</option>
    <option value="05:30" <?=date("H:i",$event['end'])=='05:30'?'selected="selected"':""?>>05:30</option>
    <option value="06:00" <?=date("H:i",$event['end'])=='06:00'?'selected="selected"':""?>>06:00</option>
    <option value="06:30" <?=date("H:i",$event['end'])=='06:30'?'selected="selected"':""?>>06:30</option>
    <option value="07:00" <?=date("H:i",$event['end'])=='07:00'?'selected="selected"':""?>>07:00</option>
    <option value="07:30" <?=date("H:i",$event['end'])=='07:30'?'selected="selected"':""?>>07:30</option>
    <option value="08:00" <?=date("H:i",$event['end'])=='08:00'?'selected="selected"':""?>>08:00</option>
    <option value="08:30" <?=date("H:i",$event['end'])=='08:30'?'selected="selected"':""?>>08:30</option>
    <option value="09:00" <?=date("H:i",$event['end'])=='09:00'?'selected="selected"':""?>>09:00</option>
    <option value="09:30" <?=date("H:i",$event['end'])=='09:30'?'selected="selected"':""?>>09:30</option>
   </select>
    </td>
    </tr>
    </table>



    <img style="float:right" src="<?=$docroot?>/data/events/m/<?=$event['id']?>.jpg" alt="Картинка мероприятия" />
    <p>Изображение (jpg/png, 3:4, не более 5Mb )</p>
	<input name="upload_file" id="upload_file" type="file" />
    </td>
    </tr>
        </tbody>

    </table>
	<br style="clear:both"/>
	
	<div style="float:left; width:48%">
    <p>Страница мероприятия в интернете</p>
    <input type="url" name="url" id="url" value="<?=stripslashes(htmlspecialchars_decode($event['url']))?>" placeholder="Название" />

      <p>ВКонтакте</p>
    <input type="url" name="vkontakte" id="vkontakte" value="<?=stripslashes(htmlspecialchars_decode($event['vkontakte']))?>" placeholder="Название" />

      <p>MySpace</p>
    <input type="url" name="myspace" id="myspace" value="<?=stripslashes(htmlspecialchars_decode($event['myspace']))?>" placeholder="Название" />

      <p>Facebook</p>
    <input type="url" name="facebook" id="facebook" value="<?=stripslashes(htmlspecialchars_decode($event['facebook']))?>" placeholder="Название" />
	</div>
	
	
	<div style="float:left; width:48%; text-align:left">
	<p>Категория:</p>
	<?
	
		$event['tags']=explode(',',$event['tags']);

		$DB->query('SELECT id,title FROM tags');
		if($DB->get_num_rows())
		{
			while($tag=$DB->fetch_row())
			{
				?>
				
				   <p>
				   <label for="tag<?=$tag['id']?>">
				  <input type="checkbox" id="tag<?=$tag['id']?>" <?if(in_array($tag['id'],$event['tags'])){?>checked="checked"<?}?> name="tag<?=$tag['id']?>" value="<?=$tag['id']?>" />
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
	<select style="margin-left:1em" name="active" id="active">
		<option style="color:red; font-weight: bolder" value="0" <?=$event['active']==0?'selected="selected"':''?>>Неактивное (нет нигде на сайте)</option>
		<option style="color:green; font-weight: bolder" value="1" <?=$event['active']==1?'selected="selected"':''?>>Активное (есть везде)</option>
	</select>
    </p>

</form>

<script type="text/javascript">
$(document).ready(function(){
  $('#date_begin').attachDatepicker({
  	yearRange: '2011:2015',
  	firstDay: 1
  });
  
  $('#date_end').attachDatepicker({
  	yearRange: '2011:2015',
  	firstDay: 1
  });
});

$('#date_begin').change(function() {
  var $value = $(this).val();
  
  if($('#date_end').val()<$value){
  $('#date_end').val($value);
  }
});
</script>

<?
    } else {error(404);}
$page[] = ob_get_contents();
ob_end_clean();
?>
