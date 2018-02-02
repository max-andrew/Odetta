<?php
	require_once '../include/dbconn.php';
	require_once '../include/unique.php';

	$pId = $_POST['pId'];
	$name = $_POST['name'];

	init($pId, $name);

	// initialize node in database and return sentinel node id
	function init($profId, $name) {
		// generate unique sentinel node
		$sentinel = makeSentinelNode();

		$dbc = connect_to_db();

		// add node to database (sentinels)
		$query = "INSERT INTO sentinels (node, profId, name, timeBuilt, open)
				  VALUES ('$sentinel', '$profId', '$name', NOW(), '1')";
		$result = perform_query($dbc, $query);

		disconnect_from_db($dbc, $result);

		return $sentinel;
	}
?>