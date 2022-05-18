<?php
session_start();

require_once "ConnectDB.php";
try{
    $Operation = $_GET["Operation"];
    $itemID = $_GET["ItemID"];
    $Column = $_GET["Column"];
    
    if($Operation == "sub"){
        $qry = "UPDATE items SET ".$Column." = ".$Column." - 1  WHERE ID = ? AND ".$Column." > 0 ;";
    }elseif($Operation == "plus"){
        $qry = "UPDATE items SET ".$Column." = ".$Column." + 1 WHERE ID = ?;";  
    }
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>