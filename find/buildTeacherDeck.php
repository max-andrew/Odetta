<?php
	require_once '../include/dbconn.php';
	require '../include/buildIdCard.php';

	// return array of user ids for available professors
	function getUsers($school_id) {
		$query = "SELECT id FROM users WHERE school_id='$school_id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);

		while ($row = mysqli_fetch_assoc($result)) {
			$online[] = $row;
		}
		disconnect_from_db($dbc, $result);

		$resultAr = array();
		if (!empty($online)) {
			foreach ($online as $a => $b) {
				foreach ($b as $c => $a) {
					array_push($resultAr, $b[$c]);
				};
			};
		}
		return $resultAr;
	}

	// returns array with ["fname", "lname"]
	function getName($id) {
		$query = "SELECT fname, lname FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr;
	}

	// return "ready" if professor is available and not in chat
	function isReady($id) {
		// get list of all professors who are available

		$query = "SELECT avail, inChat FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		$avail = $resultAr["avail"];
		$inChat = $resultAr["inChat"];

		// if given user id is in the list of available professors (not in chat)
		if ($avail == 1 && $inChat == 0) {
			return "";
		}
		else {
			return "blank";
		}
	}

	function getDept($id) {
		$query = "SELECT dept FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["dept"];
	}

	function getStatus($id) {
		$query = "SELECT lastSeen, DATE_SUB(NOW(), INTERVAL 15 MINUTE) AS diff FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		if ($resultAr["lastSeen"] < $resultAr["diff"])
			return "Idle";
	}

	// determine which deck to build and construct it
	function buildDeck($school_id) {
		// if teacher known
		foreach (getUsers($school_id) as $id) {
			echo buildIdCard($id);
		};
	}
?>