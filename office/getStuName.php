<?php
	$id = $_POST["sId"];

	// get student name from student id
	function getStuName($id) {
		$query = "SELECT name FROM students WHERE id='$id'";

		$dbc = connect_to_db();
		$result = perform_query($dbc, $query);
		$resultAr = $result->fetch_assoc();
		disconnect_from_db($dbc, $result);

		// default name student value
		$name = $resultAr["name"];

		if ($name == "") 
			$name = "Student";

		return $name;
	}

	echo getStuName($id);
?>