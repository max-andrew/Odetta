<?php
	$school = $_GET['s'];
	$prof = $_GET['p'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title>Odetta</title>
		<link type="image/icon" rel="icon" href="../img/favicon.ico">
		<link type="text/css" rel="stylesheet" href="../css/reset.css">
		<link type="text/css" rel="stylesheet" href="../css/style.css">
		<link type="text/css" rel="stylesheet" href="css/find.css">
	</head>

	<body>
		<div id="header">
			<h1>
				<a href="../find">ODETTA</a>
			</h1>
		</div>

		<script src="../include/jquery-3.2.1.js" defer></script>
		<script type="text/javascript" src="js/find.js" defer></script>

		<?php if ($prof != "") {
			echo '
				<button class="x_but" onclick="selectSchool()"><img src="../img/x.svg" class="x_img"></button>

				<h3 id="direction">Select room</h3>

				<ul id="deck">';
					require 'buildRoomCard.php';
					require '../include/buildRoomDeck.php';
					buildRoomDeck($prof);
				echo '</ul>
			';
		}
		else if ($school != "") {
			echo '
				<button class="x_but" onclick="selectSchool()"><img src="../img/x.svg" class="x_img"></button>

				<h3 id="direction">Select teacher</h3>

				<form action="../find">
					<ul id="deck">';
						require 'buildTeacherDeck.php';
						buildDeck($school);
					echo '</ul>
				</form>
			';
		}
		else {
			echo '
				<h3 id="direction">Select school</h3>

				<form action="../find">
					<ul id="deck">';
					require 'buildSchoolDeck.php';
				echo '</form>
			';
		} ?>
		<br><br>
	</body>
</html>