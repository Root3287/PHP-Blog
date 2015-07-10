<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo Config::get('config/name');?></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li<?php if($page === "home"){?> class="active"<?php } ?>><a href="<?php echo path;?>index.php">Home</a></li>
        
        <li<?php if($page === "post"){?> class="active"<?php } ?>><a href="<?php echo path;?>pages/post/index.php">Posts</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input class="form-control" placeholder="Search" type="text">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      	 <li class="dropdown">
          <?php if(!$user->isLoggedIn()){?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Guest <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo path?>pages/register/index.php">Register</a></li>
            <li><a href="<?php echo path?>pages/login/index.php">Login</a></li>
          </ul>
          <?php }else{?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user->data()->username;?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo path;?>pages/logout/index.php">logout</a></li>
            <li><a href="<?php echo path;?>pages/user/index.php">UserCP</a></li>
            <?php if($user->hasPermission('Mod')){?>
            <li class="divider"></li>
            <li><a href="<?php echo path?>pages/mod/index.php">ModCP</a></li>
            <?php }
            	if($user->hasPermission('Admin')){?>
            <li class="divider"></li>
            <li><a href="<?php echo path;?>pages/admin/index.php">AdminCP</a></li>
            <?php }?>
          </ul>
          <?php }?>
        </li>
      </ul>
    </div>
  </div>
</nav>