<!DOCTYPE phpl>
  <phpl>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <div id="navbarDash">
          <h2 class ="navBarDashTxt"> welcome <?php echo "welcome", $_SESSION['rank'] $_SESSION['fname'], $_SESSION['lname']?></h2>
          <img class = "profilePic" src="images/SgtWagar.jpg" alt="SgtDefalt" width="auto" height="150">
      </div>

      <div id="container">
        
        <div id="main">
            <h2>your Dashbord</h2>
            <p>reminders for next Cadet Session</p>
            <ul>
                <li>Iron Kit !</li>
                <li>Bring notepad and Pen!</li>
                <li>Dinner is at Benenden!</li> <!-- for tjwa only --> 
            </ul>

            <div>
                <ul class="no-bullets">
                <li class ="dashbordTroop" class ="dashbord" class = "inline"><a href = "troops.php" class = "dasbordTxt">Troop:Chard</a></li>
                <li class ="dashbordSection" class ="dashbord" class = "inline"><a href = "section.php" class = "dasbordTxt">4 section</a></li>
                <li class ="dashbordOrders" class ="dashbord"><a href = "orders.php" class = "dasbordTxt">Orders</a></li>
                <li class ="dashbordKitRequest" class ="dashbord"><a href = "kitRequest.php"class = "dasbordTxt">Uniform</a></li>
                <li class ="dashbordTrips" class ="dashbord"><a href = "trips.php"class = "dasbordTxt">Trips</a></li>
                <li class ="dashbordVPB" class ="dashbord"><a href = "#VPB"class = "dasbordTxt">Virtual Pocket Book</a></li>
                </ul>
            </div>
            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </phpl>
