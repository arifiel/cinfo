<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'О нас';

?>
<h2>Баннеры для афиш</h2>
Если вы хотите, чтобы Ваша афиша была размещена нами на сайте, то вам необходимо вставить на неё один из наших баннеров.<br />
<br />
<div style="text-align:center">
<img src="/i/banner/white.jpg" alt="Белый баннер Concertinfo.ru" /><br />
Скачать в *.psd: <a href="/data/banner/white.zip" >white.zip</a>
<br /><br />
<img src="/i/banner/black.jpg" alt="Черный баннер Concertinfo.ru" /><br />
Скачать в *.psd: <a href="/data/banner/black.zip" >black.zip</a>
<br /><br />
<div>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>