<?php 
$output->post_check();
ob_start();


global $page, $DB, $output, $data, $cat, $mod, $pathname,$img;
$skin['sidebar'] = 0;

$DB->query('SELECT * from `'.$mod['path'].'` WHERE `id` = '.$pathname[2].' LIMIT 1');
if (!$DB->get_num_rows()) { error(404);}
$data = $DB->fetch_row();



if (isset($post))
{
        //echo $_POST['review'];
        //echo $post['review'];

        $post['added'] = strtotime($post['added_date'].' '.$post['added_time']);
	unset($post['added_date']);
	unset($post['added_time']);
	$post['edited'] = time();

       $post['review']=htmlspecialchars($post['review']);


	print_r($post['review']);
        echo "<br>";
        $query = $DB->compile_db_update_string($post);


        echo 'UPDATE `'.$mod['path'].'`
		SET '.$query.'
	WHERE
		`id` = "'.$pathname[2].'"
	LIMIT 1<br><br>';

        print_r($query);

        $DB->query('UPDATE `'.$mod['path'].'`
		SET '.$query.'
	WHERE
		`id` = "'.$pathname[2].'"
	LIMIT 1
         ');
         
        $Log->event("edit", 'comment', $pathname[2], $data['prefix'], $data['prefix_id']);
        
	$output->redirect('/'.$data['prefix'].'/'.$data['prefix_id'].'/');
}

$output->title('Править');
include($conf['dir']['mod'].$mod['path'].'s/_form.php');

$page[] = ob_get_contents();
ob_end_clean();
?>