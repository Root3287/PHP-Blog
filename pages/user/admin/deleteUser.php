<?php
define('path', '../../../');
$page = "Delete User";
include path.'inc/init.php';
$user = new User();
if(!$user->exist() || !$user->hasPermission("Admin")){
	Redirect::to(path.'index.php');
}
if(Input::exists('get') && Input::get('uid')){
	$user2 = new User(Input::get('uid'));
	if(!$user2->exist()){
		session::flash('error', 'The user does not exists!');
		Redirect::to(path.'index.php');
	}
}else{
	session::flash('error', 'The user does not exists!');
	Redirect::to(path.'index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$val = new Validation();
		$val->check($_POST, array(
			'id'=> array(
				'required' => true,
			),
		));
		if($val->passed()){
			try {
				$user2->deleteUser(Input::get('id'));
				session::flash('complete','You deleted '.$user2->data()->name);
				Redirect::to(path.'index.php');
			}catch (Exception $e){
				session::flash('error', $e->getMessage());
				Redirect::to(path.'index.php');
			}
		}
	}
}
?>
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php';?>
		<div class="container">
			<form action="" method="post">
			<h1>Are you sure you want to delete <?php echo $user2->data()->name;?>?</h1>
			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" class="btn btn-danger" placeholder="confirm" id="confirm">
					<a class="btn btn-primary" href="showUser.php">Decline</a>
				</div>
			</div>
			<input type="hidden" name="token" value="<?php echo Token::generate();?>">
			<input type="hidden" name="id" value="<?php echo Input::get('uid');?>">
			</form>
		</div>
		<?php include path.'assets/php/js.php'?>
	</body>
</html>