<?php
define('path', '');
$page = "install";
require path.'inc/init.php';
$start = new dbStarter();

if($start->begin){
  foreach($start->smessage as $message){
    echo $message.'<br/>';
  }
  echo 'You can delete this file!';
}else{
 foreach($start->emessage as $message){
  echo $pessage.'<br/>';
 }
 die();
}
