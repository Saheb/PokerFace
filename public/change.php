<?php
$id = $_GET['neel'];


$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT Name FROM my_db.players WHERE Group_ID=$id");
$out = array();
while($row=mysqli_fetch_array($result))
{
	array_push($out, $row['Name']);
}

echo json_encode($out);

?>