<?php 
$output->post_check();
$output->get_check();
ob_start();
global $page, $DB, $output, $data, $cat, $mod;

$skin['sidebar'] = 0;


$output->title('Восстановление доступа к сайту',1,'both');
?>
<div style="text-align: center">
<?

$email="";

if (isset($_POST['email']))
{
   $email = $post['email'];
}
elseif (isset($pathname[2]) && is_numeric($pathname[2]))
{
     	$DB->query('SELECT email from `users` WHERE `id`='.$pathname[2].' LIMIT 1');
	if ($DB->get_num_rows()){
        	$email = $DB->fetch_row();
                $email = $email['email'];
        }
}

if($email){

    	$DB->query('SELECT * from `users` WHERE `email`=\''.$email.'\' LIMIT 1');
	if ($DB->get_num_rows()){
		$user_info = $DB->fetch_row();
		// генерируем ключ для смены пароля
             $key = sha1($email.time().'соль!');
		$DB->query('UPDATE `users` SET `passtime`="'.time().'", `passkey`="'.$key.'" WHERE `id` = "'.$user_info['id'].'" LIMIT 1');

           
		// высылает письмо с ключом активации на твой ящик
		$output->send_mail('Восстановление доступа на сайт','account_reminder',$email);

		echo '<p><span class="error">На электронный ящик '.$email.' было выслано письмо с инструкциями по восстановлению пароля.
                      <br /><br /><a href="/">&larr; На главную</a></span></p>';
                 $Log->event("reminder", 'users', $user_info['id'], ip(), 0);


	} else {
		echo '<p><span class="error">Введёные вами данные неверны! Попробуйте еще раз.<br /><a href="">&larr; Назад</a></span></p>';
	}

} else {
	{
		echo '
        <form class="email" action="#" method="post" style="text-align:center;">

		<label for="email">e-mail аккаунта</label><br />
        <input type="text" name="email" id="email" />
<br /><br />
		<input type="submit" value="Восстановить доступ"  />
		</form>
		
';
	}
}
?>
<br class="clear" />
</div>
<?
$page[] = ob_get_contents();
ob_end_clean();
?>
