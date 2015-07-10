<?php 
define('path', '../../');
require path.'inc/init.php';
$page = "login";
$user = new User();

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$val = new Validation();
		$val->check($_POST, array(
			'username' => array(
				'required' => true
			),
			'password' => array(
				'required' => true
			)
		));
		if($val->passed()){
			$remember = (Input::get('remember') == 'on')? true:false;
			
			$login = $user->login(escape(Input::get('username')), Input::get('password'), $remember);
			if($login){
				Session::flash('complete', 'You have been logged in!');
				Redirect::to(path.'index.php');
			}else{
			
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
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
					<?php if(Input::exists()){if(!$val->passed()){echo '<div class="alert alert-danger">';foreach($val->errors() as $error){echo $error.'<br/>';}echo '</div>';}}?>
					<form role="form" action="" method="post" class="form-horizontal">
						 <h2>Login</h2>
						<fieldset>
						    <div class="form-group">
						      <div class="col-lg-12">
						       <input type="text" name="username" id="username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>" class="form-control input-lg" placeholder="Username" tabindex="3">
						      </div>
						    </div>
						    <div class="form-group">
						        <div class="col-lg-12">
						        <input type="password" name="password" id="password" autocomplete="off" value="<?php echo htmlspecialchars(Input::get('password')); ?>" class="form-control input-lg" placeholder="Password" tabindex="3">
						        <div class="checkbox">
						          <label for="remember">
						            <input type="checkbox" id="remember" name="remember"> Remember Me
						          </label>
						        </div>
						      </div>
						    </div>
						    
						    <div class="form-group">
						      <div class="col-lg-12">
						        <button type="reset" class="btn btn-default">Cancel</button>
						        <button type="submit" class="btn btn-primary">Submit</button>
						      	<a class="btn btn-success" href="<?php echo path;?>pages/register/index.php">Register</a>
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