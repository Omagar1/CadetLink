<?php
// starts session
session_start();

//checks if already logged in 
if(isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] = true) ){
    header("location: mainPage.php"); // if so redirects them to the dasbord page
};

require_once "ConnectDB.php";
$uname = trim($_POST['Cnum']);
$pword = trim($_POST['Pwd']);

if ($uname != "" Or $pword != ""){
    try{
        $qry = "SELECT * FROM users WHERE Cnum = :Cnum AND Pword = :Pwd ; ";
        $stmt = $conn->prepare($qry);
        $stmt->bindParam('Cnum', $uname, PDO::PARAM_STR); // asiging varibles to SQL statement 
        $stmt->bindValue('Pwd', $pword, PDO::PARAM_STR);  // asiging varibles to SQL statement 
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 1 And !empty($row)) { //checks if there is a qry produced a username from the database and checks there's only one  
            // seting values used in other code
            $_SESSION['UserID'] = $row['ID'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['rank'] = $row['rank'];
            $_SESSION['section'] = $row['section'];
            header("location: mainPage.php");
          } else {
            $msg = "Invalid Cadet Number or Password!";
            header("location: index.php");
          }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}else {
    $msg = "Both fields are required!";
    header("location: index.php");
};

?>
