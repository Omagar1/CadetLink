<?php 
// starts session
session_start();
require_once "ConnectDB.php";
// gets values from Form
$UniformType = trim($_POST['UniformType']);
$Size = trim($_POST['Size']);
$purpose = trim($_POST['purpose']);
$NumRequested = trim($_POST['NumRequested']);

function addtoSizeRequest($itemID, $sizeTypeID, $value, $unit, $con){ 
    $qry = "INSERT INTO `sizesRequest` (`itemID` ,`sizeTypeID`, `value`, `unit`)
VALUES (?,?,?,?) ";
$stmt = $con->prepare($qry);
$stmt->execute([$itemID,$sizeTypeID,$value,$unit]);
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
        if ($matchCount == $numExpected-1){ // the number of matched values will always be $numExpected-1 
            return($matchedItemID);
        }else{

        }
        $prevVal = $val; // sets $prevVal for next loop  

    }
    echo "failed to find a match";
    return(0);// ie no ID 
}


if ($UniformType != "" or $purpose != "" or $NumRequested != "" ){
    try{
        // addding items to ItemRequest table
        $UserID = $_SESSION['UserID'];
        $UserID = (int)$UserID;
        $dateTimeRequested = date("Y-m-d H:i");
        $qry = "INSERT INTO `itemRequest` (`UserID`, `ItemTypeID`,`NumRequested`,`purpose`,`DateRequested`) VALUES (?,?,?,?,?);";
        //echo $qry;
        $stmt = $conn->prepare($qry);
        //echo $UserID ."<br>".$UniformType."<br>". $NumRequested ."<br>".$purpose."<br>". $dateTimeRequested. "<br>";
        $stmt->execute([$UserID,$UniformType,$NumRequested,$purpose,$dateTimeRequested]);
        // gets ID of last item added 
        $itemID = $conn->lastInsertId();
        // checks if $Sizes is empty so latter elements dont brake
        if ($Size == ""){ 
            $msg = " all fields are required!";
            $_SESSION['msg'] = $msg;
            //will redirect back to page
        }else{
            
        }
        // getting the Size in a Usable format and then adding them to the sizeRequest table    
        $SizeArray = explode("/",$Size); // create array out of sizes ie:  xx/yy/zz => [0] = xx [1] = yy [2] = zz
        var_dump($SizeArray);
        if ($UniformType == 1 or $UniformType == 2 or $UniformType == 3 or $UniformType == 4){ // for torso items
            $height = $SizeArray[0];
            addtoSizeRequest($itemID, 1, $height, "cm", $conn);
            $chest = $SizeArray[1];
            addtoSizeRequest($itemID, 2, $chest, "cm", $conn);
            $SizeNum = 2;// for later function  

        } elseif ($UniformType == 5){ // for trousers
            $waist = $SizeArray[0];
            addtoSizeRequest($itemID, 3, $waist, "cm", $conn);
            $insideLeg = $SizeArray[1];
            addtoSizeRequest($itemID, 4, $insideLeg, "cm", $conn);
            $seat = $SizeArray[2]; 
            addtoSizeRequest($itemID, 5, $seat, "cm", $conn);
            $SizeNum = 3; // for later function  

        }elseif ($UniformType == 8 or $UniformType == 9){ // for headdress
            $headSize = $SizeArray[0];
            addtoSizeRequest($itemID, 6, $headSize, "cm", $conn);
            $SizeNum = 1; // for later function  

        }elseif ($UniformType == 7){ // for boots 
            $shoeSize = $SizeArray[0];
            addtoSizeRequest($itemID, 7, $shoeSize, "shoeSize", $conn);
            $SizeNum = 1; // for later function  

        }


        // find out if Kit requested Matches with Stock
        $qry = "SELECT sizes.itemID FROM ((sizes INNER JOIN sizesRequest ON sizes.value = sizesRequest.value) INNER JOIN items ON sizes.itemID = items.ID)  WHERE sizesRequest.itemID = :LItemID AND ItemTypeID = :itemTypeID ; ";
        echo "the uniformType is" . $UniformType. "<br>"; //test
        $stmt = $conn->prepare($qry);
        echo $itemID. "<br>";
        $stmt->bindParam(':LItemID', $itemID);
        $stmt->bindParam(':itemTypeID', $UniformType);
        $stmt->execute();
        $result = $stmt->fetchAll();
        // result is an array of arrays 
        $itemIDArr = [];
        foreach ($result as $subArr) {
            foreach ($subArr as $val ) {
                array_push($itemIDArr,$val);
                echo $val . "<br>" ;// prints dublicates for some reason
                //var_dump($itemIDArr);
            };
          }
        //\array_splice($itemIDArr, 0, 1);// removes dublicates, hopfully 
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
        echo "After : <br>";
        foreach ($itemIDArr as $val){
            echo $val . "<br>" ;
        }
        $matchedItemID = arrMatch($itemIDArr, $SizeNum);
        echo $matchedItemID . "<br>";

        if ($matchedItemID != 0)
            //echo "$value <br>";
        //testing
        //echo $qry. "<br>";

        var_dump($result);


    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}else {
    $msg = "all fields are required!";
    $_SESSION['msg'] = $msg;
};
//SELECT ItemTypeID, sizeTypeID, `value`, unit
// FROM items
// INNER JOIN sizes
// ON items.ID = sizes.itemID
// INNER JOIN  ItemTypeID, sizeTypeID, `value`, unit
// FROM itemRequest
// INNER JOIN sizesRequest
// ON itemRequest.ID = sizesRequest.itemID WHERE itemID = :itemID;
?>