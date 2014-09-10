<?php

$pathToDbInc = './db.inc';

include $pathToDbInc;

$sqlLink = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$sqlLink) {
	fiveHundred();
}


$reqMethod = $_SERVER['REQUEST_METHOD'];
if ($reqMethod === 'POST') {
	$ip = $_SERVER['REMOTE_ADDR'];

	$postJson = json_decode(file_get_contents('php://input'));

	if (!($postJson && isset($postJson->id) && isset($postJson->addresses) && is_array($postJson->addresses))) {
		badRequest();
	}

	$id = $postJson->id;

	$addresses = $postJson->addresses;
	$reworkedAddresses = array();

	for($i = 0; $i < count($addresses); $i++) {
		$address = $addresses[$i];

		if($address && isset($address->ip) && isset($address->port) && is_int($address->port) && $address->port >= 0 && $address->port <= 65535) { 
			$reworkedAddress = array();
			$reworkedAddress['ip'] = $ip;
			$reworkedAddress['port'] = $address->port;

			$reworkedAddresses[] = $reworkedAddress;
		}
	}

	if(empty($reworkedAddresses)) {
		badRequest();
	}

	$jsonToSave = mysqli_real_escape_string($sqlLink, json_encode(array(
		"id"			=> $id,
		"addresses"		=> $reworkedAddresses
	)));


	$now = time();


	$saveQuery = "INSERT INTO nodes (node_id, node_string, access_date) VALUES ('$id', '$jsonToSave', $now) ON DUPLICATE KEY UPDATE node_string = '$jsonToSave', access_date = $now";

	mysqli_query($sqlLink, $saveQuery);

	twoOhTwo();

}
else if ($reqMethod === 'GET') {
	while (1 == 1) {
		$result = mysqli_query($sqlLink, 'SELECT * FROM nodes ORDER BY RAND() LIMIT 1');
		
		if ($result) {
			$node = mysqli_fetch_object($result);
			if ($node) {

				if (time() - $node->access_date > 3600) {
					if (!mysqli_query($sqlLink, "DELETE FROM nodes WHERE node_id='$node->node_id'")) {
						fiveHundred();
					}
				}
				else {
					header('HTTP/1.0 200 OK');
					header('Content-type: application/json; charset=utf-8');
					echo $node->node_string;
					exit();
				}
			}
			else {
				fourOhFour();
			}
		}
		else {
			fourOhFour();
		}
	}
}
else {
	fourOhFour();
}

//---------------------------

function twoOhTwo () {
	header('HTTP/1.0 202 Accepted');
	echo "<h1>202 Accepted</h1>";
	exit();
}

function fourOhFour () {
	header('HTTP/1.0 404 Not Found');
	echo "<h1>404 Not Found</h1>";
	exit();
}

function badRequest () {
	header('HTTP/1.0 400 Bad Request');
	echo "<h1>400 Bad Request</h1>";
	exit();	
}

function fiveHundred () {
	header('HTTP/1.0 500 Internal Server Error');
	echo "<h1>500 Internal Server Error</h1>";
	exit();
}