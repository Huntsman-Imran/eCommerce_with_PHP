<?
session_start(); //start session
session_unset(); //unset data
session_destroy(); //distrou session
header('location: login.php');
exit();
?>