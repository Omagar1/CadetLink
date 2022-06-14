<?php
session_start();
 include "functions.php";
 require_once "ConnectDB.php"
?>

<html>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
// ---------------------------------------------------functions---------------------------------------------------  
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitPR'])){
    echo "I Ran ";
  // getting the variables
  $userID = $_POST['userID'];
  $PwdNew = $_POST['PwdNew'];
  $PwdConfirm = $_POST['PwdConfirm'];
  // general validation
  if ($PwdNew == "" or $PwdConfirm == "" ){
    //echo "i Ran 1 <br>"; // test 
    $msg = "<p><b class = 'error'>Fields Must Not Be Empty </b></p>";
    $_SESSION['msg'] = $msg;
  }elseif($PwdNew != $PwdConfirm ){
    $msg = "<p><b class = 'error'>Passwords Do not Match</b></p>";
    $_SESSION['msg'] = $msg;
    //echo "i Ran 2 <br>"; // test 
  }else{
      //hashes Password
    $PwdHashed = password_hash($PwdNew, PASSWORD_DEFAULT);
  // send data to process page
    
    ?>
    <form Id = "AutoSendForm" action = "PRProcess.php" method="post">
    <input type="hidden" id="ID" name="ID" value="<?php echo $userID; ?>">
    <input type="hidden" id="Pwd" name="Pwd" value="<?php echo $PwdHashed; ?>">
    </form>

    <script type="text/javascript">
    document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php

  }
}else{
  
// ---------------------------------------------------main code--------------------------------------------------- 
    $userID = $_POST['resetPWord'];
    // Qry to find the rest of the data 
}
// Qry to find the rest of the data
$sql = "SELECT * FROM users WHERE ID = ?;";
$stmt = $conn->prepare($sql);
$stmt->execute([$userID]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// initialising Column arrays
$rank = $result['rank'];
$fname = $result['fname'];
$lname = $result['lname'];
//echo "Submit is:". isset($_POST['submitPR']);

      
    ?>
  </head>

  <body id = "test">
    <div id="header">
      <h1>CadetLink</h1>
    </div>

    <?php NavBar(); ?>
    <div id="container">
      
      <div id="main">
          <h2>Reset Password for: <?php echo $rank ." ". $fname ." " . $lname; ?></h2>
          <fieldset>
            <?php if (isset($_SESSION["msg"])){
                  echo $_SESSION['msg'];
                }else{
                  echo "";
                }
                
            ?>
            <form action = "resetPWord.php" method = "post">
                <label for = "PwdNew">Enter New Password:</label> <br>
                <input type = "password" id = "PwdNew" name  ="PwdNew" value = "<?php
                if(isset($PwdNew)){
                  echo $PwdNew;
                }else{
                  echo"";
                }
                ?>"><br>
                <label for = "PwdConfirm"> Confirm Password:</label> <br>
                <input type = "password" id = "PwdConfirm" name = "PwdConfirm" value = "<?php
                if(isset($PwdConfirm)){
                  echo $PwdConfirm;
                }else{
                  echo"";
                }
                ?>"><br>
                <input type="hidden" id="userID" name="userID" value="<?php echo $userID; ?>">
                <input type="submit" name ="submitPR" class = "button" value="Save">

            </form>
          </fieldset>
      </div>
    </div>
    <div id="footer">

    </div>
  </body>
</html>