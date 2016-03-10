<?php
require_once './Abstract/AbstractSearchEngine.php';
use Goutte\Client;

class GoogleSearch extends AbstractSearchEngine {

	private $URL = "https://www.google.com/search";
	private $ENGINE = "GOOGLE";
	private $client, $crawler, $results = array();
	
	function __construct($query){
		$this->client = new Client();
		$url = $this->URL . "?q=" . $query;
		$this->crawler = $this->client->request ( 'GET', $url );

		$this->crawler->filterXPath ( '//*[@class="g"]' )->each ( function (\Symfony\Component\DomCrawler\Crawler $node) {
			$url = $node->filterXPath ( '//h3/a' )->attr ( "href" );
			$title = $node->filterXPath ( '//h3' )->text ();
			$this->results[] = array("title" => $title, "url" => $this->makeUrl($url)); 
		} );
	}
	
	protected function title() {
	}
	
	protected function url() {
	}
	
	public function results() {
		return $this->results;
	}
	
	public function display() {
	}
	
	private function makeUrl($url){
// 		return str_replace("/url?q=", "", $url);
		return "https://www.google.com" . $url; 
	}
}