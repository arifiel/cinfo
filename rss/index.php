<?
// Общие настройки
require_once ('../config.php');

require_once ('../'.$conf['dir']['inc'].'bbcode/bbcode.lib.php');
require_once('../'.$conf['dir']['inc'].'functions.php');
require_once('../'.$conf['dir']['inc'].'output.php');
$output = new Output;

if(strstr($_SERVER['HTTP_HOST'], '.') && $_SERVER['HTTP_HOST']!='concertinfo.ru'){
 $output->redirect('http://concertinfo.ru/'.(isset($pathname[0])?$pathname[0].'/':'').(isset($pathname[1])?$pathname[1].'/':'').(isset($pathname[2])?$pathname[2].'/':'').(isset($pathname[3])?$pathname[3].'/':''));
}

require_once('../'.$conf['dir']['inc'].'mysql.php');
$DB = new db_driver;
$DB->connect();
$DB->query('SET NAMES utf8');

//Подключаем RSS библиотеку
  include("FeedWriter.php");
   
  //Создаем экземпляр класса FeedWriter.
  $TestFeed = new FeedWriter(RSS2);
   
  //Настройка канала элементов
  //Использование функции-оболочки для общих элементов канала
  $TestFeed->setTitle($conf['sitename']);
  $TestFeed->setLink('http://'.$_SERVER['HTTP_HOST']);
  $TestFeed->setDescription('RSS 2.0 канал сайта '.$conf['sitename']);
    
	$DB->query('SELECT `events`.`id`, `events`.`title`,`events`.`review`, `begin`, `place`.`title` as `place` FROM `events`
            LEFT JOIN `place` ON `place`.`id` = `events`.`place`
            WHERE `events`.`begin` > '.time().' AND `active` = 1 ORDER BY `begin` ASC LIMIT 30' );

	if($DB->get_num_rows())
	{
		while( $event=$DB->fetch_row() )
		{
	
	    //создаем пустой item
        $newItem = $TestFeed->createNewItem();
         
		$event['title']=str_replace("`","",$event['title']);
		$event['title']=str_replace("'","",$event['title']);
		$event['title']=htmlspecialchars_decode($output->message_show($event['title']));
		
		

		$feedimg='<img src="http://'.$_SERVER['HTTP_HOST'].'/data/events/m/'.$event['id'].'.jpg" alt="" /><br />';
		
        //добавляем в него информацию
 		$newItem->setTitle($event['title'].' ('.$event['place'].')');
        $newItem->setLink('http://'.$_SERVER['HTTP_HOST'].'/gig/'.$event['id'].'/');
        $newItem->setDate($event['begin']);

		
        $newItem->setDescription($feedimg.' '.$output->message_show($event['review']));
        
 
		//теперь добавляем item в наш канал
        $TestFeed->addItem($newItem);
		}
	}   
  //Все готово. Генерируем и выводим получившийся XML
  $TestFeed->genarateFeed();

?>