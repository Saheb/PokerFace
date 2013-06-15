<?php

$idP = $_POST['idPlayer'];
$cards = $_POST['car'];
$idS = $_POST['idServer'];
$Game = 'Game'.''.$idS;

 $con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
 {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

for ($i=1; $i<=count($cards) ; $i++) { 
$updat = "Card".''."$i";
$card = $cards[$i-1];
mysqli_query($con, "UPDATE my_db.$Game SET $updat=$card WHERE ID=$idP");
}

mysqli_query($con, "UPDATE my_db.servers SET Hand='High Card' WHERE ID=$idS");
mysqli_query($con, "UPDATE my_db.servers SET Suit='NA' WHERE ID=$idS");
mysqli_query($con, "UPDATE my_db.servers SET Card1='2' WHERE ID=$idS");
mysqli_query($con, "UPDATE my_db.servers SET Card2='NA' WHERE ID=$idS");
mysqli_query($con, "UPDATE my_db.servers SET No_Of_Cards='NA' WHERE ID=$idS");


?>

