<?
 $dns='mysql:host=localhost;dbname=shop';
 $name='root';
 $password='';
 $option=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',);

 try
 {
  $conn=new PDO($dns,$name,$password,$option);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
     echo 'Connection error: '.$e->getMessage();
 }

?>