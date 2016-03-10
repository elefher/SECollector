<?php
require_once './Abstract/AbstractSearchEngine.php';
use Goutte\Client;

class BingSearch extends AbstractSearchEngine {
	
	private $URL = "https://www.bing.com/search";
	private $ENGINE = "BING";
	private $client, $crawler, $results = array ();
	
	function __construct($query) {
		$this->client = new Client ();
		$url = $this->URL . "?q=" . $query;
		$this->crawler = $this->client->request ( 'GET', $url );
		
		$this->crawler->filterXPath ( '//*[@class="b_algo"]' )->each ( function (\Symfony\Component\DomCrawler\Crawler $node) {
			$title = $node->filterXPath ( '//h2' )->text ();
			$url = $node->filterXPath ( '//h2/a' )->attr ( "href" );
			$this->results[] = array("title" => $title, "url" => $url);
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
}