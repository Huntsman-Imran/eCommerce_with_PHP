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
      <a class="navbar-brand" href="dashboard.php"><?echo lang('HOME_ADMIN');?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?echo lang('CATEGORIES');?></a></li>
        <li><a href="items.php"><?echo lang('ITEMS');?></a></li>
        <li><a href="members.php"><?echo lang('MEMBERS');?></a></li>
        <li><a href="comments.php"><?echo lang('COMMENTS');?></a></li>
        <li><a href="#"><?echo lang('STATISTICS');?></a></li>
        <li><a href="#"><?echo lang('LOGS');?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?echo $_SESSION['name'];?><span class="caret"></span></a>
          <ul class="dropdown-menu">
             <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?echo $_SESSION['id']?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>