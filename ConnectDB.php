<?php
$servername = "2-12.co.uk";
$username = "jrowden";
$password = "tjwa1234";

try {
  $conn = new PDO("mysql:host=$servername;dbname=CadetLinkDB; charset=utf8mb4", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully </br>";
} catch(PDOException $e) {
  echo $e;
}
?>