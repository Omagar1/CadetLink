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

header("location: manageUsers.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>