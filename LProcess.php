<?php
// starts session
session_start();

//checks if already logged in 
if(!isset($_SESSION["loggedIn"]) and $_SESSION["loggedIn"] != true ){
    header("location: index.htm") // if so redirects them to the dasbord page

}

require_once "ConnectDB.php";
$uname = $_POST['CNum'];
$pword = $_POST['Pwd'];

// prone to SQL injection 
$qry = "SELECT * FROM users WHERE `Cnum` == $uname AND `Pword` == $pword;" 

$result = mysqli_query($conn, $qry);

if (mysqli_num_rows($result) > 1) {
    echo "Major Error"
} else if (mysqli_num_rows($result) == 0) { 
    echo "Cadet number or Password Incorrect"
} else if  (mysqli_num_rows($result) === 1 ){ 
    echo "logged inn"
    $_SESSION["LoggedIn"] = TRUE;
}; 














?>
