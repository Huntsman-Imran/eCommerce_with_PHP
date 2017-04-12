<?ob_start();
session_start();
if (isset($_SESSION['name']))
{
$pageTitle='Profile';
include 'init.php';
$statement=$conn->prepare('SELECT * FROM users WHERE username=? LIMIT 1');
$statement->execute(array($sessionUser));
$info=$statement->fetch();
?>
  <h1 class="text-center">My Profile</h1>

     <div class="information block">
        <div class="container">
   	     <div class="panel panel-primary">
        		<div class="panel-heading">
              My Information
    		   </div>
   		   <div class="panel-body">
          <ul class="list-unstyled">
            <li><i class="fa fa-unlock-alt fa-fw"></i>
           <span>Name:</span> <? echo $info['username'];?><br/>
           </li>

           <li><i class="fa fa-envelope-o fa-fw"></i>
           <span> Email:</span> <? echo $info['email'];?><br/>
           </li>

           <li><i class="fa fa-user fa-fw"></i>
           <span>Full Name:</span> <?echo $info['full_name'];?><br/>
          </li>

          <li><i class="fa fa-calendar fa-fw"></i>
           <span>Register Date:</span><?echo $info['date'];?><br/>
          </li>

          <li><i class="fa fa-tags fa-fw"></i>
           <span>Fav Category:</span> <?echo $info['user_id'];?><br/>
          </li>
         </ul>
   		   </div>
   	  </div>
    </div>

    <div class="my-ads block">
    <div class="container">
      	<div class="panel panel-primary">
      		 <div class="panel-heading">
          My Ads
      		 </div>
      		 <div class="panel-body">

            <?
            $checkItem=getItems('member_id',$info['user_id']) ;
             if(!empty($checkItem))
            {
              ?>

                  <div class="row">
                      <?
                      foreach (getItems('member_id',$info['user_id']) as $row) //sending catid with page id and retriving items of corresponding categories 
                      {
                         echo '<div class="col-sm-6 col-md-3">';
                         echo '<div class="thumbnail item-box">';
                         echo '<div class="price-tag">'.$row['price'].'</div>';
                         echo '<img class="img-responsive" src="" alt="" />';
                         echo '<div class="caption">';
                         echo '<h3><a href="items.php?itemid='.$row['item_id'].'">'.$row['name'].'</a></h3>';
                         echo '<p>'.$row['description'].'</p>';
                         echo '<div class="date">'.$row['add_date'].'</div>';
                         echo '</div>';
                         echo '</div>';
                         echo '</div>';
                      }
                      ?>
                  </div>
                  <?
                   }
                   else
                   {
                    echo 'Ther Is No Record To Show';
                   }
                  ?>
      		 </div>
      	</div>
    </div>   

      <div class="my-comments block">
      <div class="container">
         	<div class="panel panel-primary">
         		<div class="panel-heading">
            My Comments
         		</div>
         		<div class="panel-body">
             <?
              $statement=$conn->prepare('SELECT * FROM comments WHERE member_id=? ORDER BY c_id DESC');
              $statement->execute(array($info['user_id']));
              $result=$statement->fetchAll();
              if(!empty($result))
               {
                 foreach ($result as $row)
                  {
                   echo '<p>'.$row['comment'].'</p><br/>';
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

<?
}
else
{
	header('location: login.php');
	exit();
}
include $tpl.'footer.php';
ob_end_flush();
?>