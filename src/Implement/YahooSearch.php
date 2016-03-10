<?php
require_once './Abstract/AbstractSearchEngine.php';
use Goutte\Client;

class YahooSearch extends AbstractSearchEngine {
	
	private $URL = "https://us.search.yahoo.com/search";
	private $ENGINE = "YAHOO";
	private $client, $crawler, $results = array ();
	
	function __construct($query) {
		$this->client = new Client ();
		$url = $this->URL . "?p=" . $query;
		$this->crawler = $this->client->request ( 'GET', $url );
		
		$this->crawler->filterXPath ( '//*[@class="compTitle options-toggle"]' )->each ( function (\Symfony\Component\DomCrawler\Crawler $node) {
			$title = $node->filterXPath ( '//h3' )->text ();
			$url = $node->filter ( 'a' )->attr ( "href" );
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