<?
 ob_start();
 session_start();
 if (isset($_SESSION['name']))
  {


 	$pageTitle="Items";
 	include 'init.php';
     $do=isset($_GET['do']) ? $_GET['do'] : 'Manage';

      if ($do=='Manage') 
      {
      	$statement=$conn->prepare('SELECT items.*,categories.name AS category_name,users.username FROM items INNER JOIN categories ON items.cat_id=categories.id INNER JOIN users ON items.member_id=users.user_id  ORDER BY item_id DESC');
      	$statement->execute();
        $result=$statement->fetchAll();
        if (!empty($result))
         {
          
       ?>
       	<h1 class="text-center">Manage Item</h1>
      	<div class="container">
      		<div class="table-responsive">
	            <table class="main-table text-center table table-bordered">
			       	<tr>
			       		<td>#ID</td>
			       		<td>Item Name</td>
			       		<td>Description</td>
			       		<td>Price</td>
			       		<td>Adding Date</td>
			       		<td>Category</td>
			       		<td>Username</td>
			       		<td>Controle</td>
			       	</tr>
			       	
			       	    <?
		                foreach ($result as $row)
		                 {        
                              echo '<tr>';
		                 	         echo '<td>'.$row['item_id'].'</td>';
                               echo '<td>'.$row['name'].'</td>';
                               echo '<td>'.$row['description'].'</td>';
                               echo '<td>'.$row['price'].'</td>';
                               echo '<td>'.$row['add_date'].'</td>';
                               echo '<td>'.$row['category_name'].'</td>';
                               echo '<td>'.$row['username'].'</td>';
                               echo '<td>';
                               echo '<a class="btn btn-success" href="items.php?do=Edit&id='.$row['item_id'].'"><i class="fa fa-edit"></i>Edit</a><a class="btn btn-danger confirm" href="items.php?do=Delete&id='.$row['item_id'].'"><i class="fa fa-close"></i>Delete</a>';
                               
                              if ($row['approve']==0)
                              {
                                   echo '<a href="items.php?do=Activate&id='.$row['item_id'].'" ><div class="btn btn-info confirm"><i class="fa fa-check"></i>Activate</div></a>';   
                              }

                                echo '</td>';
                              echo  '</tr>';
		                 }
			       	    ?>
	            </table>
            </div>
            <a class="btn btn-primary" href="items.php?do=Add"><i class="fa fa-plus"></i>Add New</a>
          </div>
            
            <?
               }
             else
             {
              echo '<div clas="container">';
              echo '<div class="nice-message">There\'s No Item To Show</div>';
              echo '<a class="btn btn-primary" href="members.php?do=Add"><i class="fa fa-plus"></i>New Item</a>';
              echo '</div>';
             }
      }
      else if($do=='Add')
      {
     ?>
      <h1 class="text-center">Add Item</h1>
      <div class="container">
      	<form class="form-horizontal" action="?do=Insert" method="POST">
      		<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-10 col-md-6">
               	  <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name Of Items" required="required">
               </div>
      		</div>
      			<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Description</label>
               <div class="col-sm-10 col-md-6">
               	  <input type="text" name="description" class="form-control" autocomplete="off" placeholder="Description Of Items" required="required">
               </div>
      		</div>
      			<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Price</label>
               <div class="col-sm-10 col-md-6">
               	  <input type="text" name="price" class="form-control" autocomplete="off" placeholder="Price Of Items" required="required">
               </div>
      		</div>
      			<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Country</label>
               <div class="col-sm-10 col-md-6">
               	  <input type="text" name="country_made" class="form-control" autocomplete="off" placeholder="Country Of Made" required="required">
               </div>
      		</div>
      		<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Status</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="status">
               	<option value="0">....</option>
                <option value="1">New</option>
                 <option value="2">Like New</option>
                 <option value="3">Used</option>
                 <option value="4">Vary Old</option>
               </select>
               </div>
      		</div>

              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Member</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="member_id">
                <option value="0">....</option>
                <?
                  $statement=$conn->prepare('SELECT * FROM users ORDER BY user_id ASC');
                  $statement->execute();
                  $result=$statement->fetchAll();
                  foreach ($result as $row) 
                  {
                    echo '<option value="'.$row['user_id'].'">'.$row['username'].'</option>';
                  }
                ?>
               </select>
               </div>
          </div>

              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Category</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="cat_id">
                <option value="0">....</option>
                <?
                  $statement=$conn->prepare('SELECT * FROM categories ORDER BY id ASC');
                  $statement->execute();
                  $result=$statement->fetchAll();
                  foreach ($result as $row) 
                  {
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                  }
                ?>
               </select>
               </div>
          </div>
      
      		<div class="form-group form-group-lg">
      			<div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-primary">Save</button>
      			</div>
      		</div>
      	</form>
      </div>
     <?
      }
      else if($do=="Insert")
      {
      	 echo  '<h1 class="text-center">Update Member</h1>'; 
         echo '<div class="container">';
          

      
      if ($_SERVER['REQUEST_METHOD']=='POST') 
      {
          $name=$_POST['name'];
          $description=$_POST['description'];
          $price=$_POST['price'];
          $country_made=$_POST['country_made'];
          $status=$_POST['status'];
          $member_id=$_POST['member_id'];
          $cat_id=$_POST['cat_id'];

           //validation

         $formErrors=array();

           if(strlen($name)<3)
           {
                  $formErrors[]= 'Name Can\'t Be Less Then <strong>4 Characters </strong>';
           }
           if (strlen($name)>20)
           {
             $formErrors[]= 'Name Can\'t Be Greater Then <strong>20 Characters </strong>';
           }
           if (empty($name))
           {
             $formErrors[]= 'Name can\'t Be <strong>Empty</strong>';
           }
             if (empty($description))
           {
             $formErrors[]= 'Description can\'t Be <strong>Empty</strong>';
           }
             if (empty($price))
            {
             $formErrors[]= 'Price Can\'t Be <strong> Empty</strong>';
           }
             if (empty($country_made))
            {
             $formErrors[]= 'Country Can\'t be <strong>Empty</strong>';
           }
               if ($status==='0')
            {
             $formErrors[]= 'You Muset Choose The <strong>Status</strong>';
           }
           if ($cat_id==='0')
            {
             $formErrors[]=  'You Muset Choose The <strong>Category</strong>';
           }
            if ($member_id==='0')
            {
             $formErrors[]=  'You Muset Choose The <strong>Member</strong>';
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
             $Message='<div class="alert alert-info">Sorry This Item Is Already Exist</div>';
             redirectHome($Message,'back');
            }
            else
          {

          $statement=$conn->prepare('INSERT INTO items(name,description,price,country_made,status,add_date,cat_id,member_id) VALUES(:zname,:zdescription,:zprice,:zcountry_made,:zstatus,now(),:zcat_id,:zmember_id)');
          $statement->execute(array(
             'zname'=>$name,
             'zdescription'=>$description,
             'zprice'=>$price,
             'zcountry_made'=>$country_made,
             'zstatus'=>$status,
             'zcat_id'=>$cat_id,
             'zmember_id'=>$member_id
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
      else if ($do=='Edit')
       {
        $id=isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

        $statement=$conn->prepare('SELECT * FROM items WHERE item_id=? LIMIT 1');
        $statement->execute(array($id));
        $result=$statement->fetchAll();
        $count=$statement->rowCount();
          if ($count>0)
         {
          foreach ($result as $row) 
          {
       

        ?>
           <h1 class="text-center">Edit Item</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
              <!--sending the value of category id-->
          <input type="hidden" name="item_id" value="<? echo $row['item_id']; ?>">

          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name Of Items"  value="<?echo $row['name'];?>" required="required">
               </div>
          </div>
            <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Description</label>
               <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" autocomplete="off" placeholder="Description Of Items" value="<?echo $row['description'];?>" required="required">
               </div>
          </div>
            <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Price</label>
               <div class="col-sm-10 col-md-6">
                  <input type="text" name="price" class="form-control" autocomplete="off" placeholder="Price Of Items" value="<?echo $row['price'];?>" required="required">
               </div>
          </div>
            <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Country</label>
               <div class="col-sm-10 col-md-6">
                  <input type="text" name="country_made" class="form-control" autocomplete="off" placeholder="Country Of Made" value="<?echo $row['country_made']?>" required="required">
               </div>
          </div>
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Status</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="status">
                <option value="0">....</option>
                <option value="1" <?if($row['status']==1){echo 'selected';}?>>New</option>
                 <option value="2" <?if($row['status']==2){echo 'selected';}?>>Like New</option>
                 <option value="3" <?if($row['status']==3){echo 'selected';}?>>Used</option>
                 <option value="4" <?if($row['status']==4){echo 'selected';}?>>Vary Old</option>
               </select>
               </div>
          </div>

              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Member</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="member_id">
                <option value="0">....</option>
                <?
                  $statement1=$conn->prepare('SELECT * FROM users ORDER BY user_id ASC');
                  $statement1->execute();
                  $result1=$statement1->fetchAll();
                  foreach ($result1 as $row1) 
                  {
                   
                    echo '<option value="'.$row['user_id'].'" '; if($row['member_id']==$row1['user_id']){echo 'selected';} echo'>'.$row1['username'].'</option>';
                  
                  }
                ?>
               </select>
               </div>
          </div>

              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Category</label>
               <div class="col-sm-10 col-md-6">
               <select class="form-control" name="cat_id">
                <option value="0">....</option>
                <?
                  $statement1=$conn->prepare('SELECT * FROM categories ORDER BY id ASC');
                  $statement1->execute();
                  $result1=$statement1->fetchAll();
                  foreach ($result1 as $row1) 
                  {
                     if($row['cat_id']==$row1['id'])
                    {
                    echo '<option value="'.$row['cat_id'].'" selected>'.$row1['name'].'</option>';
                    }
                    else
                    {
                       echo '<option value="'.$row['user_id'].'">'.$row1['name'].'</option>'; 
                    }
                  }
                ?>
               </select>
               </div>
          </div>
      
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>


        <!--quick view of comments in edit item page-->

       <?
          $statement1=$conn->prepare('SELECT comments.*,users.username FROM comments INNER JOIN users ON comments.member_id=users.user_id  ORDER BY c_id DESC');
              $statement1->execute();
              $result1=$statement1->fetchAll();
             ?>
              <h1 class="text-center">Manage Comments</h1>
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                    <tr>
                      <td>Comment</td>
                      <td>User Name</td>
                      <td>Adding Date</td>
                      <td>Controle</td>
                    </tr>
                    
                        <?
                          foreach ($result1 as $row1)
                           {        
                                    echo '<tr>';
                                     echo '<td>'.$row1['comment'].'</td>';
                                     echo '<td>'.$row1['username'].'</td>';
                                     echo '<td>'.$row1['comment_date'].'</td>';
                                     echo '<td>';
                                     echo '<a class="btn btn-success" href="comments.php?do=Edit&id='.$row1['c_id'].'"><i class="fa fa-edit"></i>Edit</a><a class="btn btn-danger confirm" href="comments.php?do=Delete&id='.$row1['c_id'].'"><i class="fa fa-close"></i>Delete</a>';
                                     
                                    if ($row1['status']==0)
                                    {
                                         echo '<a href="comments.php?do=Activate&id='.$row1['c_id'].'" ><div class="btn btn-info confirm"><i class="fa fa-check"></i>Activate</div></a>';   
                                    }

                                      echo '</td>';
                                    echo  '</tr>';
                           }
                        ?>
                    </table>
                  </div>
         <!--quick view of comment-->
      </div>
        <?
        }
      }
      	
      }
      else if ($do=='Update')
       {
             echo  '<h1 class="text-center">Update Items</h1>'; 
             echo '<div class="container">';
          

                  
                  if ($_SERVER['REQUEST_METHOD']=='POST') 
                  {
                      $item_id=$_POST['item_id'];
                      $name=$_POST['name'];
                      $description=$_POST['description'];
                      $price=$_POST['price'];
                      $country_made=$_POST['country_made'];
                      $status=$_POST['status'];
                      $member_id=$_POST['member_id'];
                      $cat_id=$_POST['cat_id'];

                      //password trick
                       $password = empty($newpassword)? $oldpassword : sha1($newpassword);

                       //validation
                      $formErrors=array();

                         if(strlen($name)<3)
                         {
                                $formErrors[]= 'Item Can\'t Be Less Then <strong>4 Characters </strong>';
                         }
                         if (strlen($name)>20)
                         {
                           $formErrors[]= 'Item Can\'t Be Greater Then <strong>20 Characters </strong>';
                         }
                         if (empty($name))
                         {
                           $formErrors[]= 'Item can\'t Be <strong>Empty</strong>';
                         }
                           if (empty($description))
                         {
                           $formErrors[]= 'Description can\'t Be <strong>Empty</strong>';
                         }
                           if (empty($price))
                          {
                           $formErrors[]= 'Price Can\'t Be <strong> Empty</strong>';
                         }
                           if (empty($country_made))
                          {
                           $formErrors[]= 'Country Can\'t be <strong>Empty</strong>';
                         }
                             if ($status==='0')
                          {
                           $formErrors[]= 'You Muset Choose The <strong>Status</strong>';
                         }
                         if ($cat_id==='0')
                          {
                           $formErrors[]=  'You Muset Choose The <strong>Category</strong>';
                         }
                          if ($member_id==='0')
                          {
                           $formErrors[]=  'You Muset Choose The <strong>Member</strong>';
                         }


                         foreach ($formErrors as $error)
                          {
                             $errMessage='<div class="alert alert-danger">'.$error.'</div>';
                             redirectHome($errMessage,'back');
                         }
                         //Check if there no error proceed the update opreation
                       if(empty($formErrors))
                      {
                        $statement1=$conn->prepare('SELECT * FROM items WHERE name=? AND item_id !=?');
                        $statement1->execute(array($name,$item_id));
                        $count=$statement1->rowCount();
                        if ($count==1)
                         {
                          $errMessage='<div class="alert alert-danger">Sorry This Item Is Already Exist</div>';
                          redirectHome($errMessage,'back');
                        }
                        else
                        {
                        $statement=$conn->prepare('UPDATE items SET name=?,description=?,price=?,country_made=?,status=?,cat_id=?,member_id=? WHERE item_id=?');
                        $statement->execute(array($name,$description,$price,$country_made,$status,$cat_id,$member_id,$item_id));

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

      else if ($do=='Delete')
       {

          echo  '<h1 class="text-center">Delete Item</h1>'; 
         echo '<div class="container">';
          //check if get request user id is numeric and get the int value
           $id= isset($_GET['id'])  &&  is_numeric($_GET['id'])  ?  intval($_GET['id'])  :  0;
             
          // $statement=$conn->prepare('SELECT * FROM users WHERE user_id=? AND group_id=0 LIMIT 1'); //ei statement gular madhomeo korajae
           //$statement->execute(array($userid));
            //$count=$statement->fetchAll();
           $Check=checkItem('item_id','items',$id);
           //checking if there is any user exist on this id
           if ($Check==1) 
           {
            $statement=$conn->prepare('DELETE FROM items WHERE item_id= :zid');
            $statement->bindParam(':zid',$id);
            $statement->execute(); 
            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Deleted</div>';
            redirectHome($successMessage);
           }
           else
           {
            // if any one tries to delet a user with id this will give a restriction(confused)
            $errMessage='<div class="alert alert-danger">This Items Is Not Exist</div>';
            redirectHome($errMessage);
           }
           echo '</div>';
      	
      }

         elseif ($do=='Activate')
           {
         echo  '<h1 class="text-center">Approve Item</h1>'; 
         echo '<div class="container">';
          //check if get request user id is numeric and get the int value
           $id= isset($_GET['id'])  &&  is_numeric($_GET['id'])  ?  intval($_GET['id'])  :  0;
           $Check=checkItem('item_id','items',$id);
           //checking if there is any user exist on this id
           if ($Check==1) 
           {
            $statement=$conn->prepare('UPDATE items SET approve=1 WHERE item_id=?');
            $statement->execute(array($id)); 
            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Updated</div>';
            redirectHome($successMessage,'back');
           }
           else
           {
            // if any one tries to delet a user with id this will give a restriction(confused)
            $errMessage='<div class="alert alert-danger">This Item Is Not Exist</div>';
            redirectHome($errMessage);
           }
           echo '</div>';
            
          }

 	include $tpl.'footer.php';
 }
 else
 {
 	header('location:index.php');
 }
 ob_end_flush();
?>