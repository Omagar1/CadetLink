<?php
session_start();

require_once "ConnectDB.php";
try{
    // updating Request Table
    $newStatus = $_GET["newStatus"];
    $ID = $_GET["ID"];

    $qry = "UPDATE itemRequest SET `status` = ? WHERE ID = ?;";  
    $stmt = $conn->prepare($qry);
    $stmt->execute([$newStatus, $ID]);
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>