<?
ob_start();
session_start();
$pageTitle="Create New Item";
include 'init.php';
if ($_SESSION['name']) 
{
      if ($_SERVER['REQUEST_METHOD']=='POST') {
      	$name= filter_var($_POST['name'],FILTER_SANITIZE_STRING);
      	$description=filter_var($_POST['description'],FILTER_SANITIZE_STRING);
      	$price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
      	$country_made=filter_var($_POST['country_made'],FILTER_SANITIZE_STRING);
      	$status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
      	$cat_id=filter_var($_POST['cat_id'],FILTER_SANITIZE_NUMBER_INT);

      	$formErrors=array();


      	if (strlen($name)<4) 
      	{
      		$formErrors[]='Item Title Must Be At Least 4 Character';
      	}

      	if (strlen($description)<10) 
      	{
      		$formErrors[]='Item Description Must Be At Least 10 Character';
      	}
      	if (empty($price)) 
      	{
      		$formErrors[]='Item Price Must Not Be Empty';
      	}
      	 if (empty($country_made)) 
      	{
      		$formErrors[]='Country Of Made Must Be Not Empty';
      	}
      	if ($status==='0') 
      	{
      		$formErrors[]='You Must Choose A Status';
      	}
      	if ($cat_id==='0') 
      	{
      		$formErrors[]='You Must Choose A Category';
      	}


      	$statement=$conn->prepare('INSERT INTO items(name,description,price,country_made,status,add_date,cat_id,member_id) VALUES(:zname,:zdescription,:zprice,:zcountry_made,:zstatus,now(),:zcat_id,:zmember_id)');
      	$statement->execute(array(
                          
								'zname'=>$name,
								'zdescription'=>$description,
								'zprice'=>$price,                         
								'zcountry_made'=>$country_made,                         
								'zstatus'=>$status,
								'zcat_id'=>$cat_id,                        
								'zmember_id'=> $_SESSION['userid'] //login er somy session er madhome aseche
								));
      	      	
      }

	?>
     <h1 class="text-center"><?echo $pageTitle;?></h1>
     <div class="new-ad block">
     	<div class="container">
	     	<div class="panel panel-primary">
	     		<div class="panel-heading">
	     			<?echo $pageTitle;?>
	     		</div>
	     		<div class="panel-body">
	     			<div class="row">
		     			<div class="col-md-8">
		     				   <form class="form-horizontal main-form" action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
					      		<div class="form-group form-group-lg">
					               <label class="col-sm-3 control-label">Name</label>
					               <div class="col-sm-10 col-md-9">
					               	  <input type="text" name="name" class="form-control live" data-class=".live-name" autocomplete="off" placeholder="Name Of Items" required="required">
					               </div>
					      		</div>
					      			<div class="form-group form-group-lg">
					               <label class="col-sm-3 control-label">Description</label>
					               <div class="col-sm-10 col-md-9">
					               	  <input type="text" name="description" class="form-control live" data-class=".live-des" autocomplete="off" placeholder="Description Of Items" required="required">
					               </div>
					      		</div>
					      			<div class="form-group form-group-lg">
					               <label class="col-sm-3 control-label">Price</label>
					               <div class="col-sm-10 col-md-9">
					               	  <input type="text" name="price" class="form-control live" data-class=".live-price" autocomplete="off" placeholder="Price Of Items" required="required">
					               </div>
					      		</div>
					      			<div class="form-group form-group-lg">
					               <label class="col-sm-3 control-label">Country</label>
					               <div class="col-sm-10 col-md-9">
					               	  <input type="text" name="country_made" class="form-control" autocomplete="off" placeholder="Country Of Made" required="required">
					               </div>
					      		</div>
					      		<div class="form-group form-group-lg">
					               <label class="col-sm-3 control-label">Status</label>
					               <div class="col-sm-10 col-md-9">
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
					               <label class="col-sm-3 control-label">Category</label>
					               <div class="col-sm-10 col-md-9">
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
					      			<div class="col-sm-offset-3 col-sm-9">
					                <button type="submit" class="btn btn-primary">Add Item</button>    <!--eta input tag dia o kora jae-->
					      			</div>
					      		</div>
					      	</form>

                        <!--SHOW FORM ERROR START-->
                        
                        <?
                        if (!empty($formErrors))
                         {
                         foreach($formErrors as $error)
                           {
                                echo '<div class="alert alert-danger">'.$error.'</div>';	
                           }

                        }
                        ?>
                        <!--SHOW FORM ERROR END-->


		     			</div>
		     			<div class="col-md-4">
                         	   <div class="thumbnail item-box live-preview">
							        <div class="price-tag"><span>$</span><span class="live-price">0</span></div>
							        <img src="" alt="" />
									   <div class="caption">
									   <h3 class="live-name"></h3>
									   <p class="live-des"></p>
									   </div>
							   </div>
		     			</div>
	     		   </div>
	     		</div>
	     	</div>
        </div>
     </div>

	<?
}
else
{
	header('location: index.php');
	exit();
}
include $tpl.'footer.php';
ob_end_flush();
?>