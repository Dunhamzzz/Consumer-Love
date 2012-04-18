<?php

App::uses('Inventory', 'Model');

class InventoryTestCase extends CakeTestCase {

    public $fixtures = array('app.product', 'app.inventory', 'app.user');

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Inventory = ClassRegistry::init('Inventory');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Inventory);
        ClassRegistry::flush();

        parent::tearDown();
    }

    public function testScore() {
        $inventory = $this->Inventory->read(null, 'inventory-1');

        // Test Scoring Up
        $this->Inventory->score($inventory, 'up');

        $inventory = $this->Inventory->read(null, 'inventory-1');



        $this->assertEquals((int) 1, $inventory['Inventory']['score']);
        $this->assertEquals(date('Y-m-d'), $inventory['Inventory']['score_date']);


        // Test Scoring Down
        $this->Inventory->score($inventory, 'down');
        $inventory = $this->Inventory->read(null, 'inventory-1');

        $this->assertEquals((int) -1, $inventory['Inventory']['score']);
        $this->assertEquals(date('Y-m-d'), $inventory['Inventory']['score_date']);
    }

}

