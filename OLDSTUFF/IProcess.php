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
    $itemID = $_POST['Idata'];
    // adding reqested item back to stock if it is on request
    $sql = "SELECT StockID, NumRequested, `status` FROM itemRequest WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$itemID]);
    $result = $stmt->fetch();
    // initalising varibles 
    $status = $result["status"];
    $stockID = $result["StockID"];
    echo "stockID:". $stockID;
    $NumRequested = $result["NumRequested"];


    if ($status == "TO BE ISSUED"){
        //qry to find the current numIssued  and num reserved
        $qry = "SELECT NumIssued, NumReserved FROM items WHERE ID = ?;" ;
        $stmt = $conn->prepare($qry);
        $stmt->execute([$stockID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
        $oldNumIssued = $result["NumIssued"];
        $oldNumRequested = $result["NumReserved"];

        // updating items table  add NumRequested to numIssued;  - NumRequested from Num Reserved 
        $newNumIssued  = $oldNumIssued + $NumRequested;
        $newNumRequested = $oldNumRequested - $NumRequested;
        $qry = "UPDATE items SET NumIssued =?, NumReserved = ? WHERE ID = ?;";
        $stmt = $conn->prepare($qry);
        $stmt->execute([$newNumIssued, $newNumRequested, $stockID]);
    } elseif ($status == "AWAITING ORDER"){

        $qry = "SELECT NumIssued, NumOrdered FROM items WHERE ID = ?;" ;
        $stmt = $conn->prepare($qry);
        $stmt->execute([$stockID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($result);
        $oldNumIssued = $result["NumIssued"];
        $oldNumOrdered = $result["NumOrdered"];
        // updating items table add NumRequested to numIssued;  - NumRequested from Num Reserved 
        $newNumIssued  = $oldNumIssued + $NumRequested;
        $newNumOrdered = $oldNumOrdered - $NumRequested;
        $qry = "UPDATE items SET NumIssued=?, NumOrdered =? WHERE ID = ?;";
        $stmt = $conn->prepare($qry);
        $stmt->execute([$newNumIssued,$newNumOrdered, $stockID]);

    }
    // deleting requests from data base 
    $qry = "DELETE FROM itemRequest WHERE ID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);


    $qry = "DELETE FROM sizesRequest WHERE itemID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);

    header("location: virtualStores.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

?>