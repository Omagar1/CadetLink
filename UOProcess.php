<?php
session_start();
require_once "ConnectDB.php";
if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
    header("location: index.php"); // if so redirects them to the loginpage page
}
// Getting the data 
$fileName = $_POST["fileNameFinal"];
$dateFor = $_POST["dateFor"];
$fileType = $_POST["fileType"];
$fileTempLocation = $_POST["fileTempLocation"];
// echoing out variables for testing 
echo "<br>filename: ". $fileName;
echo "<br>DateFor: " . $dateFor;
echo "<br>fileType: " . $fileType;
echo "<br>fileTempLocation: " . $fileTempLocation;
$targetDir = "Orders/";
$fileFinalLocation = $targetDir . $fileName;

$moved = move_uploaded_file($fileTempLocation, $fileFinalLocation);
echo "<br>moved Status: ". $moved; 
if ($moved == true) {
    $msg =  "<p id = 'msg'><b class = 'success'>The file ". htmlspecialchars($fileName). " has been uploaded</b></p>";
    $_SESSION['msg'] = $msg;
    echo $msg;
    
    //adding file to Orders table
    $sql = "INSERT INTO orders (`name`,dateFor,`location`) VALUES(?,?,?);";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$fileName,$dateFor,$fileFinalLocation]);

} else {
    $msg =  "<p id = 'msg'><b class = 'error'>Sorry, there was an error uploading your file. Error N.o".$_FILES["file"]["error"]."</b></p>";
    $_SESSION['msg'] = $msg;
    echo $msg;
}
//header("location:ordersAdmin.php");