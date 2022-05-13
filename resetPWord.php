<?php session_start();?>
<html>
  <head>
    <title>CadetLink</title>
    <link href="main.css" rel="stylesheet" />
    <link href="loginSignup.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
      function showPwd() {
        var x = document.getElementById("PwdInput");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
    <?php 
      // connects to database
      require_once "ConnectDB.php";
      //checks if not logged in 
      if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };

      // system to destroy msg variable when its not wanted
      if (isset($_SESSION['previous'])) {
        if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
              unset($_SESSION['msg']);
        }else{

        }
      }else{

      }
      $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
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

    <div id="navbarDash">
      <h2 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " ";
          echo $_SESSION['fname']. " ";
          echo $_SESSION['lname'];?></h2>
      <img class = "profilePic" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefalt" width="auto" height="150">
      <form action ="<?php
      if($_SESSION['troop']=="CFAV"){
        echo "manageUsers.php";
      }else{
        echo "mainPage.php";
      }
      ?>">
      <input type="submit" class = "smallButton" value="«" name="dashButton">
      </form>
    </div>
    <div id="container">
      
      <div id="main">
          <h2>Reset Password for: <?php echo $rank . $fname . $lname; ?>?</h2>
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