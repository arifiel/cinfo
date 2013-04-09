<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod,$conf;

$date = time()+60*60*24*30*2+60*60*24*17;

echo '<span style="font-size:0.9em">';
echo '<h1>Прошедшие концерты</h1>';

$DB->query('SELECT `events`.`id`, `events`.`title`, `begin`, `place`.`title` as `place` FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`end` < '.time().' ORDER BY `begin` DESC LIMIT 1000' );

$description="Актуальные концерты в Санкт-Петербурге";

if($DB->get_num_rows())
{
    while( $event=$DB->fetch_row() )
    {
	$events[date("m.Y", $event['begin'])][]=$event;
    }
}



foreach(array_keys($events) as $month)
{
  echo '<h2 style="color:gray">'.$conf['months'][(int)substr($month,0,2)-1].(substr($month,3,4)!=date("Y")?' '.substr($month,3,4):'')."</h2>";
  echo '<span style="font-size:0.8em;">';

	foreach($events[$month] as $event)
	{

	   $description.=', '.$event['title'].', '.$event['place'];
      ?>
          <p><a title="<?=(int)date("d",$event['begin']).' '.$conf['monthof'][(int)(date("m",$event['begin']))-1];?>, <?=$event['title']?> (<?=$event['place']?>)" href="<?=$docroot?>/gig/<?=$event['id']?>">
            <?=out_date($event['begin'], 1, 0)?> (<?=$conf['weekdays'][date("N",$event['begin'])]?>)
             <?=$event['title']?> (<?=$event['place']?>, <?=date("H:i",$event['begin']);?>)
             </a>
            </p>
    <?
   }
  echo '</span><br />';
}
echo '</span>';
?><hr />
            <a href="/">&larr; К актуальным концертам</a>

            <?

$page[] = ob_get_contents();
ob_end_clean();
?>
