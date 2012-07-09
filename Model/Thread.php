<?php

class Thread extends AppModel {

    public $belongsTo = array(
        'Product' => array('counterCache' => true),
        'User',
        'FirstPost' => array(
            'className' => 'Post',
            'foreignKey' => 'first_post_id'
        ),
        'LastPost' => array(
            'className' => 'Post',
            'foreignKey' => 'last_post_id'
        )
    );
    public $hasMany = array('Post');
    public $actsAs = array(
        'Utils.Sluggable' => array(
            'label' => 'title',
            'method' => 'multibyteSlug',
            'separator' => '-',
            'slug' => 'slug',
            'length' => 150
        )
    );
    
    public $validate = array(
        
        'title' => array(
            'rule' => 'notEmpty',
            'required' => 'create',
            'message' => 'Please enter a thread title.'
        ),
        
        'content' => array(
            'rule' => 'notEmpty',
            'required' => 'create',
            'message' => 'Please enter some post content.'
        ),
        
        'product_id' => array(
            'rule' => 'uuid',
            'allowEmpty' => false,
            'required' => true
        ),
        
        'user_id' => array(
            'rule' => 'uuid',
            'allowEmpty' => false,
            'required' => true
        )
        
    );

    public function add($data) {
        $this->set($data);

        if ($this->validates()) {
            
            // @todo Spam Check 
            $data['Thread']['published'] = 1;

            $this->create();
            $this->save($data, false, array('product_id', 'user_id', 'title', 'published', 'user_ip'));

            $threadId = $this->id;
            $userId = $data['Thread']['user_id'];
            $postId = $this->Post->addFirst($threadId, $data['Thread']);

            // Now update last post IDs etc
            $this->set(array(
                'first_post_id' => $postId,
                'last_post_id' => $postId,
                'last_user_id' => $userId
            ));

            $this->save();

            return $threadId;
        } else {
            return false;
        }
    }

    /**
     * Searchs for a thread by slug, Optionally accepts product ID to refine the find
     * @param string $slug
     * @param string $productId
     * @return mixed
     */
    public function getBySlug($slug = null, $productId = null) {
        
        $conditions = array('Thread.slug' => $slug);

        if (!is_null($productId)) {
            $conditions['Thread.product_id'] = $productId;
        }

        return $this->find('first', array(
                    'conditions' => $conditions,
                    'contain' => array(
                        'Product', 'User', 'FirstPost'
                    )
                ));
    }

    public function getForReply($threadId) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Thread.id' => $threadId
                    ),
                    'contain' => array(
                        'Product'
                    )
                ));
    }

}