<?php
session_start();

require_once "ConnectDB.php";
try{
    $Operation = $_GET["Operation"];
    $itemID = $_GET["ItemID"];
    
    if($Operation == "-"){
        $qry = "UPDATE items SET NumInStore = NumInStore - 1  WHERE ID = ? AND NumInStore > 0 ;";
    }elseif($Operation == "+"){
        $qry = "UPDATE items SET NumInStore = NumInStore + 1 WHERE ID = ?;";  
    }
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>