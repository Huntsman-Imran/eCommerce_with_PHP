<?
ini_set('display_errors', 'On'); //important tutorial no 89
error_reporting(E_ALL);


include 'admin/connect.php';

  $sessionUser='';
if (isset($_SESSION['name']))
{
	$sessionUser =$_SESSION['name'];
}

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

?>