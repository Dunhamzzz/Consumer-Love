<?php

App::uses('Inventory', 'Model');

class InventoryTestCase extends CakeTestCase
{

    public $fixtures = array('app.product', 'app.inventory', 'app.user');

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Inventory = ClassRegistry::init('Inventory');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inventory);
        ClassRegistry::flush();

        parent::tearDown();
    }

    /**
     * @covers Inventory::score()
     */
    public function testScore_voteUp_expectsTrue()
    {

        // Test Scoring Up
        $score = $this->Inventory->score($this->Inventory->read(null,
                        'inventory-1'), 'up');

        $inventory = $this->Inventory->read(null, 'inventory-1');

        $this->assertTrue($score);
        $this->assertEquals((int) 1, $inventory['Inventory']['score']);
        $this->assertEquals(date('Y-m-d'), $inventory['Inventory']['score_date']);
    }

    /**
     * @covers Inventory::score()
     */
    public function testScore_voteDown_expectsTrue()
    {
        // Test Scoring Down
        $score = $this->Inventory->score($this->Inventory->read(null,
                        'inventory-1'), 'down');
        $inventory = $this->Inventory->read(null, 'inventory-1');

        $this->assertTrue($score);
        $this->assertEquals((int) -1, $inventory['Inventory']['score']);
        $this->assertEquals(date('Y-m-d'), $inventory['Inventory']['score_date']);
    }

    /**
     * @covers Inventory::score()
     * @expectedException DomainException
     * @expectedExceptionMessage Invalid inventory item passed to Inventory::score()
     */
    public function testScore_invalidInventory_expectsException() {
        $this->Inventory->score(array(), 'up');
    }

    /**
     * @covers Inventory::score()
     * @expectedException DomainException
     * @expectedExceptionMessage Invalid vote passed to Inventory::score()
     */
    public function testScore_invalidVote_expectsException() {
        $inventory = $this->Inventory->read(null, 'inventory-1');
        $this->Inventory->score($inventory, 'invalid-value');
    }
}

