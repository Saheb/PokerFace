<?php

$idServer = $_GET['idOfSer'];
$idPlayer = $_GET['acc'];

 $con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
 {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }


 $Game = 'Game'.''.$idServer;
 $cards = array();

 $result = mysqli_query($con, "SELECT Cards FROM my_db.$Game WHERE ID=$idPlayer");
 while($row=mysqli_fetch_array($result)){
 	$card_no = $row['Cards'];
 }

 for($i=1; $i<=card_no; $i++)
    {
        $updat = "Card".''."$i";
        $result = mysqli_query($con, "SELECT $updat FROM my_db.$Game WHERE ID = $idPlayer");
        while($row=mysqli_fetch_array($result))
        {
            $card_no = $row[$updat];
        }
        array_push($cards, $card_no);
    }

echo json_encode($cards);

?>