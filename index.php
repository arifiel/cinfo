<?php 
header("Cache-Control: no-store"); 
header("Expires: " . date("r"));

global $time_begin;
$time_begin=microtime(true);

$nomenu = 0;

// Общие настройки
require_once ('config.php');

//Старт сессии
//if (isset($_REQUEST['PHPSESSID']) ) {
    session_start();
//}

// Ядро
require_once ($conf['dir']['inc'].'bbcode/bbcode.lib.php');
require_once($conf['dir']['inc'].'functions.php');
require_once($conf['dir']['inc'].'output.php');
require_once($conf['dir']['inc'].'class.phpmailer.php');

$mail = new PHPMailer;

$output = new Output;

if(strstr($_SERVER['HTTP_HOST'], '.') && $_SERVER['HTTP_HOST']!='concertinfo.ru'){
 $output->redirect('http://concertinfo.ru/'.(isset($pathname[0])?$pathname[0].'/':'').(isset($pathname[1])?$pathname[1].'/':'').(isset($pathname[2])?$pathname[2].'/':'').(isset($pathname[3])?$pathname[3].'/':''));
}

require_once($conf['dir']['inc'].'mysql.php');
$DB = new db_driver;

ob_start();
$is_db=1;
if(!$DB->connect()){
 $is_db=0;
}
ob_end_clean();

if($is_db){
	
$DB->query('SET NAMES utf8');

require_once($conf['dir']['inc'].'user.php');

// if there's a mod
// just index
if (isset($pathname[0])) {
    $mod['path'] = $pathname[0];
}


if ($pathsize == 0) {
    include_once($conf['dir']['mod'].'index.php' );
// simple page
} else if ( $pathsize > 0 && is_file($conf['dir']['mod'].$pathname[0].'.php' ) ) {
    include_once($conf['dir']['mod'].$pathname[0].'.php' );

// mod dir
} else if ( $pathsize > 0 && is_dir($conf['dir']['mod'].'/'.$pathname[0] ) ) {
    include($conf['dir']['mod'].$pathname[0].'/db.php');

    // including...
    if ( isset($pathname[1]) ) {
        // mod's control?
        if (is_file($conf['dir']['mod'].$pathname[0].'/'.$pathname[1].'.php')) {
            include($conf['dir']['mod'].$pathname[0].'/'.$pathname[1].'.php');

            // let the module judge
        } else {
            include($conf['dir']['mod'].$pathname[0].'/index.php');
        }
    } else {
        include($conf['dir']['mod'].$pathname[0].'/index.php');
    }

// what was that?
} else {
		
    $error=404;
}

// cash - $page_result

ob_start();
if (!isset ($page) ) {
    $page[]= '';
}

$limit = sizeof($page);
for ($x=0;$x<$limit;$x++) {
    echo $page[$x];
}

$page_result = ob_get_contents();
ob_end_clean();


ob_start();
// skin
if (!isset($error)) {
    if ($pathsize == 0) {
        require_once($conf['dir']['skin'].'/theme/'.$conf['theme'].'/index.html');
    } else {
        if ( is_file($conf['dir']['skin'].'/theme/'.$conf['theme'].'/'.$pathname[0].'.html') && !isset($myskin)) {
            require_once($conf['dir']['skin'].'/theme/'.$conf['theme'].'/'.$pathname[0].'.html');
        } else {
            require_once($conf['dir']['skin'].'/theme/'.$conf['theme'].'/index.html');
        }
    }
} else {
    require_once($conf['dir']['skin'].'/theme/'.$conf['theme'].'/'.$error.'.html');
}
$page_end = ob_get_contents();
ob_end_clean();

// display

echo $page_end;


// end
 $DB->close_db();
 }
 else
 {
	       require_once($conf['dir']['skin'].'/theme/'.$conf['theme'].'/noconnect.html');
 }
?>
