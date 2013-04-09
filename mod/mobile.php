<?php

$output->post_check();
$output->get_check();

ob_start();
global $page, $output, $data, $cat, $mod,$conf;

$myskin=1;

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
	<?}?>

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
 echo '<h1 style="margin-left:1em;">'.$conf['months'][(int)substr($month,0,2)-1].(substr($month,3,4)!=date("Y")?' '.date("Y"):'')."</h1>";
 $is_clear=1;

	echo '<table>';
	echo '<tbody>';
	foreach($events[$month] as $event)
	{
	   echo '<tr>';
		echo '<td style="width:90px">';
		?>
		<img style="width:80px; height:100px" src="<?=$docroot?>/data/events/m/<?=$event['id']?>.jpg" alt="<?=(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1];?>, <?=$event['title']?> (<?=$event['place']?>)" />
		<?
		echo '</td>';
		echo '<td>';
		
		
	   $description.=', '.$event['title'].', '.$event['place'];
      ?>
           
				<strong>
				<span style="font-size:1.5em; display:block; float:left;padding-right:5px;"><?=(int)date('d',$event['begin'])?></span>
				</strong>
				<?=$conf['monthof'][(int)date('m',$event['begin'])-1]?>
				            
                (<strong><?=$conf['weekdays'][date("N",$event['begin'])]?></strong>)
				<br />

           
                <strong><?=$event['title']?></strong>
			

                 <br /><?=$event['place']?>

         
				<br /><?=date("H:i",$event['begin']);?>
      
    <?
			echo '</td>';

		   echo '<tr>';
   }
   echo '</tbody>';
   echo '</table>';

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
