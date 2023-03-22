<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <?php
      session_start();
      ?>
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
          <h2 class ="navBarDashTxt"><?php echo "welcome ", $_SESSION['rank']," ", $_SESSION['fname']," ", $_SESSION['lname']?></h2>
          <img class = "profilePic" src="images/defaltProfilePic.jpg" alt="SgtDefalt" width="auto" height="150">
      </div>

      <div id="container">
        
        <div id="main">
            <h2>Your Dashboard</h2>
            <p>Reminders for next Cadet Session</p>
            <ul>
                <li>Iron Kit!</li>
                <li>Bring notepad and Pen!</li>
                <li>Dinner is at Benenden!</li> <!-- for tjwa only --> 
            </ul>

            <div>
                <ul class="no-bullets">
                  <li><a href = "#troop"><button class ="BenBlue dashboard dasbordTxt">section: <?php echo $_SESSION["section"]?></button></a></li>
                  <li><a href = "events.php"><button class ="tjwaRed dashboard dasbordTxt">Events</button></a></li>
                  <li><a href = "kitRequest.php"><button class ="purple dashboard dasbordTxt">kit Request</button></a></li>
                </ul>
            </div>
            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>