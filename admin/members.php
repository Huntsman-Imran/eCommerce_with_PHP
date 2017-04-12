<?
ob_start();
session_start();
/*
** Manage members
**you can  Add | Edit | Delet members here
*/

if(isset($_SESSION['name']))
{


   $pageTitle='Members';
   include 'init.php';
  
                 $do=isset($_GET['do']) ? $_GET['do'] : 'Manage';

				//If the page is main page
				 if($do=='Manage')
				 {

          $query='';

          if (isset($_GET['page']))
           {
                   $query='AND reg_status=0 ';
           }

          $statement=$conn->prepare('SELECT * FROM users WHERE user_id!=1 '.$query.' ORDER BY user_id DESC');
          $statement->execute();
          $result=$statement->fetchAll();

          if (!empty($result))
           {
          ?>
           <h1 class="text-center">Manage Member</h1>
             <div class="container">
              <div class="table-responsive">
                   <table class="main-table text-center table table-bordered">
                      <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                      </tr>

                      <?

                        foreach ($result as $row) 
                        {
                        
                      ?>
                      <tr>
                        <td><?echo $row['user_id'];?></td>
                        <td><?echo $row['username'];?></td>
                        <td><?echo $row['email'];?></td>
                        <td><?echo $row['full_name'];?></td>
                        <td><?echo $row['date'];?></td>
                        <td>
                           <a class="btn btn-success" href="members.php?do=Edit&userid=<?echo $row['user_id'];?>"><i class="fa fa-edit"></i>Edit</a>
                           <a class="btn btn-danger confirm"  href="members.php?do=Delete&userid=<?echo $row['user_id'];?>"><i class="fa fa-close"></i>Delete</a>
                           <?
                             if ($row['reg_status']==0) 
                             {
                            ?>
                                <a class="btn btn-info confirm"  href="members.php?do=Activate&userid=<?echo $row['user_id'];?>"><i class="fa fa-close"></i>Activate</a>
                            <?
                             }
                           ?>
                        </td>
                      </tr>
                      <?
                      }
                      ?>
                    </table>
                  </div>
                  <a class="btn btn-primary" href="members.php?do=Add"><i class="fa fa-plus"></i>Add New</a>
               </div>
                  <?
                    }
                   else
                   {
                    echo '<div clas="container">';
                    echo '<div class="nice-message"> There\'s No User To Show</div>';
                    echo '<a class="btn btn-primary" href="members.php?do=Add"><i class="fa fa-plus"></i>New Member</a>';
                    echo '</div>';
                   }
				  
				 }
           else if($do=='Add')
         {
            ?>
           <h1 class="text-center">Add New Member</h1>
            <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="POST"> 
            <!--Username start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" id="" placeholder="Username To Login Into Shop"  autocomplete="off" required="required">
              </div>
            </div>
            <!--Userbane end-->

            <!--Password start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10 col-md-6">
                <input type="password" name="password" class="password form-control" id="" placeholder="Password Must Be Strong & Complex" autocomplete="new-password">
                <i class="show-pass fa fa-eye fa-2x"></i>
              </div>
            </div>
            <!--Password end-->

            <!--Email start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" id="" placeholder="Email Must Be Valid"  autocomplete="off" required="required">
              </div>
            </div>
            <!--Email end-->

             <!--Full Name start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Full Name</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="full_name"  class="form-control" id="" placeholder="Full Name Appeat In Your Profile Page"  autocomplete="off" required="required">
              </div>
            </div>
            <!--Full Name end-->
                 <!--Full Name start-->
            <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button> 
              </div>
            </div>
            <!--Full Name end-->
          </form>
        </div>
            <? 

         }


            //update part
         else if($do=='Insert')
         {
         echo  '<h1 class="text-center">Update Member</h1>'; 
         echo '<div class="container">';
          

                  
                  if ($_SERVER['REQUEST_METHOD']=='POST') 
                  {
                      $username=$_POST['username'];
                      $password=sha1($_POST['password']);
                      $email=$_POST['email'];
                      $full_name=$_POST['full_name'];

                   

                       //validation

                     $formErrors=array();

                       if(strlen($username)<4)
                       {
                              $formErrors[]= 'Username Can\'t Be Less Then <strong>4 Characters </strong>';
                       }
                       if (strlen($username)>20)
                       {
                         $formErrors[]= 'Username Can\'t Be Greater Then <strong>20 Characters </strong>';
                       }
                       if (empty($username))
                       {
                         $formErrors[]= 'Username can\'t Be <strong>Empty</strong>';
                       }
                         if (empty($password))
                       {
                         $formErrors[]= 'Password can\'t Be <strong>Empty</strong>';
                       }
                         if (empty($email))
                        {
                         $formErrors[]= 'Email Can\'t Be <strong> Empty</strong>';
                       }
                         if (empty($full_name))
                        {
                         $formErrors[]= 'Full Name Can\'t be <strong>Empty</strong>';
                       }
                       foreach ($formErrors as $error)
                        {
                         $errMessage='<div class="alert alert-danger">'.$error.'</div>';
                         redirectHome($errMessage,'back');
                       }
                        //Check if there no error proceed the insert opreation
                       if(empty($formErrors))
                      {
                        $Check=checkItem('username','users',$username);
                        if($Check==1)
                        {
                         $Message='<div class="alert alert-info">Sorry This User Is Already Exist</div>';
                         redirectHome($Message,'back');
                        }
                        else
                      {

                      $statement=$conn->prepare('INSERT INTO users(username,password,email,full_name,reg_status,date) VALUES(:zusername,:zpassword,:zemail,:zfull_name,0,now())');
                      $statement->execute(array(
                         'zusername'=>$username,
                         'zpassword'=>$password,
                         'zemail'=>$email,
                         'zfull_name'=>$full_name
                        ));

                     $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record Inserted</div>';
                     redirectHome($successMessage,'back');
                    }
                    }
                   
                  }
                  else
                  {
                    $errMessage='<div class="alert alert-danger">you Can Not Brows The page Directly</div>';
                    //calling function form function from functions.php //n. b.: ei function e header function e kichu problem ache
                      redirectHome($errMessage,'back');
                  }
                  echo '</div>';
               

         }

         else if($do=='Edit')
         {
          $userid=$_GET['userid'];
          $statement=$conn->prepare('SELECT * FROM users WHERE user_id=? LIMIT 1');
          $statement->execute(array($userid));
          $row=$statement->fetch();
          $count=$statement->rowCount();
          if ($count>0)
           {
            ?>
           <h1 class="text-center">Edit Member</h1>
            <div class="container">
              <form class="form-horizontal" action="?do=Update" method="POST"> 
                <input type="hidden" name="hdnuserid" value="<?echo $row['user_id'];?>">
                  <input type="hidden" name="hdnoldpassword" value="<?echo $row['password'];?>">
            <!--Username start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" id="" placeholder="Username" value="<?echo $row['username'];?>" autocomplete="off" required="required">
              </div>
            </div>
            <!--Userbane end-->

            <!--Password start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10 col-md-6">
                <input type="password" name="newpassword" class="form-control" id="" placeholder="Leave Blanck If Your Don't Want To Change " autocomplete="new-password">
              </div>
            </div>
            <!--Password end-->

            <!--Email start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" id="" placeholder="Email" value="<?echo $row['email'];?>" autocomplete="off" required="required">
              </div>
            </div>
            <!--Email end-->

             <!--Full Name start-->
            <div class="form-group form-group-lg">
              <label  class="col-sm-2 control-label">Full Name</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="full_name"  class="form-control" id="" placeholder="Full Name" value="<?echo $row['full_name'];?>" autocomplete="off" required="required">
              </div>
            </div>
            <!--Full Name end-->
                 <!--Full Name start-->
            <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
            <!--Full Name end-->
          </form>
        </div>
            <? 
          }

           else
          {
            echo '<div class="container">';
            $errMessage='<div class="alert alert-danger">There Is No Such ID</div>';
            redirectHome($errMessage);
            echo '</div>';
          }

                


         }


            //update part
				 else if($do=='Update')
				 {
				 echo  '<h1 class="text-center">Update Member</h1>'; 
         echo '<div class="container">';
          

                  
                  if ($_SERVER['REQUEST_METHOD']=='POST') 
                  {
                      $userid=$_POST['hdnuserid'];
                      $username=$_POST['username'];
                      $newpassword=$_POST['newpassword'];
                      $oldpassword=$_POST['hdnoldpassword'];
                      $email=$_POST['email'];
                      $full_name=$_POST['full_name'];

                      //password trick
                       $password = empty($newpassword)? $oldpassword : sha1($newpassword);

                       //validation

                     $formErrors=array();

                       if(strlen($username)<4)
                       {
                              $formErrors[]= '<div class="alert alert-danger">Username Can\'t Be Less Then <strong>4 Characters </strong></div>';
                       }
                       if (strlen($username)>20)
                       {
                       	 $formErrors[]= '<div class="alert alert-danger">Username Can\'t Be Greater Then <strong>20 Characters </strong></div>';
                       }
                       if (empty($username))
                       {
                       	 $formErrors[]= '<div class="alert alert-danger">Username can\'t Be <strong>Empty</strong></div>';
                       }
                         if (empty($email))
                        {
                       	 $formErrors[]= '<div class="alert alert-danger">Email Can\'t Be <strong> Empty</strong></div>';
                       }
                         if (empty($full_name))
                        {
                       	 $formErrors[]= '<div class="alert alert-danger">Full Name Can\'t be <strong>Empty</strong></div>';
                       }
                       foreach ($formErrors as $error)
                        {
                       	     $errMessage=$error;
                             redirectHome($errMessage,'back');
                       }
                         //Check if there no error proceed the update opreation
                       if(empty($formErrors))
                      {
                        $statement1=$conn->prepare('SELECT * FROM users WHERE username=? AND user_id !=?');
                        $statement1->execute(array($username,$userid));
                        $count=$statement1->rowCount();
                        if ($count==1)
                         {
                          $errMessage='<div class="alert alert-danger">Sorry This User Is Already Exist</div>';
                          redirectHome($errMessage,'back');
                        }
                        else
                        {
                           $statement=$conn->prepare('UPDATE users SET username=?,password=?,email=?,full_name=? WHERE user_id=?');
                            $statement->execute(array($username,$password,$email,$full_name,$userid));

                           $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Updated</div>';
                           redirectHome($successMessage,'back');
                        }
                   
                      }

                

                  }
                  else
                  {
                  	 $errMessage='<div class="alert alert-danger">you Can Not Brows The Page Directly</div>';
                      redirectHome($errMessage,'back');
                  }
                  echo '</div>';

				 }


         else if($do=='Delete')
          {
         echo  '<h1 class="text-center">Delete Member</h1>'; 
         echo '<div class="container">';
          //check if get request user id is numeric and get the int value
           $userid= isset($_GET['userid'])  &&  is_numeric($_GET['userid'])  ?  intval($_GET['userid'])  :  0;
             
          // $statement=$conn->prepare('SELECT * FROM users WHERE user_id=? AND group_id=0 LIMIT 1'); //ei statement gular madhomeo korajae
           //$statement->execute(array($userid));
            //$count=$statement->fetchAll();
           $Check=checkItem('user_id','users',$userid);
           //checking if there is any user exist on this id
           if ($Check==1) 
           {
            $statement=$conn->prepare('DELETE FROM users WHERE user_id= :zuserid');
            $statement->bindParam(':zuserid',$userid);
            $statement->execute(); 
            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Deleted</div>';
            redirectHome($successMessage,'back');
           }
           else
           {
            // if any one tries to delet a user with id this will give a restriction(confused)
            $errMessage='<div class="alert alert-danger">This ID Is Not Exist</div>';
            redirectHome($errMessage);
           }
           echo '</div>';
          }
          elseif ($do=='Activate')
           {
                  echo  '<h1 class="text-center">Activate Member</h1>'; 
         echo '<div class="container">';
          //check if get request user id is numeric and get the int value
           $userid= isset($_GET['userid'])  &&  is_numeric($_GET['userid'])  ?  intval($_GET['userid'])  :  0;
           $Check=checkItem('user_id','users',$userid);
           //checking if there is any user exist on this id
           if ($Check==1) 
           {
            $statement=$conn->prepare('UPDATE users SET reg_status=1 WHERE user_id=?');
            $statement->execute(array($userid)); 
            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Updated</div>';
            redirectHome($successMessage);
           }
           else
           {
            // if any one tries to delet a user with id this will give a restriction(confused)
            $errMessage='<div class="alert alert-danger">This ID Is Not Exist</div>';
            redirectHome($errMessage);
           }
           echo '</div>';
            
          }


   include $tpl.'footer.php';
}
else
{
 header('location: index.php');
 exit();
}
ob_end_flush();
?>



                  

