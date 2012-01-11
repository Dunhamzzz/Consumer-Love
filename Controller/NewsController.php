<?php

class NewsController extends AppController {

    public function beforeFilter() {

        $this->Auth->allow('view');

        parent::beforeFilter();
    }
    
    public function index($productSlug) {
        $product = $this->News->Product->getBySlug($productSlug);

        if (!$product) {
            throw new NotFoundException(__('Invalid Product'));
        }
    }

    public function view($slug) {

        $news = $this->News->find('first', array(
            'conditions' => array(
                'News.slug' => $slug,
                'News.deleted' => 0,
                'News.published' => 1
            ),
            'contain' => array(
                'User' => array('username', 'slug')
            )
                ));

        if (!$news) {
            throw new NotFoundException('Invalid News Item');
        }

        $this->set('news', $news);

        // Get product
        $this->set('product', $this->News->Product->getById($news['News']['product_id']));

        $this->set('title_for_layout', $news['News']['title']);
    }

    public function submit($productSlug) {
        $product = $this->News->Product->getBySlug($productSlug);

        if (!$product) {
            throw new NotFoundException(__('Invalid Product'));
        }

        if ($this->request->is('post')) {

            $this->request->data['News']['product_id'] = $product['Product']['id'];

            try {
                $news = $this->News->submit($this->request->data, AuthComponent::user('id'));
            } catch (Exception $e) {
                $this->setFlash($e->getMessage);
            }

            if ($news !== false) {
                $this->Session->setFlash(__('Thanks for submiting your %s news.', htmlspecialchars($product['Product']['name'])));
                $this->redirect(array('controller' => 'news', 'action' => 'index', 'productSlug' => $productSlug));
            }
        }

        $this->set('title_for_layout', __('Submit %s News', $product['Product']['name']));
        $this->set('product', $product);
    }

}