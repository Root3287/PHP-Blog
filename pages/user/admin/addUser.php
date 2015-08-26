<?php
define('path', '../../../');
$page = "Register";
require path.'inc/init.php';
$user = new User();
if($user->hasPermission("Admin")){
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$val = new Validation();
			$val->check($_POST, array(
					'name' => array(
							'required' => true,
					),
					'username' => array(
							'required' => true,
							'min' => 2,
							'max' => 50,
							'unique' => 'users'
					),
					'password' => array(
							'required' => true,
							'min' => 8
					),
					'password_conf' => array(
							'required' => true,
							'matches'=> 'password'
					)
			));
			if($val->passed()){	
				$salt = hash::salt(32);
					
				$password = hash::make(escape(Input::get('password')) , $salt);
					
				try{
					$user->create(array(
							'username' => escape(Input::get('username')),
							'password'=> Hash::make(escape(Input::get('password')), $salt),
							'salt' => $salt,
							'name'=> escape(Input::get('name')),
							'joined'=> date('Y-m-d- H:i:s'),
							'group'=> 1,
					));
				}catch (Exception $e){
					die($e->getMessage());
				}
			}
		}
	}
}else{
	session::flash("error", "You don't have admin permission! If you think this is an error contact your administrator or owner");
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
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
					<?php if(Input::exists()){
							if(!$val->passed()){
								echo '<div class="alert alert-danger">';
								foreach($val->errors() as $error){
									echo $error.'<br/>';
								}
								echo '</div>';
							}else{
								echo '<div class="alert alert-success">You registered '.escape(Input::get('name')).'!</div>';
							}
						  }
						  ?>
					<form role="form" action="" method="post" class="form-horizontal">
						 <h2>Register a user</h2>
						<fieldset>
							<div class="form-group">
						      <div class="col-lg-12">
						       <input type="text" name="name" id="name" autocomplete="off" value="<?php echo escape(Input::get('name')); ?>" class="form-control input-lg" placeholder="Name" tabindex="3">
						      </div>
						    </div>
						    <div class="form-group">
						      <div class="col-lg-12">
						       <input type="text" name="username" id="username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>" class="form-control input-lg" placeholder="Username" tabindex="3">
						      </div>
						    </div>
						    <div class="form-group">
						        <div class="col-lg-12">
						        <input type="password" name="password" id="password" autocomplete="off" value="<?php echo htmlspecialchars(Input::get('password')); ?>" class="form-control input-lg" placeholder="Password" tabindex="3">
						      </div>
						    </div>
						    
						      <div class="form-group">
						        <div class="col-lg-12">
						        <input type="password" name="password_conf" id="password_conf" autocomplete="off" value="" class="form-control input-lg" placeholder="Password Confirm" tabindex="3">
						      </div>
						    </div>
						    
						    <div class="form-group">
						      <div class="col-lg-12">
						        <button type="reset" class="btn btn-default">Cancel</button>
						        <button type="submit" class="btn btn-primary">Submit</button>
						      </div>
						    </div>
					  </fieldset>
					  <input type="hidden" name="token" value="<?php echo Token::generate()?>"/>
					</form>
				</div>
			</div>
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>