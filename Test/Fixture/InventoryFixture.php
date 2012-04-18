<?php

class InventoryFixture extends CakeTestFixture {

    public $import = array('model' => 'Inventory');
    public $records = array(
        array(
            'id' => 'inventory-1',
            'product_id' => 'product-1',
            'user_id' => 'user-1',
            'private' => 0,
            'feed' => 1,
            'score' => 0,
            'score_date' => '0000-00-00',
            'deleted' => 0,
            'created' => '2011-09-29 12:50:21'
        ),
        array(
            'id' => 'inventory-2',
            'product_id' => 'product-2',
            'user_id' => 'user-1',
            'private' => 0,
            'feed' => 1,
            'score' => 0,
            'score_date' => '0000-00-00',
            'deleted' => 0,
            'created' => '2011-09-29 13:50:21'
        ),
        array(
            'id' => 'inventory-3',
            'product_id' => 'product-1',
            'user_id' => 'user-2',
            'private' => 0,
            'feed' => 1,
            'score' => 1,
            'score_date' => '2011-09-29',
            'deleted' => 0,
            'created' => '2011-09-29 14:50:21'
        )
    );

}
