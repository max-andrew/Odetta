<?php	
	function isProfInChat($id) {
		$dbc = connect_to_db();

		// student is there if professor doesn't want a response
		$query = "SELECT inChat FROM users WHERE id='$id'";
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		$inChat = ($resultAr["inChat"] == '1');

		disconnect_from_db($dbc, $result);

		return $inChat;
	}

	function isReady($id) {
		$dbc = connect_to_db();

		// student is there if professor doesn't want a response
		$query = "SELECT avail FROM users WHERE id='$id'";
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		$avail = ($resultAr["avail"] == '1');

		disconnect_from_db($dbc, $result);

		return $avail;
	}

	function getCurrentSentinel($id) {
		$dbc = connect_to_db();

		$query = "SELECT node FROM sentinels WHERE profId='$id' ORDER BY timeBuilt DESC";
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		$current = $resultAr["node"];

		disconnect_from_db($dbc, $result);

		return $current;
	}

	function isCurrentSentinel($sentinel, $id) {
		$current = getCurrentSentinel($id);
		$isCurrent = $current == $sentinel;

		return $isCurrent;
	}

	/*function isProfSentinel($sentinel, $id) {
		$query = "SELECT node FROM sentinels WHERE profId='$id'";
		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return in_array($sentinel, $resultAr["node"]);
	}*/

	// return true if id relates to a user
	function idExists($id) {
		$dbc = connect_to_db();

		$query = "SELECT COUNT(id) AS count FROM users WHERE id='$id'";
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		$exists = ($resultAr["count"] > 0);

		disconnect_from_db($dbc, $result);

		return $exists;
	}
?>