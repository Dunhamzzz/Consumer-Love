<?php
class Review extends AppModel {
	public $belongsTo = array('User', 'Product');
	
}