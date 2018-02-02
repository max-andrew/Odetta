<?php
	include '../include/dbconn.php';

	$id = $_POST["id"];

	$dbc = connect_to_db();

	$query = "UPDATE users SET inChat='0', lastSeen=NOW() WHERE id='$id'";
	$result = perform_query($dbc, $query);

	disconnect_from_db($dbc, $result);
?>