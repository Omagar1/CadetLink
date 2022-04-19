<?php
session_start();

require_once "ConnectDB.php";

// if (isset($_POST['Xdata'])){
//     echo "set <br> ";
// }else{
//     echo" NOT set <br>";
// }
//echo "hello" . $_POST['Xdata'] . "world <br>" ;
//echo "data type:  ". gettype($_POST['Xdata']) . "<br>";
//echo "length: ". count($_POST['Xdata']) . "<br>";

//echo $ItemID . "test <br>";

$itemID = $_POST['Xdata'];

$qry = "DELETE FROM itemRequest WHERE ID = ?;";
$stmt = $conn->prepare($qry);
$stmt->execute([$itemID]);

$qry = "DELETE FROM sizesRequest WHERE itemID = ?;";
$stmt = $conn->prepare($qry);
$stmt->execute([$itemID]);

header("location: myRequests.php");


?>