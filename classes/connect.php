<?php
	
	define("USER","root");
	define("PASS","");
	
	$dbh = new PDO('mysql:host=localhost;dbname=filters', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
	
	return $dbh;