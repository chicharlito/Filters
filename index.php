<?php
	require_once("classes/manager.class.php");
	require_once("classes/connect.php");
	$manager = new manager($dbh);
	
	if(isset($_POST['categorieId'])){
		$id = (int) $_POST['categorieId'];
		return $result = $manager->getFiltres($id);
	}
	
	if(isset($_POST['imageData']) and isset($_POST['filter'])){
		$background = $_POST['imageData'];
		$filter = $_POST['filter'];
		$manager->createImage($background,$filter);
		exit;
	}
	
	$categories = $manager->getCategories();
	include("views/home.php");
	exit;

