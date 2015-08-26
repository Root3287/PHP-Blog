<?php 
define("path", "../../../");
include path.'inc/init.php';
$page = "Admin";
$user = new User();
if(!$user->hasPermission("Admin")){
	session::flash("error", "You dont have admin permission! If you think this is an error contact your administrator or owner!");
	Redirect::to(path."index.php");
}
?>
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php';?>
		<div class="container">
			<div class="jumbotron">
				<h1>Welcome back</h1>
				<h3><?php echo escape($user->data()->name);?></h3>
			</div>
			<div class="col-md-9">
				<h3>Navigation</h3>
				<div class="well">
					<a href="addCat.php">Add a Cat</a><br>
					<a href="addPost.php">Add a Post</a><br>
					<a href="addUser.php">Add a User</a><br>
					<a href="showUser.php">Show Users</a><br>
					<a href="deleteCat.php">Delete Cat</a><br>
					<a href="deletePost.php">Delete Post</a><br>
				</div>
			</div>
			<div class="col-md-3">
			</div>
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>