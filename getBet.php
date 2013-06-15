<?php

$id = $_GET['server'];


$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$out = array();
$result = mysqli_query($con, "SELECT * FROM my_db.servers WHERE ID=$id");
while($row=mysqli_fetch_array($result))
{
	$hand = $row['Hand'];
	array_push($out, $hand);
	$suit = $row['Suit'];
	array_push($out, $suit);
	$card1 = $row['Card1'];
	array_push($out, $card1);
	$card2 = $row['Card2'];
	array_push($out, $card2);
	$no_of_cards = $row['No_Of_Cards'];
	array_push($out, $no_of_cards);
}

echo json_encode($out);

?>