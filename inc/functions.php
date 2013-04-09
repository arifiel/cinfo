<?php
//------------------------------------------------------------------------------
//Функция вывода даты
//------------------------------------------------------------------------------
function out_date($date_to_convert=0, $long="true", $time="true") {

    if(!$date_to_convert) {
        $date_to_convert=time();
    }

    if($long) {
        $a[]="";
        $a[]="января";
        $a[]="февраля";
        $a[]="марта";
        $a[]="апреля";
        $a[]="мая";
        $a[]="июня";
        $a[]="июля";
        $a[]="августа";
        $a[]="сентября";
        $a[]="октября";
        $a[]="ноября";
        $a[]="декабря";
    }
    else {
        $a[]="";
        $a[]="янв.";
        $a[]="фев.";
        $a[]="мар.";
        $a[]="апр.";
        $a[]="мая";
        $a[]="июн.";
        $a[]="июл.";
        $a[]="авг.";
        $a[]="сен.";
        $a[]="окт.";
        $a[]="нояб.";
        $a[]="дек.";
    }

    //Месяц
    $d = date('n',$date_to_convert);

    //Месяц из массива
    $m=$a[$d];

    //День без нулей
    $c = date('j', $date_to_convert);


    $date_out=$c.' '.$m;


    if(date('d.m.Y', $date_to_convert)==date('d.m.Y')) {
        $date_out = "сегодня";
    }
    elseif(date('d.m.Y', ($date_to_convert+24*60*60))==date('d.m.Y')) {
        $date_out = "вчера";
    }
    elseif(date('d.m.Y', ($date_to_convert+2*24*60*60))==date('d.m.Y')) {
        $date_out = "позавчера";
    }
    elseif(date('d.m.Y', ($date_to_convert+3*24*60*60))==date('d.m.Y')) {
        $date_out = "3 дня назад";
    }
    elseif(date('d.m.Y', ($date_to_convert+4*24*60*60))==date('d.m.Y')) {
        $date_out = "4 дня назад";
    }
    elseif(date('d.m.Y', ($date_to_convert+5*24*60*60))==date('d.m.Y')) {
        $date_out = "5 дней назад";
    }
    elseif(date('d.m.Y', ($date_to_convert+6*24*60*60))==date('d.m.Y')) {
        $date_out = "6 дней назад";
    }
    elseif(date('d.m.Y', ($date_to_convert+7*24*60*60))==date('d.m.Y')) {
        $date_out = "неделю назад";
    }
    elseif(date('d.m.Y', ($date_to_convert-24*60*60))==date('d.m.Y')) {
        $date_out = "завтра";
    }
    elseif(date('d.m.Y', ($date_to_convert-2*24*60*60))==date('d.m.Y')) {
        $date_out = "послезавтра";
    }

    else {
        if(date('Y',$date_to_convert) != date('Y',time()))
            $date_out .= ' '.date('Y',$date_to_convert).' г.';


        /*Пробуем вывести*/

    }

    if($time && $long)
        $date_out.=date(" в H:i:s", $date_to_convert);

    $date_out=str_replace(" ", "&nbsp;", $date_out);


    return $date_out;

	}
	
	
//======================================================================
//Функция вывода ошибки
//======================================================================
function error($err) {
    global $error;

    if(!isset($error) || !$error)
        $error=$err;

}

//======================================================================
//Функция поста в ЖЖ
//======================================================================
function SendLiveJournal($title, $text){
	include('jjport.php');
	$port=new port();
	
	$port->add('username','concertinfo', 'string');
	$port->add('password','gthtgthlsi666', 'string');

	$date = time();
	$year = date("Y", $date);
	$mon = date("m", $date);
	$day = date("d", $date);
	$hour = date("G", $date);
	$min = date("i", $date);

	$port->add('mon',$mon, 'int');
	$port->add('day',$day, 'int');
	$port->add('year',$year, 'int');
	$port->add('hour',$hour, 'int');
	$port->add('min',$min, 'int');
	//public (default), private and usemask
	$port->add('security','public', 'string');
	$port->add('subject',$title, 'string');
	$port->add("lineendings", "unix", "string");
	$port->add('event',$text, 'string');
	$port->add('ver','2', 'int');

	
	$res=$port->send();
	
}

function GetUserIP()
{
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	 
	return($ip);
}

?>