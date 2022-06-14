<?php
session_start();
 include "functions.php";
 require_once "ConnectDB.php"
?>

<html>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
    ?>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <?php NavBar(); ?>
        <div id="main">
            <h2>Section - Work in Progress </h2>
            
        </div>
      <div id="footer">

      </div>
    </body>
  </html>