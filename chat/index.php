<?php
	require '../include/dbconn.php';
	require '../include/buildSmallIconCard.php';
	require '../include/buildLongCard.php';
	// unique functions
	require '../include/unique.php';
	// get most recent chat string
	require 'getChat.php';
	// validation functions
	require 'validate.php';

	// user creates chat session with name and sentinel node
	session_start();

	$name = trim($_SESSION['name']);
	$sentinel = $_GET['c'];
	// professor id
	$pId = $_GET['p'];
	// student id
	$sId = $_SESSION['id'];
	// student IP
	$ip = $_SERVER['REMOTE_ADDR'];

	// generate temporary id if needed
	if (empty($sId)) {
		$_SESSION['id'] = makeTempUserId();
		$sId = $_SESSION['id'];
	}

	// verify user exists with given id and validate sentinel id that corresponds to this professor (no recreating chat with wrong person)
	if (/*!idExists($pId) ||*/ !isProfSentinel($sentinel, $pId)) {
		header('Location: ../find');
	}

	// returns array with ["fname", "lname"]
	function getProfName($pId) {
		$query = "SELECT fname, lname FROM users WHERE id='$pId'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		return $resultAr;
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Odetta</title>
		<link type="text/css" rel="stylesheet" href="../css/reset.css">
		<link type="text/css" rel="stylesheet" href="../css/style.css">
		<link type="text/css" rel="stylesheet" href="../css/sharedChat.css">
		<link type="image/icon" rel="icon" href="../img/favicon.ico">
		<link type="text/css" rel="stylesheet" href="css/chat.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/chat.js"></script>
	</head>

	<body>
		<h2 id="name">
			<?php 
				$n = getProfName($pId); 
				echo $n["fname"]." ".$n["lname"]; 
			?>
		</h2>

		<?php 
			echo "<div class='flex'>";
				buildLongCard("Leave Chat", "chatEnd()");
			echo "</div>";
			// if student has not given their name (name popup)
			if (empty($name)) {
				echo '
					<div id="sheet">
						<input type="hidden" id="c" value="'.$sentinel.'" />
						<input type="hidden" id="p" value="'.$pId.'" />
						<input type="hidden" id="sId" value="'.$sId.'" />
						<input type="hidden" id="ip" value="'.$ip.'">

						<input type="text" autocomplete="off" maxlength="50" id="nameInp" spellcheck="false" placeholder="Your Name" tabindex="-1" autofocus />
						<input type="button" onclick="setStuName()" value="Join Chat" />
					</div>';
			}
		?>
		
		<ul id="convo">
			<div id="messages"></div>
		</ul>
		<?php 
			if (!empty($name)) {
				echo '
					<form onsubmit="send()">
						<input type="hidden" name="c" id="c" value="'.$sentinel.'" />
						<input type="hidden" name="p" id="p" value="'.$pId.'" />
						<input type="hidden" id="sId" value="'.$sId.'">

						<input autocomplete="off" type="text" id="chatInp" maxlength="500" tabindex="-1" placeholder="Message" autofocus></input>
						<button id="sendButt"/>
					</form>
				';
			}
		?>
	</body>
</html>