<?php
$post = new Post();
$user = new User();
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$val = new Validation();
		$validate = $val->check($_POST, [
			'post'=>[
				'required'=> true,
			],
			'original_post'=>[
				'required'=> true,
			],
		]);
		if($validate->passed()){
			try{
				$post->createComment([
					'content' => escape(Input::get('post')),
					'original_post' => escape(Input::get('original_post')),
					'user_id'=> escape($user->data()->id),
				]);
				echo(json_encode(['success'=>true]));
			}catch(Exception $e){
				echo(json_encode(['success'=>false]));
			}
		}
	}
}