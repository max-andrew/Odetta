<?php $email = isset($_GET['e']) ? $_GET['e'] : ""; ?>

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

		<form id="sheet" action="backOp.php" method="post">
			<input type="email" name="email" maxlength="50" id="email" spellcheck="false" autofocus value="<?php echo $email ?>" placeholder="Email">
			<br>

			<input type="password" name="password" maxlength="60" placeholder="Password">
			<br>

			<input type="submit" id="submit" value="Submit"></input>
		</form>
	</div>
</html>