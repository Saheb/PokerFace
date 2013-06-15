<html>
<head>
<script type="text/javascript" src="../paper.js/lib/paper.js"></script>
</head>
<body>
    <canvas id="canvas" resize></canvas>
    <script type="text/paperscript" canvas="canvas">
    var start = new Point(50, 50);
    var end = new Point(1000, 600);
    var center = new Point((start.x+end.x)/2 -150 ,(start.y+end.y)/2 )
    var rectangle = new Rectangle(start,end);
    var cornerSize = new Size(20, 20);
    var table = new Path.Circle(center,300);
        table.fillColor = 'green';
    var num_of_players = 6;
    var del = 360/num_of_players;
    var myCircle = new Array();
    var dealer = new Rectangle((start.x+end.x)/2 -150,(start.y+end.y)/2,20,25);
    var shift_x = dealer.x;
    var shift_y = dealer.y;
    var player = new Path.Rectangle(dealer);
        player.fillColor='black';
    var po = new Point((start.x+end.x)/2,start.y);
    var vec = po - dealer.point;
    for (var i = 0; i < num_of_players; i++) 
        {  
            temp = new Point(vec.x+shift_x,vec.y+shift_y);
            myCircle[i] = new Path.Circle(temp, 25);
            myCircle[i].fillColor = 'red';
            vec.angle += del;
         }   
        var card = new Path.Rectangle(dealer.point.x,dealer.point.y,20,25);
        card.fillColor = 'black';
        //text.paragraphStyle.justification = 'center';
        //text.characterStyle.fontSize = 20;
        //text.fillColor = 'white';

        // Define a random point in the view, which we will be moving
        // the text item towards.
        //document.write(myCircle[0].position);
        var destination = myCircle[0].position ;
        //document.write(destination.angle);
        var i =0;

    function onFrame(event) {
    // Each frame, move the path 1/30th of the difference in position
    // between it and the destination.
    
    // The vector is the difference between the position of
    // the text item and the destination point:
    var vector = destination - card.position;
    
    // We add 1/30th of the vector to the position property
    // of the text item, to move it in the direction of the
    // destination point:
    card.position += vector / 5;
    
    // Set the content of the text item to be the length of the vector.
    // I.e. the distance it has to travel still:
    //text.content = i;
    
    // If the distance between the path and the destination is less
    // than 5, we define a new random point in the view to move the
    // path to:
    if (vector.length < 75) {
        var t = new Path.Rectangle(dealer.point.x,dealer.point.y,20,25);
        t.fillColor = 'black';
        //t.paragraphStyle.justification = 'center';
        //t.characterStyle.fontSize = 20;
        //t.fillColor = 'white';
        card = t;
        i++;
        if(i>=num_of_players)
                destination = dealer.point;
        destination = myCircle[i].position;
    }
}
</script>
</body>
<html>