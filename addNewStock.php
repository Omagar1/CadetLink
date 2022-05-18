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
      if (isset($_POST['submit'])){
        // validation

      }
// ---------------------------------------------------functions---------------------------------------------------
    
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
        //echo "i ran 3";
        $inputArr = explode("/",$input);
        $lenInputArr = count($inputArr);
        //var_dump($NumExpected);
    
        //checks if the number of sizes is what is Expected 
        if ($lenInputArr != $NumExpected){
            //echo $lenInputArr . "<br>" . $NumExpected . "<br>";
            //
            $msg = " <p><b class = 'error'>Either Too Few Or Too Many Sizes Given For Selected Item!</b></p>";
            $_SESSION['msg'] = $msg;
            //echo $msg ."<br>";
            //echo "input Arr:";
            //var_dump($inputArr); //test
            return (false);
        }else{
            $loop = 0;
            //echo "i ran 4";
            //echo "lenInputArr: ".$lenInputArr ."<br>";
            while ($loop < $lenInputArr){
                //var_dump($inputArr); //test
    
                //echo $inputArr[$loop];
                //echo "i ran 5"; // test 
                //echo "<br> is nummeric: ".is_numeric($inputArr[$loop]); //test
                // checks if the sizes contains letters or other charecters
                $temp = $inputArr[$loop];
                //echo "<br> temp: ". $temp. "<br> is_numeric:". is_numeric($temp)."<br>";
                if(is_numeric($temp) != 1){
                    //echo "i ran 6";
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
      $sql = "SELECT NumSizesExpected FROM itemType WHERE ID =? ;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemTypeID]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return(implode($result));
    }
    
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitANS'])){
  // getting the variables
  $itemID = $_POST['ID'];
  $NSN = $_POST['NSN'];
  $ItemTypeID = $_POST['ItemType'];
  $NumIssued = $_POST['NumIssued'];
  $NumInStore = $_POST['NumInStore'];
  $NumReserved = $_POST['NumReserved'];
  $NumOrdered = $_POST['NumOrdered'];
  $Size = $_POST['Size'];
  // set up for validating sizes
  $NumSizesExpected = getNumExpected($ItemTypeID, $conn);
  // general validation
  if ($itemID == "" or $ItemTypeID == ""  or $NumIssued == ""  or $NumInStore == ""  or $NumReserved == ""  or $NumOrdered == "" or $Size == ""){
      //echo "i Ran 1 <br>"; // test 
      
      $msg = "<p><b class = 'error'>Fields Must Not Be Empty </b></p>";
      $_SESSION['msg'] = $msg;
  }elseif (SizesValidation($NumSizesExpected, $Size) != true){
  // sizesValidation() has its own messages  
  }elseif(is_numeric($NumIssued) != true){
      
      $msg = " <p><b class = 'error'> NumIssued has to be an Integer</b></p>"; 
      $_SESSION['msg'] = $msg;
  }elseif( is_numeric($NumInStore) != true){
      
      $msg = " <p><b class = 'error'> NumInStore has to be an Integer  </b></p>"; 
      $_SESSION['msg'] = $msg;
  }elseif( is_numeric($NumReserved) != true){
      
      $msg = " <p><b class = 'error'> NumReserved has to be an Integer  </b></p>"; 
      $_SESSION['msg'] = $msg;
  }elseif( is_numeric($NumReserved) != true){
      
      $msg = " <p><b class = 'error'> NumOrdered has to be an Integer </b></p>"; 
      $_SESSION['msg'] = $msg;
  }else{
  // send data to process page
    ?>
    <form Id = "AutoSendForm" action = "ANSProcess.php" method="post">
    <input type="hidden" id="NSN" name="NSN" value="<?php echo $NSN; ?>">
    <input type="hidden" id="ItemTypeID" name="ItemType" value="<?php echo $ItemTypeID;?>">
    <input type="hidden" id="NumIssued" name="NumIssued" value="<?php echo $NumIssued; ?>">
    <input type="hidden" id="NumInStore" name="NumInStore" value="<?php echo $NumInStore; ?>">
    <input type="hidden" id="NumReserved" name="NumReserved" value="<?php echo $NumReserved; ?>">
    <input type="hidden" id="NumOrdered" name="NumOrdered" value="<?php echo $NumOrdered; ?>">
    <input type="hidden" id="Size" name="Size" value="<?php echo $Size; ?>">
    </form>

    <script type="text/javascript">
    document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php

  }
}else{
// ---------------------------------------------------main code--------------------------------------------------- {

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
      <!-- back button --> 
      <form action ="<?php
      if($_SESSION['troop']=="CFAV"){
        echo "Stock.php";
      }else{
        echo "mainPage.php";
      }
      ?>">
      <input type="submit" class = "smallButton" value="«" name="dashButton">
      </form>
    </div>
      <div id="main">
          <h2>Virtual stores - Work in Progress </h2>
          <fieldset>
            <?php if (isset($_SESSION["msg"]) != ""){
                echo $_SESSION['msg'];
                }else{

                }
            ?>
            <table class = "tableDisplay">
            <tr>
                  <th>Column Name</th>
                  <th>Data</th>
            </tr>
            <form action = "addNewStock.php" method="post">
            <tr>
                <td>ID</td>
                <td><input type="text" id="ID" name="ID" value="Auto Generated"readonly><br></td> <!-- cannot be edited -->
            <tr>
            <tr>
                <td>NSN</td>
                <td><input type="text" id="NSN" name="NSN" value=""><br></td>
            <tr>
            <tr>
                <td>ItemType</td>
                <td><select id="ItemType" name="ItemType">
                  <?php
                  $sql = "SELECT * FROM itemType;";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value=".$row["ID"].">".$row["ItemTypeName"]."</option>";
                  }
                  ?>
                </select><br></td>
            <tr>
            <tr>
                <td>NumIssued</td>
                <td><input type="text" id="NumIssued" name="NumIssued" value=""><br></td>
            <tr>
            <tr>
                <td>NumInStore</td>
                <td><input type="text" id="NumInStore" name="NumInStore" value=""><br></td>
            <tr>
            <tr>
                <td>NumReserved</td>
                <td><input type="text" id="NumReserved" name="NumReserved" value=""><br></td>
            <tr>
            <tr>
                <td>NumOrdered</td>
                <td><input type="text" id="NumOrdered" name="NumOrdered" value=""><br></td>
            <tr>
            <tr>
                <td>Size</td>
                <td><input type="text" id="Size" name="Size" value=""><br></td>
            <tr>
            </table>
            <input type="submit" name ="submitANS" class = "button" value="Add">

            </form>
          </fieldset>
      </div>
    <div id="footer">

    </div>
  </body>
</html>