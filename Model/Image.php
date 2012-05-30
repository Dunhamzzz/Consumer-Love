<?php

/**
 * Image Model
 * @author Matthew Dunham <me@dunhamzzz.com> 
 */

class Image extends AppModel {
    
    public $belongsTo = array(
        'Product', 'User'
    );
    
    public $order = 'Image.created';
    
    public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'thumbnailQuality' => 100,
                'thumbsizes' => array(
                    '128x128' => '[128x128]',
                ),
                'thumbnailMethod' => 'php',
                'extensions' => array('.jpg', '.jpeg', '.png')
            )
        )
    );
}