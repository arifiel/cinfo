﻿<?php

    require  'config.php';

    if (!empty($_GET['code'])){

        // вконтакт присылает нам код        
        $vkontakteCode=$_GET['code'];
        
        // получим токен 
        $sUrl = "https://api.vkontakte.ru/oauth/access_token?client_id=$vkontakteApplicationId&client_secret=$vkontakteKey&code=$vkontakteCode";

// создадим объект, содержащий ответ сервера Вконтакте, который приходит в формате JSON
        $oResponce = json_decode(file_get_contents($sUrl));
        
        $fp = fopen('token.txt', 'w');
        fputs($fp, $oResponce->access_token);
        fclose($fp);
        
}

?>
<a href="http://api.vkontakte.ru/oauth/authorize?client_id=<?=$vkontakteApplicationId?>&scope=offline,wall&redirect_uri=http://concertinfo.ru/export/connect.php&response_type=code">Авторизация Вконтакте</a>
