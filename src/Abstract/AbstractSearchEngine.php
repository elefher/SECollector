<?php
abstract class AbstractSearchEngine {
	abstract protected function title();
	abstract protected function url();
	abstract public function results();
	abstract public function display();
}