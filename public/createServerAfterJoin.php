<?php

$idPlayer = $_GET["idPlaye"];
$idServer = $_GET["idServe"];

$con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
// Check connection
if (mysqli_connect_errno($con))
 {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

mysqli_query($con, "UPDATE my_db.players SET Group_ID=$idServer where ID=$idPlayer");

?>
<html>
<meta charset='UTF-8' />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }

      .startgame{
        margin: 100px 0;
        text-align: center;
      }

      .nameip{
        padding-left: 100px;
      }

      b.admin1{
        font-size: 30px;
      }

      b.admin2{
        font-size: 20px;
      }

      b.ip1{
        font-size: 30px;
        padding-left: 80px;
      }

      b.ip2{
        font-size: 20px;
        padding-left: 80px;
      }


    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons  -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<script>

 var idSer = <?php echo $idServer;?>;

   $(document).ready(function(){
   new get_started(); 
 });

  function get_started(){
    var feedback = $.ajax({
        type: "GET",
        url: "GameStarted.php",
        data : {neel:String(idSer)},
        async: false
    }).success(function(){
        setTimeout(function(){get_started();}, 1000);
    }).responseText;

    //var divi = document.getElementById('users');
    //divi.innerHTML='';

    if(feedback == 1)
    {
      $('#Start_Game').click();  
    } 
    else
    {

    }

  }

</script>

<script>
  var id = <?php echo $idServer;?>;

  $(document).ready(function(){
   new get_info(); 
 });

  function get_info(){
    var feedback = $.ajax({
        type: "GET",
        url: "change.php",
        data : {neel:String(id)},
        async: false
    }).success(function(){
        setTimeout(function(){get_info();}, 100000);
    }).responseText;

    var divi = document.getElementById('users');
    divi.innerHTML='';

    var names = $.parseJSON(feedback);
    for (var i = 0; i < names.length; i++) {
      var para = document.createElement("p");
      var text = document.createTextNode(String(names[i]));
      para.appendChild(text);
      divi.appendChild(para);
    };
}
</script>


<body>
  <form action="http://127.0.0.1/PokerFace/public/startGameAfterJoin.php" method="get">
    <div class="container">
      <div class="masthead">
        <h3 class="muted">Poker Face</h3>
        </div><!-- /.navbar -->
      </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span5" style="padding-left:80px">
          <div class="well sidebar-nav">
            <h1><?php echo $_GET["name"]; ?>'s Game</h1><br>
            <!--
	<b class="admin1">Admin</b>
            <b class="ip1">IP</b><br>
            <b class="admin2"><?php echo $_GET["name"]; ?></b>
            <b class="ip2">10.100.93.27</b><br><br>
		-->
          </div>
       </div>
       <div class="span5" style="padding-left:80px">
        <div class="well sidebar-nav">
          <b style="font-size: 30px">Number Of Players :  </b>
          <select name="players" style="width:60px">
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
          </select><br><br>
          <b style="font-size: 30px">Number Of Cards :  </b>
          <select style="width:60px">
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
          </select>
        </div>
       </div>
       </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3" style="padding-left:80px">
          <div class="well sidebar-nav">
            <b style="font-size: 25px">Players</b>
		<br><br>
            <div id="users">
            </div>
          </div>
      </div>
      <div class="span5 offset2" style="padding-left:80px;length:300px">
          <div class="well sidebar-nav">
            <h2>Chat module will come soon :)</h2><br/>
          </div>
      </div>
	</div>

      <input type="hidden" name="ID" value="<?php echo $idPlayer;?>"></input>
      <input type="hidden" name="IDServer" value="<?php echo $idServer;?>"></input>

     <div class="startgame">
        <input type="submit" class="btn btn-large btn-success" style="display: none;" id="Start_Game"/>
      </div>
      </form>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>

</html>
