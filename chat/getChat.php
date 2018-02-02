<?php 
	require_once '../include/dbconn.php';

	// increase security by not relying on client-side sentinel

	$sentinel = $_POST["sentinel"];
	$pId = $_POST["pId"];
	// current user's id
	$id = $_POST["id"];

	echo getChat($sentinel, $pId, $id);

	// build and return chat html string
	function getChat($sentinel, $pId, $id) {
		// validate that sentinel belonged to professor
		if (isProfSentinel($sentinel, $pId)) {
			// running chat return string
			$chat = "";
			// current message id
			$messId = getFirstMessId($sentinel);

			// continue grabbing id for next consecutive chat and adding message to return string
			while ($messId != $sentinel) {
				// catch infinite loop
				if ($messId == "") {
					break;
				}

				$senderId = getSenderId($messId);
				$chat .= markup($messId, $pId, $id, $senderId);
				$messId = getNextMessId($messId);
			}
			return $chat;
		}
		return "";
	}

	// get first message id given sentinel node
	function getFirstMessId($sentinel) {
		$query = "SELECT nextMess FROM sentinels WHERE node='$sentinel'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["nextMess"];
	}

	// return id of sender
	function getSenderId($messId) {
		$query = "SELECT sender FROM chats WHERE messId='$messId'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["sender"];
	}

	// return "send" or "receive" based on current user
	function getMessageDirection($id, $senderId) {
		if ($id === $senderId) {
			return "send";
		}
		else {
			return "receive";
		}
	}

	// return "isProf" if sender is professor
	function getIsProf($pId, $senderId) {
		if ($senderId === $pId) {
			return "isProf";
		}
		else {
			return "";
		}
	}

	// get the sender's name
	function getName($pId, $id, $senderId) {
		$name = "";

		$isSelf = $senderId === $id;
		$isProf = $senderId === $pId;

		// do not need to print own name
		if ($isSelf) {
			$name = "";
		}
		else if ($isProf) {
			$name = "Professor";

			$query = "SELECT fname, lname FROM users WHERE id='$senderId'";

			$dbc = connect_to_db();
			$result = perform_query($dbc, $query);
			$resultAr = $result->fetch_assoc();
			disconnect_from_db($dbc, $result);

			$name = $resultAr["fname"] . " " . $resultAr["lname"];
		}
		else {
			$name = "Student";

			$query = "SELECT name FROM students WHERE id='$senderId'";

			$dbc = connect_to_db();
			$result = perform_query($dbc, $query);
			$resultAr = $result->fetch_assoc();
			disconnect_from_db($dbc, $result);

			$name = $resultAr["name"];
		}

		return $name;
	}

	// get message given message id
	function getMessage($messId) {
		$query = "SELECT message FROM chats WHERE messId='$messId'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["message"];
	}

	// return html for chat box given message id
	function markup($messId, $pId, $id, $senderId) {
		$direction = getMessageDirection($id, $senderId);
		$message = getMessage($messId);
		$isProf = getIsProf($pId, $senderId);
		$name = getName($pId, $id, $senderId);
		// prevent blank message shells
		if ($message == "") {
			return "";
		}
		else if ($direction == "send") {
			return '
				<li class="wholeMess ' . $direction . '">
					<p class="message">' . $message . '</p>
				</li>
			';
		}
		else {
			return '
				<li class="wholeMess ' . $direction . '">
					<p class="message">' . $message . '</p>
					<p class="name ' . $isProf . '">' . $name . '</p>
				</li>
			';
		}
	}

	function getNextMessId($messId) {
		$query = "SELECT nextMess FROM chats WHERE messId='$messId'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["nextMess"];
	}

	// validate that sentinel belongs to professor
	function isProfSentinel($sentinel, $pId) {
		$query = "SELECT profId FROM sentinels WHERE node='$sentinel'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		// return if valid
		return ($resultAr["profId"] == $pId);
	}
?>