<?php
session_start();

require_once "ConnectDB.php";

try{
    $itemID = $_POST['Xdata'];
    
    $qry = "DELETE FROM items WHERE ID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);

    $qry = "DELETE FROM sizes WHERE itemID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);

    header("location: Stock.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

?>