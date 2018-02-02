<?php
	require_once '../include/dbconn.php';

	$id = $_POST['id'];

	// return if professor is in chat
	function amInChat($id) {
		// assume most recent sentinel is that of the current chat for a professor
		$query = "SELECT inChat from users where id='$id'";
		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return ($resultAr["inChat"]==1);
	}

	// student is there if professor is in a chat
	if (amInChat($id)) {
		echo 1;
	}
	else {
		echo 0;
	}
?>