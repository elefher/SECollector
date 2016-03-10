<?php
require_once './Abstract/AbstractSearchEngineFactory.php';
require_once './Implement/GoogleSearch.php';
require_once './Implement/YahooSearch.php';
require_once './Implement/BingSearch.php';

class SearchEngineFactory extends AbstractSearchEngineFactory {
	
	private $helpArray = array(), $finalResults = array();
	public $engines = array();
	
	public function search($query) {
		$res = array();
		
		if ($this->engines['google']){
			$google = new GoogleSearch($query);
			$res["GOOGLE"] = $google->results();
		}
		
		if ($this->engines['yahoo']){
			$yahoo = new YahooSearch($query);
			$res["YAHOO"] = $yahoo->results();
		}
		
		if ($this->engines['bing']){
			$bing = new BingSearch($query);
			$res["BING"] = $bing->results();
		}

		return $this->parseResults($res);
	}
	
	protected function parseResults($results){
		$this->helpArray = $results;
		$this->finalResults = $results;
		
		array_filter($results,function($res, $engine){
			unset($this->helpArray[$engine]);

			foreach ($this->helpArray as $engName => $val){
				foreach ($res as $v){
					$url = $v['url'];
					foreach ($this->helpArray[$engName] as $id => $tu){
						$conflict = array_search($url, $tu);
						if($conflict){
							unset($this->finalResults[$engName][$id]);
						}
					}
				}
			}
		}, ARRAY_FILTER_USE_BOTH);
		return $this->finalResults;
	}
}