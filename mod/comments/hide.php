<?php
$output->post_check();
ob_start();

global $page, $DB, $output, $data, $cat, $mod, $pathname,$img;
$skin['sidebar'] = 0;

$DB->query('UPDATE `'.$mod['path'].'`
            SET  `active` = "0"
	WHERE
		`id` = "'.$pathname[2].'"
	LIMIT 1
         ');

        //Получаем местоположение комментария
        $DB->query('SELECT `prefix`,`prefix_id` from `comment` WHERE id="'.$pathname[2].'" LIMIT 1');
           if ($DB->get_num_rows()) {
                   $comment = $DB->fetch_row();
         }

       $DB->query('SELECT count(id) as count from `comment` WHERE `prefix`="'.$comment['prefix'].'" AND `prefix_id`="'.$comment['prefix_id'].'" AND `active`=1 ');
        $count = $DB->fetch_row();

        $DB->query('UPDATE '.$comment['prefix'].' SET `count_comments` = '.$count['count'].' WHERE id = '.$comment['prefix_id'].' LIMIT 1');
        $Log->event("hide", 'comment', $pathname[2], $comment['prefix'], $comment['prefix_id']);

$output->redirect($_SERVER['HTTP_REFERER']);

$page[] = ob_get_contents();
ob_end_clean();
?>