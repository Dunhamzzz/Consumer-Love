<?php

class Thread extends AppModel {

    public $belongsTo = array(
        'Product' => array('counterCache' => true),
        'User',
        'FirstPost' => array(
            'className' => 'Post',
            'foreignKey' => 'first_post_id'
        ),
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

    public $order = 'Thread.last_post_date DESC';

    public function afterDelete() {

        $this->Post->deleteAll(array('thread_id' => $this->id));
    }

    /**
     * Saves a thread, returns the thread slug for redirecting to it;
     * @param type $data
     * @return boolean
     */
    public function add($data) {
        $this->set($data);

        if ($this->validates()) {

            // @todo Spam Check

            $this->create();
            $this->save($data, false, array('product_id', 'user_id', 'title', 'user_ip'));

            $userId = $data['Thread']['user_id'];
            $postId = $this->Post->addFirst($this->id, $data['Thread']);

            // Now update last post IDs etc
            $this->read(); // Need to load the record into the ORM first
            $this->set(array(
                'first_post_id' => $postId,
                'last_post_id' => $postId,
                'last_user_id' => $userId,
                'last_post_date' => date('Y-m-d H:i:s')
            ));

            $this->save();

            return $this->field('slug');
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

        $conditions['Thread.deleted'] = 0;

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

    /**
     * Updates a thread meta data
     * @param array $post Post data from $this->data
     */
    public function updateThreadData($post) {

        $this->read(null, $post['Post']['thread_id']);
        $this->save(array(
            'last_post_id' => $post['Post']['id'],
            'last_post_date' => date('Y-m-d H:i:s'),
            'last_post_user' => $post['Post']['user_id']
        ));
    }

    /**
     * Gets latest threads
     * @param type $productId
     * @return array Array of latest threads
     */
    public function getLatestByProductId($productId = null, $limit = 5) {

        if(!$productId) {
            return array();
        }

        return $this->find('all', array(
            'conditions' => array(
                'product_id' => $productId
            ),
            'contain' => array(
                'Post', 'FirstPost', 'User'
            ),
            'limit' => $limit
        ));
    }

}