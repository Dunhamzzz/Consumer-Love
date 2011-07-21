<?php
class VotesController extends AppController {

	public $name = 'Votes';
	public $uses = array('Vote', 'Product');
	
	public $paginate = array('order' => 'Vote.modified');
	
	// Main vote action, all vars come from POST, need to shorten this.
	public function vote() {
		$error = array();
		
		//Check for user and valid auth_key
		if($this->Auth->user()) {
			if(User::get('key') == $this->params['form']['ak'] && is_numeric($this->params['form']['s'])) {
				
				// Check their votes
				$votesToday = $this->Vote->getTodaysVotesByUser($this->Auth->user('id'));
				// Check if hit limit & not voting opposite on a product
				if($votesToday[0] < $this->votesPerDay
					|| abs($votesToday[1][$this->params['form']['pid']]) > abs($this->params['form']['s'])) {
					$this->data['Vote']['user_id'] = User::get('id');
					//Check for valid product
					$this->Product->recursive = -1;
					$product = $this->Product->findById($this->params['form']['pid'], array('fields' => 'id'));
					
					if($product) {
						$this->data['Vote']['product_id'] = $product['Product']['id'];
						
						// Look for existing vote
						$existingVote = $this->Vote->find('first', array(
							'conditions' => array(
								'user_id' => $this->data['Vote']['user_id'],
								'product_id' => $this->data['Vote']['product_id'],
								'DATE(Vote.created)' => date('Y-m-d')
							),
							'fields' => array('Vote.*'),
							'recursive' => -1
						));
						
						if($existingVote) {
							$this->Vote->id = $existingVote['Vote']['id'];
							$remaining = $this->votesPerDay - $votesToday[0] + abs($existingVote['Vote']['score']);
						} else {
							$this->Vote->create();
							// Work out applied score from request + remaining.
							$remaining = $this->votesPerDay - $votesToday[0];
							
						}
						$score = $this->params['form']['s'] > $remaining ? $remaining : $this->params['form']['s'];
						
						if(strpos($this->params['form']['c'], 'love') !== false) {
							$this->data['Vote']['score'] = $score;
						} else {
							$this->data['Vote']['score'] = 0 - $score;
						}
						
						// Save it
						$this->Vote->save($this->data);
						$result = array(
							'remaining' => $remaining - $score
						);
					} else {
						$error['msg'] = 'An error occured';
					}
				} else {
					// Pick out the product
					if(array_key_exists($this->params['form']['pid'], $votesToday[1])) {
						$error['count'] = $votesToday[1][$this->params['form']['pid']];
					} else {
						$error['count'] = 0;
					}
					$error['msg'] = 'You have already used up all your votes today.';
					$error['type'] = 'limit';
				}
			} else {
				// Spoofed request (invalid user auth key)
				$error['msg'] = 'An error occured';
			}
		} else {
			// Not Logged in warning.
			$error['msg'] = 'You must be logged in to do that.';
		}
		
		if(!empty($error)) {
			$this->set(compact('error'));
		} else {
			$this->set(compact('result'));
		}
	}
	
	public function index() {
		$this->paginate = array(
			'conditions' => array(
				'Vote.user_id' => User::get('id')
			),
			'contain' => array(
				'Product' => array(
					'name', 'logo', 'slug'
				)
			),
			'limit' => 25,
			'order' => array('Vote.modified' => 'desc')
		);
		
		$votes = $this->paginate('Vote');
		
		$title_for_layout = 'Your Votes';
		$this->set(compact('votes', 'title_for_layout'));
	}
	
	public function delete($voteId) {
		// Check vote can be fiddled with
		$vote = $this->Vote->find('first', array(
			'conditions' => array(
				'Vote.id' => $voteId,
				'Vote.user_id' => User::get('id')
			),
			'fields' => array('Vote.created'),
			'recursive' => -1
		));
		
		// Check vote was made today and delete it if so.
		if(!empty($vote) && date('Ymd') == date('Ymd', strtotime($vote['Vote']['created']))) {
			$this->Vote->delete($voteId);
			$result = 1;
		} else {
			$result = 0;
		}
		
		if($this->isApiCall()) {
			$this->set(compact($result));
		} else {
			$this->Session->setFlash('Vote deleted.');
			$this->redirect($this->referer());
		}
	}
	
	public function admin_index() {
		$this->Vote->recursive = 0;
		$this->set('votes', $this->paginate());
	}

}