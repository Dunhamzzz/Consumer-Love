<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	public $actsAs = array('Containable');
	
	public function afterFind($results, $primary = false) {
		if(!empty($results)) {
			foreach($results as $i => $row) {
				if(!empty($row[0])) {
					foreach($row[0] as $field => $value) {
						if(!empty($row[$this->alias][$field])) {
							$field = 'total_'.$field;
						}
						$results[$i][$this->alias][$field] = $value;
					}
					unset($results[$i][0]);
				}
			}
		}
		return parent::afterFind($results, $primary);
	}
	
	/**
	 * Returns a threaded array (therefore allows for ordering etc)
	 */
	public function getAllThreaded($flatten = false) {
		$data = $this->find('threaded', array(
			'order' => $this->name.'.'.$this->displayField.' ASC',
			'contain' => false
		));
		
		if($flatten) {
			$flatData = array();
			foreach($data as $parent) {
				$flatData[$parent[$this->alias]['id']] = $parent[$this->alias][$this->displayField];
				if(!empty($parent['children'])) {
					foreach($parent['children'] as $child) {
						$flatData[$child[$this->alias]['id']] = ' - '.$child[$this->alias][$this->displayField];
					}
				}
			}
			
			return $flatData;
		}
		
		return $data;
	}
	
	// http://bin.cakephp.org/saved/42156
	protected function compare($value = array(), $options = array(), $rule = array()) {
	    $value = is_array($value) ? current($value) : $value;
	    if (is_array($options)) {
	        $valid = $value == $this->data[$this->alias][$options[0]];
	        if (!$valid) {
	            $this->invalidate(empty($options[1]) ? $options[0] : $options[1], $rule['message']);
	        }
	    } else {
	        $valid = $value == $options;
	    }
	    return $valid;
	}
}