<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link href="loginSignup.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php
      session_start();
      //checks if not logged in 
      if(isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };
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
      </div>
      <div id="container">
        
        <div id="main">
            <h2>Kit Request Page - Work in Progress </h2>

            <a href=#kitRequest.php >
              <button class ="button buttonPressed">Make A Request</button>
            </a>
            <a href=myRequests.php >
              <button class ="button">My Requests</button>
            </a>
          <fieldset>
            <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
            ?>
            <form action = "KRProcess.php" method="post">
              <label for="UniformType">UniformType</label><br>
              <select id="UniformType" name="UniformType">
                <option value="1">Shirt Combat</option>
                <option value="2">Smock</option>
                <option value="3">Undershirt(Fleece)</option>
                <option value="4">Static T-Shirt</option>
                <option value="5">Trousers Combat</option>
                <option value="7">Boots</option>
                <option value="8">Beret</option>
                <option value="9">Cap MTP</option>
              </select><br>

              <label for="Size">Nato Size</label><br>
              <input type="text" id="Size" name="Size" value=""><br>

              <label for="purpose">Purpose</label><br>
              <select id="purpose" name="purpose">
                <option value="GROWN OUT OF OLD KIT">Grown Out of Old Kit</option>
                <option value="NEVER ISSUED">Was Never Issued</option>
                <option value="LOST OLD KIT">Lost Old Kit</option>
                <option value="OLD KIT WAS DAMAGED">Old Kit Was Damged</option>
                <option value="OTHER">Other</option>
              </select><br>

              <label for="NumRequested">How Many?</label><br>
              <select id="NumRequested" name="NumRequested">
                <option value="1">1</option>
                <option value="2">2</option>
              </select><br>
              <input type="submit" class = "button">
              
            </form>
            </fieldset>

            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>