<?
include 'connect.php';

//Routes

$tpl='includes/tamplets/';
$css='layout/css/';
$js='layout/js/';
$lang='includes/languages/';
$func='includes/functions/';


//include the important file
include $func.'functions.php';
include $lang.'english.php';
include $tpl.'header.php';



if(!isset($noNavebar)){include $tpl.'navbar.php';}


?>