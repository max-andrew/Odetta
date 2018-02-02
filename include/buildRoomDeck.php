<?php
	require_once '../include/dbconn.php';

	// return array of all room ids
	function getRooms($id) {
		$query = "SELECT node FROM sentinels WHERE profId='$id' AND deleted!='1' ORDER BY timeBuilt DESC";

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

	function getRoomName($node) {
		$query = "SELECT name FROM sentinels WHERE node='$node'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["name"];
	}

	function getRoomTime($node) {
		$query = "SELECT timeBuilt FROM sentinels WHERE node='$node'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["timeBuilt"];
	}

	// determine which deck to build and construct it
	function buildRoomDeck($id) {
		foreach (getRooms($id) as $node) {
			buildRoomCard($node, $id);
		};
	}
?>