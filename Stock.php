<!DOCTYPE html>
<?php
session_start();
 include "functions.php";
 require_once "ConnectDB.php"
?>

<html>
  <div></div>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
    ?>
    <script>
    // hopefully send data to PHP script that either + or - 1 from selected column 
    function addOrMinus(ItemID, Operation, Column) {
      console.log("I ran 0"); // test 
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        // the qry works 
        if (this.readyState == 4 && this.status == 200) { // checks connection to DataBase 
          console.log("I ran 0.5");
          console.log("ScreenWidth: " + screen.width);
          if (screen.width > 768){
            preTag = "LS";
          }else{
            preTag = "SS";
          }
          var tagID = preTag + Column + ItemID;
          console.log(tagID);// test 
          var numHTML = document.getElementById(tagID).innerHTML;//gets Html element 
          console.log(numHTML);// test 
          num = parseInt(numHTML);
          if (Operation == "sub"){
            if (num > 0){
              var newNum = num - 1;
            } else{
              var newNum = num
            }
          }else if(Operation == "plus"){
            var newNum = num + 1;
          }
          newNum = String(newNum);
          console.log(newNum);
          document.getElementById(tagID).innerHTML = newNum;
        // it doesn't
        }else if(this.readyState == 3 && this.status == 403) {

        }
    };
    xmlhttp.open("GET", "SProcess.php?Operation="+Operation+"&ItemID="+ItemID+"&Column="+Column, true); // send to precess page to ru simutaionously
    console.log("I ran 1");
    xmlhttp.send();
  }
    </script>
    <?php
      // initializing variables
      $sizeFindUsed = false;
      $count = 0;
      $findSize1 = 0;
      $findSize2 = 0;
      $findSize3 = 0;
      
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
  $findSize1 = trim($_POST["Size1"]);
  $findSize2 = trim($_POST["Size2"]);
  $findSize3 = trim($_POST["Size3"]);

  
   

  if ($findItemTypeID != 0 /* */ and $findSize1 == "" and $findSize2 == "" and $findSize3 == ""){

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
    // add the value in Each row's data to their respective columns Arrays this is done so data can be modified prior to display 
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

    <?php NavBar(); ?>
      <div id="main">
          <h2>Virtual stores - Work in Progress </h2>

          <a href=virtualStores.php >
            <button class ="button">Requests</button>
          </a>
          <a href=#Stock.php >
            <button class ="button buttonPressed">Stock</button>
          </a>
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
              <?php
              
              ?>
              <label >Nato Size</label><br>
              <ul style = "margin:0">
                <li class = "inline">  
                  <input type="text" id="Size1" name="Size1" placeholder = "Size 1" value="<?php
                  // checks if user has Entered any value into form, if so displays it
                  if (isset($findSize1)){
                    if($findSize1 == 0){
                      echo "";
                    }else{
                      echo $findSize1;
                    }
                  }else{
                    echo "";
                  }
                      
                  ?>">
                </li>
                <li class = "inline"> 
                  <input type="text" id="Size2" name="Size2" placeholder = "Size 2" value="<?php
                  // checks if user has Entered any value into form, if so displays it
                  if (isset($findSize2)){
                    if($findSize2 == 0){
                      echo "";
                    }else{
                      echo $findSize2;
                    }
                  }else{
                    echo "";
                  } ?>">
                </li>
                <li class = "inline"> 
                  <input type="text" id="Size3" name="Size3" placeholder = "Size 3" value="<?php
                  // checks if user has Entered any value into form, if so displays it
                  if (isset($findSize3)){
                    if($findSize3 == 0){
                      echo "";
                    }else{
                      echo $findSize3;
                    }
                  }else{
                    echo "";
                  }?>">
                </li>
              </ul>
              <br>
              <input type="submit" class = "button" value="find" name="find"> 
            </form>
            <form method='post' action ='addNewStock.php'>
                <input type="submit" class="button" name="addNew" value="Add New"/>
            </form>

            <div id = "PCDisplay">
              <table class = "tableDisplay">
                <tr>
                  <th>ID</th>
                  <th>NSN</th>
                  <th>Item Type</th>
                  <th>Size</th>
                  <th>Nº Issued</th>
                  <th>Nº In Store</th>
                  <th>Nº Reserved</th>
                  <th>Nº Ordered</th>
                  <th>edit?</th>
                  <th>delete?</th>
                </tr>
                

                <?php 
                  $loop = 0;
                  ////var_dump($IDArr); //test
                  // echo $empty; // test
              
                // Prints out table data  
                  while($loop < count($IDArr)){ 
                    echo "<tr>";
                      echo "<td>" .  $IDArr[$loop] . "</td>" ;
                      echo "<td>" .  $NSNArr[$loop] . "</td>";
                      echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                      echo "<td>" . sizesCompressionAdmin($IDArr[$loop],$conn). "</td>";
                      echo "<td>
                      <button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$loop],'plus','numIssued')>+</button>
                      <div id = 'LSnumIssued$IDArr[$loop]'>". $NumIssuedArr[$loop]."</div>
                      <button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$loop],'sub','numIssued')>-</button>
                      </td>";
                      echo "<td>
                      <button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$loop],'plus','numInStore')>+</button>
                      <div id = 'LSnumInStore$IDArr[$loop]'>". $NumInStoreArr[$loop]."</div>
                      <button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$loop],'sub','numInStore')>-</button>
                      </td>";  
                      echo "<td>
                      <button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$loop],'plus','numReserved')>+</button>
                      <div id = 'LSnumReserved$IDArr[$loop]'>". $NumReservedArr[$loop]."</div>
                      <button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$loop],'sub','numReserved')>-</button>
                      </td>";
                      echo "<td>
                      <button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$loop],'plus','numOrdered')>+</button>
                      <div id = 'LSnumOrdered$IDArr[$loop]'>". $NumOrderedArr[$loop]."</div>
                      <button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$loop],'sub','numOrdered')>-</button>
                      </td>";
                      echo "<td>
                      <form method='post' action ='editRow.php'>
                      <input type='hidden' id = 'editRow' name='editRow' value=' $IDArr[$loop] '/>
                      <input type='submit' name='eR' value='🔧' class = 'button'/>
                      </form>
                      </td>";
                      echo "<td>
                      <form method='post' action ='deleteRowStock.php'>
                      <input type='hidden' id = 'Xdata' name='Xdata' value=' $IDArr[$loop] '/>
                      <input type='submit' name='X' value='X' class = 'button'/>
                      </form>
                      </td>";
                    echo "</tr>";
                  
                    $loop = $loop + 1;
                  }
                  if ($loop == 0){ // ie there is nothing to display
                    echo "</br><b class = 'error'>wow Such Emptiness. Looks like the item you wanted to find doesn't exist.</b>";
                  }else{

                  }
                  ?>
              </table>
              <!-- 
              <form method='get' action ='SProcess.php'>
              <input type='hidden' id = 'Operation' name='Operation' value='plus'/>
              <input type='hidden' id = 'ItemID' name='ItemID' value='1'/>
              <input type='hidden' id = 'Column' name='Column' value='numInStore'/>
              <input type='submit' name='test' value='test'/>
              </form> test -->
          </div> <!--closes pc display   -->
          <div id = "phoneDisplay">
            <?php
             for($i = 0; $i < $count; $i++ ){
            ?>
            <div class = "events">
              <h3 class = "navBarDashTxt"><?php echo $ItemTypeIDArr[$i] ." ".sizesCompressionAdmin($IDArr[$i],$conn);?></h3>
              <table class = "eventTable tableDisplay">
                <tr>
                  <td class = "eventTd">Item ID</td>
                  <td class = "eventTd"><?php echo $IDArr[$i];?></td>
                </tr>
                <tr>
                  <td class = "eventTd">NSN</td>
                  <td class = "eventTd"><?php echo $NSNArr[$i];?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Nº Issued</td>
                  <td class = "eventTd"><?php echo "<ul class = 'noMargin'>
                    <li class = 'inline'><button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$i],'plus','numIssued')>+</button></li>
                    <li class = 'inline'><div id = 'SSnumIssued$IDArr[$i]' class = 'textBlack'>". $NumIssuedArr[$i]."</div></li>
                    <li class = 'inline'><button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$i],'sub','numIssued')>-</button></li>
                  </ul>";?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Nº In Store</td>
                  <td class = "eventTd"><?php echo"<ul class = 'noMargin'>
                      <li class = 'inline'><button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$i],'plus','numInStore')>+</button></li>
                      <li class = 'inline'><div id = 'SSnumInStore$IDArr[$i]' class = 'textBlack'>". $NumInStoreArr[$i]."</div></li>
                      <li class = 'inline'><button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$i],'sub','numInStore')>-</button></li>
                  </ul>";?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Nº Reserved</td>
                  <td class = "eventTd"><?php echo "<ul class = 'noMargin'>
                      <li class = 'inline'><button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$i],'plus','numReserved')>+</button></li>
                      <li class = 'inline'><div id = 'SSnumReserved$IDArr[$i]' class = 'textBlack'>". $NumReservedArr[$i]."</div></li>
                      <li class = 'inline'><button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$i],'sub','numReserved')>-</button></li>
                  </ul>";?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Nº Ordered</td>
                  <td class = "eventTd"><?php echo "<ul class = 'noMargin'>
                      <li class = 'inline'><button class='button smallButton' name='Plus1' onclick = addOrMinus($IDArr[$i],'plus','numOrdered')>+</button></li>
                      <li class = 'inline'><div id = 'SSnumOrdered$IDArr[$i]' class = 'textBlack'>". $NumOrderedArr[$i]."</div></li>
                      <li class = 'inline'><button class='button smallButton' name='Sub1' onclick = addOrMinus($IDArr[$i],'sub','numOrdered')>-</button></li>
                    </ul>";?></td>
                </tr>
              </table>
              <ul>
                <li class = 'inline'><form method='post' action ='editRow.php'>
                <input type='hidden' id = 'editRow' name='editRow' value='<?php echo $IDArr[$i]?>' />
                <input type='submit' name='eR' value='Edit?'class = 'button'/>
                </form></li>
                <li class = 'inline'><form method='post' action ='deleteRowStock.php'>
                <input type='hidden' id = 'Xdata' name='Xdata' value = '<?php echo $IDArr[$i]?>' />
                <input type='submit' name='X' value='Delete?' class = 'button'/>
                </form></li>
              </ul>
              
              
            </div>
            <?php
             } // close For loop 
            ?>
          </div>
      </div>
    <div id="footer">

    </div>
  </body>
</html>