<?php
// starts session
session_start();

//checks if already logged in 
if(isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] == true) ){
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
            $_SESSION['CFAV'] = $row['CFAV'];
            $_SESSION['profilePicURL'] = $row['profilePicURL'];
            $msg = ""; // declars blank varible to remove error in index.php  
            $_SESSION['msg'] = $msg;
            echo $_SESSION['CFAV'];
            if ($_SESSION['CFAV'] == 1){ // Admin Check
                header("location: adminMainPage.php"); // if true redirects them to an Admin page
            }else{
                header("location: mainPage.php");   
            }
          } else {
            $msg = "Invalid Cadet Number or Password!";
            $_SESSION['msg'] = $msg;
            header("location: index.php");
          }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}else {
    $msg = "Both fields are required!";
    $_SESSION['msg'] = $msg;
    header("location: index.php");
};

?>
