<?php

$hand = $_POST['hand'];
$suit = $_POST['suit'];
$Card1 = $_POST['card1'];
$Card2 = $_POST['card2'];
$no_of_cards = $_POST['no_of_cards'];
$server = $_POST['ser'];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con, "UPDATE my_db.servers SET Hand='$hand' WHERE ID=$server");
mysqli_query($con, "UPDATE my_db.servers SET Suit='$suit' WHERE ID=$server");
mysqli_query($con, "UPDATE my_db.servers SET Card1='$Card1' WHERE ID=$server");
mysqli_query($con, "UPDATE my_db.servers SET Card2='$Card2' WHERE ID=$server");
mysqli_query($con, "UPDATE my_db.servers SET No_Of_Cards='$no_of_cards' WHERE ID=$server");
//$name = mysqli_query($con, "SELECT Name FROM my_db.servers WHERE ID=$server");
//echo $name;
?>