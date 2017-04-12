<?session_start();
include 'connect.php';
if(isset($_POST['form_login']))
{
  try{
           if(empty($_POST['username']))
           {
             throw new Exception("Username field can not be empty !");
            
           }
           if(empty($_POST['password']))
           {
            throw new Exception("Password field can not be empty !");
            
           }

           $password=$_POST['password'];
           $password=sha1($password);

   
           $num=0;

           $statement=$conn->prepare('SELECT * FROM users WHERE username=? AND password=?');
           $statement->execute(array($_POST['username'],$password));

           $num=$statement->rowCount();

          if($num>0) 
            {
              $_SESSION['name'] = 'admin';
              header("location: dashboard.php");
            }
           else
           {
             throw new Exception('Invalid Username and/or password !');
           }
      }
      catch(Exception $e)
      {
        $error_message= $e->getMessage();
      }
} ?>
<?
include 'init.php';
include $tpl.'header.php';
include $lang.'english.php';
     
?>
 
 <form class="login" action="" method="post">
 	<? if (isset($error_message)) {
 		echo $error_message;
 	}?>
 	<h4 class="text-center"> Admin Login<h4>
 	<input class="form-control " name="username" type="text" placeholder="Username" autocomplete="off">
 	<input class="form-control" name="password" type="password" placeholder="Password" autocomplete="new-password">
 	<input class="btn btn-primary btn-block" type="submit" value="Login" name="form_login">
 </form>

<?include $tpl.'footer.php';?>


