<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'О нас';

if(isset($_POST))
{
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
}

?>
<h2>Войти</h2>
<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
<iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url=http://concertinfo.ru/enter" 
style="width:359px;height:300px;" scrolling="no" frameborder="no"></iframe>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>