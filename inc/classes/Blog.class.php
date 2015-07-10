<?php
class Blog{
	private $_db;
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	public function addPost($title, $content, $cat, $user){
		if(!$this->_db->insert('posts', array(
				'title'=>$title, 
				'content'=>$content, 
				'cat_id'=>$cat, 
				'date'=>date('Y-m-d- H:i:s') ))){
			throw new Exception('There was an error making the new post!');
		}
	}
	public function editPost($id, $title, $content, $cat){
		if($this->_db->update('posts', $id, array('title'=> $title, 'content' => $content, 'cat_id'=> $cat))){
			throw new Exception('There was an error editing the fields');
		}
	}
	public function deletePost($id){
		$this->_db->delete('posts', array('id', '=', $id));
	}
	public function deleteCat($id){
		$this->_db->delete('cat', array('id', '=', $id));
	}
	public function getPost($id = null, $cat = null) {
		if($id == null && $cat != null){
			$q = $this->_db->query("SELECT `posts`.`id` AS `post_id`, `cat`.`id` AS `cat_id`, `title`, `content`, `author` ,`date`,`cat`.`name` FROM `posts` INNER JOIN `cat` ON `cat`.`id`= `posts`.`cat_id` WHERE `cat_id` = {$cat} ORDER BY `post_id` DESC")->results();
		} else if($id== null&& $cat == null){
			$q = $this->_db->query("SELECT `posts`.`id` AS `post_id`, `cat`.`id` AS `cat_id`, `title`, `content`, `author` ,`date`,`cat`.`name` FROM `posts` INNER JOIN `cat` ON `cat`.`id`= `posts`.`cat_id` ORDER BY `post_id` DESC")->results();
		}else if($id !=null && $cat == null){ // Leave null at the moment for futher processing...
			//$q = $this->_db->query("SELECT `posts`.`id` AS `post_id`, `cat`.`id` AS `cat_id`, `title`, `content`, `date`,`cat`.`name` FROM `posts` INNER JOIN `cat` ON `cat`.`id`= `posts`.`cat_id` ORDER BY `post_id` DESC")->results();
		}else if($id !=null && $cat !=null){
			$q = $this->_db->query("SELECT `posts`.`id` AS `post_id`, `cat`.`id` AS `cat_id`, `title`, `content`, `author` , `date`,`cat`.`name` FROM `posts` INNER JOIN `cat` ON `cat`.`id`= `posts`.`cat_id` WHERE `post_id` = {$id} AND `cat_id` = {$cat} ORDER BY `post_id` DESC")->results();
		}
		return $q;
	}
	public function addCat($name){
		if(!$this->_db->insert('cat', array('name'=> $name))){
			throw new Exception('There was an error adding a new category!');
		}
	}
	public function getCat($id= null){
		$q = ($id ==null)? $this->_db->query('SELECT * FROM cat') : $this->_db->get('cat', array('id', '=', $id));
		return $q->results();
	}
}