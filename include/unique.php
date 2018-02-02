<?php
	/* Public methods */
	// generate a unique message id
	function makeId($length) {
		// all possible characters
		$characters = 'bcdfghjklmnpqrstvwxyz0123456789';
		$idLen = $length;
		$id = '';

		// construct an id
 		for ($i = 0; $i < $idLen; $i++) {
      		$id .= $characters[rand(0, strlen($characters) - 1)];
 		}

		return $id;
	}

	// generate a unique user id
	function makeUserId() {
		$id = makeId(4);

 		// if not unique, try again
 		while (isUniqueUserId($id) == False) {
 			$id = makeId(4);
 		}

		return $id;
	}

	// generate a unique temporary id
	function makeTempUserId() {
		// mark as temporary id to prevent confusion with permanent ids
		$id = "S".makeId(5);

 		// if not unique, try again
 		while (isUniqueTempUserId($id) == False) {
 			$id = "S".makeId(5);
 		}

 		setTempUserId($id);

		return $id;
	}

	function makeMessId() {
		$id = makeId(8);

 		// if not unique, try again
 		while (isUniqueMessId($id) == False) {
 			$id = makeId(8);
 		}

		return $id;
	}

	function makeSentinelNode() {
		$node = makeId(8);

 		// if not unique, try again
 		while (isUniqueSentinel($node) == False) {
 			$node = makeId(8);
 		}

		return $node;
	}

	/* Internal methods */

	// return if id is unique 
	function isUniqueUserId($id) {
		// query for number of rows with given id
		$query = "SELECT COUNT(id) as count FROM users WHERE id='$id'";

		$dbc = connect_to_db();
		
		// save query result object
		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();

		disconnect_from_db($dbc, $result);
		// get count specifically
		$repeatCount = $resultAr["count"];

		// if id is unique, and passwords match
		if ($repeatCount == 0) {
			return True;
		}
		return False;
	}

	// return if message is unique 
	function isUniqueMessId($id) {
		// query for number of rows with given id
		$query = "SELECT COUNT(messId) as count FROM chats WHERE messId='$id'";

		$dbc = connect_to_db();
		// save query result object
		$result = perform_query($dbc, $query);
		disconnect_from_db($dbc, $result);

		// save as array of values
		$resultAr = $result->fetch_assoc();
		// get count specifically
		$repeatCount = $resultAr["count"];

		// if id is unique, and passwords match
		if ($repeatCount == 0) {
			return True;
		}
		return False;
	}

	// return if temp user id is unique 
	function isUniqueTempUserId($id) {
		// query for number of rows with given id
		$query = "SELECT COUNT(id) as count FROM students WHERE id='$id'";

		$dbc = connect_to_db();
		// save query result object
		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);
		
		// get count specifically
		$repeatCount = $resultAr["count"];

		// if id is unique, and passwords match
		if ($repeatCount == 0) {
			return True;
		}
		return False;
	}

	// return if sentinel is unique 
	function isUniqueSentinel($node) {
		// query for number of rows with given id
		$query = "SELECT COUNT(node) FROM sentinels WHERE node='$node'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		// get count specifically
		$repeatCount = $resultAr["node"];

		// if id is unique, and passwords match
		if ($repeatCount == 0) {
			return True;
		}
		return False;
	}

	// return if email is unique
	function isUniqueEmail($email) {
		// query for number of rows with given email
		$query = "SELECT COUNT(email) as count FROM users WHERE email='$email'";

		$dbc = connect_to_db();
		// save query result object
		$result = perform_query($dbc, $query);
		disconnect_from_db($dbc, $result);

		// save as array of values
		$resultAr = $result->fetch_assoc();
		// get bool value of unique
		return $resultAr["count"] == 0;
	}

	// save temp user id to database
	function setTempUserId($id) {
		$dbc = connect_to_db();

		$query = "INSERT INTO students (id) VALUES ('$id')";

		$result = perform_query($dbc, $query);
		disconnect_from_db($dbc, $result);
	}
?>