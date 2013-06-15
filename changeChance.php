<?php

$idserver = $_GET['idOfSer'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Game = 'Game'.''.$idserver;

mysqli_query($con, "UPDATE my_db.$Game SET Chance=0 WHERE ID=$idserver");

$prev = 0;
$result = mysqli_query($con, "SELECT * FROM my_db.$Game");
while($row=mysqli_fetch_array($result)){
	$id = $row['ID'];
	if($prev == 1){
		mysqli_query($con, "UPDATE my_db.$Game SET Chance=1 WHERE ID=$id");		
		break;
	}
	if($id == $idserver){
		$prev = 1;
	}
}

//echo $id_server;

//$i=10;
//echo $i;

?>