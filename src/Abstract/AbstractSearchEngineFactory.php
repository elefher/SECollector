<?php
abstract class AbstractSearchEngineFactory{
	abstract public function search($query);
	abstract protected function parseResults($results);
}