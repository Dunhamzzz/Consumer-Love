<?php

class ReviewsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    // Ajax action to return the form
    public function form($productId) {
        $this->set(compact('productId'));
    }

}