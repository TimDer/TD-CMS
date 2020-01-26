<?php

$servername	= "";
$username	= "";
$password	= "";
$dbname		= "";

// create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
$conn = mysqli_connect($servername, $username, $password ,$dbname);

// Check connection
if (!$conn) {
	die("Connection failed: " . $conn->connect_error);
}

//echo "<p>connection to the database was successfully</p>";
