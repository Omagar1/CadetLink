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
      //checks if not logged in  - broken 
      if(isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };
      if (isset($_POST['submit'])){
        // validation

        }
// ---------------------------------------------------functions---------------------------------------------------

    function findName($IDuser, $con){
      $sql = "SELECT `rank`, fname, lname FROM users WHERE ID =?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$IDuser]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $fullName = implode(" ",$result);
      return($fullName);
    }
    
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
        echo "i ran 3";
        $inputArr = explode("/",$input);
        $lenInputArr = count($inputArr);
        var_dump($NumExpected);
    
        //checks if the number of sizes is what is Expected 
        if ($lenInputArr != $NumExpected){
            echo $lenInputArr . "<br>" . $NumExpected . "<br>";
            //
            $msg = " <p><b class = 'error'>Either Too Few Or Too Many Sizes Given For Selected Item!</b></p>";
            $_SESSION['msg'] = $msg;
            echo $msg ."<br>";
            echo "input Arr:";
            var_dump($inputArr); //test
            return (false);
        }else{
            $loop = 0;
            echo "i ran 4";
            echo "lenInputArr: ".$lenInputArr ."<br>";
            while ($loop < $lenInputArr){
                var_dump($inputArr); //test
    
                echo $inputArr[$loop];
                echo "i ran 5"; // test 
                echo "<br> is nummeric: ".is_numeric($inputArr[$loop]); //test
                // checks if the sizes contains letters or other charecters
                $temp = $inputArr[$loop];
                echo "<br> temp: ". $temp. "<br> is_numeric:". is_numeric($temp)."<br>";
                if(is_numeric($temp) != 1){
                    echo "i ran 6";
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
    function ItemTypeValidation($ItemTypeName, $con){
      // checking if such a Item type exist in DB
      $sql = "SELECT itemTypeName FROM itemType WHERE itemTypeName =? ;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemTypeName]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
      $lenResult = count($result);
      if ($lenResult == 0 ){
        return(false);  // if there is no result there is no uch a Item type in the DB
      }elseif ($lenResult == 1){
        return(true); // there is only one match, every thing check out there is one  
      }else{
        return(false); // if this happens there are two or mor of this Item type ban :(
        
      }
    }
    function getNumExpected($ItemTypeName, $con){
      //qry to find the number expected for the ItemType We want 
      // we do not need to check if there are more than one result because ItemTypeValidation already assures there is only one 
      $sql = "SELECT NumSizesExpected FROM itemType WHERE itemTypeName =? ;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemTypeName]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return(implode($result));
    }
    function getItemTypeID($ItemTypeName, $con){
      $sql = "SELECT ID FROM itemType WHERE itemTypeName =? ;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemTypeName]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return(implode($result));
    }
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitER'])){
  // getting the variables
  $itemID = $_POST['ID'];
  $NSN = $_POST['NSN'];
  $ItemType = $_POST['ItemType'];
  $NumIssued = $_POST['NumIssued'];
  $NumInStore = $_POST['NumInStore'];
  $NumReserved = $_POST['NumReserved'];
  $NumOrdered = $_POST['NumOrdered'];
  $Size = $_POST['Size'];
  // set up for validating sizes
  $NumSizesExpected = getNumExpected($ItemType, $conn);
  // general validation
  if ($itemID == "" or $NSN == ""  or $ItemType == ""  or $NumIssued == ""  or $NumInStore == ""  or $NumReserved == ""  or $NumOrdered == "" or $Size == ""){
      echo "i Ran 1 <br>"; // test 
      
      $msg = "<p><b class = 'error'>Fields Must Not Be Empty </b></p>";
      $_SESSION['msg'] = $msg;
  }elseif(ItemTypeValidation($ItemType, $conn) != true) {
      
      $msg = " <p><b class = 'error'> ItemType not matched with known ItemType </b></p>"; 
      $_SESSION['msg'] = $msg;
  }elseif (SizesValidation($NumSizesExpected, $Size) != true){
      
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
    <form Id = "AutoSendForm" action = "ERProcess.php" method="post">
    <input type="hidden" id="ID" name="ID" value="<?php echo $itemID; ?>">
    <input type="hidden" id="NSN" name="NSN" value="<?php echo $NSN; ?>">
    <input type="hidden" id="ItemTypeID" name="ItemType" value="<?php echo getItemTypeID($ItemType, $conn); ?>">
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
// ---------------------------------------------------main code---------------------------------------------------
  $itemID = $_POST['editRow'];
  // Qry to find requests of this User
  
  $sql = "SELECT * FROM items WHERE ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$itemID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  // initialising Column arrays
  $NSN  = $result['NSN'];
  $ItemTypeID  = $result['ItemTypeID'];
  $NumIssued  = $result['NumIssued'];
  $NumInStore  = $result['NumInStore'];
  $NumReserved  = $result['NumReserved'];
  $NumOrdered  = $result['NumOrdered'];


  // Qry to find the sizes of their requests
  
  // get the look up table for Item Type
  $sql = "SELECT itemTypeName FROM itemType WHERE ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$ItemTypeID]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  //var_dump($result); // test 
  $ItemType = implode($result);
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
      <button onclick="history.go(-1);">Back </button>
    </div>
    <div id="container">
      
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
            <form action = "editRow.php" method="post">
            <tr>
                <td>ID</td>
                <td><input type="text" id="ID" name="ID" value="<?php echo $itemID; ?>"readonly><br></td> <!-- cannot be edited -->
            <tr>
            <tr>
                <td>NSN</td>
                <td><input type="text" id="NSN" name="NSN" value="<?php echo $NSN; ?>"><br></td>
            <tr>
            <tr>
                <td>ItemType</td>
                <td><input type="text" id="ItemType" name="ItemType" value="<?php echo $ItemType; ?>"><br></td>
            <tr>
            <tr>
                <td>NumIssued</td>
                <td><input type="text" id="NumIssued" name="NumIssued" value="<?php echo $NumIssued; ?>"><br></td>
            <tr>
            <tr>
                <td>NumInStore</td>
                <td><input type="text" id="NumInStore" name="NumInStore" value="<?php echo $NumInStore; ?>"><br></td>
            <tr>
            <tr>
                <td>NumReserved</td>
                <td><input type="text" id="NumReserved" name="NumReserved" value="<?php echo $NumReserved; ?>"><br></td>
            <tr>
            <tr>
                <td>NumOrdered</td>
                <td><input type="text" id="NumOrdered" name="NumOrdered" value="<?php echo $NumOrdered; ?>"><br></td>
            <tr>
            <tr>
                <td>Size</td>
                <td><input type="text" id="Size" name="Size" value="<?php echo sizesCompressionAdmin($itemID,$conn); ?>"><br></td>
            <tr>
            </table>
            <input type="submit" name ="submitER" class = "button" value="Save">

            </form>
          </fieldset>
      </div>
    </div>
    <div id="footer">

    </div>
  </body>
</html>