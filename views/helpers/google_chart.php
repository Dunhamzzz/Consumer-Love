<?php
/**
 * Google Chart Helper
 * @link https://code.google.com/apis/chart/image/docs/making_charts.html
 */
class GoogleChartHelper extends AppHelper {
	public $helpers = array('Html');
	
	protected  $baseUrl = 'https://chart.googleapis.com/chart?';
	
	protected $supportedTypes = array('lc', 'ls');
	
	// Unformatted Chart Variables
	protected $chartUrl;
	protected $chartType;
	protected $chartWidth;
	protected $chartHeight;
	protected $chartData;
	protected $chartDataSize;
	protected $chartColors;
	
	// Options var used to build the query
	protected $options = array();
	
	public function chart($options = array()) {
		if(!empty($options)) {
			// Check to see if various options have been defined in $options param
			if(array_key_exists('data', $options)) {
				
				$this->setData($options['data']);
			}
			
			if(array_key_exists('type', $options)) {
				$this->setType($options['type']);
			}
			
			if(array_key_exists('size', $options)) {
				$this->setSize($options['size']);
			}
			
			if(array_key_exists('color', $options)) {
				$this->setColors($options['color']);
			}
		}
		
		$this->buildUrl();
		
		return $this->Html->image(
			$this->chartUrl,
			array(
				'width' => $this->chartWidth,
				'height' => $this->chartHeight
			)
		);
	}
	
	public function buildUrl() {
		$this->_options['chs'] = $this->chartWidth.'x'.$this->chartHeight;
		$this->_options['cht'] = $this->chartType;
		$this->_options['chd'] = 't:'.implode(',', $this->chartData);
		$this->_options['chco'] = implode(',',$this->chartColors);
		
		// Build Query
		//$this->chartUrl = $this->baseUrl.http_build_query($this->_options);

		$this->chartUrl = $this->baseUrl;
		foreach ($this->_options as $key => $value) {
			$this->chartUrl.= $key.'='.$value.'&';
		}
	}
	
	public function getUrl() {
		if(empty($this->chartUrl)) {
			$this->buildUrl();
		}
		return $this->chartUrl;
	}
	
	public function setData($dataArray = array()) {
		// Overwrite existing data
		$this->chartData = array();
		
		foreach($dataArray as $data) {
			$this->chartData[] = $data;
		}
	}
	
	public function setSize($width, $height = false) {
		if(is_array($width)) {
			$height = $width[1];
			$width = $width[0];
		}
		
		$this->chartWidth = $width;
		$this->chartHeight = $height;
	}
	
	public function setType($type) {
		$this->chartType = $type;
	}
	
	public function setColors($colors) {
		if(!is_array($colors)) {
			$colors = array($colors);
		}
		$this->chartColors = $colors;
	}
}