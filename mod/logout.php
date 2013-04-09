<?php
global $Log, $user,$docroot;
$redirect=$_SERVER['HTTP_REFERER'];

setcookie('member_id','',0,'/');
setcookie('login','',0,'/');
setcookie('pass_hash','',0,'/');
header('status: 303 See Other');
header("Location: ".$redirect);
exit;
$page[] = 'Вы вышли из системы';
?>
