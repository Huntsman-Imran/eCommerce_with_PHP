<?
session_start();
if(isset($_SESSION['name']))
{
    header('location: dashboard.php');
}
include 'connect.php';
$noNavebar='';
$pageTitle='Login';
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $count=0;
    $hashedpassword=sha1($password);
    $statement=$conn->prepare('SELECT user_id,username,password FROM users WHERE username=? AND password=? AND group_id=1 LIMIT 1');
    $statement->execute(array($username,$hashedpassword));
    $row=$statement->fetch();
    $count=$statement->rowCount();
    if($count>0)
    {
      $_SESSION['name']=$username;
      $_SESSION['id']=$row['user_id'];
      header('location: dashboard.php');
      exit();
    }
}
?>
<?
include 'init.php';
?>
 
 <form class="login" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
 	<h4 class="text-center"> Admin Login<h4>
 	<input class="form-control" name="username" type="text" placeholder="Username" autocomplete="off">
 	<input class="form-control" name="password" type="password" placeholder="Password" autocomplete="new-password">
 	<input class="btn btn-primary btn-block" type="submit" value="Login">
 </form>

<?include $tpl.'footer.php';?>


