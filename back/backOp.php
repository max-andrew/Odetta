<?php 	
	require_once '../include/dbconn.php';
	require_once '../include/unique.php';

	// sanitize inputs
	$email = trim($_POST['email']);

	// query for number of rows with given email
	$query = "SELECT COUNT(email) as count FROM users WHERE email='$email'";

	$dbc = connect_to_db();
	// save query result object
	$result = perform_query($dbc, $query);
	// save as array of values
	$resultAr = $result->fetch_assoc();
	disconnect_from_db($dbc, $result);
	// get bool value of whether email exists
	$email_exist = $resultAr["count"] == 1;

	if ($email_exist) {
		$entered = $_POST['password'];

		$query = "SELECT (password) FROM users WHERE email='$email'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		$password = $resultAr["password"];

		if (password_verify($entered, $password)) {
			good();
		}
		else {
			error($email);
		}
	}
	else {
		error("");
	}

	// all verified 
	function good() {
		$email = trim($_POST['email']);

		// get prof Id
		$query = "SELECT (id) FROM users WHERE email='$email'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		 $id = $resultAr["id"];
		// get cookieKey
		$cooKey = makeId(5);

		// add key to database
		$query = "UPDATE users SET cookieKey='$cooKey', avail='1', lastSeen=NOW() WHERE id='$id'";
		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		disconnect_from_db($dbc, $result);

		// start session storing id and session key
		session_start();

		$_SESSION["logIn"] = array("id" => $id, "key" => $cooKey);

		// redirect to find on completion
		header("Location: ../office");
	}

	function error($email) {
		header("Location: ../back?e=".$email);
	}
?>