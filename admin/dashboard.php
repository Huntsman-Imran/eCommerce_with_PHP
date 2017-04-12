<?
ob_start();
session_start();

if(isset($_SESSION['name']))
{
   $pageTitle='Admin';
   include 'init.php';

   $numUsers=5;
   $latestUsers=getlatest('*','users','user_id',$numUsers);

     $numItems=5;
   $latestItems=getlatest('*','items','item_id',$numItems);

   $numComments=4;

   /********numI start*******/
?>
<div class=" home-states ">
	<div class="container text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3">
	       <div class="stat st-members">
          <i class="fa fa-users"></i>
          <div class="pull-right">
				       Total Members
				       <span><a href="members.php"><? echo countItems('user_id','users');?></a></span>
             </div>
	          </div>
			</div>

			<div class="col-md-3">
	       <div class="stat st-pending">
            <i class="fa fa-user-plus"></i>
          <div class="pull-right"> 
				Pending Members
			   <span><a href="members.php?page=Pending"><? echo checkItem('reg_status','users',0);?></a></span>
       </div>
           </div>
			</div>


			<div class="col-md-3">
			<div class="stat st-items">
        <i class="fa fa-tags"></i>
         <div class="pull-right">
				Total Items
				   <span><? echo countItems('item_id','items');?></span>
            </div>
          </div>
			</div>

			<div class="col-md-3">
	            <div class="stat st-comments">
                <i class="fa fa-comments"></i>
              <div class="pull-right">
          			Total Comments
          			<span>250</span>
                </div> 
                </div> 
	          </div>
			</div>
		</div> 
	</div>
</div>

<div class="latest">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
                   <div class="panel-heading">
                   	<i class="fa fa-users"></i>Latest <?echo $numUsers;?> Users
                    <!--plus sign-->
                    <div class="toggle-info pull-right">
                    <i class="fa fa-plus fa-lg"></i>
                    </div>
                   </div>
                   <div class="panel-body ">
                   	<ul class="list-unstyled latest-user">
                   	<?

                    if(!empty($latestUsers))
                    {
                     foreach ($latestUsers as $row)
                      {
                        echo '<li>';
                        echo $row['username'].'<a href="members.php?do=Edit&userid='.$row['user_id'].'"><div class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</div></a>';
                        if($row['reg_status']==0)
                        {
                        echo '<a href="members.php?do=Activate&userid='.$row['user_id'].'" ><div class="btn btn-info pull-right confirm"><i class="fa fa-eheck"></i>Activate</div></a>';
                        }
                        echo '</li>';	
                     }
                   }
                   else
                   {
                    echo 'There There\'s No User To Show';
                   }
                   	?>
                   </ul>
                   </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
                   <div class="panel-heading">
                   	<i class="fa fa-tags"></i>Latest <?echo $numItems;?> Items
                    <!--plus sign-->
                   <div class="pull-right">
                   <i class="fa fa-plus fa-lg"></i>
                   </div> 
                   </div>
                   <div class="panel-body ">
                   <ul class="list-unstyled latest-itmes">
                   	<?
                    if(!empty($latestItems))
                    {
                       foreach ($latestItems as $row)
                        {
                           echo '<li>';
                           echo $row['name'].'<a href="items.php?do=Edit&id='.$row['item_id'].'"><div class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</div></a>';
                           if ($row['approve']==0)
                            {
                           	     echo '<a href="items.php?do=Activate&id='.$row['item_id'].'" ><div class="btn btn-info pull-right confirm"><i class="fa fa-check"></i>Activate</div></a>';   
                            }
                           echo '</li>';	
                        }
                    }
                   else
                   {
                    echo 'There\'s No Item To Show';
                   }
                   	?>
                   </ul>
                   </div>
				</div>
			</div>
		</div>

    <!--start latest comments-->

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
                   <div class="panel-heading">
                    <i class="fa fa-comments-o"></i>Latest <? echo $numComments;?> Comments
                    <!--plus sign-->
                    <div class="toggle-info pull-right">
                    <i class="fa fa-plus fa-lg"></i>
                    </div>
                   </div>
                   <div class="panel-body">
                    <?
                      $statement=$conn->prepare('SELECT comments.*,users.username FROM comments  INNER JOIN users ON comments.member_id=users.user_id  ORDER BY c_id DESC');
                      $statement->execute();
                      $result=$statement->fetchAll();
                      if (!empty($result)) 
                      {
                      foreach ($result as $row)
                       {
                         echo '<div class="comment-box">';
                             echo '<span class="comment-m">'.$row['username'].'</span>';
                             echo '<p class="comment-c">'.$row['comment'].'</p>';
                         echo '</div>';
                      }
                    }
                   else
                   {
                    echo 'There\'s No Comment To Show';
                   }
                    ?>
                   </div>
        </div>
      </div>
    </div>
   

    <!--end latest comment-->
	</div>
</div>
<?
   /********Dashboard end*********/

   include $tpl.'footer.php';
}
else
{
 header('location: index.php');
 exit();
}
ob_end_flush();
?>
