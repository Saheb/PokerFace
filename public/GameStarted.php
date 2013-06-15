<?php

$id = $_GET['neel'];


$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT Start FROM my_db.servers Where ID=$id");
while($row=mysqli_fetch_array($result))
{
	$start = $row['Start'];
}
echo $start;

?>