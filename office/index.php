<?php
	require '../include/dbconn.php';
	// unique functions
	require '../include/unique.php';
	// get most recent chat string
	require '../chat/getChat.php';
	require 'buildRoomCard.php';
	require '../include/buildIconCard.php';
	require '../include/buildIdCard.php';
	require '../include/buildTextCard.php';
	require '../include/buildSmallIconCard.php';
	require '../include/buildLongCard.php';
	require '../include/buildSubCopyTextCard.php';
	require '../include/buildEmailCard.php';
	require '../include/buildRoomDeck.php';

	session_start();

	/* VALID USER */

	// build page for professor (valid cookie found)
	function buildControlDeck($id) {
		// set $inChat to boolean value
		$inChat = ($_GET['i'] == 1);

		// start building toolbelt
		// add log out, do not disturb, share link, and/or end chat buttons
		echo "<input type='hidden' id='p' value='".$id."' />
		<div id='header'>
			<h1>
				<a href='../office'>ODETTA</a>
			</h1>
		</div>";

		// office homepage or chatbox
		if (!$inChat) {
			// build professor share link
			/*$link = "odetta.co/chat/index.php?p=".$id;
			buildSubCopyTextCard("Share Link:", $link);*/
			
			// function to alternate which card is shown (input or cover card)
			// buildIconCard("../img/mail.svg", "Invite Class", "toEmailCard()", "invite_card");

			// buildIconCard("", "Share Room", "share()");

			buildRoomDeck($id);

			buildIconCard("../img/new.svg", "Add Room", "buildNewRoom('".$id."')");

			// buildIconCard("", "Edit Rooms", "edit()");

			buildIconCard("../img/log_out.svg", "Log Out", "logOut()");
		}
		else {
			echo "<div class='flex'>";
				// buildLongDoNotDisturb($id);
				buildLongCard("Leave Chat", "chatEnd()");
			echo "</div>";
			// construct chat box
			buildChat($id);
		}
	}

	/* NO USER */
	// no or invalid cookie

	// allow sign in and register
	function noUserDeck() {
		echo '<div id="header">
			<h1>
				<a href="../office">ODETTA</a>
			</h1>
		</div>
		<input type="hidden" id="deacon" value="noUser"/>
		<ul id="deck">';
			buildIconCard("../img/add.svg", "Join", "window.location.href = '../new'");
			buildIconCard("../img/log_in.svg", "Log In", "window.location.href = '../back'");
		echo '</ul>';
	}

	/* CHAT */

	function getSentinel($id) {
		// assume most recent sentinel is that of the current chat for a professor
		$query = "SELECT node from sentinels where profId='$id' ORDER BY timeBuilt desc limit 1";
		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr["node"];
	}

	function buildChat($id) {
		$sentinel = $_GET['c'];

		echo '<ul id="convo">
			<div id="messages"></div>
		</ul>
		<form onsubmit="send()">
			<input type="hidden" name="c" id="s" value="'.$sentinel.'" />
			<input type="hidden" name="i" value="1" />
			<input autocomplete="off" type="text" id="chatInp" maxlength="500" tabindex="-1" placeholder="Message" autofocus></input>
			<button id="sendButt"/>
		</form>';
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>Odetta</title>
		<link type="text/css" rel="stylesheet" href="../css/reset.css">
		<link type="text/css" rel="stylesheet" href="../css/style.css">
		<link type="text/css" rel="stylesheet" href="../css/sheet.css">
		<link type="text/css" rel="stylesheet" href="../css/sharedChat.css">
		<link type="image/icon" rel="icon" href="../img/favicon.ico">
		<script src="../include/jquery-3.2.1.js" defer></script>
		<script type="text/javascript" src="js/office.js" defer></script>
	</head>

	<body>
		<?php
			// check if user logged on
			if (isset($_SESSION['logIn'])) {
				// verify session integrity 
				$key = $_SESSION["logIn"]["key"];
				$id = $_SESSION["logIn"]["id"];

				$query = "SELECT (cookieKey) FROM users WHERE id='$id'";

				$dbc = connect_to_db();
				$result = perform_query($dbc, $query);
				// save as array of values
				$resultAr = $result->fetch_assoc();
				disconnect_from_db($dbc, $result);

				$key_db = $resultAr["cookieKey"];

				// salted (real, db) password is hashed cookie password
				if ($key == $key_db) {
				    // user logged in
				    buildControlDeck($id);
				}
				else {
					noUserDeck();
				}
			}
			// build log in and register cards
			else {
				return noUserDeck();
			} 
		?>
	</body>
</html>