<?php

$output->post_check();
$output->get_check();

ob_start();
global $page, $output, $data, $cat, $mod,$conf;


$DB->query('SELECT DISTINCT `place`.`title` as `title`, `events`.`place` as `id`, `active` FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`end` > '.time().' ORDER BY `place`.`title` LIMIT 500' );
if($DB->get_num_rows())
{
    while( $place=$DB->fetch_row() )
    {
	$actual_places[]=$place;
    }
}

if(!isset($post)){
$DB->query('SELECT active, `events`.`id`, `events`.added, `events`.`title`, `begin`, `place`.`title` as `place`, `events`.`place` as `place_id` FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`end` > '.time().' AND active=1 ORDER BY `begin` LIMIT 500' );
}
else
{
   $query='SELECT active, `events`.`id`, `events`.added, `events`.`title`, `begin`, `place`.`title` as `place`, `events`.`place` as `place_id` FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place` WHERE ';

   if(isset($post['place']) && is_numeric($post['place']) && $post['place']!=0)
   {
       $query.=' `events`.`place` ='.$post['place'].' ';

   }

   if(isset($post['place']) && is_numeric($post['place']) && ($post['place']!=0) && isset($post['date']))
   {
       $query.=' AND ';
   }

   if(isset($post['date']))
   {
       $query.=' `events`.`end` > '.strtotime($post['date']);
   }

   $query.=' ORDER BY `begin` ';

   if(isset($post['num']) && $post['num']>0)
   {
    $query.=' LIMIT '.$post['num'];
   }

   
    $DB->query($query);

}

$description="Актуальные концерты в Санкт-Петербурге";

if($DB->get_num_rows())
{
    while( $event=$DB->fetch_row() )
    {
	if($event['active']){
		$events[date("m.Y", $event['begin'])][]=$event;
		}
    }
}
?>

  <div class="container-right">

                       <div class="sidebar">
				<h3>Последние фотоотчёты</h3>
				<div style="font-size:0.7em; border-left: 1px solid #eee; padding-left:1em">
				<?
					$photo_reports=array();
					$DB->query('SELECT photo.events, photo.added, events.title, events.begin, place.title as place
					
							   FROM `photo`
							LEFT JOIN `events` ON `events`.`id` = `photo`.`events`
							LEFT JOIN `place` ON `events`.`place` = `place`.`id`
							
					WHERE events.end < '.time().'
					ORDER BY photo.added DESC');
					
					if($DB->get_num_rows())
					{
					
					 while ($pr=$DB->fetch_row()){
							
							if(!isset($photo_reports[$pr['events']])){
							$photo_reports[$pr['events']]=$pr;
							} else {
							
							 if($photo_reports[$pr['events']]['added']<$pr['added']){
								$photo_reports[$pr['events']]=$pr;
							 }
							
							}
						if(sizeof($photo_reports) > 15){
							break;
						}
					
					
					 }
					 
					 foreach($photo_reports as $pr){
						
						 echo '<table><tbody><tr><td>';
						 echo '<a title="Фотоотчет '.$output->message_show($pr['title'].' ('.$pr['place'].')').'" href="/gig/'.$pr['events'].'#photos">';
						 echo '<img src="/data/events/m/'.$pr['events'].'.jpg" style="width:75px; height:100px" alt=""/>';
						 echo '</a>';
						 echo '</td><td>';
						 echo '<a href="/gig/'.$pr['events'].'#photos">';
						 
						 echo date('d.m.Y', $pr['begin']).' <br /> <strong>'.$output->message_show($pr['title'].' ('.$pr['place'].')').'</strong> ';
					     echo '</a>';
						 echo '</td></tr></tbody></table>';
					
						 
					 }
					 
					} else {
					
					echo 'Пока не сделано ни одного фоторепортажа.';
					
					}
				
				?>
				</div>
				
				</div>
	</div>

         <div class="content">

<?



//Уведомление о том что концерт добавлен
if(isset($get) && isset($get['added']) && is_numeric($get['added']))
{
	$DB->query('SELECT `events`.`title`,
					   `begin`, 
					   `place`.`title` as `place`
					   FROM `events`
					LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`id`='.$get['added'].' ORDER BY `added` LIMIT 500' );
	if($DB->get_num_rows())
	{
		$addedgig=$DB->fetch_row();
		?>
		<div class="tooltip">
		<p style="float:right; margin-top:-0.5em; font-size:14px"><a href="<?=$docroot.'/'?>">Закрыть это сообщение</a></p>
		Спасибо!<br />
		Мероприятие <strong><?=date('d.m', $addedgig['begin']).' - '.$addedgig['title'].' ('.$addedgig['place'].')'?></strong> успешно добавлено в очередь на рассмотрение!
		</div>
		<?
	}
	

?>
	<?}


//Неактивные, неподтвержденные концерты
if($output->AuthCheck('admin'))
	{
	
				
	$DB->query('SELECT active, `events`.`id`, 
				       `events`.`title`,
					   `begin`, `place`.`title` as `place`, 
					   `events`.`place` as `place_id` ,
					   `added`
					   FROM `events`
					LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `active` = "0" ORDER BY `added` LIMIT 500' );
			
			
			
	if($DB->get_num_rows())
	{
	?>
	<div class="tooltip">
	<h1 style="float:right; color:gray; margin-top:-0.5em">Неподтверждённые концерты</h1>
	<?
	
	 while ($noactive=$DB->fetch_row())
	 {	
			echo '<p>'.
			date('d.m.Y', $noactive['added']).
			' - <a href="'.$docroot.'/gig/'.$noactive['id'].'">'.$noactive['title'].
			' ('.$noactive['place'].', '.
			date("d.m.Y", $noactive['begin']).
			')</a></p>';
	 }
	?>
	</div>
	<?
	}
	}
	
?>





<div id="filter">
        <form action="<?=$docroot?>/" method="post" enctype="multipart/form-data">
        Клуб: <select id="place" name="place">
            <option value="0">Все</option>
   <?
        foreach($actual_places as $place)
        {?>
       <option value="<?=$place['id']?>" <?=($post['place']==$place['id']?'selected="selected"':'')?>><?=$place['title']?></option>
        <?}?>
   </select>
        Начиная с: <input id="datech" style="max-width:80px" placeholder="Сегодня" value="<?=isset($post['date'])?$post['date']:date("d.m.Y",time())?>" name="date" />
        Показать: <select style="max-width:40px" id="num" name="num">

            <option value="0" <?=($post['num']==0?'selected="selected"':'')?>>Все</option>
            <option value="10" <?=($post['num']==10?'selected="selected"':'')?>>10</option>
            <option value="20" <?=($post['num']==20?'selected="selected"':'')?>>20</option>
            <option value="50" <?=($post['num']==50?'selected="selected"':'')?>>50</option>
            <option value="100" <?=($post['num']==100?'selected="selected"':'')?>>100</option>
       </select>
        <input type="submit" value="Фильтровать!" />
        </form>
   </div>
   <div>
   
<?



$date = time()+60*60*24*30*2+60*60*24*17;

//echo '<h2>'.$conf['months'][(int)(date("m",$date))-1].'</h2>';



$is_clear=0;

if(!isset($events))
{
    echo '<div style="text-align:center; padding:2em"><br /><br />Ой! К сожалению не найдено ни одного концерта.';
    if(isset($post))
    {
        echo'<br />Попробуйте изменить запрос или перейти на <a href='.$docroot.'>главную</a><br />';
    }
    echo '</div>';
}
else
{
foreach(array_keys($events) as $month)
{
 echo '<h1 style="margin-left:1em;">'.$conf['months'][(int)substr($month,0,2)-1].(substr($month,3,4)!=date("Y")?' '.(date("Y")+1):'')."</h1>";
 $is_clear=1;

	foreach($events[$month] as $event)
	{
  
	   $description.=', '.$event['title'].', '.$event['place'];
      ?>
        <div class="gig_block" title="<?=$event['title']?>" >
            <span class="gig_date" <?if(date('d.m.Y',$event['begin'])==date('d.m.Y',time())){echo'style="color:green;"';}
			?>>
				<strong>
				<span style="font-size:1.5em; display:block; float:left;padding-right:5px;"><?=(int)date('d',$event['begin'])?></span>
				</strong>
				<?=$conf['monthof'][(int)date('m',$event['begin'])-1]?> 
				<?if( (time()-$event['added'])<60*60*24*4 ){?>
				<span style="color:green"><img src="<?=$docroot?>/i/new.png" alt="New!" title="Новый"></span>
				<?}?>
                
            </span>

            <span class="gig_day">
                <strong><?=$conf['weekdays'][date("N",$event['begin'])]?></strong>
            </span>

            <a 
				title="<?=(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1];?>, <?=$event['title']?> (<?=$event['place']?>)" href="<?=$docroot?>/gig/<?=$event['id']?>">
                    <img class="gig_img" src="<?=$docroot?>/data/events/m/<?=$event['id']?>.jpg" alt="<?=(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1];?>, <?=$event['title']?> (<?=$event['place']?>)" />
                </a><br />
				
            <span class="gig_title">
                <strong><?=$event['title']?></strong>
            </span>

            <span class="gig_club">
                <a href="#">
                        <?=$event['place']?></a>
            </span>

            <span class="gig_time">
            <?=date("H:i",$event['begin']);?>
            </span>

        </div>
    <?
   }

}
}
?>
<br class="clear"/>

<?if(!isset($post)){?>
<a href="/last/">Прошедшие концерты &darr;</a>
<?} else {?>
<a href="<?$docroot?>">&larr; Вернуться на главную</a>
<?}?>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  // ---- Календарь -----
  $('#datech').attachDatepicker({
  	yearRange: '2011:2015',
  	firstDay: 1
  });
  // ---- Календарь -----
});
</script>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>
