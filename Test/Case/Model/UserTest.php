<?php

App::uses('User', 'Model');

class UserTestCase extends CakeTestCase
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

        $this->User = ClassRegistry::init('User');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->User);
        ClassRegistry::flush();

        parent::tearDown();
    }

    /**
     * @covers User::checkUsernameAvailability
     */
    public function testCheckUsernameAvailability_uniqueName_expectsTrue() {
        $this->assertTrue($this->User->checkUsernameAvailability('aUniqueUserName'));
    }

    /**
     * @covers User::checkUsernameAvailability
     */
    public function testCheckUsernameAvailability_dupeName_expectsFalse() {
        $this->assertFalse($this->User->checkUsernameAvailability('user-1'));
    }
}