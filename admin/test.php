<?
 include 'init.php';
    echo '<div class="cat">';
      echo '<div class="hidden-buttons">';
	   echo '<a href="categories.php?do=Edit&id='.$row['id'].'"><div class="btn btn-xs btn-primary" ><i class="fa fa-edit">Edit</i></div></a>';
	   echo '<a href="categories.php?do=Delete&id='.$row['id'].'"><div class="btn btn-xs btn-danger"><i class="fa fa-close">Delete</i></div></a>';
	  echo '</div>';
	  echo '</div>';
 include $tpl.'footer.php';
?>