<?php 
define('path', '../../');
require path.'inc/init.php';

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
			$user = new User();
			$login = $user->login(escape(Input::get('username')), Input::get('password'), $remember);
			if($login){
				//Session::flash('complete', 'You have been logged in!');
				Redirect::to(path.'index.php');
			}
		}else{
			foreach ($val->errors() as $error){
				echo $error.'<br/>';
			}
		}
	}
}
?>
<html>
	<head>
	</head>
	<body>
		<a href="../../index.php">Back</a>
		<form action="" method="post">
			<label for="username">
				Username: <input type="text" name="username" id="username"/><br/>
			</label>
			<label for="password">
				Password: <input type="password" name="password" id="password"/><br/>
			</label>
			<label for="remember">Remember me?</label>
			<input type="checkbox" name="remember" id="remember"/>
			
			<input type="hidden" name="token" value="<?php echo Token::generate()?>"/>
			<input type="submit" value="Submit" id="Submit" name="submit"/>
		</form>
	</body>
</html>