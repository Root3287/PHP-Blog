<?php
define('path', '../../');
require path.'inc/init.php';
$user = new User();
$user->logout();
Redirect::to(path.'index.php');
