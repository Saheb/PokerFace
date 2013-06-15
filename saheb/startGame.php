<META HTTP-EQUIV="Refresh" CONTENT="URL=/saheb/table.php">
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>
<!-- Load the Paper.js library -->
<script type="text/javascript" src="../paper.js/lib/paper.js"></script>
<script type="text/javascript" src="bet.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<!-- Define inlined JavaScript -->
 <link href="../css/bootstrap.css" rel="stylesheet">
 <link href="../css/bootstrap-responsive.css" rel="stylesheet">
 <script type="text/javascript" src="Cards/playingCards.js"></script>
    <script type="text/javascript" src="Cards/playingCards.ui.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="Cards/playingCards.ui.css"/>
    <script type="text/javascript">
   var hand_score = {
    "Royal Flush"    :  10,
    "Straight Flush" :  9,
    "Four of a Kind"    :  8,
    "Full House"     :  7,
    "Flush"          :  6,
    "Three of a Kind"    :  5,
    "Straight"        :  4,
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
        if (current_bet.Hand=="Full House" || current_bet.Hand =="2 of a Kind") 
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
        else if(current_bet.Hand=="4 of a Kind" || current_bet.Hand=="Pair" || current_bet.Hand=="3 of a Kind")
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

</script>
<script>
$(document).ready(function(){
        $("#cards").click(function(event){
            var cardDeck = $("#cardDeck").playingCards();
            //cardDeck.spread();    
            var hand = [];
            var showHand = function(){
                var el = $('#yourHand')
                el.html('');
                for(var i=0;i<hand.length;i++){
                    el.append(hand[i].getHTML());
                }
            }
            var doShuffle = function(){
                cardDeck.shuffle();
                //cardDeck.spread(); // update card table
            }
            function doDrawCard() {
                var c = cardDeck.draw();
                if(!c){
                    showError('no more cards');
                    return;
                }
                hand[hand.length] = c;
                //cardDeck.spread();
                //showHand();
            }
           
            
            function addtoHand(){
                doShuffle();
                doDrawCard();
            }

            var NumberOfCards = 8;
            for (var i = NumberOfCards - 1; i >= 0; i--) {
                addtoHand();
            }
            showHand();

                   });

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

            var last_bet = new Object();
            last_bet.Hand = document.getElementById('lastbet_hand').innerHTML;
            last_bet.Suit = document.getElementById('lastbet_suit').innerHTML;
            last_bet.Card1 = document.getElementById('lastbet_card1').innerHTML;
            last_bet.Card2 = document.getElementById('lastbet_card2').innerHTML;
            last_bet.NumberOfCards = document.getElementById('lastbet_numofcards').innerHTML;

            if(compare(current_bet,last_bet))
                {
                    document.getElementById('lastbet_hand').innerHTML = current_bet.Hand;
                    document.getElementById('lastbet_suit').innerHTML = current_bet.Suit;
                    document.getElementById('lastbet_card1').innerHTML = current_bet.Card1;
                    document.getElementById('lastbet_card2').innerHTML = current_bet.Card2;
                    document.getElementById('lastbet_numofcards').innerHTML = current_bet.NumberOfCards;
                }
            else
                alert('You need to bet higher than last bet!');

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
                <option value="0">Not Applicable</option>
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
            <Iframe src="/saheb/table.php" width="725px" height="750px" scrolling="no"></Iframe>
        </div>
        <div class="span2 offset2">
            <div class=""row>
                <h2>Last Bet</h2>
                    <p id="lastbet_hand">Full House</p>
                    <p id="lastbet_suit">NA</p>
                    <p id="lastbet_card1">King</p>
                    <p id="lastbet_card2">Queen</p>
                    <p id="lastbet_numofcards">NA</p>
            </div>
            <div class="row">
            <h2>Chat Window</h2>
            </div>
        </div>
    </div>
</body>
</html>