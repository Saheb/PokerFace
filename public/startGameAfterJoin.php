<?php
    
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
?>
<META HTTP-EQUIV="Refresh" CONTENT="URL=/saheb/table.php">
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<script type="text/javascript" src="paper.js/lib/paper.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/bootstrap-responsive.css" rel="stylesheet">
 <script type="text/javascript" src="../saheb/Cards/playingCards.js"></script>
<script type="text/javascript" src="../saheb/Cards/playingCards.ui.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../saheb/Cards/playingCards.ui.css"/>
<script type="text/javascript">
       var hand_score = {
        "Royal Flush"    :  10,
        "Straight Flush" :  9,
        "Four of a Kind"    :  8,
        "Full House"     :  7,
        "Flush"          :  6,
        "Three of a Kind"    :  4,
        "Straight"        :  5,
        "Two Pairs"        :  3,
        "Pairs"           :  2,
        "High Card"      :  1,
        "NA"            :0
        };
        var card_score = {
            "Ace"   : 14,
            "King"  : 13,
            "Queen" : 12,
            "Jack"  : 11,
            "10"    : 10,
            "9"     : 9,
            "8"     : 8,
            "7"     : 7,
            "6"     : 6,
            "5"     : 5,
            "4"     : 4,
            "3"     : 3,
            "2"     : 2,
            "NA"    :0
        };
        var suit_score = {
            "Spades"   : 4,
            "Diamonds" : 3,
            "Clubs"    : 2,
            "Hearts"   : 1,
            "NA"        : 0 
        };

    function compare(current_bet,last_bet)
    {
        if(hand_score[current_bet.Hand] > hand_score[last_bet.Hand])
            return true;
        else if (hand_score[current_bet.Hand] == hand_score[last_bet.Hand])
        {
            if (current_bet.Hand=="Full House" || current_bet.Hand =="Two Pairs") 
            {
                if(card_score[current_bet.Card1] > card_score[last_bet.Card1])
                    return true;
                else if(current_bet.Card1 == current_bet.Card1)
                        {
                            if(card_score[current_bet.Card2] > card_score[last_bet.Card2])
                                return true;
                            else 
                                return false;
                        }
                 else
                    return false;       
            }
            else if (current_bet.Hand=="Flush" || current_bet.Hand=="Straight Flush" || current_bet.Hand=="Royal Flush")
            {
                if(current_bet.NumberOfCards > last_bet.NumberOfCards)
                    return true;
                else if(current_bet.NumberOfCards==last_bet.NumberOfCards)
                {
                    if(suit_score[current_bet.Suit] > suit_score[last_bet.Suit])
                        return true;
                    else if (current_bet.Suit == last_bet.Suit) 
                        {
                            if(card_score[current_bet.Card1] > card_score[last_bet.Card1])
                                return true;
                            else
                                return false;
                        }
                    else
                        return false;
                }
                else
                    return false;
            }
            else if(current_bet.Hand=="Four of a Kind" || current_bet.Hand=="Pair" || current_bet.Hand=="Three of a Kind")
            {
                if(card_score[current_bet.Card1] > card_score[last_bet.Card1])
                    return true;
                else
                    return false;
            }
            else
            {
                if(card_score[current_bet.Card1] > card_score[last_bet.Card1])
                    return true;
                else
                    return false;
            }
        }
        else
            return false;
    }
    function challenge_accepted(last_bet,total_hand,card_count,suit_count)
    {
        if(last_bet.Hand=="Four of a Kind")
        {
            if(card_count[last_bet.Card1]==4)
                return true;
            else 
                return false;
        }
        else if(last_bet.Hand=="Three of a Kind")
        {
            if(card_count[last_bet.Card1]>=3)
                return true;
            else 
                return false;
        }
        else if (last_bet.Hand=="Pairs")
        {
            if(card_count[last_bet.Card1]>=2)
                return true;
            else 
                return false;   
        }
        else if (last_bet.Hand=="Two Pairs")
        {
            if(card_count[last_bet.Card1]>=2 && card_count[last_bet.Card2]>=2)
                return true;
            else
                return false;
        }
        else if (last_bet.Hand=="Full House")
        {
            if(card_count[last_bet.Card1] >=3 && card_count[last_bet.Card2]>=2)
                return true;
            else
                return false;
        }
        else if (last_bet.Hand=="Flush")
        {
            if(card_count[last_bet.Card1]>=1)
            { 
                if(suit_count[last_bet.Suit]>=last_bet.NumberOfCards)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
        else if (last_bet.Hand=="High Card")
        {
            if(card_count[last_bet.Card1]>=1)
                return true;
            else 
                return false;
        }
        else if (last_bet.Hand=="Straight")
        {
            var flag=0;
            if(card_count[last_bet.Card1]>=1)
            {
                for (var i = last_bet.Card1+1; i < last_bet.Card1 + 4; i++) {
                    if(card_count[i]<1)
                        flag==1;
                 }
                for (var i = last_bet.Card1-4; i < last_bet.Card1; i++) {
                    if(card_count[i]<1)
                        flag==1;
                }
                 if(flag)
                    return false;
                else 
                    return true; 
                
            }
            else 
                return false;
        }
        else if(last_bet.Hand="Straight Flush")
        {
            
        }
    }

</script>

<script>
var id_server = <?php echo $idServe;?>;
var id_player = <?php echo $id?>;

$(document).ready(function(){
   new get_chance(); 
 });

function get_chance(){
    var feedback = $.ajax({
        type: "GET",
        url: "checkMychance.php",
        data : {server:String(id_server), player:String(id_player)},
        async: false
    }).success(function(){
        setTimeout(function(){get_chance();}, 1000);
    }).responseText;

    if(feedback == 1){
        document.getElementById('bet').style.visibility = 'visible';
        document.getElementById('challenge').style.visibility = 'visible';
    } else {
        document.getElementById('bet').style.visibility = 'hidden';
        document.getElementById('challenge').style.visibility = 'hidden';
    }
}

</script>

<script>

var id = <?php echo $idServe?>;
    
$(document).ready(function(){
   new get_bet(); 
 });

function get_bet()
{
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
$(document).ready(function()
{
        
        var total_hand = [];
        var last_bet = new Object();
            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;
        var suit_count = new Object();
                suit_count['S'] = 0;
                suit_count['D'] = 0;
                suit_count['C'] = 0;
                suit_count['H'] = 0;
        var card_count = new Object();
                card_count['A'] = 0;
                card_count['K'] = 0;
                card_count['Q'] = 0;
                card_count['J'] = 0;
                card_count['10'] = 0;
                card_count['9'] = 0;
                card_count['8'] = 0;
                card_count['7'] = 0;
                card_count['6'] = 0;
                card_count['5'] = 0;
                card_count['4'] = 0;
                card_count['3'] = 0;
                card_count['2'] = 0;
                card_count['1'] = 0;
                var players = new Array();
        
        function convert2value(hand)
        {
            var hand_value = [];
            for (var i = 0; i < hand.length; i++) {
                hand_value[i] = hand[i].card_value; 
            }
            return hand_value;
        }

        function convert2hand(int_hand)
        {
            //document.write(int_hand[0]);
            var conv1 = {
            "2": "2",
            "3": "3",
            "4": "4",
            "5": "5",
            "6": "6",
            "7": "7",
            "8": "8",
            "9": "9",
            "10": "10",
            "11": "J",
            "12": "Q",
            "0": "K",
            "1": "A"
        };
            var conv3 = {
            "1": "S",
            "2": "D",
            "3": "C",
            "4": "H"
        };
            var conv2 = {
            "1": "Spades",
            "2": "Diamonds",
            "3": "Clubs",
            "4": "Hearts"
        };
            var conv4 = {
            "2": "Two",
            "3": "Three",
            "4": "Four",
            "5": "Five",
            "6": "Six",
            "7": "Seven",
            "8": "Eight",
            "9": "Nine",
            "10": "Ten",
            "11": "Jack",
            "12": "Queen",
            "0": "King",
            "1": "Ace"
        };
            var myhand =[];
            for (var i = 0; i < int_hand.length; i++) {
               var card = new Object();
               card.rank = conv1[String(int_hand[i]%13)];
               card.suit = conv3[String(parseInt(int_hand[i]/13)+1)];
               card.suitString = conv2[String(parseInt(int_hand[i]/13)+1)];
               card.rankString = conv4[String(int_hand[i]%13)];
               var temp_card = new playingCards.card(card.rank,card.rankString,card.suit,card.suitString);
               //document.write(temp_card);
               myhand[i]=temp_card;
            }
            //document.write(myhand);
            return myhand;
    }//convert2hand ends here
            
        function showHand(myhand)
        {

                //document.write(suit_count['S']);
                var el = $('#yourHand');
                el.html('');
                for(var i=0;i<myhand.length;i++){
                    //document.write(myhand.length);
                    el.append(myhand[i].getHTML());

                }
                //el.append(myhand[0].card_value);
                //el.append(suit_count['S']);
                //el.append(card_count['K']);
        }
            //showHand(total_hand);
            
        $("#cards").click(function(event)
        {

            var cards_id = <?php echo json_encode($cards);?>;
            
            var hand_id = convert2hand(cards_id);

            showHand(hand_id);
        });

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
        
        function change_chance(){
            var server_id = <?php echo $idServe;?>;
            var player_id = <?php echo $id;?>;
            //$('#chat').html(server_id);
            var feedback = $.ajax({
            type: "GET",
            url: "changechance.php",
            data : {idOfSer:String(server_id), idOfPlay:String(player_id)},
            async: false
            }).responseText;

            //$('#chat').html(feedback);
        }

        function change_cards(accepted){
            var server_id = <?php echo $idServe;?>;
            var player_id = <?php echo $id;?>;
            //$('#chat').html(server_id);
            var feedback = $.ajax({
            type: "GET",
            url: "changecards1.php",
            data : {idOfSer:String(server_id), idOfPlay:String(player_id), acc:String(accepted)},
            async: false
            }).responseText;
        }

        $("#bet").click(function(event)
        {
            //document.write("hello");
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
                    change_chance();
                    document.getElementById('bet').style.visibility = 'hidden';
                    document.getElementById('challenge').style.visibility = 'hidden';
                    document.getElementById('lastbet_hand').innerHTML = current_bet.Hand;
                    document.getElementById('lastbet_suit').innerHTML = current_bet.Suit;
                    document.getElementById('lastbet_card1').innerHTML = current_bet.Card1;
                    document.getElementById('lastbet_card2').innerHTML = current_bet.Card2;
                    document.getElementById('lastbet_numofcards').innerHTML = current_bet.NumberOfCards;
                }
            else
                alert('You need to bet higher than last bet!');
        });

        $('#challenge').click(function(event)
        {
            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;
            var accepted;
            if(challenge_accepted(last_bet,total_hand,card_count,suit_count))
            {
                accepted = 0;
                alert('Challenge has been lost');
            }
            else
            {
                accepted = 1;
                alert('Challenge has been won');
            }
            change_cards(accepted);
        });
});
</script>

</head>
<body>
    <?php 
    //$num_of_players_php = $_POST["players"];
    //echo $num_of_players_php;
    ?>
    <div class="row-fluid">
        <br><br>
    <div class="span2 offset1" id="hand">
        <h3>Current Bet </h3>
        <a href="#myModal" role="button" class="btn" data-toggle="modal" id="cards">View Cards</a>
             <!-- Modal -->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <h3 id="myModalLabel">Your Cards</h3>
                  </div>
                  <div class="modal-body">
                        <div id="yourHand"></div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                  </div>
                </div>
                <br>
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
            Suit:<br>
            <select id="suit">
                <option value="NA">Not Applicable</option>
                <option value="Spades">Spades</option>
                <option value="Diamonds">Diamonds</option>
                <option value="Clubs">Clubs</option>
                <option value="Hearts">Hearts</option>
            </select>
            <br><br>
            Card 1:<br>
            <select id="card1">
                <option value="NA">Not Applicable</option>
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
                <option value="NA">Not Applicable</option>
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
                <option value="NA">Not Applicable</option>
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
            <Iframe src="http://127.0.0.1/PokerFace/table.php" width="725px" height="700px" scrolling="no"></Iframe>
        </div>
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
                <p>hello</p>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
