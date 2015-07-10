<?php
define('path' , '');
$page = "home";
require path.'inc/init.php';
$user = new User();
$blog = new Blog();
?>
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php';?>
		<div class="container">
		<?php
			if(Session::exists('complete')){
				echo '<div class="alert alert-success">'; 
				echo Session::flash('complete');
				echo '</div>';
			}
			if(Session::exists('error')){
				echo '<div class="alert alert-danger">';
				echo Session::flash('error');
				echo '</div>';
			}
		?>
			<div class="jumbotron">
				<h1>Hello!</h1>
				<?php if(!$user->isLoggedIn()){echo'<h3>Please come and stay for an while</h3>';}else{echo 'Welcome back '.$user->data()->name;}?>
			</div>
			<div class="col-md-9">
				<?php
					$i=0;
					foreach ($blog->getPost() as $cat){
						if($i<=4){
						echo '<div class="panel panel-primary">';
							echo '<div class="panel-heading">';
								echo '<h3 class="panel-title">'.$cat->title.' ~ '.$cat->name.' @ '.$cat->date.' By: '.$cat->author.'</h3>';
							echo '</div>';
							echo '<div class="panel-body">';
								echo $cat->content;
							echo '</div>';
						echo '</div>';
						}
						$i++;
					}
				?>
			</div>
			<div class="col-md-3">
			<?php
				if($user->isLoggedIn() && $user->hasPermission('Admin')){?>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">AdminCP Quick Panel</h3>
						</div>
						<div class="panel-body">
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPost">
 								Add Post
							</button>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCat">
 								Add Cat
							</button>
							
							<div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Add Post</h4>
							      </div>
							      <div class="modal-body">
							        <form method="post" action="pages/user/admin/addPost.php">
							        	<div class="form-group">
							        		<textarea class="form-control" name="title" rows="1" cols="255" placeholder="title"></textarea>
							        	</div>
							        	<div class="form-group">
							        		<textarea class="form-control" name="content" rows="12" cols="255" placeholder="Content"></textarea>
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
							        	<input type="hidden" name="token" value="<?php echo Token::generate()?>">
							        	<div class="form-group">
							      			<button type="reset" class="btn btn-default">Reset</button>
							       			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							        		<button type="submit" class="btn btn-primary">Save changes</button>
							        	</div>
							        </form>
							      </div>
							    </div>
							  </div>
							</div>
							
							<div class="modal fade" id="addCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Add Cat</h4>
							      </div>
							      <div class="modal-body">
							        <form method="post" action="pages/user/admin/addCat.php">
							        	<div class="form-group">
							        		<input name="name" placeholder="Cat Name" class="form-control" type="text">
							        	</div>
							        	<input type="hidden" name="token" value="<?php echo Token::generate()?>">
							        	<div class="form-group">
							      			<button type="reset" class="btn btn-default">Reset</button>
							       			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							        		<button type="submit" class="btn btn-primary">Save changes</button>
							        	</div>
							        </form>
							      </div>
							    </div>
							  </div>
							</div>
						</div>
					</div>
			<?php
				}
			?>
			</div>
		</div>

		<?php include path.'assets/php/js.php';?>
	</body>
</html>