<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8"/>
		<title><?getTitle();?></title>
		<link rel="stylesheet" href="<? echo $css; ?>bootstrap.min.css"/>
		<link rel="stylesheet" href="<? echo $css; ?>font-awesome.min.css"/>
		<link rel="stylesheet" href="<? echo $css; ?>jquery-ui.css"/>
		<link rel="stylesheet" href="<? echo $css; ?>fontend.css"/>
	
		
</head>
		<body>
			<div class="upper-bar">
				<div class="container">
					<?if(isset($_SESSION['name']))
                      {
                      	echo 'Welcome '.$sessionUser.' ';
                      	echo '<a href="profile.php">My Profile</a> - ';
                      	echo '<a href="newad.php">New Ad</a> - ';
                      	echo  '<a href="logout.php">Logout</a>';
                      	$checkStatus=checkUserStatus($sessionUser);

                      	if ($checkStatus==1)
                      	 {
                      	  
                      	 }
                   
                       }
                       else
                       {
                       	?>
                        <a href="login.php">
                        	<span class="pull-right">Login/Signup</span>
                        </a>
                       	<?
                       }
					?>
			</div>
			</div>
			<nav class="navbar navbar-inverse">
			  <div class="container">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="index.php">Homepage</a>
			    </div>
			       <div class="collapse navbar-collapse" id="app-nav">
			          <ul class="nav navbar-nav navbar-right">
			          	<?
                          foreach (getCat() as $row)
                          {
                          	echo '<li>';
                          	echo '<a href="categories.php?pageid='.$row['id'].'&pagename='.str_replace(' ','-',$row['name']).'">'.$row['name'].'</a>';
                          	echo '</li>';
                          }
			          	?>
			  
			      </ul>
			       </div>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>