<?php

class InventoriesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function score() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Check user has product in inventory
        $inventory = $this->Inventory->has($this->request->data['Inventory']['product_id'], AuthComponent::user('id'));

        if (empty($inventory)) {
            throw new DomainException('You do not have this item in your inventory.');
        }

        // Grab Product
        $product = $this->Inventory->Product->find('first', array(
            'conditions' => array(
                'id' => $this->request->data['Inventory']['product_id']
            ),
            'contain' => false
                ));

        // Scoring up or down?
        if (stripos($this->request->data['score'], 'love') !== false) {
            $score = 'up';
            $message = 'Thanks for showing your love for ' . $product['Product']['name'] . '.';
        } else {
            $score = 'down';
            $message = 'Thanks for voicing your opinion on ' . $product['Product']['name'] . '.';
        }

        try {
            $status = $this->Inventory->score($inventory, $score);
        } catch (Exception $e) {
            $status = false;
            $message = $e;
        }

        if (!$this->request->is('ajax')) {
            $this->Session->setFlash($message);
            $this->redirect($this->referer());
        }

        $this->set(compact('status'));
    }

    public function remove($productId) {
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException();
        }
        $this->set('status', $this->Inventory->remove($productId, AuthComponent::user('id')));
    }

    public function toggle($productId) {
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException();
        }
        $status = $this->Inventory->toggle($productId, AuthComponent::user('id'));

        $this->set(compact('status'));
    }

}