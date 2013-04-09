<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'О нас';
?>
          <?
				include $conf['dir']['skin'].'theme/'.$conf['theme'].'/elements/feedback1.html';
			?>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>