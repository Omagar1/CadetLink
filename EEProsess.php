<?php
session_start();
require_once "ConnectDB.php";

// Getting the data 
// event Variables
$eventID = $_POST["eventID"];
$eventName = $_POST["eventName"];
$eventLocation = $_POST["eventLocation"];
$eventStartDate = $_POST["eventStartDate"];
$eventEndDate = $_POST["eventEndDate"];
$eventStartTime = $_POST["eventStartTime"];
$eventEndTime = $_POST["eventEndTime"];
// File Variables
$fileType = $_POST["fileType"];
$fileTempLocation = $_POST["fileTempLocation"];

// echoing out variables for testing 
// event Variables
echo "<br>eventName: " . $eventName;
echo "<br>eventLocation: " . $eventLocation;
echo "<br>eventStartDate: " . $eventStartDate;
echo "<br>eventEndDate: " . $eventEndDate;
echo "<br>eventStartTime: " . $eventStartTime;
echo "<br>eventEndTime: " . $eventEndTime;

// File Variables
echo "<br>fileType: " . $fileType;
echo "<br>fileTempLocation: " . $fileTempLocation;

// Uploading Event variables
$qry = "UPDATE events
SET `name` = ?, `location` = ?, `startDate` = ?, `endDate` = ?, `startTime` = ?, `endTime` = ?,
WHERE condition;";
$stmt = $conn->prepare($qry);
$stmt->execute([$eventName, $eventLocation, $eventStartDate, $eventEndDate, $eventStartTime, $eventEndTime]);

//file stuff - currently broken 
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
header("location: ");