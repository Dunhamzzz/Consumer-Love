<?php
class Vote extends AppModel {
	public $order = 'Vote.modified DESC';
	public $validate = array();
	
	public $belongsTo = array('Product', 'User');
	
	/**
	 * getTodaysVotes()
	 * Returns the number votes of the day for a certain user
	 * @param int $userId
	 */
	public function getTodaysVotesByUser($userId) {
		$votesArray = $this->find('all', array(
        	'conditions' => array(
        		'user_id' => $userId,
        		'DATE(Vote.created)' => date('Y-m-d')
        	),
        	'fields' => array('score','product_id'),
        	'contain' => false
        ));
        
        $totalVotes = 0;
        $votes = array();
        
        foreach($votesArray as $vote) {
        	$totalVotes += abs($vote['Vote']['score']);
        	// Set as product_id => score so we can look it up easily
        	$votes[$vote['Vote']['product_id']] = $vote['Vote']['score'];
        }
        
        return array($totalVotes, $votes);
	}
	
	//Get Products by most votes in last 24 hours.
	public function getTrending($period = '-1 day') {
		return $this->find('all', array(
			'conditions' => array(
				'Vote.modified >' => date('Y-m-d H:i:s', strtotime($period))
			),
			'fields' => array(
				'COUNT(*) AS numVotes',
				'SUM(Vote.score) AS numScore',
				'Product.*'
			),
			'group' => 'Vote.product_id',
			'order' => 'numVotes DESC'
		));
	}
	
	public function votesToday($productId) {
		return $this->find('all', array(
			'conditions' => array(
				'Vote.product_id' => $productId,
				'DATE(Vote.created)' => date('Y-m-d')
			),
			'recursive' => -1
		));
	}
	
	/**
	 * Gets Voting history of a product
	 * @param int $productId
	 * @param string $interval daily, monthly, yearly
	 */
	public function voteStats($productId, $interval = 'daily', $limit = 7) {
		
		$fields = array(
			'SUM(Vote.score) AS `score`',
			'COUNT(*) AS `votes`',
			'COUNT(DISTINCT Vote.user_id) AS voters'
		);
		
		$group = array();
		
		switch($interval) {
			case 'yearly': case 'year' :
				$fields[] = 'YEAR(Vote.created) AS `year`';
				$group[] = 'year';
				break;
			case 'monthly': case 'month':
				$fields[] = 'CONCAT(YEAR(Vote.created), \'-\', MONTH(Vote.created)) AS `month`';
				$group[] = 'month';
				break;
			case 'daily': case 'day': default:
				$fields[] = 'DATE(Vote.created) AS `day`';
				$group[] = 'day';
		}
		$stats = $this->find('all', array(
			'conditions' => array(
				'product_id' => $productId,
				'score >' => 0
			),
			'fields' => $fields,
			'group' => $group,
			'recursive' => -1
		));
		
		return $stats;
	}
}