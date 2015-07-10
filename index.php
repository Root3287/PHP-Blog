<?php
define('path' , '');
require path.'inc/init.php';
$user = new User();
?>
<html>
	<head>
	</head>
	<body>
		<?php
			if(Session::exists('complete')){
				echo Session::flash('complete');
			}
			
			if($user->isLoggedIn()){
				echo 'Welcome back '.$user->data()->username;
			}
		?>
		<ul>
			<li><a href="pages/login/index.php">Login</a></li>
			<li><a href="pages/register/index.php">Sign Up</a></li>
			<li><a href="pages/logout/index.php">Log Out</a></li>
		</ul>
	</body>
</html>