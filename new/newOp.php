<?php 
	require_once '../include/dbconn.php';
	require_once '../include/unique.php';

	// sanitize inputs
	$fname = trim(strip_tags($_POST['first']));
	$lname = trim(strip_tags($_POST['last']));
	$dept = trim(strip_tags($_POST['dept']));
	$email = trim($_POST['email']);

	// query for number of rows with given email
	$query = "SELECT COUNT(email) as count FROM users WHERE email='$email'";

	$dbc = connect_to_db();
	// save query result object
	$result = perform_query($dbc, $query);
	// save as array of values
	$resultAr = $result->fetch_assoc();
	disconnect_from_db($dbc, $result);

	// get bool value of unique
	$email_uniq = $resultAr["count"] == 0;

	$pass_match = $_POST['password'] == $_POST['repeat'];
	
	// all values above min or below max length
	$pass_len = strlen($_POST['password']) >= 7;

	$email_verif = (strlen($_POST['email']) <= 50 && $email_uniq);
	$pass_verif = $pass_match && $pass_len;

	// all is good 
	if ($email_verif && $pass_verif) {
		good($fname, $lname, $email, $dept);
	}
	else {
		error($fname, $lname, $dept, $email);
	}

	function good($fname, $lname, $email, $dept) {
		$id = makeUserId();

		$password = $_POST['password'];
		$dbc = connect_to_db();
		$pass_hash = password_hash($password, PASSWORD_BCRYPT);
		disconnect_from_db($dbc, $result);

		$query = "INSERT INTO users (id, fname, lname, email, password, register, dept, avail, inChat) VALUES ('$id', '$fname', '$lname', '$email', '$pass_hash', NOW(), '$dept', '1', '0')";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);

		// get prof Id
		$query = "SELECT (id) FROM users WHERE email='$email'";

		$result = perform_query($dbc, $query);
		// save as array of values
		$resultAr = $result->fetch_assoc();

		$id = $resultAr["id"];
		// get cookieKey
		$cooKey = makeId(5);

		// add key to database
		$query = "UPDATE users SET cookieKey='$cooKey' WHERE id='$id'";
		$result = perform_query($dbc, $query);
		disconnect_from_db($dbc, $result);

		// start session storing id and session key
		session_start();

		$_SESSION["logIn"] = array("id" => $id, "key" => $cooKey);

		// redirect to find on completion
		header("Location: ../office");
	}

	function error($fname, $lname, $dept, $email) {
		header("Location: ../new?f=".$fname."&l=".$lname."&d=".$dept."&e=".$email);
		// something went wrong error
		// redirect to new page
		// fields should be sticky, but nothing saved to prevent sign up back end issues
	}
?>