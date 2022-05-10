<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link href="loginSignup.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php
      session_start();
      
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
      require_once "ConnectDB.php";

      function sizesCompressionAdmin($ItemID,$con){
        $sql = "SELECT sizes.itemID, sizes.value 
        FROM sizes INNER JOIN items ON sizes.ItemID = items.ID  
        WHERE sizes.itemID = ?;";
        $stmt = $con->prepare($sql);
        $stmt->execute([$ItemID]);
        // Making the sizes into the format =~ xx/yy/zz
        $arr  = []; //initializing
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($arr,$result['value']);
        }
        return(implode("/",$arr));
      }

      function SizesValidation($NumExpected, $input){
        //echo"i ran 3";
        $inputArr = explode("/",$input);
        $lenInputArr = count($inputArr);
        
    
        //checks if the number of sizes is what is Expected 
        if ($lenInputArr != $NumExpected){
             echo "len:".$lenInputArr . "<br> numExpt: " . $NumExpected . "<br>";
            //
            $msg = " <p><b class = 'error'>Either Too Few Or Too Many Sizes Given For Selected Item!</b></p>";
            $_SESSION['msg'] = $msg;
            //echo$msg ."<br>";
            //echo"input Arr:";
            //var_dump($inputArr); //test
            return (false);
        }else{
            $loop = 0;
            //echo"i ran 4";
            //echo"lenInputArr: ".$lenInputArr ."<br>";
            while ($loop < $lenInputArr){
                //var_dump($inputArr); //test
    
                //echo$inputArr[$loop];
                //echo"i ran 5"; // test 
                //echo"<br> is nummeric: ".is_numeric($inputArr[$loop]); //test
                // checks if the sizes contains letters or other charecters
                $temp = $inputArr[$loop];
                //echo"<br> temp: ". $temp. "<br> is_numeric:". is_numeric($temp)."<br>";
                if(is_numeric($temp) != 1){
                    //echo"i ran 6";
                    //
                    $msg = "<p><b class = 'error'> Sizes Must Only Contain Intigers Seperated By A / </b></p>";
                    $_SESSION['msg'] = $msg;
                    return (false);
                // checks if the sizes is too long
                }elseif (strlen($inputArr[$loop])>3){
                    //
                    $msg = "<p><b class = 'error'>Too Large Of A Size Inputed To Be Accepted</b></p>";
                    $_SESSION['msg'] = $msg;
                    return (false);
                }else{
                    //pass valadation
                }
                $loop = $loop + 1;
            }
            return(true);
        }
    
    
    }
    function getNumExpected($ItemTypeID, $con){
      //qry to find the number expected for the ItemType We want 
      // we do not need to check if there are more than one result because ItemTypeValidation already assures there is only one 
      $sql = "SELECT NumSizesExpected FROM itemType WHERE ID =? ;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemTypeID]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return(implode($result));
    }
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitKR'])){
  // getting the variables
  $ItemTypeID = trim($_POST['ItemType']);
  $Size = trim($_POST['Size']);
  $purpose = trim($_POST['purpose']);
  $NumRequested = trim($_POST['NumRequested']);
  echo $ItemTypeID ."<br>";
  echo $Size ."<br>";
  echo $purpose ."<br>";
  echo $NumRequested ."<br>";

  // set up for validating sizes
  $NumSizesExpected = getNumExpected($ItemTypeID, $conn);
  // general validation
  if ($ItemTypeID == "" or $Size == ""  or $purpose == ""  or $NumRequested == ""){
      echo"i Ran 1 <br>"; // test 
      
      $msg = "<p><b class = 'error'>Fields Must Not Be Empty </b></p>";
      $_SESSION['msg'] = $msg;
  }elseif (SizesValidation($NumSizesExpected, $Size) != true){
      // do nothing
      //echo"i Ran 2 <br>"; // test 
  }else{
  // send data to process page
    //echo"i Ran 3 <br>"; // test 
    ?>
    <form Id = "AutoSendForm" action = "KRProcess.php" method="post">
    <input type="hidden" id="ItemType" name="ItemType" value="<?php echo $ItemTypeID; ?>">
    <input type="hidden" id="Size" name="Size" value="<?php echo $Size; ?>">
    <input type="hidden" id="purpose" name="purpose" value="<?php echo $purpose; ?>">
    <input type="hidden" id="NumRequested" name="NumRequested" value="<?php echo $NumRequested; ?>">    
    </form>

    <script type="text/javascript">
    document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php

  }
}else{

}
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
      </div>
      <div id="container">
        
        <div id="main">
            <h2>Kit Request Page - Work in Progress </h2>

            <a href=#kitRequest.php >
              <button class ="button buttonPressed">Make A Request</button>
            </a>
            <a href=myRequests.php >
              <button class ="button">My Requests</button>
            </a>
          <fieldset>
            <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
            ?>
            <form action = "kitRequest.php" method="post">
              <label for="ItemType">ItemType</label><br>
              <select id="ItemType" name="ItemType">
                <?php
                $sql = "SELECT * FROM itemType;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  echo "<option value=".$row["ID"].">".$row["ItemTypeName"]."</option>";
                }
                ?>
              </select><br>
              <label for="Size">Nato Size</label><br>
              <input type="text" id="Size" name="Size" value=""><br>

              <label for="purpose">Purpose</label><br>
              <select id="purpose" name="purpose">
                <option value="GROWN OUT OF OLD KIT">Grown Out of Old Kit</option>
                <option value="NEVER ISSUED">Was Never Issued</option>
                <option value="LOST OLD KIT">Lost Old Kit</option>
                <option value="OLD KIT WAS DAMAGED">Old Kit Was Damaged</option>
                <option value="OTHER">Other</option>
              </select><br>

              <label for="NumRequested">How Many?</label><br>
              <select id="NumRequested" name="NumRequested">
                <option value="1">1</option>
                <option value="2">2</option>
              </select><br>
              <input type="submit" class = "button" name = "submitKR"  id = "submitKR">
              
            </form>
            </fieldset>

            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>