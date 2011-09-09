<?php
class InventoriesController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function toggle($productId = null) {
		$status = $this->Inventory->toggle($productId, $this->userData['id']);
		if(!$this->request->is('ajax')) {
			$this->redirect($this->referer());
		}
		$this->set(compact('status'));
	}
}