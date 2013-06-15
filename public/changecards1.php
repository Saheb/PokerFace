<?php

$server_id = $_GET['idOfSer'];
$accepted = $_GET['acc'];
$player_id = $_GET['idOfPlay'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$server_id;

if($accepted == 0){
	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		if($id == $player_id){
			$card = $row['Cards'];
			break;
		}
		else{
			$prevID = $id;
		}
	}
	$card++;
	mysqli_query($con, "UPDATE my_db.$Game SET Cards=$card WHERE ID=$player_id");

	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$id");		
	}
	mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$prevID");		
}

else{
	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		if($id == $player_id){
			break;
		}
		else{
			$card = $row['Cards'];
			$prevID = $id;
		}
	}
	$card++;
	mysqli_query($con, "UPDATE my_db.$Game SET Cards=$card WHERE ID=$prevID");

	$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
	while($row=mysqli_fetch_array($result)){
		$id = $row['ID'];
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$id");		
	}
	mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$player_id");			
}

?>