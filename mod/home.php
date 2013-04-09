<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod;
$title = 'Сделать домашней страницей';

include $conf['dir']['skin'].'theme/'.$conf['theme'].'/elements/feedback.html';

?>
		<h2>Сделайте concertinfo.ru домашней страницей</h2>
		<p>Мы надеемся, что Вы высоко оценили возможности нашего сервиса и&nbsp;удобство работы, и&nbsp;теперь будете начинать свой день в&nbsp;Интернете с concertinfo.ru.<br />Для этого достаточно, чтобы сайт стал домашней страницей в&nbsp;Вашем браузере. Ниже описано, как&nbsp;это&nbsp;сделать.</p>

		<h3>Для&nbsp;браузера Internet Explorer</h3>
		<p><i>Сервис <span>&rarr;</span> Свойства обозревателя <span>&rarr;</span> Общие <span>&rarr;</span> Домашняя страница</i></p>
		<p>Откройте меню Сервис (Tools) и&nbsp;выберите в&nbsp;нем пункт Свойства обозревателя (InternetOptions). В&nbsp;открывшемся окне перейдите к&nbsp;вкладке Общие (General). В&nbsp;разделе Домашняя страница (HomePage) вместо &laquo;about: blank&raquo; или&nbsp;уже&nbsp;имеющегося адреса введите <a href="http://concertinfo.ru">http://concertinfo.ru</a>. Затем нажмите&nbsp;&laquo;OK&raquo;.</p>

		<h3>Для браузера Firefox 1.5 и&nbsp;выше</h3>
		<p><i>Инструменты <span>&rarr;</span> Настройки <span>&rarr;</span> Основные <span>&rarr;</span> Начальная страница</i></p>
		<p>Откройте меню Инструменты (Tools) и&nbsp;выберите в&nbsp;нем пункт Настройки (Options). В&nbsp;открывшемся окне выберите вкладку Основные (Main), и&nbsp;в&nbsp;разделе Начальная страница вместо &laquo;about: blank&raquo; или&nbsp;другого имеющегося там адреса введите <a href="http://concertinfo.ru">http://concertinfo.ru</a>. Затем нажмите &laquo;OK&raquo;.</p>

		<h3>Для браузера Firefox 2.0 и&nbsp;выше</h3>
		<p><i>1. Инструменты <span>&rarr;</span> Настройки <span>&rarr;</span> Основные <span>&rarr;</span> Запуск <span>&rarr;</span> Домашняя страница<br />2. При запуске Firefox... <span>&rarr;</span> Показать домашнюю страницу</i></p>

		<p>Откройте меню Инструменты (Tools) и&nbsp;выберите в&nbsp;нем пункт Настройки (Options). В&nbsp;открывшемся окне перейдите к&nbsp;вкладке Основные (Main). Найдите раздел Запуск (Startup) и&nbsp;введите <a href="http://concertinfo.ru">http://concertinfo.ru</a> в&nbsp;поле Домашняя страница (Home Page). Затем в&nbsp;выпадающем списке При запуске Firefox... (When Firefox starts) выберите пункт Показать домашнюю страницу (Showmyhomepage) и&nbsp;нажмите &laquo;OK&raquo;.</p>

		<h3>Для&nbsp;браузера Opera</h3>
		<p><i>Инструменты <span>&rarr;</span> Настройки <span>&rarr;</span> Общие <span>&rarr;</span> Домашняя страница</i></p>
		<p>Откройте меню Инструменты (Tools) и&nbsp;выберите в&nbsp;нем пункт Настройки (Preferences). В&nbsp;открывшемся окне перейдите к&nbsp;вкладке Общие (General), введите <a href="http://concertinfo.ru">http://concertinfo.ru</a> в&nbsp;разделе Домашняя страница (Home page) и&nbsp;нажмите &laquo;OK&raquo;.</p>

		<h3>Для браузера Safari</h3>
		<p><i>Настройки <span>&rarr;</span> Основные <span>&rarr;</span> В&nbsp;новых окнах открывать <span>&rarr;</span> Домашнюю страницу <span>&rarr;</span> Домашняя страница</i></p>
		<p>В&nbsp;меню браузера выберите пункт Настройки (Preferences) и&nbsp;перейдите к&nbsp;вкладке Основные (General). В&nbsp;выпадающем списке В&nbsp;новых окнах открывать (New windows open with) выберите пункт &laquo;Домашнюю страницу&raquo; (Home page). Введите <a href="http://concertinfo.ru">http://concertinfo.ru</a> в&nbsp;поле &laquo;Домашняя страница&raquo; (Home page).</p>

		<h3>Для браузера Google Chrome</h3>
		<p><i>В&nbsp;правом верхнем углу кликнуть на&nbsp;гаечный ключ, выбрать пункт &laquo;Параметры&raquo;</i></p>
		<p>В&nbsp;окне &laquo;Параметры&raquo; выберите закладку &laquo;Основные&raquo;. В&nbsp;пункте &laquo;Главная страница&raquo; поставьте кружок в&nbsp;&laquo;Открыть эту страницу&raquo;, введите адрес <a href="http://concertinfo.ru">http://concertinfo.ru</a> и&nbsp;нажмите кнопку &laquo;Закрыть&raquo;.</p>
		<br />
		<a href="/<?$docroot?>">&larr; Вернуться на главную</a>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>