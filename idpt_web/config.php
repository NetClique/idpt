<?php

$host="localhost"; // Host name 
$username="pacid"; // Mysql username 
$password="deity"; // Mysql password 
$db_name="pacid"; // Database name 

// Connect to server and select database.
mysql_connect($host, $username, $password)
	or die("cannot connect"); 
mysql_select_db($db_name)
	or die("cannot select DB");

?>