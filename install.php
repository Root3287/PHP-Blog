<?php
define('path', '');
$page = "install";
require path.'inc/init.php';
$start = new dbStarter();

if(!$start->startTables()->hasError()){
  foreach($start->getMessage as $message){
    echo $message.'<br/>';
  }
  echo 'You can delete this file!';
}else{
 foreach($start->getError() as $message){
  echo $pessage.'<br/>';
 }
 die();
}
