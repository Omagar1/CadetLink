<?php
session_start();

require_once "ConnectDB.php";

// if (isset($_POST['Xdata'])){
//     echo "set <br> ";
// }else{
//     echo" NOT set <br>";
// }



try{
    $Operation = $_REQUEST["ItemID"];
    $itemID = $_REQUEST["ItemID"];
    
    if($Operation == "-"){
        $qry = "UPDATE items SET NumInStore = NumInStore - 1  WHERE ID = ? AND NumInStore > 0 ;";
    }elseif($Operation == "+"){
        $qry = "UPDATE items SET NumInStore = NumInStore + 1 WHERE ID = ?;";  
    }
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
    //header("location: Stock.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>