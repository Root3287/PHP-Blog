<?php 
define('path', '../../../');
require path.'inc/init.php';
$page = "Add Cat";
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
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php';?>
		<div class="container">
			<div class="col-md-9">
			
			</div>
			<div class="col-md-3"></div>
			<form action="" method="post">
				<div class="form-group">
					<div class="col-md-12">
						<input type="text" class="form-control" name="name" id="name"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<a href="index.php" class="btn btn-danger">Back</a>
						<input type="submit" class="btn btn-primary">
					</div>
				</div>
				<input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>"/>
			</form>	
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>