<?php 
$output->post_check();
ob_start();
global $page, $get, $DB, $Notice, $output, $data, $cat, $mod, $pathname;

if (isset($post)) {
    
    
#	echo '<p style="color:red;font-weight: bold;">добавлено!</p>';
    $data = $post;
    $pathname_mod = $output->parse_path($_SERVER['HTTP_REFERER']);
    if (isset($get['path']) && $get['path']) {
        $path = $get['path'];
    } else {
        $path = $pathname_mod[0];
    }

    if($path=='support') $path='tasks';

    //TODO: Переделать на $query = $DB->compile_db_insert_string($data);
    $DB->query ('
    INSERT INTO `comment`
    	(`prefix`,`prefix_id`,`user_id`,`user_login`,`review`,`added`)
    VALUES
    	(
         "'.$path.'",
         "'.$pathname[2].'",
         "'.$user['id'].'",
         "'.$user['login'].'",
         "'.addslashes(htmlspecialchars($data['review'])).'",
         "'.time().'"
         )');

    $item_id = $DB->get_insert_id();

    $DB->query('SELECT count(id) as count from `comment` WHERE `prefix`="'.$path.'" AND `prefix_id`="'.$pathname[2].'" AND `active`=1 ');

    //Перенаправляем на страницу, откуда пришли
    $output->redirect($_SERVER['HTTP_REFERER'].'#comments');

}

$page[] = ob_get_contents();
ob_end_clean();
?>
