<?php 
// starts session
session_start();
$errors = false;// make global
require_once "ConnectDB.php";
function addtoSizeRequest($itemRequestID, $sizeTypeID, $value, $unit, $con){
    $qry = "INSERT INTO `sizesRequest` (`itemID` ,`sizeTypeID`, `value`, `unit`)
VALUES (?,?,?,?) ";
$stmt = $con->prepare($qry);
$stmt->execute([$itemRequestID,$sizeTypeID,$value,$unit]);
echo "completed <br>"; 
}
function arrMatch($arr, $numExpected){ // checks if any elemets of the arrays are the same
    $prevVal = 0;
    $matchCount = 0;
    array_push($arr, 0); // adds extra blank so it works when theres only one value 
    foreach ($arr as $val) {
        if ($val == $prevVal){
            $matchCount = $matchCount + 1;
            $matchedItemID = $val;
        }else{
        	$matchCount = 0; // changes match count if not consecutively matched which means this will not match if matching values do not occur consecutively, this is fine for my perposes as the data will always be ordered 
        }
        if ($matchCount == $numExpected-1){ // the number of matched values will always be $numExpected-1 unless there is only one 
            return($matchedItemID);
        }else{
			
        }
        $prevVal = $val; // sets $prevVal for next loop  
        
    }
    echo "failed to find a match";
    return(0);// returns a value to signify no ID 
}
function resultToVal($result){ // Removes the Weirdness that $result is normaly 
    // result is an array of arrays 
    $itemIDArr = [];
    foreach ($result as $subArr) {
        foreach ($subArr as $val ) {
            array_push($itemIDArr,$val);
            echo $val . "<br>" ;// prints dublicates for some reason
            //var_dump($itemIDArr);
        };
      }
    //array_splice($itemIDArr, 0, 1);// removes dublicates, hopfully 
    //test 
    echo "before: <br>";
    foreach ($itemIDArr as $val){
        echo $val . "<br>" ;
    }
    //  Actualy removes dublicates
    $arrlength = count($itemIDArr);
    for($x = 0; $x < $arrlength; $x++) {
        if ($x % 2 == 0) { 
            unset($itemIDArr[$x]);
         } else{
         }
      }
    //test 
    echo "After : <br>";
    foreach ($itemIDArr as $val){
        echo $val . "<br>" ;
    }
    // clafifies returns ie checks whenever there is one item in the array or not 
    $arrlength = count($itemIDArr);
    if ($arrlength > 1 ){
        return ($itemIDArr);
    }else{
        $matchedItemID = implode($itemIDArr);
        return($matchedItemID);
    }
}
function addRequest($itemID, $NumRequested, $itemRequestID, $con){
    $qry = "SELECT NumInStore, NumReserved FROM items WHERE ID = ?;" ;
    $stmt = $con->prepare($qry);
    $stmt->execute([$itemID]);
    $result = $stmt->fetchAll(); // result is an array of arrays 
    $resultArr = resultToVal($result);
    var_dump($resultArr);
    $oldNumInStore = $resultArr[1];
    $oldNumRequested = $resultArr[3];
    if ($oldNumInStore < $NumRequested){
        return(0);// ie not enough in store so cant withdraw 
    } else{
        // updating items table 
        $newNumInStore  = $oldNumInStore - $NumRequested;
        $newNumRequested = $oldNumRequested + $NumRequested;
        $qry = "UPDATE items SET NumInStore =?, NumReserved = ? WHERE ID = ?;";
        $stmt = $con->prepare($qry);
        $stmt->execute([$newNumInStore, $newNumRequested, $itemID]);
        
        // updating itemRequest table 
        $qry = "UPDATE itemRequest SET StockID =?, `status` = 'TO BE ISSUED' WHERE ID = ?;"; 
        
        $stmt = $con->prepare($qry);
        $stmt->execute([$itemID, $itemRequestID]);
        return(1); // task succeded sucsesfuly

    }
}

function onOrder($itemID, $NumRequested, $itemRequestID, $con){
    $qry = "SELECT NumOrdered FROM items WHERE ID = ?;" ;
    $stmt = $con->prepare($qry);
    $stmt->execute([$itemID]);
    $result = $stmt->fetchAll(); // result is an array of arrays 
    //$resultArr = resultToVal($result);
    //var_dump($resultArr); // test 
    $oldNumOrdered = $result["NumOrdered"];
    // updating items table 
    $newNumOrdered  = $oldNumNumOrdered + $NumRequested;
    $qry = "UPDATE items SET NumOrdered =? WHERE ID = ?;";
    $stmt = $con->prepare($qry);
    $stmt->execute([$newNumOrdered, $itemID]);
    // updating itemRequest table 
    $qry = "UPDATE itemRequest SET StockID =?,`status` = 'AWAITING ORDER' WHERE ID = ?;";
    $stmt = $con->prepare($qry);
    echo "itemID: ". $itemID. "<br>ItemRequestedID: ". $itemRequestID;
    $stmt->execute([$itemID, $itemRequestID]);
    return(1); // task succeded sucsesfuly  
}

// gets values from Form
$ItemType = trim($_POST['ItemType']);
$Size = trim($_POST['Size']);
$purpose = trim($_POST['purpose']);
$NumRequested = trim($_POST['NumRequested']);
echo $Size ."<br>";

//----------------------------------- main code -----------------------------------

if ($GLOBALS['errors'] == true){ 
    echo "yay I RAN ERROR: ";
    echo $msg;
    header("location: kitRequest.php");
}else{
    echo "NOOO I RAN <br>";
    echo "errors: ". $errors."<br>";
    try{
        // addding items to ItemRequest table
        $UserID = $_SESSION['UserID'];
        $UserID = (int)$UserID;
        $dateTimeRequested = date("Y-m-d H:i");
        $qry = "INSERT INTO `itemRequest` (`UserID`, `ItemTypeID`,`NumRequested`,`purpose`,`DateRequested`) VALUES (?,?,?,?,?)";
        //echo $qry;
        $stmt = $conn->prepare($qry);
        //echo $UserID ."<br>".$ItemType."<br>". $NumRequested ."<br>".$purpose."<br>". $dateTimeRequested. "<br>";
        $stmt->execute([$UserID,$ItemType,$NumRequested,$purpose,$dateTimeRequested]);
        // gets ID of last item added 
        $itemRequestID = $conn->lastInsertId();

        // getting the Size in a Usable format and then adding them to the sizeRequest table    
        $SizeArray = explode("/",$Size); // create array out of sizes ie:  xx/yy/zz => [0] = xx [1] = yy [2] = zz
        // var_dump($SizeArray); // test
        if ($ItemType == 1 or $ItemType == 2 or $ItemType == 3 or $ItemType == 4){ // for torso items
            $height = $SizeArray[0];
            addtoSizeRequest($itemRequestID, 1, $height, "cm", $conn);
            $chest = $SizeArray[1];
            addtoSizeRequest($itemRequestID, 2, $chest, "cm", $conn);
            $SizeNum = 2;// for later function  

        } elseif ($ItemType == 5){ // for trousers
            $waist = $SizeArray[0];
            addtoSizeRequest($itemRequestID, 3, $waist, "cm", $conn);
            $insideLeg = $SizeArray[1];
            addtoSizeRequest($itemRequestID, 4, $insideLeg, "cm", $conn);
            $seat = $SizeArray[2]; 
            addtoSizeRequest($itemRequestID, 5, $seat, "cm", $conn);
            $SizeNum = 3; // for later function  

        }elseif ($ItemType == 8 or $ItemType == 9){ // for headdress
            $headSize = $SizeArray[0];
            addtoSizeRequest($itemRequestID, 6, $headSize, "cm", $conn);
            $SizeNum = 1; // for later function  

        }elseif ($ItemType == 7){ // for boots 
            $shoeSize = $SizeArray[0];
            addtoSizeRequest($itemRequestID, 7, $shoeSize, "shoeSize", $conn);
            $SizeNum = 1; // for later function  
        }

        // find out if Kit requested Matches with Stock
        $qry = "SELECT sizes.itemID FROM ((sizes INNER JOIN sizesRequest ON sizes.value = sizesRequest.value) INNER JOIN items ON sizes.itemID = items.ID)  WHERE sizesRequest.itemID = :LItemID AND ItemTypeID = :itemTypeID ; ";
        echo "the uniformType is" . $ItemType. "<br>";
        $stmt = $conn->prepare($qry);
        echo $itemRequestID. "<br>";
        $stmt->bindParam(':LItemID', $itemRequestID);
        $stmt->bindParam(':itemTypeID', $ItemType);
        $stmt->execute();
        $result = $stmt->fetchAll(); // result is an array of arrays 

        $resultVal = resultToVal($result);
        if ($SizeNum > 1 ){ // arrMatch($itemIDArr, $SizeNum) does not work with one value  
            $matchedItemID = arrMatch($resultVal, $SizeNum);
            echo "matched item id:".$matchedItemID . "<br>";
        }else{
            $matchedItemID = $resultVal;
            echo "matched item id:".$matchedItemID . "<br>";
        }
        $inStock = addRequest($matchedItemID, $NumRequested, $itemRequestID, $conn); // num request comes from line 11
        if ($inStock == 1){
            $msg = " <p><b class = 'success'>Item Requested In Stock And Now Reserved For You</b></p>";
            echo $msg;
            $_SESSION['msg'] = $msg;
            
        }elseif($inStock == 0){
            onOrder($matchedItemID, $NumRequested, $itemRequestID, $conn); 
            $msg = "<p><b class = 'success'>Item Requested Not In Stock And Now On Order</b></p>";
            echo $msg;
            $_SESSION['msg'] = $msg;
            
        }
        header("location: kitRequest.php");
            //echo "$value <br>";
        //testing
        //echo $qry. "<br>";
        
        //var_dump($result);
        
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}
//SELECT ItemTypeID, sizeTypeID, `value`, unit
// FROM items
// INNER JOIN sizes
// ON items.ID = sizes.itemID
// INNER JOIN  ItemTypeID, sizeTypeID, `value`, unit
// FROM itemRequest
// INNER JOIN sizesRequest
// ON itemRequest.ID = sizesRequest.itemID WHERE itemID = :itemID;
?>