<?php

class LinkHelper extends AppHelper {

    public $helpers = array('Html', 'Text');

    // Link to a users inventory
    public function inventory($user, $anchorText, $htmlAttrs = array()) {
        $user = $this->extractRow('User', $user);

        return $this->Html->link(
                        $anchorText, array('controller' => 'users', 'action' => 'inventory', 'userSlug' => $user['slug']), $htmlAttrs
        );
    }

    // Returns a link to a new item
    public function news($news, $anchorText = false, $htmlAttrs = array()) {
        $news = $this->extractRow('News', $news);

        $anchorText = $anchorText ? : $news['title'];

        return $this->Html->link(
                        $anchorText, array(
                    'controller' => 'news',
                    'action' => 'view',
                    'admin' => false,
                    'newsSlug' => $news['slug']
                        )
        );
    }

    // Returns a link to a product
    public function product($product, $anchorText = false, $htmlAttrs = array()) {
        $product = $this->extractRow('Product', $product);
        $anchorText = $anchorText ? : $product['name'];

        return $this->Html->link(
                        $anchorText, array(
                    'controller' => 'products',
                    'action' => 'view',
                    'admin' => false,
                    'productSlug' => $product['slug']
                        ), $htmlAttrs
        );
    }

    // Returns a link to a profile
    public function user($user, $anchorText = false, $htmlAttrs = array()) {
        $user = $this->extractRow('User', $user);

        $anchorText = $anchorText ? : $user['username'];
        return $this->Html->link($anchorText, array(
                    'controller' => 'users',
                    'action' => 'view',
                    'admin' => false,
                    'userSlug' => $user['slug']
                        ), $htmlAttrs
        );
    }

    // Links to a forum
    public function forum($productSlug, $anchorText = 'Forum', $htmlAttrs = array()) {
        if (is_array($productSlug)) {
            $product = $this->extractRow('Product', $productSlug);
            $productSlug = $product['slug'];
        }

        return $this->Html->link($anchorText, array(
                    'controller' => 'threads',
                    'action' => 'all',
                    'productSlug' => $productSlug
                        ), $htmlAttrs
        );
    }

    public function category($category, $anchorText = false, $htmlAttrs = array()) {
        $category = $this->extractRow('Category', $category);
        $anchorText = $anchorText ? : $category['name'];

        return $this->Html->link($anchorText, array(
                    'controller' => 'categories',
                    'action' => 'view',
                    'slug' => $category['slug']
                        ), $htmlAttrs
        );
    }

    // To a Thread
    public function thread($thread, $htmlAttrs = array()) {
        return $this->Html->link($thread['Thread']['title'], array(
                    'controller' => 'threads',
                    'action' => 'view',
                    'threadSlug' => $thread['Thread']['slug'],
                    'productSlug' => $thread['Product']['slug']
                        ), $htmlAttrs);
    }

    // A button to a new thread
    public function newThread($productId) {
        return $this->Html->link('New Thread', array(
                    'controller' => 'threads', 'action' => 'create', $productId
                        ), array(
                    'class' => 'show-thread-form cta'
                ));
    }

}