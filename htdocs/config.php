<?php
$host = 'localhost';
$username = 'root';
$pass = '';
$db = 'socialz';

$db = new mysqli($host,$username,$pass,$db);

if ($db->connect_error) {
	 die("Connection Failed". $db->connect_error);
}

?>