<?

$mod['path'] = 'comment';

function count_data($cat,$id) {
	global $DB, $mod, $pathname;
	$DB->query('SELECT count(id) as count from `'.$mod['path'].'` WHERE `prefix`="'.$cat.'" AND prefix_id="'.$id.'" AND `active`=1');
	$count = $DB->fetch_row();
#$DB->free_result();
	return $count['count'];
}

function delete_data($cat) {
	global $DB, $mod;
	$DB->query('SELECT `prefix`, `prefix_id` from `'.$mod['path'].'` WHERE id="'.$cat.'"');
    if ($DB->get_num_rows()) {
		$prefix = $DB->fetch_row();
		$DB->query ('DELETE FROM `'.$mod['path'].'` WHERE id="'.$cat.'" LIMIT 1');
		$count = count_data($prefix['prefix'],$prefix['prefix_id']);
		$DB->query('UPDATE `'.$prefix['prefix'].'` SET `count_comments` = '.$count.' WHERE `id` = '.$prefix['prefix_id'].' LIMIT 1');
    }
}

?>