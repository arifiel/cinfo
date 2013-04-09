<?
	require_once('Vkapi.Class.php');
	
	
	//VkApi::auth(array('offline', 'wall', 'groups'));

	
	VkApi::invoke('wall.post', array(
    'owner_id' => '1931',
    'message' => '%message%',
    'from_group' => 1
	));
	
	
?>