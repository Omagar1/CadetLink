<?php
echo "Loading....";
session_start();
require_once "ConnectDB.php";
try{
// getting the variables
$Cnum = $_POST['Cnum'];
$Pwd = $_POST['Pwd'];
$rank = $_POST['rank'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$troop = $_POST['troop'];

// ---------------------------------------------main code --------------------------------------------
// creating the new item items table 

$qry = "INSERT INTO users (Cnum, Pword, `rank`, fname, lname, troop)
VALUES (?,?,?,?,?,?);";
$stmt = $conn->prepare($qry);
$stmt->execute([$Cnum, $Pwd, $rank, $fname, $lname, $troop]);
echo "task sucsesfuly sucseded ";
header("location: manageUsers.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>