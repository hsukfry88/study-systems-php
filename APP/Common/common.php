<?php

function p($data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function net($url) {
	$url = $_SERVER['SERVER_NAME'] . $url;
	echo $url;die;
	header("Location: " . $url);
	exit;
}

function getURL($url) {
	return $url;
}

?>