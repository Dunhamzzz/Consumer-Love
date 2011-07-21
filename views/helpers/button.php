<?php
class ButtonHelper extends AppHelper {
	
	public $helpers = array('Text', 'Html', 'Js');
	
	public function thread($productId) {
		return $this->Js->link('New Thread',
			array(
				'controller' => 'threads',
				'action' => 'create',
				$productId
			),
			array(
				'update' => '#threads',
				'class' => 'new-thread cta',
				'title' => 'Start a new thread'
			)
		);
	}
}