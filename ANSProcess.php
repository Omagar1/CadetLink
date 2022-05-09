<?php
echo "Loading....";
session_start();
$errors = false;// global

require_once "ConnectDB.php";
// ---------------------------------------------functions ---------------------------------------------
function updateSize($itemID, $sizeTypeID, $value, $con){
    $qry = "INSERT INTO sizes (itemID, sizeTypeID, `value`)
    VALUES (?,?,?);";
    $stmt = $con->prepare($qry);
    $stmt->execute([$itemID, $sizeTypeID, $value]);
    //echo"completed <br>";
}

try{
// getting the variables
$NSN = $_POST['NSN'];
$ItemTypeID = $_POST['ItemType'];
$NumIssued = $_POST['NumIssued'];
$NumInStore = $_POST['NumInStore'];
$NumReserved = $_POST['NumReserved'];
$NumOrdered = $_POST['NumOrdered'];
$Size = $_POST['Size'];

// ---------------------------------------------main code --------------------------------------------


// creating the new item items table 

$qry = "INSERT INTO items (NSN, ItemTypeID, NumIssued, NumInStore, NumReserved, NumOrdered)
VALUES (?,?,?,?,?,?);";
$stmt = $conn->prepare($qry);
$stmt->execute([$NSN, $ItemTypeID, $NumIssued, $NumInStore, $NumReserved, $NumOrdered]);
$newID = $conn->lastInsertId();


// updating sizes 
$SizeArray = explode("/",$Size); // create array out of sizes ie:  xx/yy/zz => [0] = xx [1] = yy [2] = zz
    // var_dump($SizeArray); // test
if ($ItemTypeID == 1 or $ItemTypeID == 2 or $ItemTypeID == 3 or $ItemTypeID == 4){ // for torso items
    $height = $SizeArray[0];
    //echo"height: " .$height . "<br>";
    updateSize($newID, 1, $height, $conn);
    $chest = $SizeArray[1];
    updateSize($newID, 2, $chest, $conn);
    //echo"chest: " .$chest . "<br>";            

} elseif ($ItemTypeID == 5){ // for trousers
    $waist = $SizeArray[0];
    updateSize($newID, 3, $waist, $conn);
    $insideLeg = $SizeArray[1];
    updateSize($newID, 4, $insideLeg, $conn);
    $seat = $SizeArray[2]; 
    updateSize($newID, 5, $seat, $conn);

}elseif ($ItemTypeID == 8 or $ItemTypeID == 9){ // for headdress
    $headSize = $SizeArray[0];
    updateSize($newID, 6, $headSize, $conn);           

}elseif ($ItemTypeID == 7){ // for boots 
    $shoeSize = $SizeArray[0];
    updateSize($newID, 7, $shoeSize, $conn);
}
header("location: Stock.php");
  
} catch (PDOException $e) {
    echo"Error : ".$e->getMessage();
}

?>