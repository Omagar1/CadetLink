<?php
echo "Loading....";
session_start();
require_once "ConnectDB.php";
try{
// getting the variables
$userID = $_POST['ID'];
$PwdNew = $_POST['Pwd'];
$admin = $_POST['admin'];
// ---------------------------------------------main code --------------------------------------------
// creating the new item items table 

$qry = "UPDATE users SET Pword = ? WHERE ID =?";
$stmt = $conn->prepare($qry);
$stmt->execute([$PwdNew, $userID]);
echo "task successfully succeeded ";
if($admin == true){
    echo $admin;
    header("location: manageUsers.php");
}else{
    header("location: mainPage.php");
    echo $admin;
}
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>