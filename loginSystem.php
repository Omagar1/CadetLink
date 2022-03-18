<?php
// starts session
session_start();

//checks if already logged in 
if(isset($_SESSION["loggedIn"]) and $_SESSION["loggedIn"] === true ){
    header("location: index.php") // if so redirects them to the dasbord page

}

require_once "ConnectDB.php"


?>
