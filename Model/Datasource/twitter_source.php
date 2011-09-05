<?php
App::import('Vendor', 'HttpSocketOauth');
class TwitterSource extends DataSource {
	
	public $_baseConfig = array(
		'key' => null,
		'secret' => null
	);
	
	protected $_schema = array(
		'tweets' => array(
			'id' => array(
				'type' => 'integer',
				'null' => true,
				'key' => 'primary',
				'length' => 11
			),
			'text' => array(
				'type' => 'string',
				'null', true,
				'key' => 'primary',
				'length' => 140
			),
			'status' => array(
				'type' => 'string',
				'null' => true,
				'key' => 'primary',
				'length' => 140
			)
		)
	);
	
	public function __construct($config = null, $autoConnect = true) {
		parent::__construct($config, $autoConnect);
		if($autoConnect) {
			$this->connect();
		}
	}
	
	public function listSources() {
		return array('tweets');
	}
	
	public function describe($model) {
		return $this->_schema['tweets'];
	}
	
	public function connect() {
		$this->connected = true;
		$this->connection = new HttpSocketOauth();
		return $this->connected;
	}
	
	public function close() {
		if($this->connected) {
			unset($this->connection);
			$this->connected = false;
		}
	}
	
	public function token($callback = null) {
		$response = $this->connection->request(array(
			'method' => 'GET',
			'uri' => array(
				'host' => 'api.twitter.com',
				'path' => '/oauth/request_token'
			),
			'auth' => array(
				'method' => 'OAuth',
				'oauth_callback' => $callback,
				'oauth_consumer_key' => $this->config['key'],
				'oauth_consumer_secret' => $this->config['secret']
			)
		));
		
		if(!empty($response)) {
			parse_str($response, $response);
			if(empty($response['oauth_token']) && count($response) ==1 && current($response) == '') {
				trigger_error(key($response), E_USER_WARNING);
			} elseif(!empty($response['oauth_token'])) {
				return $response['oauth_token'];
			}
			
			return false;
		}
	}
	
	public function authorize($token, $verifier) {
		$return = false;
		$response = $this->connection->request(array(
			'method' => 'GET',
			'uri' => array(
				'host' => 'api.twitter.com',
				'path' => '/oauth/access_token'
			),
			'auth' => array(
				'method' => 'OAuth',
				'oauth_consumer_key' => $this->config['key'],
				'oauth_consumer_secret' => $this->config['secret'],
				'oauth_token' => $token,
				'oauth_verifier' => $verifier
			)
		));
		
		if(!empty($response)) {
			parse_str($response, $response);
			if(count($response) ==1 && current($response) == '') {
				trigger_error(key($response), E_USER_WARNING);
			} else {
				return $response;
			}
			
			return false;
		}
	}
	
	// Read Tweets
	public function read($model, $queryData = array()) {
		if(
			empty($queryData['conditions']['username'])
			|| empty($this->config['authorize'])
		) {
			return false;
		}
		
		$response = $this->connection->request(array(
			'method' => 'GET',
			'uri' => array(
				'host' => 'api.twitter.com',
				'path' => '1/statuses/user_timeline/' . $queryData['conditions']['username'] . '.json'
			),
			'auth' => array_merge(array(
				'method' => 'OAuth',
				'oauth_consumer_key' => $this->config['key'],
				'oauth_consumer_secret' => $this->config['secret']
			), $this->config['authorize'])
		));
		
		if(empty($response)) {
			return false;
		}
		
		$response = json_decode($response, true);
		if(!empty($response['error'])) {
			trigger_error($response['error'], E_USER_ERROR);
		}
		
		$results = array();
		foreach($response as $record) {
			$record = array('Tweet' => $record);
			$record['User'] = $record['Tweet']['user'];
			unset($record['Tweet']['user']);
			$results[] = $record;
		}
		
		return $results;
	}
	
	// Create Tweets
	public function create($model, $fields = array(), $values = array()) {
		if(empty($this->config['authorize'])) {
			return false;
		}
		
		$response = $this->connection->response(array(
			'method' => 'POST',
			'uri' => array(
				'host' => 'api.twitter.com',
				'path' => '1/statuses/update.json'
			),
			'auth' => array(
				'method' => 'OAuth',
				'oauth_token' => $this->config['authorize']['oauth_token'],
				'oauth_token_secret' => $this->config['authorize']['oauth_token_scret'],
				'oauth_consumer_key' => $this->config['key'],
				'oauth_conumser_secret' => $this->config['secret']
			),
			'body' => array_combine($fields, $values)
		));
		
		if(empty($response)) {
			return false;
		}
		
		$response = json_decode($response, true);
		if(!empty($response['error'])) {
			trigger_error($response['error'], E_USER_ERROR);
		}
		
		if(!empty($response['id'])) {
			$model->setInsertId($response['id']);
			return true;
		}
		
		return false;
	}
}