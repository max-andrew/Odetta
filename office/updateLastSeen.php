<?php
	require '../include/dbconn.php';

	$id = $_POST['id'];

	$dbc = connect_to_db();

	$query = "UPDATE users SET lastSeen=NOW() WHERE id='$id'";
	$result = perform_query($dbc, $query);
	
	disconnect_from_db($dbc, $result);
?>