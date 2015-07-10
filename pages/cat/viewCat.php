<?php
define('path', '../../');
require path.'inc/init.php';
if(Input::exists('get')){
	if(Input::get('c') == null){
		Session::flash('error', 'There is no cat in here');
		Redirect::to(path.'index.php');
	}
	
	
}
?>