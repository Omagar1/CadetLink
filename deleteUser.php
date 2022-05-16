<?php
session_start();

require_once "ConnectDB.php";

try{
    $userID = $_POST['Xdata'];


    if (trim($_SESSION['UserID']) == trim($userID)){
        $msg = "<p><b class = 'error'>No Matter How Bad You Feel You Never Want To Delete Your Self!</b></p>";
        $_SESSION['msg'] = $msg;

    }else{
        $qry = "DELETE FROM users WHERE ID = ?;";
        $stmt = $conn->prepare($qry);
        $stmt->execute([$userID]);
    }
    header("location: manageUsers.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

?>