<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'Регистрация';

?>
<h2>Регистрация</h2>
<p style="text-align: center">
    К сожалению регистрация пользователей временно не работает,<br />
    приносим свои глубочайшие извинения.
<br /><br />
<a href="javascript:history.go(-1)">&larr; Вернуться назад</a></p>
<?
$page[] = ob_get_contents();
ob_end_clean();
?>