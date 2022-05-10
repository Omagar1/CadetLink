<?php
echo "Loading....";
session_start();
$errors = false;// global

require_once "ConnectDB.php";
// ---------------------------------------------functions ---------------------------------------------
function updateSize($itemID, $sizeTypeID, $value, $Requests, $con){
    $qry = "UPDATE sizes SET `value`= ? WHERE itemID = ? AND sizeTypeID = ? ;";
    $stmt = $con->prepare($qry);
    $stmt->execute([$value, $itemID, $sizeTypeID]);
    //echo"completed <br>";
    //echo$Requests;
    if ($Requests == true){
        $qry = "UPDATE sizesRequest  INNER JOIN itemRequest ON sizesRequest.itemID = itemRequest.ID SET `value`= ? WHERE itemRequest.stockID = ? AND sizesRequest.sizeTypeID = ? ;";
        $stmt = $con->prepare($qry);
        $stmt->execute([$value, $itemID, $sizeTypeID]);
    }else{

    }
}

try{
// getting the variables
$itemID = $_POST['ID'];
$NSN = $_POST['NSN'];
$ItemTypeID = $_POST['ItemTypeID'];
$NumIssued = $_POST['NumIssued'];
$NumInStore = $_POST['NumInStore'];
$NumReserved = $_POST['NumReserved'];
$NumOrdered = $_POST['NumOrdered'];
$Size = $_POST['Size'];

// ---------------------------------------------main code --------------------------------------------


// updating items table 

$qry = "UPDATE items SET NSN =?, ItemTypeID =?,NumIssued =?, NumInStore =?, NumReserved = ?, NumOrdered =? WHERE ID = ?;";
$stmt = $conn->prepare($qry);
$stmt->execute([$NSN, $ItemTypeID, $NumIssued, $NumInStore, $NumReserved, $NumOrdered, $itemID]);

// checks to see if there are any requests 
$qry = "SELECT ID  FROM itemRequest WHERE stockID = ?;";
$stmt = $conn->prepare($qry);
$stmt->execute([$itemID]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($result) != 1){
    $Requests = false;
}else{
    $Requests = true;
}

// updating sizes 

$SizeArray = explode("/",$Size); // create array out of sizes ie:  xx/yy/zz => [0] = xx [1] = yy [2] = zz
    // var_dump($SizeArray); // test
if ($ItemTypeID == 1 or $ItemTypeID == 2 or $ItemTypeID == 3 or $ItemTypeID == 4){ // for torso items
    $height = $SizeArray[0];
    //echo"height: " .$height . "<br>";
    updateSize($itemID, 1, $height, $Requests, $conn);
    $chest = $SizeArray[1];
    updateSize($itemID, 2, $chest, $Requests, $conn);
    //echo"chest: " .$chest . "<br>";            

} elseif ($ItemTypeID == 5){ // for trousers
    $waist = $SizeArray[0];
    updateSize($itemID, 3, $waist, $Requests, $conn);
    $insideLeg = $SizeArray[1];
    updateSize($itemID, 4, $insideLeg, $Requests, $conn);
    $seat = $SizeArray[2]; 
    updateSize($itemID, 5, $seat, $Requests, $conn);

}elseif ($ItemTypeID == 8 or $ItemTypeID == 9){ // for headdress
    $headSize = $SizeArray[0];
    updateSize($itemID, 6, $headSize, $Requests,  $conn);           

}elseif ($ItemTypeID == 7){ // for boots 
    $shoeSize = $SizeArray[0];
    updateSize($itemID, 7, $shoeSize, $Requests, $conn);
}
header("location: Stock.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>