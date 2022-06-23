<?php
session_start();

require_once "ConnectDB.php";
try{
    // updating Request Table
    $newStatus = $_GET["newStatus"];
    $oldStatus = $_GET["oldStatus"];
    $ID = $_GET["ID"];

    $qry = "UPDATE itemRequest SET `status` = ? WHERE ID = ?;";  
    $stmt = $conn->prepare($qry);
    $stmt->execute([$newStatus, $ID]);

    //  -------------updating Items Table -------------
    // getting ItemID From Request
    $qry = "SELECT ItemTypeID FROM itemRequest WHERE ID = ?;";  
    $stmt = $conn->prepare($qry);
    $stmt->execute([$ID]);
    $itemID = implode($stmt->fetch(PDO::FETCH_ASSOC));
    echo "itemID:  ";
    var_dump($itemID);// test 
    // finding the Linked columns 
    $sql = "SELECT linkedColumn FROM statuses WHERE `status` = ?;";
    $stmt = $conn->prepare($sql);
    //get new Linked Column 
    $stmt->execute([$newStatus]);
    $newLinkedColum = implode($stmt->fetch(PDO::FETCH_ASSOC));
    echo "newLinked Column: ";
    var_dump($newLinkedColum);// test 
    //get old Linked Column 
    $stmt->execute([$oldStatus]);
    $oldLinkedColum = implode($stmt->fetch(PDO::FETCH_ASSOC));
    echo "OldLinked Column: ";
    var_dump($oldLinkedColum);// test 
    // Update New column
    if ($newLinkedColum != null){
    $qry = "UPDATE items SET ".$newLinkedColum." = ".$newLinkedColum." + 1  WHERE ID = ?;";//add one for now will ad variable amounts soon 
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
    }
    // Update old column
    if ($oldLinkedColum != null){
    $qry = "UPDATE items SET ".$oldLinkedColum." = ".$oldLinkedColum." - 1  WHERE ID = ?;"; // minus one for now will ad variable amounts soon 
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
    }
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>