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
      ?>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <div id="navbarDash">
        <h2 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " ";
            echo $_SESSION['fname']. " ";
            echo $_SESSION['lname'];?></h2></h2>
        <img class = "profilePic" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefalt" width="auto" height="150">
        <form action ="<?php
        if($_SESSION['troop']=="CFAV"){
          echo "adminMainPage.php";
        }else{
          echo "mainPage.php";
        }
        ?>">
        <input type="submit" class = "smallButton" value="«" name="dashButton">
        </form>
      </div>
      <div id="container">
        
        <div id="main">
            <h2>Orders Page - Work in Progress </h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <br>
            <input type="submit" value="Upload file" name="submit">
            </form>
            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>