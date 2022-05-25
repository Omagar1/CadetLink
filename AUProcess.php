<?php
echo "Loading....";
session_start();
require_once "ConnectDB.php";

// getting the variables
$Cnum = $_POST['Cnum'];
$Pwd = $_POST['Pwd'];
$rank = $_POST['rank'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$troop = $_POST['troop'];
$addAnother = $_POST['addAnother'];
echo "AddAnother:".$addAnother. "<br>";
// ---------------------------------------------main code --------------------------------------------
// creating the new item items table 

$qry = "INSERT INTO users (Cnum, Pword, `rank`, fname, lname, troop)
VALUES (?,?,?,?,?,?);";
$stmt = $conn->prepare($qry);
$stmt->execute([$Cnum, $Pwd, $rank, $fname, $lname, $troop]);
echo "task sucsesfuly sucseded ";
if($addAnother == 0 ){
    header("location: manageUsers.php");
}elseif($addAnother == 1){
    header("location: addUsers.php");
}else{

}
?>