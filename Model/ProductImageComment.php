<?php

class ProductImageComment extends AppModel {
    
    public $belongsTo = array('ProductImage', 'User');
    
}