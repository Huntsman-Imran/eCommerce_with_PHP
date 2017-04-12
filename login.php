<?
ob_start();
session_start();
if(isset($_SESSION['name']))
{
    header('location: index.php');
}
$pageTitle='Login';
include 'init.php';
if($_SERVER['REQUEST_METHOD']=='POST')
{
  if (isset($_POST['login']))
   {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $count=0;
    $hashedpassword=sha1($password);
    $statement=$conn->prepare('SELECT user_id,username,password FROM users WHERE username=? AND password=?');
    $statement->execute(array($username,$hashedpassword));
    $row=$statement->fetch();
    $count=$statement->rowCount();
    if($count>0)
    {
      $_SESSION['name']=$username;
      $_SESSION['userid']=$row['user_id'];
      header('location: index.php');
      exit();
    }
   }
   else
   {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    $email=$_POST['email'];
    $full_name=$_POST['full_name'];

    $formErrors=array();

    if (isset($username))
    {
       $filterUser=filter_var($username, FILTER_SANITIZE_STRING);  

       if (strlen($filterUser)<4) 
       {
         $formErrors[]='Username Must Be Larger Then 4 Character';
       }

    }

    if (isset($password)&& isset($password2))
     {
      if (empty($password))
       {
        $formErrors[]='Password Can Not Be Empty';
       }
       if (sha1($password)!=sha1($password2))
        {
         $formErrors[]='Password Is Not Match';
        }

      }

      if (isset($email))
       {
         $filterEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
         if ($filterEmail!=true)
          {
           $formErrors[]='The Email Is Not valid'; 
          }
       }

  if (isset($full_name))
    {
       $filterUser=filter_var($full_name, FILTER_SANITIZE_STRING);  

       if (empty($full_name)) 
       {
         $formErrors[]='Full Name Can Not Be Empty';
       }

    }

      if (empty($formErrors))
        {
            $check=checkItem('username','users',$username);
            if ($check>0) 
            {
              $formErrors[]='Sorry This User Is Already Exist';
            }
            else
            {
              $statement=$conn->prepare('INSERT INTO users(username,password,email,full_name,reg_status,date) VALUES(:zusername,:zpassword,:zemail,:zfull_name,0,now())');
              $statement->execute(array(
               'zusername'=>$username,
               'zpassword'=>sha1($password),
               'zemail'=>$email,
               'zfull_name'=>$full_name
              ));

            }

          $success='You Have Registered Successfully';
        }

   }

}
?>

 <div class="container login-page">
    <h4 class="text-center">
         <span class="selected" data-class="login">Login</span> 
         |
         <span data-class="signup">Signup</span>
    </h4>

 <form class="login" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="input-container">
 	<input class="form-control" name="username" type="text" id="" placeholder="Type your username" autocomplete="off" required="required"/>
 </div>
  <div class="input-container">
 	<input class="form-control" name="password" type="password" id="" placeholder="Type your password" autocomplete="new-password" required="required"/>
 </div>
 	<input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
 </form>

  <form class="signup" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="input-container">
  <input class="form-control" name="username" type="text" id="" placeholder="Type your username" autocomplete="off" required="required"/>
 </div>
  <div class="input-container">
  <input class="form-control" name="password" type="password" id="" placeholder="Type a complex password" autocomplete="new-password" required="required"/>
 </div>
   <div class="input-container">
  <input class="form-control" name="password2" type="password" id="" placeholder="Type a password again" autocomplete="new-password"  required="required"/>
 </div>
  <div class="input-container">
  <input class="form-control" name="email" type="email" id="" placeholder="Type a valid email" autocomplete="off" required="required"/>
 </div>  
  <div class="input-container">
  <input class="form-control" name="full_name" type="text" id="" placeholder="Type a full name" autocomplete="off" required="required"/>
 </div> 

  <input class="btn btn-success btn-block" name="submit" type="submit" value="Signup">
 </form>

 <div class="the-errors text-center">
  <?
    if (!empty($formErrors))
     {
          foreach ($formErrors as $err)
           {
             echo '<div class="msg error">'.$err.'</div>';
           } 
     }

     if (isset($success)) 
     {
      echo '<div class="msg success">'.$success.'</div>';
     }
  ?>
  </div>

 
</div>
<?
include $tpl.'footer.php';
ob_end_flush();
?>


