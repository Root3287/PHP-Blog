<?php 
define('path', '../../../');
$page = "Edit User";
include path.'inc/init.php';
$user = new User();

if(!Input::get('get') || Input::get('uid') == null){
	session::flash('error', 'The user does not exsit!');
}
if(Input::get('get') || Input::get('uid') !=null){
	$user2 = new User(Input::get('uid'));
	if(!$user2->exist()){
		session::flash('error', 'The user does not exist!');
		Redirect::to(path.'index.php');
	}
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validation();
		$validate->check($_POST, array(
			'id'=> array(
				'required' => true,
			),
			'name' => array(
				'required' => true,
			),
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 15,	
			),
			'group' => array(
				'required' => true,
			),
		));
		if ($validate->passed()){
			try{
				$user2->update(Input::get('name'), Input::get('group'), Input::get('username'), Input::get('id'));
				session::flash('complete', 'You updated '.Input::get('name').' details!');
				Redirect::to(path.'index.php');
			}catch (Exception $e){
				session::flash('error', 'There was an error updating the user '.Input::get('name').' with the message of '.$e->getMessage().'('.$e->getCode().')');
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
			<div class="col-md-9">
				<form action="" method="post">
					<div class="form-group">
						<div class="col-md-12">
							<input type="text" name="group" id="group" autocomplete="off" value="<?php echo $user2->data()->group;?>" class="form-control input-md" placeholder="Group" tabindex="3">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<input type="text" name="name" id="name" autocomplete="off" value="<?php echo $user2->data()->name;?>" class="form-control input-md" placeholder="Name" tabindex="3">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<input type="text" name="username" id="username" autocomplete="off" value="<?php echo $user2->data()->username;?>" class="form-control input-md" placeholder="Username" tabindex="3">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<input type="submit" class="btn btn-primary">
						</div>
					</div>
					<input type="hidden" name="id" id="token" value="<?php echo Input::get('uid');?>">
					<input type="hidden" name="token" id="token" value="<?php echo Token::generate();?>">
				</form>
			</div>
			<div class="col-md-3">
			</div>
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>