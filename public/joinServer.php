<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Template &middot; Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
</script>

  <script>
      $(document).ready(function(){
          $(".server").hover(function(){
            $(".serverdetails").fadeToggle(100);
          });
        });
  </script>
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="muted">Poker Face</h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li><a href="home.html">Home</a></li>
                <li><a href="createServer.html">Create Server</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>

      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Join Server</h1>
        <p class="lead">You are just a click away to get started</p>
      </div>

      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <?php

          $con=mysqli_connect("127.0.0.1:3306","root","abc","my_db");
          if (mysqli_connect_errno($con))
          {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }

          $namex = $_GET['name'];

          mysqli_query($con, "INSERT INTO my_db.players (ID, Name, Group_ID)
          VALUES (0, '$namex', 1)");   

          $ids = mysqli_query($con, "select ID from my_db.players");
          while($row=mysqli_fetch_array($ids))
          {
            $idPlayer = $row['ID'];
          }

          $result = mysqli_query($con, "select * from my_db.servers");
          while($row=mysqli_fetch_array($result))
          {
            $idServer = $row['ID'];
            $name = $row['Name'];
            echo '<div class="span2">';
              echo '<h2 class="server">';
              echo $name;
              echo '</h2>';
              echo '<form action="http://127.0.0.1/PokerFace/public/createServerAfterJoin.php" method="get">';
                echo '<p><input type="submit" value="join" class="btn">&raquo;</a></p>';
                echo '<input type="hidden" name="idServe" value="'.$idServer.'"/>';
                echo '<input type="hidden" name="idPlaye" value="'.$idPlayer.'"/>';
                echo '<input type="hidden" name="name" value="'.$name.'"/>';
              echo '</form>';
            echo '</div>';
          }

        ?>
      </div>
      <hr>


    </div> <!-- /container -->

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
