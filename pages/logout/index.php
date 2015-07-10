<?php
define('path', '../../');
require path.'inc/init.php';
$user = new User();
$user->logout();
Session::flash('complete', 'You have been logged out!');
Redirect::to(path.'index.php');
