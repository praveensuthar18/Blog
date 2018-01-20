<?php 
//$Connection= mysqli_connect('localhost','root','');
//$ConnectingDB= mysqli_select_db($Connection,'phpcms');

//Setting credentials for MySQL login
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'phpcms');

// Connect to MySQL
$dbcon = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set encoding
mysqli_set_charset($dbcon, 'utf8');

?>