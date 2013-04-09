<?php 
$output->post_check();
ob_start();
global $page, $DB, $output, $data, $cat, $mod;

$output->title('Смена пароля');
?>
	<div id="admin">
<?

if (isset($_GET['key'])){
	$output->get_check();
	$DB->query('SELECT * from `users` WHERE `passkey`=\''.$get['key'].'\' LIMIT 1');
	if ($DB->get_num_rows()){
	
		$user_info = $DB->fetch_row();
		
		// проверяем время

		// показываем форму замены пароля
		echo '
        <form class="email" action="/'.$pathname[0].'/'.$pathname[1].'/" method="post" style="text-align:center;">

		<label for="password">Ваш новый пароль</label><br />
        <input type="password" name="password" id="password" />
<br /><br />
		<input type="hidden" name="key" value="'.$get['key'].'" />
		<input type="submit" value="Сохранить"  />
		</form>
		
';
	} else {
		// нет такого юзера
		echo '<p><span class="error">Ссылка недействительна. Если вы считаете, что это произошло по ошибке - свяжитесь с администрацией.</span></p>';

	}
} else if (isset($_POST['password'])) {
	$output->post_check();
	$DB->query('SELECT * from `users` WHERE `passkey`="'.$post['key'].'" LIMIT 1');
	if ($DB->get_num_rows()){
		$user_info = $DB->fetch_row();

		// записываем пароль в базу
		$DB->query('UPDATE `users` SET `pass`="'.md5($post['password']).'", `passkey`="", `passtime`="" WHERE `id` = "'.$user_info['id'].'" LIMIT 1');

                $Log->event("new_password", 'users', $user_info['id'], "users", $user['id']);

		// показываем окно с поздравлением
		echo '<p><span class="error">Вы установили новый пароль.<br />Для доступа к сайту <a href="/">авторизуйтесь</a>.</span></p>';
		
	} else {	
		// перебрасываем на главную
		$output->redirect('/');
		echo '<p><span class="error">Нет такого юзера</span></p>';
	
	}
	
} else {
	// перебрасываем на главную
	$output->redirect('/');
}
?>
<br class="clear" />
</div>
<?
$page[] = ob_get_contents();
ob_end_clean();
?>
