<?php
	require_once '../include/dbconn.php';

	$node = $_POST['node'];

	// return if pchat is open
	function isChatOpen($node) {
		$query = "SELECT open from sentinels where node='$node'";
		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return ($resultAr["open"]=="1");
	}

	if (isChatOpen($node)) {
		echo 1;
	}
	else {
		echo 0;
	}
?>