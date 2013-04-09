<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'О нас';

include $conf['dir']['skin'].'theme/'.$conf['theme'].'/elements/feedback.html';

?>
<h2>О нас</h2>
Мы расскажем Вам о всех актуальных мероприятиях формата Rock и Metal, проводимых в Северной Столице. Наша основная задача - 
сделать единое пространство, одну большую афишу с удобной навигацией по ней, минимальным дизайном и максимальными возможностями.
<br /><br />
Наша цель быть такими, чтобы вам не стыдно было поставить этот сайт себе на 
<a class="homepage" onclick="this.style.behavior='url(#default#homepage)';try{this.setHomePage('http://concertinfo.ru/');return false;}catch(e){}" href="<?=$docroot?>/home/">стартовую страницу</a>!
<br /><br />
Мы есть в: <a href="http://vkontakte.ru/concertinfo" class="vkontakte">Вконтакте</a>, <a href="http://www.facebook.com/profile.php?id=100002984603597&amp;sk=wall" class="facebook">Facebook</a>, <a href="http://twitter.com/concert_info" class="twitter">Twitter</a> и <a href="http://concertinfo.livejournal.com" class="lj">LiveJournal</a>, а также у нас есть своя <a href="<?=$docroot?>/rss" class="rss">RSS лента</a> Подписывайтесь!
<hr />
  <form action="http://groups.google.com/group/concert-info-ru/boxsubscribe">
  Электронная почта: <input type="email" name="email" placeholder="Введите свой email"/>
  <input type=submit name="sub" value="Подписка на еженедельный дайджест концертов" />
	</form>
<hr />
Добавить свою афишу можно <a href="<?=$docroot?>/events/add">здесь</a>. Если вы хотите, чтобы Ваша афиша была размещена нами на сайте, то вам необходимо вставить на неё один из наших баннеров.<br />
<br />
<div style="text-align:center">
<img src="/i/banner/white.jpg" alt="Белый баннер Concertinfo.ru" /><br />
Скачать в *.psd: <a href="<?=$docroot?>/data/banner/white.zip" >white.zip</a>
<br /><br />
<img src="/i/banner/black.jpg" alt="Черный баннер Concertinfo.ru" /><br />
Скачать в *.psd: <a href="<?=$docroot?>/data/banner/black.zip" >black.zip</a>
<br />
</div><hr />
Вы можете помочь нам мелочью для того чтобы мы могли оплатить<br />хостинг.
<table cellpadding="0" cellspacing="0" border="0" style="font: 0.8em Arial, sans-serif; width:116px"><tr><td width="116" height="77" style="border: 0; background:url(https://img.yandex.net/i/money/top-5rub-pink.gif) repeat-y; text-align:center; padding: 0;" align="center" valign="bottom"><form style="margin: 0; padding: 0 0 2px;" action="https://money.yandex.ru/donate.xml" method="post"><input type="hidden" name="to" value="41001309857553"/><input type="hidden" name="s5" value="5rub"/><input type="submit" value="Дай пять"/></form></td></tr><tr><td width="116" height="38" style="font-size:13px; color:black;padding: 0; border: 0; background:url(https://img.yandex.net/i/money/bg-pink.gif) repeat-y; text-align:center; padding: 5px 0;" align="center" valign="top"><b>На хостинг </b></td></tr><tr><td style="padding: 0; border:0;"><img src="https://img.yandex.net/i/money/bottom-pink.gif" width="116" height="40" alt="" usemap="#button" border="0" /><map name="button"><area alt="Яндекс" coords="38,2,49,21" href="http://www.yandex.ru"><area alt="Яндекс. Деньги" coords="52,1,84,28" href="https://money.yandex.ru"><area alt="Хочу такую же кнопку" coords="17,29,100,40" href="https://money.yandex.ru/choose-banner.xml"></map></td></tr></table>
<a href="/<?$docroot?>">&larr; Вернуться на главную</a>
<br />
<?
$page[] = ob_get_contents();
ob_end_clean();
?>