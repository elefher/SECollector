<?php
require '../vendor/autoload.php';
require_once './Factory/SearchEngineFactory.php';

$query = $_POST['query'];
$google = $_POST['eng']['google'];
$yahoo = $_POST['eng']['yahoo'];
$bing = $_POST['eng']['bing'];

if(!$query){
	echo json_encode(array());
	return ;
}

if(!$google && !$yahoo && !$bing){
	echo json_encode(array());
	return ;
}

$sEF = new SearchEngineFactory();
$sEF->engines['google'] = $google;
$sEF->engines['yahoo'] = $yahoo;
$sEF->engines['bing'] = $bing;
$results = $sEF->search($query);
echo json_encode($results);