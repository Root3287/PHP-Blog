<?php
define('path', '../../../');
require path.'inc/init.php';
$user = new User();$blog = new Blog();
if(!$user->hasPermission('Admin')){
	Session::flash('error', 'You must have delete to proform that!');
	Redirect::to(path.'index.php');
}
if(Input::exists('get')){
	if (Input::get('c') ==null){
		session::flash('error', 'You have to have the id of the cat you want to delete!');
		Redirect::to(path.'index.php');
	}else{
		$c = escape(Input::get('c'));	
	}
	if(!$blog->getCat($c)){
		Session::flash('error', 'The cat has to be valid!');
		Redirect::to(path.'index.php');
	}
	$oldCat = $blog->getCat($c);
	
	$blog->deleteCat(Input::get('c'));
	session::flash('complete', 'You have deleted the cat '.$c->name);
	Redirect::to(path.'index.php');
}
