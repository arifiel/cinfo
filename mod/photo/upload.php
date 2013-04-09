<?php

$output->post_check();
$output->get_check();

ob_start();
global $page, $output, $data, $cat, $mod;


if(isset($get['gig']) && isset($_FILES)){

	//Количество файлов
	$count = sizeof($_FILES['upload']['name']);

	//Прошариваемся
	for($i=0; $i<$count; $i++){
		
		echo $_FILES['upload']['name'][$i].'<br />';
		
		 
		$DB->query('INSERT INTO photo (events, user_id, added,review,active)
			VALUES
			("'.$get['gig'].'", '.$user['id'].', '.time().', "",1 ) ');
		$item_id = $DB->get_insert_id();
		
		add_foto($item_id, $i);
		
	}
	
	$output->redirect($docroot.'/gig/'.$get['gig'].'#photos');
}

	$output->redirect($docroot.'/');

$page[] = ob_get_contents();
ob_end_clean();
?>