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

}

if ($UniformType != "" or $purpose != "" or $NumRequested != "" ){
    try{
        // addding items to ItemRequest table
        $UserID = $_SESSION['UserID'];
        $UserID = (int)$UserID;
        $dateTimeRequested = date("Y-m-d H:i");
        $qry = "INSERT INTO `itemRequest` (`UserID`, `ItemTypeID`,`NumRequested`,`purpose`,`DateRequested`) VALUES (?,?,?,?,?)";
        echo $qry;
        $stmt = $conn->prepare($qry);
        echo $UserID ."<br>".$UniformType."<br>". $NumRequested ."<br>".$purpose."<br>". $dateTimeRequested. "<br>";
        $stmt->bindValue(':UniformType', "1");
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
        if ($UniformType == 1 or $UniformType == 2 or $UniformType == 3 or $UniformType == 4){ // for torso items
            $height = $SizeArray[0];
            addtoSizeRequest($itemID, 1, $height, "cm", $conn);
            $chest = $SizeArray[1];
            addtoSizeRequest($itemID, 2, $chest, "cm", $conn);

        } elseif ($UniformType == 5){ // for trousers
            $waist = $SizeArray[0];
            addtoSizeRequest($itemID, 3, $waist, "cm", $conn);
            $insideLeg = $SizeArray[1];
            addtoSizeRequest($itemID, 4, $insideLeg, "cm", $conn);
            $seat = $SizeArray[2]; 
            addtoSizeRequest($itemID, 5, $seat, "cm", $conn);

        }elseif ($UniformType == 8 or $UniformType == 9){ // for headdress
            $headSize = $SizeArray[0];
            addtoSizeRequest($itemID, 6, $headSize, "cm", $conn);

        }elseif ($UniformType == 7){ // for boots 
            $shoeSize = $SizeArray[0];
            addtoSizeRequest($itemID, 7, $seat, "shoeSize", $conn);
        }
        
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}else {
    $msg = "all fields are required!";
    $_SESSION['msg'] = $msg;
};

?>
