<?php
session_start();

require_once "ConnectDB.php";

// if (isset($_POST['Xdata'])){
//     echo "set <br> ";
// }else{
//     echo" NOT set <br>";
// }



try{
    if(isset($_POST['sub1NumInStore'])){
        $itemID = $_POST['sub1NumInStore'];
        echo "iran ";
    }elseif(isset($_POST['Plus1NumInStore'])){
        $itemID = $_POST['Plus1NumInStore'];
        echo "iran2" ;
    }
    else{
        header("location: stock.php");
    }
    // getting currant data  
    $qry = "SELECT NumInStore FROM items WHERE ID = ?;" ;
    $stmt = $conn->prepare($qry);
    $stmt->execute([$itemID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($result);

    $oldNumInStore = $result["NumInStore"];
    if(isset($_POST['sub1NumInStore'])){
        if ($oldNumInStore != 0){
        $newNumInStore  = $oldNumInStore - 1;
        }
        else{
        
        }
        
    }elseif(isset($_POST['Plus1NumInStore'])){
        $newNumInStore  = $oldNumInStore + 1;  
        
    }
    
    // updating items table 
    
    $qry = "UPDATE items SET NumInStore =? WHERE ID = ?;";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$newNumInStore, $itemID]);
    header("location: Stock.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}
   

?>