<?session_start();
$pageTitle='Category';
include 'init.php';?>
<div class="container">
	<h1 class="text-center"><?echo str_replace('-',' ',$_GET['pagename'])?></h1>
	  <div class="row">
		<?
		foreach (getItems('cat_id',$_GET['pageid']) as $row) //sending catid with page id and retriving items of corresponding categories 
		{
		   echo '<div class="col-sm-6 col-md-4">';
		   echo '<div class="thumbnail item-box">';
		   echo '<div class="price-tag">'.$row['price'].'</div>';
		   echo '<img class="img-responsive" src="" alt="" />';
		   echo '<div class="caption">';
		   echo '<h3>'.$row['name'].'</h3>';
		   echo '<p>'.$row['description'].'</p>';
		   echo '</div>';
		   echo '</div>';
		   echo '</div>';
		}
		?>
	   </div>
	</div>
<?
include $tpl.'footer.php';
?>