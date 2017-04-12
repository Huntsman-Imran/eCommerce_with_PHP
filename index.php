<?session_start();
$pageTitle='Homepage';
include 'init.php';
echo $sessionUser;
include $tpl.'footer.php';
?>