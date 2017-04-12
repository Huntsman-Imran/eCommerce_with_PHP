<?
/*
Categories=[ Insert | Update | Delete | Edit | Manage | States | Add ]
*/
 $do=isset($_GET['do'])?$_GET['do']:'Manage';

//If the page is main page
 if($do=='Manage')
 {
  echo 'Welcome you are in manage category page';
  echo '<a href="/?do=Insert">Add New Category</a>';
 }
 else if ($do=='Add')
 {
   echo 'Welcome you are in add category page';
 }
 else if($do=='Insert')
 {
     echo 'Welcome you are in insert category page';
 }
 else
 {
 	echo 'There is no page in this name';
 }



?>
