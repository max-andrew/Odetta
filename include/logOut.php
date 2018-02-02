<?php
	require 'dbconn.php';

	session_start();

	$id = $_SESSION["logIn"]["id"];
	$key = $_SESSION["logIn"]["key"];

	$query = "SELECT (cookieKey) FROM users WHERE id='$id'";

	$dbc = connect_to_db();
	$result = perform_query($dbc, $query);
	// save as array of values
	$resultAr = $result->fetch_assoc();
	disconnect_from_db($dbc, $result);

	$key_db = $resultAr["cookieKey"];

	// cookie key is real (database) key
	if ($key == $key_db) {
		// make unavailable
		$dbc = connect_to_db();

		$query = "UPDATE users SET avail='0', lastSeen=NOW() WHERE id='$id'";
		$result = perform_query($dbc, $query);
		
		disconnect_from_db($dbc, $result);

		// end the session
		session_unset($_SESSION["logIn"]);
		// session_destroy();

	}
	else {
		echo ("invalid key");
	}
?>