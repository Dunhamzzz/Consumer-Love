<?php

/* Post Fixture generated on: 2011-09-06 22:35:33 : 1315348533 */

/**
 * PostFixture
 *
 */
class PostFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
    public $import = array('model' => 'Post');

    /**
     * Records
     *
     * @var array
     */
    public $records = array(
        array(
            'id' => 'post-1',
            'thread_id' => 'thread-1',
            'user_id' => 'user-1',
            'user_ip' => '80.7.15.114',
            'content' => 'Really can\'t!',
            'deleted' => 1,
            'created' => '2011-09-05 20:55:03',
            'modified' => '2011-09-05 20:55:03'
        ),
        array(
            'id' => 'post-2',
            'thread_id' => 'thread-1',
            'user_id' => 'user-2',
            'user_ip' => '80.7.15.114',
            'content' => 'Gimme an answer!',
            'deleted' => 1,
            'created' => '2011-09-05 21:00:29',
            'modified' => '2011-09-05 21:00:29'
        ),
        array(
            'id' => 'post-3',
            'thread_id' => 'thread-2',
            'user_id' => 'user-1',
            'user_ip' => '80.7.15.114',
            'content' => 'This is undeleted!',
            'deleted' => 0,
            'created' => '2011-09-06 20:00:17',
            'modified' => '2011-09-06 20:00:17'
        ),
        array(
            'id' => 'post-3.5',
            'thread_id' => 'thread-2',
            'user_id' => 'user-1',
            'user_ip' => '80.7.15.114',
            'content' => 'Alternatives? Don\'t be silly!',
            'deleted' => 1,
            'created' => '2011-09-06 20:22:17',
            'modified' => '2011-09-06 20:22:17'
        ),
        array(
            'id' => 'post-4',
            'thread_id' => 'thread-1',
            'user_id' => 'user-1',
            'user_ip' => '80.7.15.114',
            'content' => 'first 10 char',
            'deleted' => 1,
            'created' => '2012-09-06 20:05:48',
            'modified' => '2012-09-06 20:05:48'
        ),
        array(
            'id' => 'post-5',
            'thread_id' => 'thread-1',
            'user_id' => 'user-1',
            'user_ip' => '80.7.111.114',
            'content' => 'A reply of 10 charactrs',
            'deleted' => 1,
            'created' => '2012-09-06 20:07:48',
            'modified' => '2012-09-06 20:07:48'
        ),
        
        array(
            'id' => 'post-6',
            'thread_id' => 'thread-1',
            'user_id' => 'user-2',
            'user_ip' => '80.7.15.114',
            'content' => 'A bitchin\' reply to your reply!',
            'deleted' => 1,
            'created' => '2012-09-06 20:11:48',
            'modified' => '2012-09-06 20:11:48'
        ),
    );

}
