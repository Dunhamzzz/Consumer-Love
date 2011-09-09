<?php
class PostsController extends AppController {
	
	public $components = array('Recaptcha.Recaptcha');
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function reply() {
		if($this->request->is('post')) {
			$thread = $this->Post->Thread->find('first', array(
				'conditions' => array('Thread.id' => $this->request->data['Post']['thread_id']),
				'contain' => array('Product')
			));
			
			if(empty($thread)) {
				throw new NotFoundException(__('Invalid Thread'));
			}
				
			$save = false;
			$this->Post->set($this->request->data);
			if($this->request->is('post') && $this->Post->validates()) {
				$save = true;
			}
			
			// Check if we want a user to do a captcha
			if(AuthComponent::user('human_proven_count') < Configure::read('ProvenHuman')) {
				if(!empty($this->request->data)) {
					if($this->Recaptcha->verify() && $save) {
						$this->User->increaseHumanProven();
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
				
				if($postId = $this->Post->savePost($this->request->data)) {
					
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
			
		} else {
			throw new DomainException();
		}
		
		$title_for_layout = 'Reply To Thread';
		
		$this->set(compact('thread', 'title_for_layout'));
	}
	
	public function edit($postId) {
		$post = $this->Post->find('first', array(
			'conditions' => array(
				'Post.id' => $postId,
				'Post.user_id' => AuthComponent::user('id')
			),
			'contain' => false
		));
		
		if(empty($post)) {
			throw new NotFoundExcpetion(__('Invalid Post'));
		}
		
		$thread = $this->Post->Thread->findById($post['Post']['thread_id']);
		
		// Save
		if ($this->request->is('post')) {
			$this->Post->id = $id;
		
			if ($this->Post->savePost($this->request->data)) {
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

		$title_for_layout = __('Edit Your Post');
		$this->set(compact('title_for_layout', 'post', 'thread'));
	}
}