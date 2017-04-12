<?
ob_start();
session_start();
if(isset($_SESSION['name']))
{
	$pageTitle='Categories';
	include 'init.php';
	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
	if ($do=='Manage') 
	{
        $sort='ASC';
       $sortarray=array('ASC','DESC');
       if(isset($_GET['sort'])&&in_array($_GET['sort'], $sortarray))
       {
        $sort=$_GET['sort'];
       }

       $statement=$conn->prepare('SELECT * FROM categories ORDER BY  ordering '.$sort);
       $statement->execute();
       $result=$statement->fetchAll();
       if (!empty($result))
        {
        ?>
        <h1 class="text-center">Manage Category</h1>
         <div class="container categories">
          <div class="panel panel-default">
            <div class="panel-heading panel-effect">
              <i class="fa fa-edit"></i>All Categories

                 <!--ordering linnk-->
            <div class="option pull-right">
                 <i class="fa fa-sort"></i>Ordering:
              [<a class="<? if($sort=='ASC'){echo 'active';}?>" href="categories.php?sort=ASC"> Asc</a> |
                <a class="<?if($sort=='DESC'){echo 'active';}?>" href="categories.php?sort=DESC">Desc</a>]
                <i class="fa fa-eye"></i>view:
                [<span class="active" data-view="full">Full</span> |
                <span data-view="classic">Classic</span>]
            </div>
            </div>
            <div class="panel-body">
              <?
              foreach ($result as $row)
               {
                echo '<div class="cat">';

                echo '<div class="hidden-buttons">';
                   echo '<a href="categories.php?do=Edit&id='.$row['id'].'"><div class="btn btn-xs btn-primary" ><i class="fa fa-edit">Edit</i></div></a>';
                   echo '<a href="categories.php?do=Delete&id='.$row['id'].'"><div class="btn btn-xs btn-danger"><i class="fa fa-close">Delete</i></div></a>';
                echo '</div>';
                         
                echo  '<h3>'.$row['name'].'</h3>';
                 
                 echo '<div class="full-view">';

                echo '<p>'; 

                if($row['description']==''){ echo 'This Category Has No Description';}else{ echo $row['description'];} echo '<br/>'; 
                echo 'Ordering Is '.$row['ordering']; 

                echo '</p>';

                echo '<span>';   
                if($row['visibility']==1){ echo '<span class="visibility cat-span"><i class="fa fa-eye"></i>Hidden</span>';} 
                echo '</span>';

                echo '<span>';   
                if($row['allow_comment']==1){ echo '<span class="allow_comment cat-span"><i class="fa fa-close"></i>Comment Disabled</span>';} 
                echo '</span>';

                echo '<span>';   
                if($row['allow_ads']==1){ echo '<span class="allow_ads cat-span"><i class="fa fa-close"></i>Ads Disabled</span>';} 
                echo '</span>';  

                echo '</div>';              

                echo '</div>';
                echo '<hr>';
              }
              ?>
            </div>
          </div>
               <a class="btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New</a>
         </div>
        <?
      }
     else
     {
      echo '<div class="container">';
      echo '<div class="nice-message"> There\'s No Category To Show</div>';
      echo '<a class="btn btn-primary" href="members.php?do=Add"><i class="fa fa-plus"></i>New Category</a>';
      echo '</div>';
     }
	}
    else if($do=='Add')
	 {
	 ?>
       <div class="container">
       	<h1 class="text-center">Add New Category</h1>
       	<form class="form-horizontal" action="?do=Insert" method="POST">
       		<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Name</label>
                 <div class="col-sm-10 col-md-6">
                 	<input type="text" name="name" id="" class="form-control" placeholder="Name Of Category" autocomplete="off" required="required">
                 </div>
       			</div>
       			<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Description</label>
                 <div class="col-sm-10 col-md-6">
                 	<input type="text" name="description" id="" class="form-control" placeholder="Describe The Category" autocomplete="off">
                 </div>
       			</div>
       			<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Ordering</label>
                 <div class="col-sm-10 col-md-6">
                 	<input type="text" name="ordering" id="" class="form-control" placeholder="Number To Arrange The Category" autocomplete="off">
                 </div>
       			</div>
       			<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Visible</label>
                 <div class="col-sm-10 col-md-6">
                 	<div>
                 		<input type="radio" id="vis-yes" name="visibility" value="0" checked>
                 		<lebel for="vis-yes">Yes</lebel> 
                 	</div>
                 	<div>
                 		<input type="radio" id="vis-no" name="visible" value="1">
                 		<lebel for="vis-yes">No</lebel> 
                 	</div>
                 </div>
       			</div>
       			<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Allow Commenting</label>
                 <div class="col-sm-10 col-md-6">
                 	<div>
                 		<input type="radio" id="com-yes" name="allow_comment" value="0" checked>
                 		<lebel for="com-yes">Yes</lebel> 
                 	</div>
                 	<div>
                 		<input type="radio" id="com-no" name="allow_comment" value="1">
                 		<lebel for="com-yes">No</lebel> 
                 	</div>
                 </div>
       			</div>
       			<div class="form-group form-group-lg">
       			<label class="col-sm-2 control-label">Allow Ads</label>
                 <div class="col-sm-10 col-md-6">
                	<div>
                 		<input type="radio" id="ads-yes" name="allow_ads" value="0" checked>
                 		<lebel for="ads-yes">Yes</lebel> 
                 	</div>
                 	<div>
                 		<input type="radio" id="ads-no" name="allow_ads" value="1">
                 		<lebel for="ads-yes">No</lebel> 
                 	</div>
                 </div>
       			</div>
       			<div class="from-group from-group-lg">
       				<div class="col-sm-offset-2 col-sm-10">
       					<button class="btn btn-primary">Save</button>
       				</div>
       			<div>
       	</form>
       </div>
	 <?
	 }
	 else if($do=='Insert')
	 {
	     echo '<div class="container">';
	     echo '<h1 class="text-center">Insert Category</h1>';
	     if ($_SERVER['REQUEST_METHOD']=='POST')
	      {
	     	$name=$_POST['name'];
	     	$description=$_POST['description'];
	     	$ordering=$_POST['ordering'];
	     	$visibility=$_POST['visibility'];
	     	$allow_comment=$_POST['allow_comment'];
	     	$allow_ads=$_POST['allow_ads'];

            $formErrors=array();

         if(strlen($name)<3)
         {
                $formErrors[]= 'Name Can\'t Be Less Then <strong>3 Characters </strong>';
         }
         if (strlen($name)>20)
         {
           $formErrors[]= 'Name Can\'t Be Greater Then <strong>20 Characters </strong>';
         }
         if (empty($name))
           {
             $formErrors[]= 'Name can\'t Be <strong>Empty</strong>';
           }

           foreach ($formErrors as $error)
            {
             echo '<div class="alert alert-danger">'.$error.'</div>';
           }

	     	$check=checkItem('name','categories',$name);
	     	if ($check==1) 
	     	{
	     	     $errMessage= '<div class="alert alert-danger">Sorry This Category Is Already <strong>Exist</strong></div>';
	     	     redirectHome($errMessage,'back');
	     	}
	     	else
	     	{
	     		$statement=$conn->prepare('INSERT INTO categories(name,description,ordering,visibility,allow_comment,allow_ads) VALUES(:zname,:zdescription,:zordering,:zvisibility,:zallow_comment,:zallow_ads)');
	     		$statement->execute(array(
                    'zname'=>$name,
                    'zdescription'=>$description,
                    'zordering'=>$ordering,
                    'zvisibility'=>$visibility,
                    'zallow_comment'=>$allow_comment,
                    'zallow_ads'=>$allow_ads
	     			));
	     		  $successMessage= '<div class="alert alert-success">'.$statement->rowCount().' Record Updated</div>';
	     	     redirectHome($successMessage,'back');

	     	}
	     	
	     }
    else
      {
        echo '<div class="container">';
        $errMessage='<div class="alert alert-danger">you Can Not Brows The page Directly</div>';
        //calling function form function from functions.php //n. b.: ei function e header function e kichu problem ache
          redirectHome($errMessage,'back');
          echo '</div>';
      }
	     echo '</div>';
	 }

   else if ($do=='Edit')
    {
       $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

      $statement=$conn->prepare('SELECT * FROM categories   WHERE id=? LIMIT 1');
      $statement->execute(array($id));
      $result=$statement->fetchAll();
      foreach ($result as $row)
       {

?>
      <div class="container">
        <h1 class="text-center">Edit Category</h1>
        <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="hdnid" value="<?echo $row['id']; ?>">
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
                 <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" id="" class="form-control" placeholder="Name Of Category" autocomplete="off" value="<?echo $row['name'];?>" required="required">
                 </div>
            </div>
            <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
                 <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" id="" class="form-control" placeholder="Describe The Category" value="<?echo $row['description'];?>" autocomplete="off">
                 </div>
            </div>
            <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
                 <div class="col-sm-10 col-md-6">
                  <input type="text" name="ordering" id="" class="form-control" placeholder="Number To Arrange The Category" value="<?echo $row['ordering'];?>" autocomplete="off">
                 </div>
            </div>
            <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
                 <div class="col-sm-10 col-md-6">
                  <div>
                    <input type="radio" id="vis-yes" name="visibility" value="0" checked>
                    <lebel for="vis-yes">Yes</lebel> 
                  </div>
                  <div>
                    <input type="radio" id="vis-no" name="visible" value="1">
                    <lebel for="vis-yes">No</lebel> 
                  </div>
                 </div>
            </div>
            <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Commenting</label>
                 <div class="col-sm-10 col-md-6">
                  <div>
                    <input type="radio" id="com-yes" name="allow_comment" value="0" checked>
                    <lebel for="com-yes">Yes</lebel> 
                  </div>
                  <div>
                    <input type="radio" id="com-no" name="allow_comment" value="1">
                    <lebel for="com-yes">No</lebel> 
                  </div>
                 </div>
            </div>
            <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
                 <div class="col-sm-10 col-md-6">
                  <div>
                    <input type="radio" id="ads-yes" name="allow_ads" value="0" checked>
                    <lebel for="ads-yes">Yes</lebel> 
                  </div>
                  <div>
                    <input type="radio" id="ads-no" name="allow_ads" value="1">
                    <lebel for="ads-yes">No</lebel> 
                  </div>
                 </div>
            </div>
            <div class="from-group from-group-lg">
              <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary">Save</button>
              </div>
            <div>
        </form>
       </div>
       <?
     }
     
   }
   else if($do=='Update')
   {

       echo  '<h1 class="text-center">Update member</h1>'; 
         echo '<div class="container">';
          

                    

                  if ($_SERVER['REQUEST_METHOD']=='POST') 
                  {
                      $id=$_POST['hdnid'];
                      $name=$_POST['name'];
                      $description=$_POST['description'];
                      $ordering=$_POST['ordering'];
                      $visibility=$_POST['visibility'];
                      $allow_comment=$_POST['allow_comment'];
                      $allow_ads=$_POST['allow_ads'];

                       //validation

                     $formErrors=array();

                       if(strlen($name)<4)
                       {
                              $formErrors[]= '<div class="alert alert-danger">Name Can\'t Be Less Then <strong>4 Characters </strong></div>';
                       }
                       if (strlen($name)>20)
                       {
                         $formErrors[]= '<div class="alert alert-danger">Name Can\'t Be Greater Then <strong>20 Characters </strong></div>';
                       }
                       if (empty($name))
                       {
                         $formErrors[]= '<div class="alert alert-danger">Name can\'t Be <strong>Empty</strong></div>';
                       }
                        
                       foreach ($formErrors as $error)
                        {
                        echo $error;
                       }
                         //Check if there no error proceed the update opreation
                       if(empty($formErrors))
                      {


                        $statement1=$conn->prepare('SELECT * FROM categories WHERE name=? AND id !=?');
                        $statement1->execute(array($name,$id));
                        $count=$statement1->rowCount();
                        if ($count==1)
                         {
                          $errMessage='<div class="alert alert-danger">Sorry This Category Is Already Exist</div>';
                          redirectHome($errMessage,'back');
                        }
                        else
                        {
                      $statement=$conn->prepare('UPDATE categories SET name=?,description=?,ordering=?,visibility=?,allow_comment=?,allow_ads=? WHERE id=?');
                      $statement->execute(array($name,$description,$ordering,$visibility,$allow_comment,$allow_ads,$id));

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
      echo '<h1 class="text-center">Delete Category<h1>';
      echo '<div class="container">';
       $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

       $Check=checkItem('id','categories',$id);

       if ($Check==1) 
       {
            $statement=$conn->prepare('DELETE FROM categories WHERE id= :zid');
            $statement->bindParam(':zid',$id);
            $statement->execute(); 
            $successMessage='<div class="alert alert-success">'.$statement->rowCount().' Record  Deleted</div>';
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
}
ob_end_flush();
?>