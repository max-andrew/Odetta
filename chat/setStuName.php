<?php
	require_once '../include/dbconn.php';

	$name = $_POST["name"];
	$id = $_POST["id"];
	$ip = $_POST["ip"];

	$dbc = connect_to_db();
	$query = "UPDATE students SET name='$name', ip='$ip' WHERE id='$id'";
	$result = perform_query($dbc, $query);
	disconnect_from_db($dbc, $result);

	session_start();
	$_SESSION['name'] = $name;
?>