<?
ini_set('display_errors',1);
error_reporting(E_ALL);
echo '1';

require '../config.php';

echo '2';
require_once('../'.$conf['dir']['inc'].'mysql.php');
require_once('../'.$conf['dir']['inc'].'output.php');
echo '3';
require_once('../'.$conf['dir']['inc'].'functions.php');

echo 'begin';
SendLiveJournal("Test", 'Review');

echo 'end';
?> 