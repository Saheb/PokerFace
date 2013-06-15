<?php
    
    //ignore_user_abort(true);
    //set_time_limit(0);

    $id = $_GET['ID'];
    $idServe = $_GET['IDServer'];

    $con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $Game = 'Game'.''.$idServe;
    $cards = array();
    $result = mysqli_query($con, "SELECT Cards FROM my_db.$Game WHERE ID = $id"); 
    while($row=mysqli_fetch_array($result))
    {
        $no_of_cards = $row['Cards'];
    }


    for($i=1; $i<=$no_of_cards; $i++)
    {
        $updat = "Card".''."$i";
        $result = mysqli_query($con, "SELECT $updat FROM my_db.$Game WHERE ID = $id");
        while($row=mysqli_fetch_array($result))
        {
            $card_no = $row[$updat];
        }
        array_push($cards, $card_no);
    }

    echo $cards[0];


    //$name = mysqli_query($con, "SELECT Name from my_db.players WHERE ID=$id");
    /**while(1)
    {
        // Did the connection fail?
        if(connection_status() != CONNECTION_NORMAL)
        {

            break;
        }
        // Sleep for 10 seconds
        sleep(10);
    }*/


?>
<META HTTP-EQUIV="Refresh" CONTENT="URL=../table.php">
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<!-- Load the Paper.js library -->
<script type="text/javascript" src="paper.js/lib/paper.js"></script>
<!-- Define inlined JavaScript -->
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/bootstrap-responsive.css" rel="stylesheet">
 <script>
 $(document).ready(function(){

    var array_of_cards = <?php echo json_encode($cards);?>;
    $('#chat').html(array_of_cards[0]);

  $("#bet").click(function(event)
  {
    var current_bet = new Object();
    var radios = document.getElementsByName("Hand");
    for (var i = 0; i < radios.length; i++) {       
        if (radios[i].checked) {
            current_bet.Hand = radios[i].value;
            break;
        }
    }
    current_bet.Suit = document.getElementById('suit').value;
    current_bet.Card1 = document.getElementById('card1').value;
    current_bet.Card2 = document.getElementById('card2').value;
    current_bet.NumberOfCards = document.getElementById('numofcards').value;
    //document.write(current_bet.Hand);
    });
  });
 </script>

<script>

var id = <?php echo $idServe?>;
    
$(document).ready(function(){
   new get_bet(); 
 });

function get_bet(){
    var feedback = $.ajax({
        type: "GET",
        url: "getbet.php",
        data : {server:String(id)},
        async: false
    }).success(function(){
        setTimeout(function(){get_bet();}, 1000);
    }).responseText;

    var g = $.parseJSON(feedback);
    //document.getElementById('last_bet_static').innerHTML = "";
    document.getElementById('lastbet_hand').innerHTML = String(g[0]);
    document.getElementById('lastbet_suit').innerHTML = String(g[1]);
    document.getElementById('lastbet_card1').innerHTML = String(g[2]);
    document.getElementById('lastbet_card2').innerHTML = String(g[3]);
    document.getElementById('lastbet_numofcards').innerHTML = String(g[4]);

    //$('#chat').html(feedback);
}

</script>


<script>

$(document).ready(function(){

        function change_bet(handn, suitn, card1n, card2n, no_of_cardsn)
        {
            var server_id = <?php echo $idServe;?>;
            //$('#chat').html(handn);
            var feedback = $.ajax({
            type: "POST",
            url: "changebet.php",
            data : {hand:String(handn), suit:String(suitn), card1:String(card1n), card2:String(card2n), no_of_cards:String(no_of_cardsn), ser:String(server_id)},
            async: false
            }).responseText;
            //$('#chat').html("nan");
            $('#chat').html(feedback);
        }
        
        $("#bet").click(function(event)
          {
            var current_bet = new Object();
            var radios = document.getElementsByName("Hand");
            for (var i = 0; i < radios.length; i++) {       
                if (radios[i].checked) {
                    current_bet.Hand = radios[i].value;
                    break;
                }
            }
            current_bet.Suit = document.getElementById('suit').value;
            current_bet.Card1 = document.getElementById('card1').value;
            current_bet.Card2 = document.getElementById('card2').value;
            current_bet.NumberOfCards = document.getElementById('numofcards').value;

            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;

            if(compare(current_bet,last_bet))
                {
                    change_bet(current_bet.Hand, current_bet.Suit, current_bet.Card1, current_bet.Card2, current_bet.NumberOfCards);
                    document.getElementById('lastbet_hand').innerHTML = current_bet.Hand;
                    document.getElementById('lastbet_suit').innerHTML = current_bet.Suit;
                    document.getElementById('lastbet_card1').innerHTML = current_bet.Card1;
                    document.getElementById('lastbet_card2').innerHTML = current_bet.Card2;
                    document.getElementById('lastbet_numofcards').innerHTML = current_bet.NumberOfCards;
                }
            else
                alert('You need to bet higher than last bet!');
        });

        $('#challenge').click(function(event){
            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;
            document.write(challenge_accepted(last_bet,total_hand,card_count,suit_count));
        });
});

</script>


</head>
<body>
	<?php 
    $num_of_players_php = $_POST["players"];
	//echo $num_of_players_php;
	?>
    <div class="row-fluid">
        <br><br>
    <div class="span2 offset1" id="hand">
        <div class="row">
            <input type="radio" value="Straight Flush" name="Hand" id="rf"/> Straight Flush <br/>
            <input type="radio" value="Four of a Kind" name="Hand" id="fk"/> Four of a Kind <br/>
            <input type="radio" value="Full House" name="Hand" id="fh"/> Full House  <br/>
            <input type="radio" value="Flush" name="Hand" id="flush"/> Flush <br/>
            <input type="radio" value="Straight" name="Hand" id="st"/> Straight <br/>
            <input type="radio" value="Three of a Kind" name="Hand" id="trio"/> Trio <br/>
            <input type="radio" value="Two Pairs" name="Hand" id="tp"/> Two Pairs <br/>
            <input type="radio" value="High Card" name="Hand" id="hc"/> High Card <br/>
        </div>
        <br>
        <br>
        <div class="row">
            <h2>Current Bet </h2>
            Suit:<br>
            <select id="suit">
                <option value="Spades">Spades</option>
                <option value="Diamonds">Diamonds</option>
                <option value="Clubs">Clubs</option>
                <option value="Hearts">Hearts</option>
            </select>
            <br><br>
            Card 1:<br>
            <select id="card1">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="Jack">Jack</option>
                <option value="Queen">Queen</option>
                <option value="King">King</option>
                <option value="Ace">Ace</option>
            </select>
            <br><br>
            Card 2:<br>
            <select id="card2">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="Jack">Jack</option>
                <option value="Queen">Queen</option>
                <option value="King">King</option>
                <option value="Ace">Ace</option>
            </select>
            <br><br>
            Number of Cards:<br>
            <select id="numofcards">
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>    
            <br>
            <a class="btn btn-large btn-success" id="bet"> Bet </a>
            <a class="btn btn-large btn-success" id="challenge"> Challenge </a>
        </div>
    </div>
        <div class="span6" id="table" style="width:500px; height:500px;">
            <Iframe src="http://127.0.0.1/PokerFace/table.php" width="725px" height="750px" scrolling="no"></Iframe>
        </div>
        <div class="span2 offset2">
            <div class="span2 offset2">
            <div class=""row id="last_bet_static">
                <h2>Last Bet</h2>
                    <p id="lastbet_hand">High Card</p>
                    <p id="lastbet_suit">NA</p>
                    <p id="lastbet_card1">King</p>
                    <p id="lastbet_card2">NA</p>
                    <p id="lastbet_numofcards">NA</p>
            </div>
            <div class="row">
            <h2>Chat Window</h2>
            <div id="chat">
            </div>
            </div>
        </div>
    </div>
</body>
</html>
