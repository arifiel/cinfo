<?php 
$output->post_check();
ob_start();

global $page, $DB, $output, $data, $cat, $mod;

#$output->title('вход в систему');
?>
    <div id="admin">
<?


if (isset($_POST['login'])&&isset($_POST['password'])){
	$email=$_POST['login'];
	$pass=$_POST['password'];


        if(isset($_POST['alien-computer']) && $_POST['alien-computer'])
        {
            $time = time()+60*60;
        }
        else
        {
            $time = time()+365*24*60*60;
        }

	$DB->query('SELECT * from `users` WHERE `email`="'.$email.'" AND `pass`=MD5("'.$pass.'") AND `usertype`>0 LIMIT 1');

	if ($DB->get_num_rows()){
		$user = $DB->fetch_row();
		setcookie('member_id',$user['id'],$time,'/');
		setcookie('email',$user['email'],$time,'/');
		setcookie('pass_hash',$user['pass'],$time,'/');
		$DB->query('UPDATE `users` SET `last_visit`="'.time().'" WHERE `id` = "'.$user['id'].'" LIMIT 1');
		header('status: 303 See Other');
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit;
	} else {
		echo '<p><span class="error">Введёные вами данные неверны! Попробуйте еще раз.</span></p>';
	}

} else {
	if ( isset($access) && $access )
	{
		$output->redirect("/".$docroot);
	}
	else
	{
                $address="";
                $address=$address.'http://';

                    $address=$address.$_SERVER['SERVER_NAME'];

                for($i=0; $i<10; $i++)
                {
                    if(isset($pathname[$i]))
                    {
                        $address=$address.'/'.$pathname[$i];
                    }
                    else break;

                }
                
		echo '<div style="margin:0 auto; width:640px">
        <form class="login" action="#" method="post" style="text-align:center;">

    <input type="hidden" name="address" id="address" value="'.$address.'" />

		<label for="flogin" accesskey="l">Логин:</label>
        
            <input type="text" name="login" id="flogin" />
<br />
        <label for="fpass">Пароль:</label>
        <input type="password" name="password" id="fpass" />
<br />
		<input type="submit" value="submit"  />
		<br /><br />
		</form>
		</div>
		
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