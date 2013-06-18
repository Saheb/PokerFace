<?php
    
    //ignore_user_abort(true);
    //set_time_limit(0);

    $id = $_GET['ID'];
    $players = $_GET['players'];
    $idServe = $_GET['IDServer'];

    $con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con, "UPDATE my_db.servers SET Players=$players WHERE ID=$id");
    //$name = mysqli_query($con, "SELECT Name from my_db.players WHERE ID=$id");
    $nam = 'Game'.''.$id;
    //echo $nam;

    mysqli_query($con,'
        CREATE TABLE '.$nam.' 
        (
            ID  int PRIMARY KEY,
            Name char(30),
            Cards int,
            Position int,
            Admin int,
            Chance int,
            Card1 int,
            Card2 int,
            Card3 int,
            Card4 int,
            Card5 int,
            Card6 int,
            Card7 int,
            Card8 int
        );
    ');

    $result = mysqli_query($con, "SELECT * FROM my_db.players WHERE Group_ID=$id");
    $gamers = array();
    $i=1;
    while($row=mysqli_fetch_array($result))
    {
        array_push($gamers, $row['ID']);
        $idf = $row['ID'];
        $na = $row['Name'];
        mysqli_query($con, "INSERT INTO my_db.$nam (ID, Name, Cards, Position, Admin, Chance)
            VALUES ($idf, '$na', 2, $i, 1, 0)");
        $i++;
    }

    mysqli_query($con, "UPDATE my_db.servers SET Start=1 WHERE ID=$idServe");

    mysqli_query($con, "UPDATE my_db.servers SET Hand='High Card' WHERE ID=$idServe");
    mysqli_query($con, "UPDATE my_db.servers SET Suit='NA' WHERE ID=$idServe");
    mysqli_query($con, "UPDATE my_db.servers SET Card1='2' WHERE ID=$idServe");
    mysqli_query($con, "UPDATE my_db.servers SET Card2='NA' WHERE ID=$idServe");
    mysqli_query($con, "UPDATE my_db.servers SET No_Of_Cards='NA' WHERE ID=$idServe");

    mysqli_query($con, "UPDATE my_db.$nam SET Chance=1 WHERE ID=$idServe");


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

<META HTTP-EQUIV="Refresh" CONTENT="URL=saheb/table.php">
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<script type="text/javascript" src="paper.js/lib/paper.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
 <link href="css/bootstrap.css" rel="stylesheet">
 <link href="css/bootstrap-responsive.css" rel="stylesheet">
 <script type="text/javascript" src="saheb/Cards/playingCards.js"></script>
<script type="text/javascript" src="saheb/Cards/playingCards.ui.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="saheb/Cards/playingCards.ui.css"/>
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
                //document.write(card_score[String(last_bet.Card1)]);
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

$(document).ready(function(){
   new get_chance(); 
 });

function get_chance(){
    var feedback = $.ajax({
        type: "GET",
        url: "checkMyChance.php",
        data : {server:String(id_server)},
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

function get_bet(){
    var feedback = $.ajax({
        type: "GET",
        url: "getBet.php",
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
                function convert(hand)
        {
            //document.write(hand[0]);
            var hand_value = [];
            for (var i = 0; i < hand.length; i++) {
                hand_value[i] = hand[i].card_value; 
            }
            return hand_value;
        }
        function updateCards(id_of_player, id_of_server, cards){
            //document.write("hello");
            $('#chat').html("hellooooo");
           var feedback = $.ajax({
                type: "POST",
                url: "changeCards.php",
                data : {idPlayer:String(id_of_player), car:cards, idServer:String(id_of_server)}, 
                async: false
            }).responseText;

            $('#chat').html(feedback);
        }  

        function deal(number_of_players,dealer,player_cards){

            $('#chat').html("hellooooo");
            var name_g = <?php echo $id;?>;
            name_g = "Game" + name_g;

            //document.write(name_g);
            var cardDeck = $("#cardDeck").playingCards();
            //cardDeck.spread();
            
            var pids = <?php echo json_encode($gamers);?>;
            var server = <?php echo $idServe?>;
            //document.write(pids[0]);
            for (var i = 0; i < number_of_players; i++) {
                var hand = [];
                for (var j = 0; j < player_cards[i]; j++) {
                    var c = cardDeck.draw();
                    hand[hand.length] = c;
                    total_hand[total_hand.length] = c; 
                }
                players[pids[i]] = hand;
                //document.write(players[pid[i]]);
                var hands_int = convert(players[pids[i]]);
                //document.write(hands_int[0]);
               updateCards(pids[i], server, hands_int);
            }
        }    

         



           
            function showHand(myhand){

                //document.write(suit_count['S']);
                var el = $('#yourHand')
                el.html('');
                for(var i=0;i<myhand.length;i++){
                    //document.write(myhand.length);
                    el.append(myhand[i].getHTML());

                }
                el.append(myhand[0].card_value);
                //el.append(suit_count['S']);
                //el.append(card_count['K']);
            }
            //showHand(total_hand);
            var doShuffle = function(){
                cardDeck.shuffle();
                //cardDeck.spread(); // update card table
            };
            function doDrawCard() {
                var c = cardDeck.draw();
                if(!c){
                    showError('no more cards');
                    return;
                }
                hand[hand.length] = c;
                total_hand[total_hand.length] = c;
                //cardDeck.spread();
                //showHand();
            }
           
            
            function addtoHand(){
                doShuffle();
                doDrawCard();
            }

            function get_numofcards(){
                var server_id = <?php echo $idServe;?>;
                var feedback = $.ajax({
                type: "GET",
                url: "checkMyNumofcards.php",
                data : {server:String(server_id)},
                async: false
            }).responseText;

            var cards_num = $.parseJSON(feedback);
            //document.write(cards_num);
            return cards_num;
            }
            
            //document.write(get_numofcards());
            deal(3,2,get_numofcards());
            
           for (var i = 0; i < total_hand.length; i++) {
                suit_count[total_hand[i].suit] +=1;
                card_count[total_hand[i].rank] +=1;
            };
        card_count['Ace'] = card_count['A'];
        card_count['King'] = card_count['K'];
        card_count['Queen'] = card_count['Q'];
        card_count['Jack'] = card_count['J'];
        suit_count['Spades'] = suit_count['S'];
        suit_count['Hearts'] = suit_count['H'];
        suit_count['Clubs'] = suit_count['C'];
        suit_count['Diamonds'] = suit_count['D'];
        $("#cards").click(function(event){
          

            //var NumberOfCards = 8;
            //for (var i = NumberOfCards - 1; i >= 0; i--) {
            //    addtoHand();
            //}
            
            
            showHand(players[<?php echo $id?>]);
       });

        function change_bet(handn, suitn, card1n, card2n, no_of_cardsn)
        {
            var server_id = <?php echo $idServe;?>;
            //$('#chat').html(handn);
            var feedback = $.ajax({
            type: "POST",
            url: "changeBet.php",
            data : {hand:String(handn), suit:String(suitn), card1:String(card1n), card2:String(card2n), no_of_cards:String(no_of_cardsn), ser:String(server_id)},
            async: false
            }).responseText;
            //$('#chat').html("nan");
            $('#chat').html(feedback);
        }

        function change_chance(){
            var server_id = <?php echo $idServe;?>;
           // $('#chat').html(server_id);
            var feedback = $.ajax({
            type: "GET",
            url: "changeChance.php",
            data : {idOfSer:String(server_id)},
            async: false
            }).responseText;

            //$('#chat').html(feedback);
        }

        function change_cards(accepted){
            var server_id = <?php echo $idServe;?>;
            //$('#chat').html(server_id);
            var feedback = $.ajax({
            type: "GET",
            url: "changeCards1.php",
            data : {idOfSer:String(server_id), acc:String(accepted)},
            async: false
            }).responseText;
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
            //document.write(last_bet.Card1);
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

        $('#challenge').click(function(event){
            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;
            var accepted;
            if(challenge_accepted(last_bet,total_hand,card_count,suit_count)){
                accepted = 0;
                alert('Challenge has been lost');
            }
            else{
                accepted = 1;
                alert('Challenge has been won');
            }
            change_cards(accepted);
            deal(3,2,get_numofcards());
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
	    <br>
            <input type="radio" value="Straight Flush" name="Hand" id="rf"/> Straight Flush <br/>
            <input type="radio" value="Four of a Kind" name="Hand" id="fk"/> Four of a Kind <br/>
            <input type="radio" value="Full House" name="Hand" id="fh"/> Full House  <br/>
            <input type="radio" value="Flush" name="Hand" id="flush"/> Flush <br/>
            <input type="radio" value="Straight" name="Hand" id="st"/> Straight <br/>
            <input type="radio" value="Three of a Kind" name="Hand" id="trio"/> Trio <br/>
            <input type="radio" value="Two Pairs" name="Hand" id="tp"/> Two Pairs <br/>
	    <input type="radio" value="Pair" name="Hand" id="p"/> Pair <br/>
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
            <Iframe src="table.php" width="725px" height="700px" scrolling="no"></Iframe>
        </div>
        <div class="span2 offset2">
            <div class=""row id="last_bet_static">
                <h2>Last Bet</h2>
                    <p id="lastbet_hand">High Card</p>
                    <p id="lastbet_suit">NA</p>
                    <p id="lastbet_card1">5</p>
                    <p id="lastbet_card2">NA</p>
                    <p id="lastbet_numofcards">NA</p>
            </div>
            <div class="row">
            <h2>Chat Window</h2>
            <div id="chat">
                <p></p>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
