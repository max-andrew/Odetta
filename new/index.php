<?php
	$fname = isset($_GET['f']) ? $_GET['f'] : "";
	$lname = isset($_GET['l']) ? $_GET['l'] : "";
	$dept = isset($_GET['d']) ? $_GET['d'] : "";
	$email = isset($_GET['e']) ? $_GET['e'] : "";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Odetta</title>
		<link type="text/css" rel="stylesheet" href="../css/reset.css">
		<link type="text/css" rel="stylesheet" href="../css/style.css">
		<link type="image/icon" rel="icon" href="../img/favicon.ico">
		<link type="text/css" rel="stylesheet" href="../css/sheet.css">
	</head>

	<body>
		<div id="header">
			<h1>
				<a href="../office">ODETTA</a>
			</h1>
		</div>

		<form id="sheet" action="newOp.php" method="post">
			<input type="text" name="first" maxlength="35" value="<?php echo $fname ?>" placeholder="First name">
			<input type="text" name="last" maxlength="35" value="<?php echo $lname ?>" placeholder="Last name">
			<br>

			<input type="text" name="dept" maxlength="50" value="<?php echo $dept ?>" placeholder="Department">
			<br>

			<input type="email" name="email" maxlength="50" id="email" spellcheck="false" value="<?php echo $email ?>" placeholder="Email">
			<br>

			<input type="password" name="password" maxlength="60" placeholder="Password">
			<input type="password" name="repeat" maxlength="60" placeholder="Repeat">
			<br>

			<input type="submit" id="submit" value="Register"></input>
		</form>
	</div>
</html>