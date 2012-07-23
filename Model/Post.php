<?php

class Post extends AppModel {

    public $belongsTo = array(
        'Thread' => array('counterCache' => true),
        'Author' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'counterCache' => true
        )
    );
    public $hasMany = array(
       /* 'Report' => array(
            'foreignKey' => 'foreign_key',
            'conditions' => array(
                'Report.model' => 'post'
            )
        ) */
    );
    public $validate = array(
        'content' => array(
            'rule' => array('minLength', 10),
            'message' => 'Your post must have a minimum of 10 characters.'
        )
    );

    public function afterSave($created) {

        // Update Product post count for most popular products forums
        if($created) {
            $this->Thread->Product->updateForumData($this->data);
        }
    }

    public function addFirst($threadId, $data) {

        $post = array(
            'thread_id' => $threadId,
            'user_id' => $data['user_id'],
            'user_ip' => $data['user_ip'],
            'content' => $data['content'],
            'published' => 1
        );

        $this->create();
        $this->save($post, false, array_keys($post));

        return $this->id;
    }

    public function savePost($data) {
        $this->set($data);

        if ($this->validates()) {

            // If being created
            if (empty($data['Post']['id'])) {
                $data['Post']['published'] = 1;
            }

            $this->save($data, false, array('thread_id', 'user_id', 'user_ip', 'content', 'published'));

            if (empty($data['Post']['id'])) {
                // Set latest post info in thread
                $this->Thread->id = $data['Post']['thread_id'];
                $this->Thread->set(array(
                    'last_post_id' => $this->id,
                    'last_user_id' => $data['Post']['user_id']
                ));
                $this->Thread->save();
            }

            return $this->id;
        }

        return false;
    }

    /**
     * Get latest posts globally
     * @param int $limit
     */
    public function getLatest($limit = 5, $userId = null) {
        
        if(!(int) $limit) {
            throw new DomainException('Invalid value passed for limit.');
        }
        
        $conditions = array('Post.published' => 1);
        
        if($userId) {
            $conditions['Post.user_id'] = $userId;
        }
        
        return $this->find('all', array(
            'conditions' => $conditions, 
            'contain' => array('Author', 'Thread' => array('Product' => array('slug'))),
            'order' => 'Post.created DESC',
            'limit' => $limit
        ));
    }

}