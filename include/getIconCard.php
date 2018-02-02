<?php
	require_once 'buildIconCard.php';

	$img_location = $_POST["img_location"];
	$title = $_POST["title"];
	$action = $_POST["action"];

	echo buildIconCard($img_location, $title, $action);
?>