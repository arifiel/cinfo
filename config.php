<?php
$conf = array (
	'dir'	=> array(
					'inc'        => 'inc/',
    				        'skin'	     => 'skin/',
    			        	'mod'	     => 'mod/',
					'side'       => 'side/',
					'html'	     => 'html/',
					'templates'  => 'templates/',
					'upload'     => 'data/',
    				)
);
ini_set('display_errors',1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'ru_RU.UTF-8');

global $conf, $head;
#set_magic_quotes_runtime(0);
ini_set('magic_quotes_gpc','0');
ini_set('magic_quotes_runtime',     0);
ini_set('magic_quotes_sybase',      0);
#ini_set('session.use_only_cookies', 1);
#ini_set('session.use_trans_sid',    0);
ignore_user_abort(true);

#date_default_timezone_set('Europe/Moscow');


$conf['dateformat'] = 'd.m.Y';
$conf['dateshort'] = 'd.m.Y';
$conf['days'] = array('день','дня','дней');
$conf['weekdays'] = array('Вс','Пн','Вт','Ср','Чт','Пт','Сб', 'Вс');
$conf['weekdays_full'] = array('Воскресение','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота', 'Воскресение');

$conf['months'] = array("Январь","Февраль",
                        "Март", "Апрель","Май",
                        "Июнь", "Июль","Август",
                        "Сентябрь","Октябрь","Ноябрь",
                        "Декабрь");

//Следующий месяц и предыдущий (не поспоришь ^_^ )
$conf['months'][-1]="Декабрь";
$conf['months'][12]="Январь";

$conf['monthof'] = array("января","февраля",
                        "марта", "апреля","мая",
                        "июня", "июля","августа",
                        "сентября","октября","ноября",
                        "декабря","января");


//Конфигурация для работы сайта на локальной машине

//Включаем error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

$docroot = "";

$conf['sitename'] = 'Афиша Rock / Metal концертов в Санкт-Петербурге';
$conf['sitepath'] = $_SERVER['SCRIPT_FILENAME'];

$conf['stat'] = true;

$head = $conf['sitename'];
$conf['theme'] = 'sci';

if ( strstr($_SERVER['HTTP_HOST'],'.') ) {
	include ( 'web.conf.php');
} else {
	include ( 'local.conf.php');
}

$Mail_Config_From               = "svart2011@gmail.com";
$Mail_Config_Hostname           = "concertinfo.ru";
$Mail_Config_Host               = "smtp.gmail.com";
$Mail_Config_Port               = 465;
$Mail_Config_SMTPSecure         = 'ssl';
$Mail_Config_SMTPAuth           = true;
$Mail_Config_Username           = 'svart2011@gmail.com';
$Mail_Config_Password           = 'gthtgthlsi';
$Mail_Config_Timeout            = 10;

?>
