<?php 
define('path', '../../');
$page = "post";
require path.'inc/init.php';
$user= new User();
$blog = new Blog();

if(Input::exists('get')){
	
}
?>
<html>
	<head>
		<?php include path.'assets/php/css.php';?>
	</head>
	<body>
		<?php include path.'assets/php/nav.php'?>
		<div class="container">
			<div class="col-md-9">
				<?php if(!Input::exists('get')){
					foreach ($blog->getPost() as $cat){
						echo '<div class="panel panel-primary">';
						echo '<div class="panel-heading">';
						echo '<h3 class="panel-title">'.$cat->title.' ~ '.$cat->name.' @ '.$cat->date.' By: '.$cat->author.'</h3>';						
						echo '</div>';
						echo '<div class="panel-body">';
						echo $cat->content;
						echo '</div>';
						echo '</div>';
					}
				}else{
					if(Input::get('c') != null){
						$c = Input::get('c');
					}else{
						$c = null;
					}
					if(Input::get('p') !=null){
					$p = Input::get('p');
					}else{
						$p = null;
					}
					foreach ($blog->getPost(input::get('p'), Input::get('c')) as $cat){
						echo '<div class="panel panel-primary">';
						echo '<div class="panel-heading">';
						echo '<h3 class="panel-title">'.$cat->title.' ~ '.$cat->name.' @ '.$cat->date.' By: '.$cat->author.'</h3>';
						echo '</div>';
						echo '<div class="panel-body">';
						echo $cat->content;
						echo '</div>';
						echo '</div>';
					}
				}
				?>
			</div>
			<div class="col-md-3">
				<div class="well">
					<h3>Categories</h3>
					<ul class="nav nav-list">
						<li><a href="index.php">All</a></li>
						<?php foreach ($blog->getCat() as $cat){
							echo '<li><a href="?c='.$cat->id.'">'.$cat->name.'</a></li>';
						}?>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>