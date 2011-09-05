<?php
class PostsController extends AppController {
	
	public $components = array('Recaptcha.Recaptcha');
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function reply($threadId) {
		$thread = $this->Post->Thread->getSlugsById($threadId);
		if(empty($thread)) {
			$this->cakeError('error404');
		}
		
		$save = false;
		$this->Post->set($this->request->data);
		if(!empty($this->request->data) && $this->Post->validates()) {
			$save = true;
		}
		
		// Check if we want a user to do a captcha
		if(User::get('human_proven_count') < Configure::read('ProvenHuman')) {
			if(!empty($this->request->data)) {
				if($this->Recaptcha->verify() && $save) {
					$this->Auth->getModel()->increaseHumanProven();
				} else {
					$save = false;
					$this->set('recaptchaInvalid', true);
				}
			}
			
			$this->set('requireCaptcha', true);
		}
		
		if($save) {
			$this->request->data['Post']['user_id'] = $this->userData['id'];
			$this->request->data['Post']['user_ip'] = $this->RequestHandler->getClientIp();
			
			
			if($postId = $this->Post->addPost($this->request->data)) {
				// Redirect to thread and post
				$this->redirect(array(
					'controller' => 'threads',
					'action' => 'view',
					'threadSlug' => $thread['Thread']['slug'],
					'productSlug' => $thread['Product']['slug'],
					'#' => 'post-'.$postId
				));
			}
		}
		
		$title_for_layout = 'Reply To Thread';
		
		$this->set(compact('thread', 'title_for_layout'));
	}
	
	public function edit($postId) {
		$post = $this->Post->findById($postId);
		if(empty($post)) {
			$this->cakeError('error404');
		}
		
		// Save
		if (!empty($this->request->data)) {
			$this->Post->id = $id;
		
			if ($this->Post->save($this->request->data, true, array('content'))) {
				$thread = $this->Post->Thread->getSlugsById($post['Thread']['id']);
				
				$this->redirect(array(
					'controller' => 'threads',
					'action' => 'view',
					'threadSlug' => $thread['Thread']['slug'],
					'productSlug' => $thread['Product']['slug'],
					'#' => 'post-'.$postId
				));
			}
		} else {
			$this->request->data = $post;
		}

		
		$title_for_layout = 'Edit Post';
		$this->set(compact('title_for_layout', 'post'));
	}
}