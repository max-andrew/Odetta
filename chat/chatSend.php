<?php
	include '../include/dbconn.php';
	include '../include/unique.php';

	$dbc = connect_to_db();
	
	$message = strip_tags(trim(mysqli_real_escape_string($dbc, $_POST['input'])));
	$sender = strip_tags(trim($_POST['sender']));
	$messId = makeMessId();
	$sentinel = strip_tags(trim($_POST['sentinel']));

	/* 1. if conversation exists */
	// search for a pre-existing conversation by finding where nextMess is the sentinel node (find the last message if in db)
	
	/* make room for new message by updating current terminal message (end of list pointing to sentinel), or updating the sentinel of nextMess if the conversation has just started */
	$query = "SELECT nextMess FROM sentinels WHERE node='$sentinel'";
	$result = perform_query($dbc, $query);
	$resultAr = $result->fetch_assoc();

	// (true) conversation exists (nextMess set to something)
	if ($resultAr['nextMess'] != "") {
		// fix previous terminal message's nextMess (add this message to the end of the list)
		$query = "UPDATE chats SET nextMess='$messId' WHERE nextMess='$sentinel'";
		$result = perform_query($dbc, $query);
	}
	// (false) in sentinels, update nextMess to be current message id
	else {
		$query = "UPDATE sentinels SET nextMess='$messId' WHERE node='$sentinel'";
		$result = perform_query($dbc, $query);
	} 

	// add name to db (and temp id)

	/* 2. send */
	// verify (prevent RESTful sending)
	if ($message == $sender && $sentinel == $sender && $sentinel == $message) {
		echo ("Error");
	}
	else {
		// send new message to database
		$query = "INSERT INTO chats (messId, message, sender, timeSent, nextMess)
				  VALUES ('$messId', '$message', '$sender',  NOW(), '$sentinel')";
		// save query result object
		$result = perform_query($dbc, $query);
	}

	// disconnect from db
	disconnect_from_db($dbc, $result);
?>