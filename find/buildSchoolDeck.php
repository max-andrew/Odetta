<?php
	require_once '../include/dbconn.php';
	require '../include/buildSchoolCard.php';

	buildDeck();

	// return array of all school ids
	function getSchools() {
		$query = "SELECT school_id FROM schools";

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

	function getSchoolName($schId) {
		$query = "SELECT name FROM schools WHERE school_id='$schId'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr;
	}

	// determine which deck to build and construct it
	function buildDeck() {
		foreach (getSchools() as $schId) {
			buildSchoolCard($schId);
		};
	}
?>