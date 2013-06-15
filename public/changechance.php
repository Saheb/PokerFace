<?php

$idserver = $_GET['idOfSer'];
$idplayer = $_GET['idOfPlay'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$idserver;

mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$idplayer");

$prev = 0;
$count1 = 0;
$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
while($row=mysqli_fetch_array($result)){
	$id = $row['ID'];
	if($prev == 1){
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$id");		
		break;
	} else {
		$count1++;
	}
	if($id == $idplayer){
		$prev = 1;
	}
}

$count2 = 0;
$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
while($row=mysqli_fetch_array($result)){
	$count2++;
}


if($count2 == $count1){
	mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$idserver");
}
//echo $id_server;

//$i=10;
//echo $i;

?>