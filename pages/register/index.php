<?php
define('path', '../../');
require path.'inc/init.php';
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
					'unique' => users
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
		if(!$val->passed()){
			foreach ($val->errors() as $error){
				echo $error.'<br/>';
			}
		}else{
			$user = new User();
			
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
			session::flash('complete', 'you completely register');
			Redirect::to(path.'index.php');
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
		<label for="name">
				Name: <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name'));?>"/><br/>
			</label>
			<label for="username">
				Username: <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>"/><br/>
			</label>
			<label for="password">
				Password: <input type="password" name="password" id="password" value="<?php echo escape(Input::get('password'));?>"/><br/>
			</label>
			<label for="password_conf">
				Password: <input type="password" name="password_conf" id="password_conf"/><br/>
			</label>
			<input type="hidden" name="token" value="<?php echo Token::generate();?>"/>
			<input type="submit" value="Submit"/>
		</form>
	</body>
</html>
