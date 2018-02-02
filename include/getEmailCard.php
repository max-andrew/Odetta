<?php
	require_once '../include/buildEmailCard.php';

	$to = $_POST["to"];
	$message = $_POST["message"];

	echo buildEmailCard($to, $message);
?>