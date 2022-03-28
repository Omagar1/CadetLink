<?php
require_once "ConnectDB.php";
// $qry = "INSERT INTO test (test1, test2) VALUES (:test1,:test2)";
// $test1 = "hello";
// $test2 = "world";
// echo $qry;
// $stmt = $conn->prepare($qry);
// echo $test1 ."<br>".$test2;
// $stmt->bindParam(':test1', $test1);
// $stmt->bindParam(':test2', $test2);
// $stmt->execute();


$qry = "INSERT INTO `itemRequest` (`UniformType`) VALUES (:UniformType)";
echo $qry;
$stmt = $conn->prepare($qry);
//echo $UserID ."<br>".$UniformType."<br>". $NumRequested ."<br>".$purpose."<br>". $dateTimeRequested. "<br>";
$stmt->bindValue(':UniformType', "1");
$stmt->execute();
?>