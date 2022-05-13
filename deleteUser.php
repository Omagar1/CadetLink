<?php
session_start();

require_once "ConnectDB.php";

try{
    $userID = $_POST['Xdata'];
    
    $qry = "DELETE FROM users WHERE ID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$userID]);

    header("location: manageUsers.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

?>