<?php
	require_once '../include/dbconn.php';

	$id = $_POST['id'];

	// return true if available
	function amAvailable($id) {
		$query = "SELECT (avail) FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return ($resultAr["avail"]==1);
	}

	// 1 if professor is available
	if (amAvailable($id)) {
		echo 1;
	}
	else {
		echo 0;
	}
?>