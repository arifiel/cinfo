<?php

$output->post_check();
ob_start();
global $page, $mail, $output, $data, $cat, $mod,$conf;

$output->send_mail('Проверка. Заголовок','Привет, какой чудесный <strong>день!</strong>','demonoide@mail.ru');

$page[] = ob_get_contents();
ob_end_clean();
?>
