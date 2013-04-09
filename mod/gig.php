<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod,$conf;

if(!isset($pathname[1]) || !is_numeric($pathname[1]))
{
    error(404);
}

$DB->query('SELECT `events`.`id`, 
                   `events`.`title`,
                   `events`.`review`,
                   `events`.`begin`,
                   `events`.`end`,
                   `events`.`active`,
				   `events`.`tags`,
				   `events`.`review`,
                   `events`.`price`,				   
                   `events`.`url`,
                   `events`.`vkontakte`,
                   `events`.`myspace`,
                   `events`.`facebook`,
				   `events`.`place` as `place_id`,
                   `place`.`title` as `place`,
	           `place`.`yandex_x` as `x`,
	           `place`.`yandex_y` as `y`,
	           `place`.`address` as `address`
                    FROM `events`
                    LEFT JOIN `place` ON `place`.`id` = `events`.`place`
                    WHERE
                        `events`.`id` = "'.(int)$pathname[1].'"
                            ORDER BY `begin` LIMIT 1' );

if($DB->get_num_rows())
{
    $event=$DB->fetch_row();
	$event['title']=$output->message_show($event['title']);
	$event['price']=$output->message_show($event['price'],1);
	$event['review']=$output->message_show($event['review'],1);
	$event['url']=$output->message_show($event['url']);
	$event['vkontakte']=$output->message_show($event['vkontakte']);
	$event['myspace']=$output->message_show($event['myspace']);
	$event['facebook']=$output->message_show($event['facebook']);
	
	
	
	
    $title = "Концерт ".(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1].' '.date("Y",$event['begin']). ', '.$event['title'].' ('.$event['place'].')';
    
	
    $description = str_replace("\n"," ",$event['review']);
    $description = str_replace("\r"," ",$description);
    $description = str_replace('"',"'",$description);
    $description = "Концерт ".$description.", ме, вечеринка, мероприятие, метал, металл";

	
	if(!$event['active']){
	
	if($output->AuthCheck('admin'))
	{?>
	<div class="tooltip">
	Концерт неподтвержден, <a href="<?=$docroot?>/events/edit/<?=$event['id']?>">отредактируйте</a> для подтверждения.
	
	</div>
	<?}
	else
	{
		error(404);
	}
	
	}
  
    {?>

        <div class="container-right">

                       <div class="sidebar">
		<div style="text-align:center">
        <?if(0){?>
        <div id="vk_like"></div>
        <script type="text/javascript">
        VK.Widgets.Like("vk_like", {type: "button", verb: 1, pageTitle:"<?=((int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1]).', '.$event['title'].' ('.$event['place'].')';?>", pageUrl:"<?='http://concertinfo.ru/'.$pathname[0].'/'.$pathname[1]?>/", pageImage: "<?='http://concertinfo.ru/data/events/covers/'.$pathname[1].'.jpg'?>", page_id: <?=$pathname[1]?> });
        </script>

	<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="concert_info" data-lang="ru">Твитнуть</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

	<iframe src="http://www.facebook.com/plugins/like.php?href=<?='http://concertinfo.ru/'.$pathname[0].'/'.$pathname[1]?>&amp;layout=standard&amp;show_faces=false&amp;width=200&amp;action=like&amp;font=tahoma&amp;colorscheme=light&amp;height=35"
        scrolling="no" frameborder="0"
        style="border:none; width:200px; height:35px"></iframe>


	<g:plusone></g:plusone>

	<a target="_blank" class="mrc__plugin_like_button" href="http://connect.mail.ru/share?share_url=http%3A%2F%2Fconcertinfo.ru%2Fgig%2F<?=$pathname[1]?>" data-mrc-config="{'type' : 'button', 'width' : '90'}">Нравится</a>
    <script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>

        <br />
        <?}
		if($output->AuthCheck('admin')){
        ?>
		<a href="<?=$docroot?>/events/edit/<?=$pathname[1]?>">Редактировать</a><br />
		<?if($event['active']){?>
		<a onclick="if (!confirm('Точно экспортировать это событие в соц. сети?')) {return false;}" href="<?=$docroot?>/export/export.php?gig=<?=$pathname[1]?>">Экспорт</a><br />		
		<?} else {
		?><a href="<?=$docroot?>/events/delete/<?=$pathname[1]?>">Удалить</a><br /><?
		}
		}?>
		<div style="text-align:center; border:1px solid gray; width:160px; margin-left:40px">
			<div id='calendar_weekday' style="background-color: #900; width:100%; padding-top:0.5em; padding-bottom:0.5em; text-align:center; color:white; font-size:1em">
				<?=$conf['weekdays_full'][(int)date("w",$event['begin'])]?>
			</div>
			
			<div id='calendar_monthday' style="width:100%; margin:0; padding:0; font-size:4em; font-weight:bold">
				<?=(int)date("d",$event['begin'])?>
			</div>
			
			<div id="calendar_monthname" style="width:100%; margin:0; padding:0;">
				<?=$conf['monthof'][(int)date("m",$event['begin'])-1]?>
			</div>
			
			<div id="calendar_time" style="width:100%; margin:0; padding:0; font-size:0.9em; color:gray">
				<?=date("H:i",$event['begin']);?>-<?=date("H:i",$event['end']);?>
			</div>
			
		</div>
		
        </div>
		
        <p style="text-align:center"><?
		if(is_file("data/places/".$event['place_id'].'.png'))
		{?>
			<img src="<?=$docroot?>/data/places/<?=$event['place_id']?>.png" alt="<?=$event['place']?>" style="width:200px; height:80px" />
		<?} else {
		echo '<div style="text-align:center"><h3>'.$event['place'].'</h3></div>';
		}
		
		?></p>
		
	<?if(strlen($event['x']) && strlen($event['y'])){?>
	<div id="YMapsID" style="width:220px;height:300px"></div>
	<script type="text/javascript">
	window.onload = function () {
		var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
		map.setCenter(new YMaps.GeoPoint(<?=$event['x']?>,<?=$event['y']?>),14);
		map.openBalloon(new YMaps.GeoPoint(<?=$event['x']?>, <?=$event['y']?>), "<?=$event['place']?>", {maxWidth:100});
	    };
	</script>
	<?}?>
	<p style="font-size:0.7em; text-align:center"><?=$event['address']?></p>
        <br />
        <hr />
        <? if(strlen($event['vkontakte']) ||
	      strlen($event['facebook']) ||
	      strlen($event['url']) ||
	      strlen($event['myspace'])	){?>
   <strong>Ссылки:</strong><br />
	<?}?>

	<?if(strlen($event['url'])){?>
        <a rel="nofollow" target="_blank" class="homepage" title="<?=$event['title']?>. Домашняя страница события" href="<?=$event['url']?>">В интернете</a><br />
	<?}?>

	<?if(strlen($event['vkontakte'])){?>
        <a rel="nofollow" target="_blank" title="<?=$event['title']?>. Встреча ВКонтакте" href="<?=$event['vkontakte']?>">ВКонтакте</a><br />
	<?}?>

	<?if(strlen($event['facebook'])){?>
        <a rel="nofollow" target="_blank" title="<?=$event['title']?>. Встреча Facebook" href="<?=$event['facebook']?>">Facebook</a><br />
	<?}?>

	<?if(strlen($event['myspace'])){?>
        <a rel="nofollow" target="_blank" title="<?=$event['title']?>. Встреча MySpace" href="<?=$event['myspace']?>">MySpace</a><br />
	<?}?>

        </div>

         <div class="content">
   
         <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>

		<div style="float:right; font-size:0.7em;">
		<a href="/feedback/gig/<?=$event['id']?>" class="error">Сообщить об ошибке</a>
		</div>
        <h1><?=$title?></h1>
		<? if($event['end']<time()){?>
			<div class="tooltip">
				Мероприятие состоялось <?=(int)date("d",$event['end']).' '.$conf['monthof'][(int)(date("m",$event['end']))-1].' '.date("Y",$event['end'])?>
			</div>
		<?} ?>
        <div style="font-size:15px" class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,friendfeed,moikrug"></div>
        <div class="gig_big_image">
        <img src="<?=$docroot?>/data/events/covers/<?=$event['id']?>.jpg" style="max-width:360px; padding: 0.5em" alt="<?=$title?>" />
        </div>
		<?if (isset($event['review']) && !empty($event['review'])) {?>
		<p class="gig_review">
		<strong>Описание:</strong><br />	
		<?=$event['review']?>
		</p>
		<?}?>
		
		<?if (isset($event['price']) && !empty($event['price'])) {?>
    	<?if (isset($event['review']) && !empty($event['review'])) {?>
		<br />
		<?}?>
		
		<p class="gig_price">
		<strong>О ценах / Купить билет:</strong><br />	
		<?=$event['price']?>
		</p><br />
		<?}?>
		
		<?if(strlen($event['tags'])){?>		
		<p class="gig_tags">
		<strong>Категория:</strong><br />
		<?
			$event['tags']=explode(',', $event['tags']);
			
			
			$DB->query('SELECT id,title FROM tags');
			if($DB->get_num_rows())
			{
				while($tag[]=$DB->fetch_row());
			}
			
			$tags=array();
			
			foreach($tag as $t)
			{
				if(in_array($t['id'], $event['tags'])){
				$tags[]=$t['title'];
				}
			}
			
			$tags=implode(', ', $tags);
			echo $tags;
			
			
		?>
		</p>

		<?}?>
		
        <hr />
       
      
			<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: true, 
				continuous: true,
			});
		});	
	</script>

	<?
	$toview = array();
	$tags = $event['tags'];
	
	$DB->query('SELECT DISTINCT  `id`,`tags`,`title`,`begin` FROM `events`
            WHERE `events`.`end` > '.time().' AND tags NOT LIKE "" AND id!="'.$pathname[1].'" ORDER BY `title` LIMIT 100' );
			
	if($DB->get_num_rows())
	{
		
		while($gig = $DB->fetch_row())
		{
			$a['priority']=0;
			$a['begin']=-$gig['begin'];
			$a['title']=$gig['title'];
			$a['tags']=$gig['tags'];
			$a['id']=$gig['id'];
			
			$gigs[]=$a;
		};	
		
		$gig_size=sizeof($gigs);
		
		//Делаем из строки тегов массив
		for($i=0; $i<$gig_size; $i++){
		if(strstr($gigs[$i]['tags'],","))
			{
			  $gigs[$i]['tags']=explode(",",$gigs[$i]['tags']);	  
	        } else {
			
			$a=$gigs[$i]['tags'];
			
			unset($gigs[$i]['tags']);
			$gigs[$i]['tags'][0]=$a;
			
			}
		}
		
		//Заполняем у каждого количество совпадений
		for($i=0; $i<$gig_size; $i++)
		{
			
			if(isset($event['tags']) && is_array($event['tags']))
			foreach($event['tags'] as $t)
			{
				if(in_array($t,$gigs[$i]['tags']))
				{
					$gigs[$i]['priority']++;
					
					if($gigs[$i]['id']==7 || 
					$gigs[$i]['id']==173){
					$gigs[$i]['priority']+=5;
					}
				}
			}
			
			if ($gigs[$i]['priority'] == 0 || !is_file('data/events/m/'.$gigs[$i]['id'].'.jpg'))
			{
				unset($gigs[$i]);
			}
		}
		
			arsort($gigs);

		foreach($gigs as $g)
		{
			//Правим индексы
			$events[]=$g;
		}

	if($event['end']<time()){
	
	$DB->query('SELECT DISTINCT  `id`,`events`,`user_id`,`added` FROM `photo`
            WHERE `events` = '.$pathname[1].' AND active = 1 ORDER BY `added` ');
	
		if($DB->get_num_rows()){
		
		while($p=$DB->fetch_row()){
		$photos[]=$p;
		}
		
	?>
	
	<link rel="stylesheet" type="text/css" href="/css/fancybox.css" />

	<div class="content_block" >
	<?if($output->AuthCheck('admin')){?>
	<div style="float:right"><a href="#">Загрузить фото</a></div>
	<?}
	$title='Фотоотчёт, '.$title;
	?>
	<h2 style="margin-top:-0.2em; margin-bottom:0.2em; text-align:center" id="photos">Фотоотчёт</h2>
	
	<ul id="gallery">

	
	<?
		foreach($photos as $p){
  
			echo '<li>
					<a class="lightbox-enabled"	rel="lightbox-stream" title="Фотография с концерта '.(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1].' '.date("Y",$event['begin']). ', '.$event['title'].' ('.$event['place'].')" rel="fancy-tour" href="/data/photo/big/'.$p['id'].'.jpg"
					><img src="/data/photo/min/'.$p['id'].'.jpg" alt="'."Фотография с концерта ".(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1].' '.date("Y",$event['begin']). ', '.$event['title'].' ('.$event['place'].')" 
					/></a>
				</li>';
		}
	?>	
  </ul>

	</div>

	<?}
	
	if($output->AuthCheck('admin')){
	?>
	
		Загрузить фотографии
		<form action="<?=$docroot?>/photo/upload?gig=<?=$pathname[1]?>" method="post" enctype="multipart/form-data">
			 <input type="file" name="upload[]" id="file-field" accept="image" multiple="true" required="required" />
			 <input type="submit" value="Загрузить" /> 
		</form>
		
	<?
	}
	
	} else
	{
		?>
	
	<h3 style="color:silver; margin-top:-1em">Также посетите: </h3>	
	<div id="slider" style="margin:0 auto">
			<ul>	

				<?
				for($i=0; $i < sizeof($events); $i+=5)
				{
					echo '<li>';
					
					for($j=0; $j<5; $j++)
					if(isset($events[$i+$j])){
					echo '<a href="/gig/'.$events[$i+$j]['id'].'" title="'.date('d.m.Y', -$events[$i+$j]['begin']).' - '.$events[$i+$j]['title'].'"><img style="width:150px; height:200px" src="/data/events/m/'.$events[$i+$j]['id'].'.jpg" alt="'.date('d.m.Y', $events[$i+$j]['begin']).' - '.$events[$i+$j]['title'].'"></a> ';
					}
					
					echo '</li>';
				}
				
				?>
				</ul>
		</div>
		<?}?>
	
	          <?
				//include $conf['dir']['skin'].'theme/'.$conf['theme'].'/elements/comments.html';
			?>

			<!-- Put this div tag to the place, where the Comments block will be -->
			
			<?if($event['active']){?>
			<div id="vk_comments" style=" padding:1em;"></div>
			<script type="text/javascript">
		VK.Widgets.Comments("vk_comments", {limit: 20, width: "720", attach: "photo,video,audio"});
		</script>
			<?}?>
			</div>
  
     
        </div>


    <?}
	}
}
else
{
    echo "Нет такого гига";
}

?>

<?



$page[] = ob_get_contents();
ob_end_clean();
?>
