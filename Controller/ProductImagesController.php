<?php

/**
 * Product Image gallery controller 
 */

class ProductImagesController extends AppController {
    
    public function beforeFilter() {
        
        $this->Auth->allow('index');
        parent::beforeFilter();
    }
    
    /**
     * Index action, displays a gallery of images associated to a product
     * @param string $productSlug 
     */
    public function index($productSlug = null) {
        
        $product = $this->ProductImage->Product->getBySlug($productSlug);
        
        if(!$product) {
            throw new NotFoundException(__('Invalid Product.'));
        }
        
        $this->set('product', $product);
        $this->set('title_for_layout', __('%s Image Gallery', $product['Product']['name']));
    }
    
    /**
     * Main upload function
     * @param string $productSlug 
     */
    public function upload($productSlug = null) {
        
        $product = $this->Product->findBySlug($productSlug);
        if(!$product) {
            throw new NotFoundException(__('Invalid Product.'));
        }
    }
    
    /**
     * Views a single image and details on it
     * @param type $imageId 
     */
    public function view($imageId) {
        
    }
    
}