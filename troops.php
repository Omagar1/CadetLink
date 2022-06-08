<?php
session_start();
 include "functions.php";
 require_once "ConnectDB.php"
?>

<html>
    <?php
      head();// from functions.php, echoes out the head tags

      notLoggedIn(); // from functions.php, checks if user is logged in 

      destroyUnwantedSession();// from functions.php, destroys unwanted error messages from other pages 
      ?>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <div id="navbarDash">
        <h2 class ="navBarDashTxt"> welcome Sgt sleep paralysis demon</h2>
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
        <div id="main">
            <h2>Troop page - Work in Progress </h2>
            
        </div>
      <div id="footer">

      </div>
    </body>
  </phpl>