<?php

class TweetsController extends AppController {
	public function index($twitter) {
		$tweets = $this->Tweet->find('all', array(
			'conditions' => array(
				'username' => $twitter
			)
		));
		
		pr($tweets);
	}
}