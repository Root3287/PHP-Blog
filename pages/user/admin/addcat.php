<?php 
define('path', '../../../');
require path.'inc/init.php';

$blog = new Blog();

$user = new User();

if(!$user->hasPermission('create')){
	Session::flash('error', 'You do not have create access!');
	Redirect::to(path.'index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		//echo 'token';
		$val = new Validation();
		
		$val->check($_POST, array(
			'name' => array(
				'required'=> true,
				'unique' => 'cat',
				'max' => '255'
			)	
		));
		
		if($val->passed()){
			try{
			$blog->addCat(escape(Input::get('name')));
			Session::flash('complete', 'You added an cat');
			Redirect::to(path.'index.php');
			}catch (Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach ($val->errors() as $error){
				echo $error.'<br/>';
			}
		}
	}
}
?>
<form action="" method="post">
	<input type="text" name="name" id="name"/>
	<input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>"/>
	<input type="submit">
</form>