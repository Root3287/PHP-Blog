<?php
class dbStarter{
  private $_db, $_smessage, $_emessage, $_error = true;
  
  public function __construct(){
    $this->_db = DB::getInstance();
  }
  
  public function startTables(){
    $this->_error = false;
    $tables = array(
      'CREATE TABLE `cat` (`id` INT(11) NOT NULL AUTO_INCREMENT,`name` TINYTEXT NOT NULL,PRIMARY KEY (`id`)) COLLATE=`latin1_swedish_ci` ENGINE=InnoDB',
      'CREATE TABLE `groups` (`id` INT(11) NOT NULL AUTO_INCREMENT,`group_name` TEXT NOT NULL,`permissions` TEXT NOT NULL,PRIMARY KEY (`id`)) COLLATE=`latin1_swedish_ci` ENGINE=InnoDB',
      'CREATE TABLE `posts` (`id` INT(11) NOT NULL AUTO_INCREMENT,`cat_id` INT(11) NOT NULL,`title` VARCHAR(255) NOT NULL,`content` LONGTEXT NOT NULL,`author` TEXT NOT NULL,`date` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\',PRIMARY KEY (`id`)) COLLATE=`latin1_swedish_ci` ENGINE=InnoDB',
      'CREATE TABLE `users` (`id` INT(11) NOT NULL AUTO_INCREMENT,`username` VARCHAR(50) NOT NULL,`password` LONGTEXT NOT NULL,`salt` LONGTEXT NOT NULL, `name` VARCHAR(50) NOT NULL, `group` INT(11) NOT NULL, `joined` DATETIME NOT NULL, PRIMARY KEY (`id`)) COLLATE=`latin1_swedish_ci` ENGINE=InnoDB',
      'CREATE TABLE `user_session` (`id` INT(11) NOT NULL AUTO_INCREMENT, `user_id` INT(11) NOT NULL, `hash` LONGTEXT NOT NULL, PRIMARY KEY (`id`)) COLLATE=`latin1_swedish_ci` ENGINE=InnoDB',
    );
    $i = 0;
    foreach($tables as $table){
      $q = $this->_db->query($table)->count();
      if(!$q){
        $this->addMessage('Table index '.$i.' has been added');
      }else{
        $this->addError('There was an error while adding table at index '.$i);
     }
      $i++;
    }
    
    if(!empty($this->_emessage)){
      $this->_error = true;
    }
    
    return $this;
  }
  
  private function addError($string = ''){
    $this->_emessage[] = $string;
  }
  private function addMessage($string = ''){
    $this->_smessage[] = $string;
  }
  public function getError(){
    return $this->_emessage;
  }
  public function getMessage(){
    return $this->_smessage;
  }
  public function hasError(){
    return ($this->_error)? true:false;
  }
}
