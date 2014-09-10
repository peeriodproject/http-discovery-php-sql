<?php

$pathToDbInc = './db.inc';

include $pathToDbInc;

$sqlLink = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$sqlLink) {
	fiveHundred();
}
else {
	createDb($sqlLink);
}


//---------------------------

function createDb ($link) {
	$sql = 'CREATE TABLE nodes(node_id CHAR(40) NOT NULL,PRIMARY KEY(node_id),node_string TEXT NOT NULL,access_date BIGINT NOT NULL)';

	if (!mysqli_query($link, $sql)) {
		echo mysqli_error($link);
	}
}


//---------------------------

function fourOhFour () {
	header('HTTP/1.0 404 Not Found');
	echo "<h1>404 Not Found</h1>";
	exit();
}

function fiveHundred () {
	header('HTTP/1.0 500 Internal Server Error');
	echo "<h1>500 Internal Server Error</h1>";
	exit();
}