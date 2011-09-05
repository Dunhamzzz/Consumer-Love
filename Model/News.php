<?php

class News extends AppModel {

	public $belongsTo = array('Product', 'User');
	
}