<?php
// starts session
session_start();


require_once "ConnectDB.php";
// gets values from Form
$UniformType = trim($_POST['UniformType']);
$Size = trim($_POST['Size']);
$Perpose = trim($_POST['Perpose']);
$NumRequested = trim($_POST['NumRequested']);

function addtoSizeRequest($itemID, $value, $unit){
    $qry = "INSERT INTO sizesRequest (itemID ,sizeTypeID, value, unit)
VALUES (?,?,?,?) ";
$stmt = $conn->prepare($qry);
$stmt->execute([$itemID,$sizeTypeID,$value,$unit]);

}

if ($UniformType != "" or $Perpose != "" or $NumRequested != "" ){
    try{
        // addding items to ItemRequest table
        $UserID = $_SESSION['UserID'];
        $dateTimeRequested = date("Y-m-d H:i");
        $qry = "INSERT INTO itemRequest (UserID, ItemTypeID, NumRequested, purpose, DateRequested) VALUES (:UserID,:UniformType,:NumRequested,:Perpose,:dateTimeRequested)";
        echo $qry;
        $stmt = $conn->prepare($qry);
        echo $UserID ."<br>".$UniformType."<br>". $NumRequested ."<br>".$Perpose."<br>". $dateTimeRequested. "<br>";
        $stmt->bindParam(':UserID', $UserID);
        $stmt->bindParam(':UniformType', $UniformType);
        $stmt->bindParam(':NumRequested', $NumRequested);
        $stmt->bindParam(':Perpose', $Perpose);
        $stmt->bindParam(':dateTimeRequested', $dateTimeRequested);
        $stmt->execute();
        //[$UserID,$UniformType,$NumRequested,$Perpose,$dateTimeRequested]
        // get ID of Item Just Added
        if ($conn->query($qry) === TRUE) {
            $conn->exec($qry);
            $last_id = $conn->lastInsertId();
            } else {
            echo "Error: " . $qry . "<br>" . $conn->error;
            }
        // checks if $Sizes is empty so latter elements dont brake
        if ($Size == ""){ 
            $msg = " all fields are required!";
            $_SESSION['msg'] = $msg;
            //will redirect back to page
        }else{
            
        }
        // getting the Size in a Usable format and then adding them to the sizeRequest table    
        $SizeArray = explode("/",$Size); // create array out of sizes xx/yy/zz => [0] = xx [1] = yy [2] = zz
        if ($UniformType = 1 or $UniformType = 2 or $UniformType = 3 or $UniformType = 4){ // for torso items
            $height = $SizeArray[0];
            addtoSizeRequest($itemID, $height, "cm");
            $chest = $SizeArray[1];
            addtoSizeRequest($itemID, $chest, "cm");
        } elseif ($UniformType = 1){ // for trousers
            $waist = $SizeArray[0];
            addtoSizeRequest($itemID, $waist, "cm");
            $insideLeg = $SizeArray[1];
            addtoSizeRequest($itemID, $insideLeg, "cm");
            $seat = $SizeArray[2]; 
            addtoSizeRequest($itemID, $seat, "cm");
        }elseif ($UniformType = 8 or $UniformType = 9){ // for headdress
            $headSize = $SizeArray[0];
            addtoSizeRequest($itemID, $headSize, "cm");
        }elseif ($UniformType = 7){ // for boots 
            $shoeSize = $SizeArray[0];
            addtoSizeRequest($itemID, $seat, "shoeSize");
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}else {
    $msg = "all fields are required!";
    $_SESSION['msg'] = $msg;
};

?>
