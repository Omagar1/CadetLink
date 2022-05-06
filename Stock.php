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
      $sizeFindUsed = false;
      $count = 0;
      // connects to database
      require_once "ConnectDB.php";
      //checks if not logged in  - broken 
     if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };

    // Qry to find the sizes of their requests
    function sizesCompressionAdmin($ItemID,$con){
      $sql = "SELECT sizes.itemID, sizes.value 
      FROM sizes INNER JOIN items ON sizes.ItemID = items.ID  
      WHERE sizes.itemID = ?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$ItemID]);
      // Making the size into the format =~ xx/yy/zz
      $arr = []; //initialising
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row['value']);
      }
      return(implode("/",$arr));
    }

    function findName($IDuser, $con){
      $sql = "SELECT `rank`, fname, lname FROM users WHERE ID =?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$IDuser]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $fullName = implode(" ",$result);
      return($fullName);
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

    function matchArr($arr1, $arr2){
      $arrMatched = [];
      foreach($arr1 as $val1){
        foreach($arr2 as $val2){
          if($val1 == $val2){
            array_push($arrMatched,$val1);
          }else{

          }
        }
      }
      return($arrMatched);
    }
    function sizeFind($Size1,$Size2,$Size3,$ItemTypeID,$NumExpected, $con){
      //echo "iran0";
      $qry = "SELECT itemID FROM sizes WHERE `value` = ?;";
      $stmt = $con->prepare($qry);
      $Size1ItemIDArr = [];
      $Size2ItemIDArr = [];
      $Size3ItemIDArr = [];
      if ($NumExpected == 1){
        $stmt->execute([$Size1]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size1ItemIDArr,$row['itemID']);
        }
        //var_dump($Size1ItemIDArr);
        return($Size1ItemIDArr);
      }elseif ($NumExpected == 2){
        $stmt->execute([$Size1]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size1ItemIDArr,$row['itemID']);
        }
        $stmt->execute([$Size2]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size2ItemIDArr,$row['itemID']);
        }
        $matchedItemIDarr1 = matchArr($Size1ItemIDArr,$Size2ItemIDArr);
        return($matchedItemIDarr1);
      }elseif ($NumExpected == 3){
        $stmt->execute([$Size1]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size1ItemIDArr,$row['itemID']);
        }
        $stmt->execute([$Size2]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size2ItemIDArr,$row['itemID']);
        }
        $stmt->execute([$Size3]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($Size3ItemIDArr,$row['itemID']);
        }
        $matchedItemIDarr1 = matchArr($Size1ItemIDArr,$Size2ItemIDArr);
        $matchedItemIDarr2 = matchArr($matchedItemIDarr1,$Size3ItemIDArr);// match the third array to the already matched array
        return($matchedItemIDarr2);
      }else{
        return(0);
      }
    }
      
//----------------------------------------Main Code----------------------------------------
// initialising colum arrays
$IDArr = [];
$NSNArr = [];
$ItemTypeIDArr = [];
$NumIssuedArr = [];
$NumInStoreArr = [];
$NumReservedArr = [];
$NumOrderedArr = [];


if (isset($_POST['find'])){
  $findItemTypeID = $_POST["ItemType"];
  $findSize1 = $_POST["Size1"];
  $findSize2 = $_POST["Size2"];
  $findSize3 = $_POST["Size3"];

  if ($findItemTypeID != 0 /* */ and $findSize1 != "" and $findSize2 != "" and $findSize3 != ""){

    $sql = "SELECT * FROM items WHERE ItemTypeID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$findItemTypeID]);
    $count = $stmt->rowCount();
    //echo "I ran 0 <br>";
  }elseif($findSize1 != "" and $findSize2 != "" and $findSize3 != "" and $findItemTypeID != 0){
    $NumExpected  = 3;
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      $sql = "SELECT * FROM items WHERE ID = ? AND ItemTypeID = ?;"; ///ahhh 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val, $findItemTypeID]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row != false){ 
        array_push($IDArr,$row['ID']);
        array_push($NSNArr,$row['NSN']);
        array_push($ItemTypeIDArr,$row['ItemTypeID']);
        array_push($NumIssuedArr,$row['NumIssued']);
        array_push($NumInStoreArr,$row['NumInStore']);
        array_push($NumReservedArr,$row['NumReserved']);
        array_push($NumOrderedArr,$row['NumOrdered']);
      }else{

      }
    }
    //echo "iran1";
    //var_dump($IDArr);
    $sizeFindUsed = true;
    //echo "I ran 3 <br>";
  }elseif($findSize1 != "" and $findSize2 != "" and $findItemTypeID != 0 /* */ and $findSize3 == ""){
    $NumExpected  = 2;
    $findSize3 = 0; // adding a blank value so error is not thrown
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      
      $sql = "SELECT * FROM items WHERE ID = ? AND ItemTypeID = ?;"; 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val, $findItemTypeID]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row != false){ 
        array_push($IDArr,$row['ID']);
        array_push($NSNArr,$row['NSN']);
        array_push($ItemTypeIDArr,$row['ItemTypeID']);
        array_push($NumIssuedArr,$row['NumIssued']);
        array_push($NumInStoreArr,$row['NumInStore']);
        array_push($NumReservedArr,$row['NumReserved']);
        array_push($NumOrderedArr,$row['NumOrdered']);
      }else{

      }
    }
    //echo "iran2";
    //var_dump($IDArr);
    $sizeFindUsed = true;
  }elseif($findSize1 != "" and $findItemTypeID != 0 /* */and $findSize2 == "" and $findSize3 == ""){
    $NumExpected  = 2;
    $findSize2 = 0; // adding a blank value so error is not thrown
    $findSize3 = 0; // adding a blank value so error is not thrown
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      $sql = "SELECT * FROM items WHERE ID = ? AND ItemTypeID = ?;"; 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val, $findItemTypeID]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row != false){ 
      array_push($IDArr,$row['ID']);
      array_push($NSNArr,$row['NSN']);
      array_push($ItemTypeIDArr,$row['ItemTypeID']);
      array_push($NumIssuedArr,$row['NumIssued']);
      array_push($NumInStoreArr,$row['NumInStore']);
      array_push($NumReservedArr,$row['NumReserved']);
      array_push($NumOrderedArr,$row['NumOrdered']);
      }else{

      }
    }
    //echo "iran3";
    //var_dump($IDArr);
    $sizeFindUsed = true;
  }elseif($findSize1 != "" and $findSize2 != "" and $findSize3 != "" and /* */ $findItemTypeID == 0){
    $NumExpected  = 3;
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      $sql = "SELECT * FROM items WHERE ID = ?;"; 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      array_push($IDArr,$row['ID']);
      array_push($NSNArr,$row['NSN']);
      array_push($ItemTypeIDArr,$row['ItemTypeID']);
      array_push($NumIssuedArr,$row['NumIssued']);
      array_push($NumInStoreArr,$row['NumInStore']);
      array_push($NumReservedArr,$row['NumReserved']);
      array_push($NumOrderedArr,$row['NumOrdered']);
    }
    //echo "iran4";
    //var_dump($IDArr);
    $sizeFindUsed = true;
  }elseif($findSize1 != "" and $findSize2 != "" /* */and $findSize3 == "" and $findItemTypeID == 0){
    $NumExpected  = 2;
    $findSize3 = 0; // adding a blank value so error is not thrown
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      $sql = "SELECT * FROM items WHERE ID = ?;"; ///ahhh 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      array_push($IDArr,$row['ID']);
      array_push($NSNArr,$row['NSN']);
      array_push($ItemTypeIDArr,$row['ItemTypeID']);
      array_push($NumIssuedArr,$row['NumIssued']);
      array_push($NumInStoreArr,$row['NumInStore']);
      array_push($NumReservedArr,$row['NumReserved']);
      array_push($NumOrderedArr,$row['NumOrdered']);
    }
    //echo "iran5";
    //var_dump($IDArr);
    $sizeFindUsed = true;
  }elseif($findSize1 != ""  and /* */ $findSize2 == "" and $findSize3 == "" and $findItemTypeID == 0){
    $NumExpected  = 1;
    $findSize2 = 0; // adding a blank value so error is not thrown
    $findSize3 = 0; // adding a blank value so error is not thrown
    $MatchedIDsArr = sizeFind($findSize1,$findSize2,$findSize3,$findItemTypeID, $NumExpected, $conn);
    foreach($MatchedIDsArr as $val){
      $sql = "SELECT * FROM items WHERE ID = ?;"; ///ahhh 
      $stmt = $conn->prepare($sql);
      $stmt->execute([$val]);
      $count = $stmt->rowCount();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      array_push($IDArr,$row['ID']);
      array_push($NSNArr,$row['NSN']);
      array_push($ItemTypeIDArr,$row['ItemTypeID']);
      array_push($NumIssuedArr,$row['NumIssued']);
      array_push($NumInStoreArr,$row['NumInStore']);
      array_push($NumReservedArr,$row['NumReserved']);
      array_push($NumOrderedArr,$row['NumOrdered']);
    }
    //echo "iran6";
    //var_dump($IDArr);
    $sizeFindUsed = true;
  }else{
    $sql = "SELECT * FROM items;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    //echo "I ran 4 <br>";
  }
}else{
// Qry to find all items
$sql = "SELECT * FROM items;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$count = $stmt->rowCount();
//echo "I ran 2 <br>";
}
$empty = 0;
  if ($count == 0){
    $empty = 1;
  }else{

  }

  if($sizeFindUsed != true){
    // add the value in Each row's data to their respective colums Arrays this is done so data can be modified prior to display 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      //echo $row['ID'] . "<br>"; test
      array_push($IDArr,$row['ID']);
      array_push($NSNArr,$row['NSN']);
      array_push($ItemTypeIDArr,$row['ItemTypeID']);
      array_push($NumIssuedArr,$row['NumIssued']);
      array_push($NumInStoreArr,$row['NumInStore']);
      array_push($NumReservedArr,$row['NumReserved']);
      array_push($NumOrderedArr,$row['NumOrdered']);
    }
  }else{

  }
 
  
  // get the look up table for Item Type
  $sql = "SELECT ItemTypeName FROM itemType;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ////var_dump($result); // test 

  // getting the data in a usable form 
  $lenResult = count($result);
  $loop = 0; 
  $ItemTypeNameArr =["test"]; // initialising with value at start of array so the Index matches the ID 

  // creates  array $ItemTypeNameArray out of the result 
  while($loop < $lenResult){
    $temp = implode($result[$loop]);
    //echo $temp . " hello <br>"; // test 
    array_push($ItemTypeNameArr,$temp);
    $loop = $loop + 1;
  }

////var_dump($ItemTypeNameArr); // test


// matching the ID to the name
$lenItemTypeIDArr = count($ItemTypeIDArr);
$lenItemTypeNameArr = count($ItemTypeNameArr);
//echo $lenItemTypeIDArr. "<br>";
//echo $lenItemTypeNameArr . "<br>";
$loop = 0;
$loopID = 1;
while ($loop < $lenItemTypeIDArr){
  while ($loopID <= $lenItemTypeNameArr){
    if ($ItemTypeIDArr[$loop] == $loopID){
      //echo $ItemTypeIDArr[$loop] . "<br>"; // test 
      $ItemTypeIDArr[$loop] = $ItemTypeNameArr[$loopID];
      //echo $ItemTypeIDArr[$loop] . "<br>"; // test 
      break; 
    }else{
      $loopID = $loopID + 1;
    }
  }
  $loop = $loop + 1;// incrimenting loop var
  $loopID = 1 ; // need to reset the loop ID 
  //echo "I ran <br>"; // test 
}
// $ItemTypeIDArr
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
          <h2>Virtual stores - Work in Progress </h2>

          <a href=virtualStores.php >
            <button class ="button">Requests</button>
          </a>
          <a href=#Stock.php >
            <button class ="button buttonPressed">Stock</button>
          </a>
          <a href=kitRequest.php >
            <button class ="button ">Make A Request</button>
          </a>
          <fieldset>
            <form action = "Stock.php" method="post">
            <label for="ItemType">ItemType</label><br>
            <select id="ItemType" name="ItemType">
              <option value="0">No Filter</option>
              <?php
                $sql = "SELECT * FROM itemType;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  echo "<option value=".$row["ID"].">".$row["ItemTypeName"]."</option>";
                }
                ?>
              </select><br>
              <label >Nato Size</label><br>
              <input type="text" id="Size1" name="Size1" value="">
              <input type="text" id="Size2" name="Size2" value="">
              <input type="text" id="Size3" name="Size3" value="">
              <br>
              <input type="submit" class = "button" value="find" name="find">
              
            </form>
              <table class = "tableDisplay">
                <tr>
                  <th>ID</th>
                  <th>NSN</th>
                  <th>ItemTypeID</th>
                  <th>NumIssued</th>
                  <th>NumInStore</th>
                  <th>NumOrdered</th>
                  <th>NumReserved</th>
                  <th>Size</th>
                  <th>edit?</th>
                  <th>delete?</th>

                </tr>
                <?php 
                  $loop = 0;
                  ////var_dump($IDArr); //test
                  // echo $empty; // test
              
                // actuly what displays 
                  while($loop < count($IDArr)){ 
                  echo "<tr>";
                      echo "<td>" .  $IDArr[$loop] . "</td>" ;
                      echo "<td>" .  $NSNArr[$loop] . "</td>";
                      echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                      echo "<td>" .  $NumIssuedArr[$loop] . "</td>"; 
                      echo "<td>
                      <form method='post' action ='SProcess.php'>
                      <input type='hidden' id = 'sub1NumInStore' name='sub1NumInStore' value=' $IDArr[$loop] '/>
                      <input type='submit' class='smallButton' name='Sub1' value='-'/>
                      </form>"
                      .  $NumInStoreArr[$loop]. 
                      "<form method='post' action ='SProcess.php'>
                      <input type='hidden' id = 'Plus1NumInStore' name='Plus1NumInStore' value=' $IDArr[$loop] '/>
                      <input type='submit' class='smallButton' name='Plus1' value='+'/>
                      </form></td>";  
                      echo "<td>" .  $NumReservedArr[$loop]. "</td>";
                      echo "<td>" .  $NumOrderedArr[$loop]. "</td>"; 
                      echo "<td>" . sizesCompressionAdmin($IDArr[$loop],$conn). "</td>";
                      echo "<td>
                      <form method='post' action ='editRow.php'>
                      <input type='hidden' id = 'editRow' name='editRow' value=' $IDArr[$loop] '/>
                      <input type='submit' name='eR' value='edit'/>
                      </form>
                      </td>";
                      echo "<td>
                      <form method='post' action ='deleteRowStock.php'>
                      <input type='hidden' id = 'Xdata' name='Xdata' value=' $IDArr[$loop] '/>
                      <input type='submit' name='X' value='X'/>
                      </form>
                      </td>";
                  echo "</tr>";
                  
                  $loop = $loop + 1;
                  }
                  ?>

              </table>
          </fieldset>
      </div>
    </div>
    <div id="footer">

    </div>
  </body>
</html>