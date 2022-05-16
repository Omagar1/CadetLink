<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php
      session_start();

      //checks if not logged in 
      if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };

      // system to destroy msg variable when its not wanted
      if (isset($_SESSION['previous'])) {
        if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
             unset($_SESSION['msg']);
        }else{

        }
      }else{

      }
      $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
      ?>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <div id="navbarDash">
          <h2 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " ";
            echo $_SESSION['fname']. " ";
            echo $_SESSION['lname'];?></h2>
          <img class = "profilePic" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefalt" width="auto" height="150">
          <form method="get" action="LOProcess.php">
              <button type="submit" class = "w3-threequarter, button">LogOut</button>
          </form>
      </div>
        <div id="main">
            <h2>your Dashboard</h2>
            <p>time to do Admin suff</p>
            <ul>
                <li>Iron Kit !</li>
                <li>Bring notepad and Pen!</li>
                <li>Dinner is at Benenden!</li> <!-- for tjwa only --> 
            </ul>

            <div>
                <ul class="no-bullets">
                <li class ="dashbordSection" class ="dashbord" class = "inline"><a href = "manageUsers.php" class = "dasbordTxt">Manage Users</a></li>
                <li class ="dashbordOrders" class ="dashbord"><a href = "ordersAdmin.php" class = "dasbordTxt">Orders</a></li>
                <li class ="dashbordKitRequest" class ="dashbord"><a href = "virtualStores.php"class = "dasbordTxt">Virtual Stores</a></li>
                <li class ="dashbordKitRequest" class ="dashbord"><a href = "kitRequest.php"class = "dasbordTxt">kit Request</a></li>
                <li class ="dashbordTrips" class ="dashbord"><a href = "trips.php"class = "dasbordTxt">Trips</a></li>
                <li class ="dashbordVPB" class ="dashbord"><a href = "#VPB"class = "dasbordTxt">Virtual Pocket Book</a></li>
                </ul>
            </div>
            
        </div>
      
      <div id="footer">

      </div>
    </body>
  </html>
