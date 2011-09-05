<?php
class InventoriesController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function toggle($productId) {
		$status = $this->Inventory->toggle($productId, $this->userData['id']);
		if(!$this->request->is('ajax')) {
			if($status < 0) {
				$this->Session->setFlash('An Error occured processing your request.');
			}
			$this->redirect($this->referer());
		}
		$this->set(compact('status'));
	}
	
}