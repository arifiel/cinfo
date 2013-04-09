<?php
global $error,$Log;

function user(){
	global $_COOKIE,$DB,$user;
	if (isset($_COOKIE['email'])&&isset($_COOKIE['member_id'])&&isset($_COOKIE['pass_hash'])){
		foreach ($_COOKIE as $key => $value){
			$$key = addslashes($value);
		}

		$DB->query('SELECT * from `users` WHERE `id`="'.$member_id.'" AND `email`="'.$email.'" AND `usertype`>0 AND `pass`="'.$pass_hash.'" LIMIT 1');
        if ($DB->get_num_rows())
        	{
			$user = $DB->fetch_row();
 
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}


if ( user() ){
	$access = true;
} else {
	$access = false;
	if (isset($pathname[0]) && $pathname[0] == 'account') {
		error(512);
	} else {
                //echo "1234";
                //error(403);
	}
}

/*
$path_allowed[] = 'logout';
$path_allowed[] = 'support';
$path_allowed[] = 'profile';
$path_allowed[] = 'documents';
$path_allowed[] = 'comments';
$path_allowed[] = 'users';
*/

//if ($user['company_id']>1 && ( ( !isset($pathname[0]) || !in_array($pathname[0],$path_allowed) ))) {
//  $output->redirect ('/support/');
//}
?>
