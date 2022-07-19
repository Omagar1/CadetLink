<?php
session_start();
require_once "ConnectDB.php";
include "functions.php"
?>
<!DOCTYPE html>
<html>
    
<?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
?>
<script>
    $("#troopHelp").click(function(){
    $("#troopHelpTxt").toggle();
    });
</script>
</head>

<body id = "test">
    <div id="header">
        <h1>CadetLink</h1>
    </div>

    <?php
        NavBar();
    ?>
    <div id="main">
    <h2>Help page</h2>
    <div>
    <ul class="no-bullets">
        <li><button class ="BenBlue dashboard dasbordTxt" id = "troopHelp">Troop Help</button></li>
            <p id = "troopHelpTxt" class = "hidden"> Phasellus to hate eu diam easy to stop but sometimes the lion.
                 Some need to ensure neither. Until the jaws of the entrance sit before the law enforcement.
                  Aenean eu enim purus. Curabitur porttitor, lorem ac bibendum vulputate, mi erat ornare diam, 
                  vitae consectetur purus nisi nec neque. The pain bears the consequences of the vehicle, 
                  but before the vengeful and the flats. But the mourning is not ok. Even the biggest 
                  urn should be loved by the spice, let the mourning be fun to raise. Duis sed quam nibh. The 
                  pain of the arrows or the price A soft warm environment for the vehicles. The man who's very 
                  smart and can't stop loving the free man. But a mass of arrows. According to the storytelling 
                  of the bear-free man, who is the greatest orcs of any time. Each course is a mass of wise, it is 
                  important to bow down to the ferry weekend. But the members of the wise, not for the sake of the 
                  unconventional. Until eu urn teenagers, cartoon.</p>
        <li><button class ="tjwaRed dashboard dasbordTxt">Event Help</button></li>
            <p id = "eventHelpTxt"></p>
        <li><button class ="purple dashboard dasbordTxt">kit Request help</button></li>
            <p id = "kitRequestHelp"></p>
        <li><button class ="paleGreen dashboard dasbordTxt">Virtual Stores Help</button></li>
            <p id = "virtualStoresHelp"></p>
    </ul>
    </div>
    </div>
</body>