<?php
define('path', '../../../');
include path.'inc/init.php';
$page = "admin";

$user= new User();
$blog = new Blog();

$val = new Validation();

if($user->isLoggedIn() && $user->hasPermission('delete')){
	if(input::exists()){
		if(Token::check(input::get('token'))){
			
			$val->check($_POST, array(
				'ConfirmDel'=> array(
					'required'=> true,
				),
				'post_id' => array(
					'required'=> true,
				)
			));
			if($val->passed()){
				$blog->deletePost(Input::get('post_id'));
				session::flash('complete', 'You have deleted a post!');
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
			<div class="col-md-9">
				<?php if(Input::exists()){if(!$val->passed()){?><div class="alert alert-danger"><?php foreach ($val->errors() as $error){echo $error.'<br/>';}?></div><?php }}?>
				<form action="" method="post">
					<div class="form-group">
					<select name="post_id">
						<?php 
							foreach ($blog->getPost() as $post){
								echo "<option name='cat' id='cat' value='{$post->post_id}'>{$post->title}</option>";
							}
						?>
					</select>
					</div>
					<div class="form-group">
						<label for="Confirm">Ready for deletion</label>
						<input type="checkbox" id="Confirm" name="ConfirmDel" value="hello">
					</div>
					<div class="form-group">
						<input type="hidden" name="token" value="<?php echo Token::generate()?>">
						<button type="submit" class="btn btn-primary">Delete</button>
					</div>
				</form>
			</div>
			<div class="col-md-3">
				<?php include path.'assets/php/adminNav.php';?>
			</div>
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>