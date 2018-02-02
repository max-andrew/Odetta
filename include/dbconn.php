<?php
  function connect_to_db() {
      $user = "max";
      $key = "GGsmjXqxHNDKAsPj";
      $dbname = "odetta";
      
    	$dbc = new mysqli("localhost", $user, $key, $dbname);
    	if ($dbc->connect_errno) {
      	echo "Failed to connect to MySQL: (" . $dbc->connect_errno . ") " . $dbc->connect_error;
      	exit(1);
    	}
    	return $dbc;
  }

  function disconnect_from_db($dbc, $result) {
      if (gettype($result)==="object") mysqli_free_result($result);
      	mysqli_close($dbc);
  }

  function perform_query($dbc, $query) {
  	$result = mysqli_query($dbc, $query) or 
  			die("bad query".mysqli_error($dbc));
  	return $result;
  }
?>