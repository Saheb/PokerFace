<?php

$idP = $_POST['per'];
$idS = $_POST['ser'];
$Game = 'Game'.''.$idS;


$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
 {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 //mysqli_query($con, "UPDATE my_db.$Game SET $updat=$card WHERE ID=$idP");

 $out = array();
$result =  mysqli_query($con, "SELECT Cards FROM my_db.$Game WHERE ID = $idP"); 
while($row=mysqli_fetch_array($result))
{
    $no_of_cards = $row['Cards'];
}

for($i=1; $i<=$no_of_cards; $i++)
    {
        $updat = "Card".''."$i";
        $result = mysqli_query($con, "SELECT $updat FROM my_db.$Game WHERE ID = $idP");
        while($row=mysqli_fetch_array($result))
        {
            $card_no = $row[$updat];
        }
        array_push($out, $card_no);
    }

   echo json_encode($out);

?>