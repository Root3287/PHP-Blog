<?php
define('path', '../../../');
require path.'inc/init.php';
$page = "admin";
$user = new User();
$blog = new Blog();

if($user->hasPermission('create')){
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$val = new Validation();
			$val->check($_POST, array(
				'title' => array(
					'max' => 255,
					'required' => true,
					'unique' => 'posts',
				),
				'content' => array(
						'required' => true
				),
				'cat' => array(
						'required' => true
				)
			));
			
			if($val->passed()){
				try{
					$blog->addPost(escape(Input::get('title')), escape(Input::get('content')), escape(Input::get('cat')));
					session::flash('complete', 'You have added a post!');
					Redirect::to(path.'index.php');
				}catch (Exception $e){
					die($e->getMessage());
				}
			}else{
				foreach ($val->errors() as $e){
					echo $e.'<br/>';
				}
			}
		}
	}
}
?>
<html>
	<head><?php include path.'assets/php/css.php';?></head>
	<body>
		<?php include path.'assets/php/nav.php'?>
		<div class="container">
			<div class="col-md-9">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<form action="" method="post">
							
							<div class="form-group">
								<textarea class="form-control" rows="1" cols="255" id="title" name="title" placeholder="Title"><?php echo escape(Input::get('title'))?></textarea>
							</div>
							<div class="form-group">
								<textarea class="form-control" rows="25" cols="255" id="content" name="content" placeholder="content"><?php echo escape(Input::get('content'))?></textarea>
							</div>
							<div class="form-group">
								<select class="form-control" name="cat" id="cat">
									<option value="<?php echo null;?>" id='cat'>Category</option>
									<?php 
										foreach ($blog->getCat() as $cat){
											echo "<option name='cat' id='cat' value='{$cat->id}'>{$cat->name}</option>";
										}
									?>
								</select>
							</div>
							
							<input type="hidden" value="<?php echo Token::generate(); ?>" name="token"/>
							<div class="form-group">
								<button class="btn btn-default" type="reset">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3">
			<?php include path.'assets/php/adminNav.php';?>
			</div>
		</div>
		<?php include path.'assets/php/js.php';?>
	</body>
</html>