<?php
session_start();

require_once "ConnectDB.php";

// if (isset($_POST['Xdata'])){
//     echo "set <br> ";
// }else{
//     echo" NOT set <br>";
// }
//echo "hello" . $_POST['Xdata'] . "world <br>" ;
//echo "data type:  ". gettype($_POST['Xdata']) . "<br>";
//echo "length: ". count($_POST['Xdata']) . "<br>";

//echo $ItemID . "test <br>";
try{
    $itemID = $_POST['Xdata'];
    // adding reqested item back to stock if it is on request
    $sql = "SELECT StockID, NumRequested, `status`  FROM itemRequest WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$itemID]);
    $result = $stmt->fetch();

    $status = $result["status"];
    $stockID = $result["StockID"];
    echo "stockID:". $stockID;
    $NumRequested = $result["NumRequested"];

    
    if ($status == "TO BE ISSUED"){
        $qry = "SELECT NumInStore, NumReserved FROM items WHERE ID = ?;" ;
        $stmt = $conn->prepare($qry);
        $stmt->execute([$stockID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
        $oldNumInStore = $result["NumInStore"];
        $oldNumRequested = $result["NumReserved"];
        
        // updating items table 
        $newNumInStore  = $oldNumInStore + $NumRequested;
        $newNumRequested = $oldNumRequested - $NumRequested;
        $qry = "UPDATE items SET NumInStore =?, NumReserved = ? WHERE ID = ?;";
        $stmt = $conn->prepare($qry);
        $stmt->execute([$newNumInStore, $newNumRequested, $stockID]);
    } elseif ($status == "AWAITING ORDER"){

        $qry = "SELECT NumOrdered FROM items WHERE ID = ?;" ;
        $stmt = $conn->prepare($qry);
        $stmt->execute([$stockID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
        $oldNumOrdered = $result["NumOrdered"];
        // updating items table 
        $newNumOrdered = $oldNumOrdered - $NumRequested;
        $qry = "UPDATE items SET NumOrdered =? WHERE ID = ?;";
        $stmt = $conn->prepare($qry);
        $stmt->execute([$newNumOrdered, $stockID]);

    }
    // deleting requests from data base 
    $qry = "DELETE FROM itemRequest WHERE ID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);

    $qry = "DELETE FROM sizesRequest WHERE itemID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);

    header("location: " . $_SESSION['previous']);
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

?>