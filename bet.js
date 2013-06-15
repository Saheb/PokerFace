<script>
   var hand_score = {
    "Royal Flush"    :  10,
    "Straight Flush" :  9,
    "4 of a Kind"    :  8,
    "Full House"     :  7,
    "Flush"          :  6,
    "3 of a Kind"    :  5,
    "Staight"        :  4,
    "2 Pairs"        :  3,
    "Pair"           :  2,
    "High Card"      :  1
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
    "2"     : 2
};
var suit_score = {
    "Spades"   : 4,
    "Diamonds" : 3,
    "Clubs"    : 2,
    "Hearts"   : 1 
};

var function compare(current_bet,last_bet)
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

    

    function call()
    {
    
    //document.write("Hello"); 
    
    lb = new Object();
    lb.Hand = document.getElementById("hand").value;
    lb.Card1 = document.getElementById("card1").value;
    lb.Card2 = document.getElementById("card2").value;
    lb.Suit = document.getElementById("suit").value;
    lb.NumberOfCards = document.getElementById("number").value;
    cb = new Object();
    cb.Hand = document.getElementById("cu_hand").value;
    cb.Card1 = document.getElementById("cu_card1").value;
    cb.Card2 = document.getElementById("cu_card2").value;
    cb.Suit = document.getElementById("cu_suit").value;
    cb.NumberOfCards = document.getElementById("cu_number").value;
    
    if(compare(cb,lb))
        document.write("Current Bet is Accepted");
    else
        document.write("Current Bet is not acceptable");    
    }   
</script>