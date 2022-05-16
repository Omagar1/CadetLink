<?php
echo "Loading....";
session_start();



require_once "ConnectDB.php";
// ---------------------------------------------main code --------------------------------------------

try{
// getting the variables
$userID = $_POST['ID'];
$Cnum = $_POST['Cnum'];
$rank = $_POST['rank'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$troop = $_POST['troop'];

// updating users table 

$qry = "UPDATE users SET Cnum =?, `rank` =?, fname =?, lname = ?, troop =? WHERE ID = ?;";
$stmt = $conn->prepare($qry);
$stmt->execute([$Cnum, $rank, $fname, $lname, $troop, $userID]);

if ( trim($userID) == trim($_SESSION["UserID"])){
    echo "i ran";
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['rank'] = $rank;
    $_SESSION['troop'] = $troop;
}else{
    echo "no I RAN";
}

header("location: manageUsers.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>