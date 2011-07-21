<?php
/* Votes Test cases generated on: 2011-02-08 19:55:23 : 1297194923*/
App::import('Controller', 'Votes');

class TestVotesController extends VotesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class VotesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.vote', 'app.user', 'app.product', 'app.category');

	function startTest() {
		$this->Votes =& new TestVotesController();
		$this->Votes->constructClasses();
	}

	function endTest() {
		unset($this->Votes);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>