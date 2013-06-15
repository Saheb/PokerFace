<?php

$server_id = $_GET['idOfSer'];
$accepted = $_GET['acc'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$server_id;

if($accepted == 0){
	$result = mysqli_query($con, "SELECT Cards FROM my_db.$Game WHERE ID=$server_id");
	while($row=mysqli_fetch_array($result)){
		$card = $row['Cards'];
	}
	$card++;
	mysqli_query($con, "UPDATE my_db.$Game SET Cards=$card WHERE ID=$server_id");

	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$id");		
	}
	mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$id");		
}

if($accepted == 1){
	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$id");		
	}

	$result = mysqli_query($con, "SELECT Cards FROM my_db.$Game WHERE ID=$id");
	while($row=mysqli_fetch_array($result)){
		$card = $row['Cards'];
	}
	$card++;
	mysqli_query($con, "UPDATE my_db.$Game SET Cards=$card WHERE ID=$id");

	mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$server_id");			
}


mysqli_query($con, "UPDATE my_db.servers SET Hand='High Card' WHERE ID=$server_id");
mysqli_query($con, "UPDATE my_db.servers SET Suit='NA' WHERE ID=$server_id");
mysqli_query($con, "UPDATE my_db.servers SET Card1='2' WHERE ID=$server_id");
mysqli_query($con, "UPDATE my_db.servers SET Card2='NA' WHERE ID=$server_id");
mysqli_query($con, "UPDATE my_db.servers SET No_Of_Cards='NA' WHERE ID=$server_id");

?>