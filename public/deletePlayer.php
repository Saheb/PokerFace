<?php

$id = $_GET['neel'];


$time = time();
$current_time = $time;
while (1) {
	if ($current_time - $time > 1) {

		$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
		// Check connection
		if (mysqli_connect_errno($con))
		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_query($con, "DELETE FROM my_db.players WHERE ID=$id");

		break;
	} else {
		$current_time = time();
	}
	
}

?>