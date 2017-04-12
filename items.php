<?
ob_start();
session_start();
$pageTitle="Show Items";
include 'init.php';
$itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;
$statement=$conn->prepare('SELECT items.*,categories.name AS cat_name,users.username FROM items INNER JOIN categories ON items.cat_id=categories.id INNER JOIN users  ON items.member_id =users.user_id WHERE item_id=?');
$statement->execute(array($itemid));
$count=$statement->rowCount();
if($count>0)
{
 $result=$statement->fetch();
?>
<h1 class="text-center"><?echo $result['name'];?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
         <img class="img-responsive img-thumbnail center-block" src="" alt=""/>
		</div>
		<div class="col-md-9 item-info">
             <h2><?echo $result['name'];?></h2>
             <p> <?echo $result['description'];?> </p>
             <ul class="list-unstyled"> 
               <li><i class="fa fa-calendar fa-fw"></i>
               <span>Added Date</span>:<?echo $result['add_date'];?>
               </li>
				<li><i class="fa fa-money fa-fw"></i>
				<span>Price</span>:<?echo $result['price'];?>
				</li>
				<li><i class="fa fa-building fa-fw"></i>
				<span>Made In</span>:<?echo $result['country_made'];?>
				</li>
				<li><i class="fa fa-tags fa-fw"></i>
				<span>Category</span>:<?echo $result['cat_name']?>
				</li>
				<li><i class="fa fa-user fa-fw"></i>
				<span>Added By</span>:<?echo $result['username']?>
				</li>
             </ul>
		</div>
	</div>

<hr class="custom-hr">
<?
if (isset($_SESSION['name']))
 {
?>
<div class="col-md-offset-3 add-comment">
     <h3>Add Your Comment</h3>
	<form action="<? echo $_SERVER['PHP_SELF'].'?itemid='.$result['item_id']; ?>" method="POST">
	<textarea name="comment"></textarea>
	<input type="submit" class="btn btn-primary" value="Add Comment">  <!--<button type="submit" class="btn btn-primary">Add Comment</button>-->
	</form>

	<?
	if ($_SERVER['REQUEST_METHOD']=='POST')
	 {
	 	       $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
               $item_id=$result['item_id'];
               $user_id=$result['member_id'];

       $statement=$conn->prepare('INSERT INTO comments(comment,status,comment_date,item_id,member_id) VALUES(:zcomment,0,now(),:zitem_id,:zuser_id)');
       $statement->execute(array(
                       'zcomment' => $comment,
                       'zitem_id'  =>$item_id,
                       'zuser_id' =>$user_id
       	                ));

       if ($statement)
        {
       	echo '<div class="alert alert-success">Comment Added</div>';
       }
		
	}
	?>

</div>
<?
}
else
{
     echo '<a href="login.php">Login</a> of <a href="login.php">Register</a> To Add Comment';
}
?>

<hr class="custom-hr">

<?
$statement=$conn->prepare('SELECT comments.*,users.username FROM comments INNER JOIN users ON comments.member_id=users.user_id  WHERE item_id=? AND status=1 ORDER BY C_id DESC');
$statement->execute(array($result['item_id']));
$comment=$statement->fetchAll();

?>
  <?
  foreach ($comment as $row) 
  {
  	echo '<div class="comment-box">';
    echo '<div class="row">';
	echo '<div class="col-md-3 text-center">';
 	echo   '<img class="img-responsive img-thumbnail img-circle center-block" src="16.JPG" />';
           echo $row['username'];       
	echo '</div>';
	echo '<div class="col-md-9">';
	echo '<p class="led">'.$row['comment'].'</p>';
	echo '</div>';
    echo '</div>';
    echo '</div>';
 
 echo '<hr class="custom-hr">';
}
 ?>
</div>
<?
}
else
{
  echo 'There is No Such ID';
}
include $tpl.'footer.php';
ob_end_flush();
?>