<?php 
global $page, $DB, $output, $data, $mod, $pathname, $Log;
if($user['usertype'] == 2 && isset($pathname[2])) {

         //Получаем местоположение комментария
        $DB->query('SELECT `prefix`,`prefix_id` from `comment` WHERE id="'.$pathname[2].'" LIMIT 1');
           if ($DB->get_num_rows()) {
                   $comment = $DB->fetch_row();
         }
	delete_data($pathname[2]);

        $Log->event("delete", 'comment', $pathname[2], $comment['prefix'], $comment['prefix_id']);

}
$output->redirect($_SERVER['HTTP_REFERER']);
?>
