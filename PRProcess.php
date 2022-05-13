<?php
echo "Loading....";
session_start();
require_once "ConnectDB.php";
try{
// getting the variables
$userID = $_POST['ID'];
$PwdNew = $_POST['Pwd'];
// ---------------------------------------------main code --------------------------------------------
// creating the new item items table 

$qry = "UPDATE users SET Pword = ? WHERE ID =?";
$stmt = $conn->prepare($qry);
$stmt->execute([$PwdNew, $userID]);
echo "task sucsesfuly sucseded ";
header("location: manageUsers.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>