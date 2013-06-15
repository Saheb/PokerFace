<?php

$server_id = $_GET['server'];
$player_id = $_GET['player'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$server_id;

$result = mysqli_query($con, "SELECT Chance FROM my_db.$Game WHERE ID=$player_id");
while($row=mysqli_fetch_array($result))
{
    $chance = $row['Chance'];
}

echo $chance;

?>