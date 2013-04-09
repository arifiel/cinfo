<?php
error_reporting(E_ALL | E_STRICT);
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>xBBEditor demo</title>
<meta name="author" content="Dmitriy Skorobogatov" />

<link href="./style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src='./xbb.js.php'></script>
<script type="text/javascript">
XBB.textarea_id = 'test_js'; // идентификатор textarea
XBB.area_width = '100%';
//XBB.area_height = '400px';
XBB.state = 'plain'; // 'plain' or 'highlight'
XBB.lang = 'ru_utf8'; // локализация
onload = function() {
    XBB.init(); // инициалиизация редактора
}
</script>
</head>
<body>

<div align="center">
<form action="preview.php" name="test" target="_blank" method="post">
<textarea style="width:700px;height:400px" name="xbb_textarea" id="test_js"></textarea>
<input type="submit" value="Send" />
</form>
</div>


</body>
</html>
