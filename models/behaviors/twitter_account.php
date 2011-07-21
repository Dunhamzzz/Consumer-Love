<?php
App::import('Core', 'HttpSocket');

class TwitterAccountBehavior extends ModelBehavior {
	protected static $httpSocket;

	public function setup($model, $config = array()) {
		parent::setup($model, $config);

		$this->settings[$model->alias] = array_merge(array(
			'field' => 'twitter',
			'cache' => 'default'
			), $config);
	}
	
	public function beforeFind($model, $query) {
		$this->settings[$model->alias]['tweets'] = !isset($query['tweets']) ? true : $query['tweets'];
		return parent::beforeFind($model, $query);
	}
	
	public function afterFind($model, $results, $primary) {
		$rows = parent::afterFind($model, $results, $primary);
		if(!is_null($rows)) {
			$results = $rows;
		}
		
		if(!empty($this->settings[$model->alias]['tweets']) && isset($results[0][$model->alias])) {
			$field = $this->settings[$model->alias]['field'];
			$count = is_int($this->settings[$model->alias]['tweets']) ? $this->settings[$model->alias]['tweets'] : 10;
			$cacheConfig = $this->settings[$model->alias]['cache'];
			foreach($results as $i => $result) {
				$twitter = $result[$model->alias][$field];
				$tweets = array();
				if(!empty($cacheConfig)) {
					$tweets = Cache::read('tweets_' . $twitter, $cacheConfig);
				}
				if(empty($tweets) && !empty($result[$model->alias][$field])) {
					$result = $this->timeline($twitter, $count);
					if(!empty($result) && is_array($result)) {
						foreach($result as $tweet) {
							$tweets[] = array(
								'created' => date('Y-m-d H:i:s', strtotime($tweet->created_at)),
								'source' => $tweet->source,
								'user' => $tweet->user->screen_name,
								'text' => $tweet->text
							);
						}
					}
					Cache::write('tweets_' . $twitter, $tweets, $cacheConfig);
				}
				$results[$i]['Tweet'] = $tweets;
			}
		}
		return $results;
	}
	
	public function beforeDelete($model, $cascade = true) {
		$field = $this->settings[$model->alias]['field'];
		$this->settings[$model->alias]['delete'] = $model->field($field, array(
			$model->primaryKey => $model->id
		));
		parent::beforeDelete($cascade);
	}
	
	public function afterDelete($model) {
		if(!empty($this->settings[$model->alias]['delete'])) {
			$cacheConfig = $this->settings[$model->alias]['cache'];
			$twitter = $this->settings[$model->alias]['delete'];
			Cache::delete('tweets_' . $twitter, $cacheConfig);
		}
		return parent::afterDelete($model);
	}
	
	// Main timeline method
	protected function timeline($twitter, $count = 10, $returnStatus= false) {
		if(!isset(self::$httpSocket)) {
			self::$httpSocket = new HttpSocket();
		}
		
		$content  = self::$httpSocket->get('http://twitter.com/status/user_timeline/' . $twitter . '.json?count=' . $count);
		$status = self::$httpSocket->response['status']['code'];
		if(!empty($content)) {
			$content = json_decode($content);
		}
		
		if($returnStatus) {
			return compact('status', 'content');
		}
		return $content;
	}
	
	// Validation method
	public function validateTwitter($model, $data) {
		$field = $this->settings[$model->alias]['field'];
		if(!empty($data[$field])) {
			$value  = $data[$field];
			$result = $this->timeline($value, 1, true);
			if($result['status'] == 404) {
				$result = false;
			}
		}
		return $result;
	}
}