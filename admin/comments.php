<?
 ob_start();
 session_start();
 if ($_SESSION['name'])
 {
 $pageTitle='Comments';
 include 'init.php';
 $do=isset($_GET['do']) ? $_GET['do'] : 'Manage';


				if($do=='Manage')
				{
                    $statement=$conn->prepare('SELECT comments.*,items.name AS item_name,users.username FROM comments INNER JOIN items ON comments.item_id=items.item_id INNER JOIN users ON comments.member_id=users.user_id  ORDER BY c_id DESC');
			      	$statement->execute();
			        $result=$statement->fetchAll();
			        if ($result)
			         {
			       ?>
			       	<h1 class="text-center">Manage Comments</h1>
			      	<div class="container">
			      		<div class="table-responsive">
				            <table class="main-table text-center table table-bordered">
						       	<tr>
						       		<td>#ID</td>
						       		<td>Comment</td>
						       		<td>Item Name</td>
						       		<td>User Name</td>
						       		<td>Adding Date</td>
						       		<td>Controle</td>
						       	</tr>
						       	
						       	    <?
					                foreach ($result as $row)
					                 {        
			                              echo '<tr>';
					                 	   echo '<td>'.$row['c_id'].'</td>';
			                               echo '<td>'.$row['comment'].'</td>';
			                               echo '<td>'.$row['item_name'].'</td>';
			                               echo '<td>'.$row['username'].'</td>';
			                               echo '<td>'.$row['comment_date'].'</td>';
			                               echo '<td>';
			                               echo '<a class="btn btn-success" href="comments.php?do=Edit&id='.$row['c_id'].'"><i class="fa fa-edit"></i>Edit</a><a class="btn btn-danger confirm" href="comments.php?do=Delete&id='.$row['c_id'].'"><i class="fa fa-close"></i>Delete</a>';
			                               
			                              if ($row['status']==0)
			                              {
			                                   echo '<a href="comments.php?do=Activate&id='.$row['c_id'].'" ><div class="btn btn-info confirm"><i class="fa fa-check"></i>Activate</div></a>';   
			                              }

			                                echo '</td>';
			                              echo  '</tr>';
					                 }
						       	    ?>
				            </table>
			            </div>
			        </div>
			     <?  }
                   else
                   {
                   	echo '<div class="container">';
                    echo '<div class="nice-message">There\'s No Comment To Show</div>';
                    echo '</div>';
                   }
				}
				else if($do=='Edit')
				{


						$id=isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;

					    $statement=$conn->prepare('SELECT * FROM comments WHERE item_id=? LIMIT 1');
					    $statement->execute(array($id));
					    $result=$statement->fetchAll();
					    $count=$statement->rowCount();
					      if ($count>0)
					     {
					      foreach ($result as $row) 
					      {
					   

					    ?>
					       <h1 class="text-center">Edit Comment</h1>
					  <div class="container">
					    <form class="form-horizontal" action="?do=Update" method="POST">
					          <!--sending the value of category id-->
					      <input type="hidden" name="c_id" value="<? echo $row['c_id']; ?>">

					      <div class="form-group form-group-lg">
					           <label class="col-sm-2 control-label">Comment</label>
					           <div class="col-sm-10 col-md-6">
					              <textarea name="comment" class="form-control" autocomplete="off" required="required"><?echo $row['comment'];?></textarea>
					           </div>
					      </div> 
					      <div class="form-group form-group-lg">
					        <div class="col-sm-offset-2 col-sm-10">
					               <button type="submit" class="btn btn-primary btn-lg">Save</button> <!--<input type="sbubmit" value="save" class="btn btn-primary btn-lg">-->
					        </div>
					      </div>
					    </form>
					  </div>
					    <?
					    }
					  }
				 
				}
				else if($do=='Update')
				{

                 echo  '<h1 class="text-center">Update Comment</h1>'; 
                  echo '<div class="container">';
          

                  
                  if ($_SERVER['REQUEST_METHOD']=='POST') 
                  {
                      $c_id=$_POST['c_id'];
                      $comment=$_POST['comment'];

                      $statement=$conn->prepare('UPDATE comments SET comment=? WHERE c_id=?');
                      $statement->execute(array($comment,$c_id));

                     $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Updated</div>';
                     redirectHome($successMessage,'back');
 

                  }
                  else
                  {
                     $errMessage='<div class="alert alert-danger">you Can Not Brows The Page Directly</div>';
                      redirectHome($errMessage);
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
		           $Check=checkItem('c_id','comments',$id);
		           //checking if there is any user exist on this id
		           if ($Check==1) 
		           {
		            $statement=$conn->prepare('DELETE FROM comments WHERE c_id= :zid');
		            $statement->bindParam(':zid',$id);
		            $statement->execute(); 
		            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Deleted</div>';
		            redirectHome($successMessage,'back');
		           }
		           else
		           {
		            // if any one tries to delet a user with id this will give a restriction(confused)
		            $errMessage='<div class="alert alert-danger">This Id Is Not Exist</div>';
		            redirectHome($errMessage);
		           }
		           echo '</div>';

               }

         elseif ($do=='Activate')
           {
         echo  '<h1 class="text-center">Approve Comment</h1>'; 
         echo '<div class="container">';
          //check if get request user id is numeric and get the int value
           $id= isset($_GET['id'])  &&  is_numeric($_GET['id'])  ?  intval($_GET['id'])  :  0;
           $Check=checkItem('c_id','comments',$id);
           //checking if there is any user exist on this id
           if ($Check==1) 
           {
            $statement=$conn->prepare('UPDATE comments SET status=1 WHERE c_id=?');
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
   header('location: index.php');
   exit();
 }
 ob_end_flush();
?>