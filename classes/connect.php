<?php
	
	define("USER","root");
	define("PASS","");
	
	$dbh = new PDO('mysql:host=localhost;dbname=filters', USER, PASS);
	
	return $dbh;