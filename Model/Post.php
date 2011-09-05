<?php
class Post extends AppModel {

	public $belongsTo = array(
		'Thread' => array('counterCache' => true),
		'Author' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'counterCache' => true
		)
	);
	
	public $hasMany = array(
		'Report' => array(
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'Report.model' => 'post'
			)
		)
	);
	
	public $validate = array(
		'content' => array(
			'rule' => array('minLength', 10),
			'message' => 'Your post must have a minimum of 10 characters.'
		)
	);
	
	public function addFirstPost($threadId, $data) {
		
		$post = array(
			'thread_id' => $threadId,
			'user_id' => $data['user_id'],
			'user_ip' => $data['user_ip'],
			'content' => $data['content']
		);
		
		$this->create();
		$this->save($post, false, array_keys($post));
		
		return $this->id;
	}
	
	public function addPost($data) {
		$this->set($data);
		
		if($this->validates()) {
			
			$this->create();
			$this->save($data, false, array('thread_id', 'user_id', 'user_ip', 'content'));
			
			$postId = $this->id;
			
			// Set latest post info in thread
			$this->Thread->id = $data['Post']['thread_id'];
			$this->Thread->set(array(
				'last_post_id' => $postId,
				'last_user_id' => $data['Post']['user_id']
			));
			$this->Thread->save();
			
			return $postId;
			
		}
		
		return false;
	}
}