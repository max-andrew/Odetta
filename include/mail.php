<?php
	require 'dbconn.php';

	$to = $_POST["to"];
	$message = $_POST["message"];
	$id = $_POST["id"];

	$subject = "Join Chat";

	// add cookie key verification
	// $query = "SELECT (cookieKey) FROM users WHERE id='$id'";

	$link = "http://odetta.co/chat/index.php?p=".$id;

	// get professor's email address
	$query = "SELECT email FROM users WHERE id='$id'";

	$dbc = connect_to_db();
	$result = perform_query($dbc, $query);
	// save as array of values
	$resultAr = $result->fetch_assoc();
	disconnect_from_db($dbc, $result);

	$email = $resultAr["email"];

	$html_message = "
	<html>
		<head>
			<title>".$subject."</title>
			<style>
				* {
					background: #F7E8C1;
				}
				h1 {
					font-weight: 500;
					font-size: 3em;
					letter-spacing: .33em;
				}
				h1 a {
					text-decoration: none;
				}
				p {
					font-weight: 400;
				    font-size: 1.25em;
				}
				body, h1, p, a {
					font-family: 'Avenir Next', 'Avant Garde', Arial, sans-serif;
					color: #04061B;
				}
			</style>
		</head>
		<body>
			<center><h1><a href='http://odetta.co' style='text-decoration: none; color: #04061B;'>ODETTA</a></h1></center>
			<p>
				".$message."
				<br>
				<br>
				<a href='".$link."' style='color: #04061B;'>Join office hours</a>
			</p>
		</body>
	</html>
	";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: ' . $email . "\r\n";

	mail($to, $subject, $html_message, $headers);
?>