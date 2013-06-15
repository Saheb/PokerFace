<?php

$server_id = $_GET['server'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$server_id;

$numofcards = array();
$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
while($row=mysqli_fetch_array($result))
{
    $temp = $row['Cards'];
    array_push($numofcards, $temp);
}

echo json_encode($numofcards);

?>