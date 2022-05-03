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
    function findName($IDuser, $con){
      $sql = "SELECT `rank`, fname, lname FROM users WHERE ID =?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$IDuser]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $fullName = implode(" ",$result);
      return($fullName);
    }
    function sizeFind($SizeArr, $con){ 
      $qry = "SELECT itemID FROM sizes WHERE `value` = ?;";
      $stmt = $con->prepare($qry);
      $resultArr = []; // initialising
      $lengthArr = [0]; // initialising
      $forCount = 0;
      // getting the values from the data base
      foreach ($SizeArr as $val){
        $stmt->execute([$val]);
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
        // echo "<br>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          //echo $row['ID'] . "<br>"; test
          array_push($resultArr, $row["itemID"]);
        }
        $length = count($resultArr);
        $newLength = $length - $lengthArr[$forCount];
        array_push($lengthArr, $newLength);
        var_dump($lengthArr);
        $forCount = $forCount +1;
      }
      $numOfSizes = count($lengthArr);
      
      foreach($lengthArr as $val){
        $whileCount = 0;
        while ($whileCount < $val){

        }

      }
      var_dump($resultArr);
      echo "<br>";
      return (0);
      
      
      // $prevVal = 0;
      // $matchCount = 0;
      // array_push($arr, 0); // adds extra blank so it works when theres only one value 
      // foreach ($arr as $val) {
      //     if ($val == $prevVal){
      //         $matchCount = $matchCount + 1;
      //         $matchedItemID = $val;
      //     }else{
      //       $matchCount = 0; // changes match count if not consecutively matched which means this will not match if matching values do not occur consecutively, this is fine for my perposes as the data will always be ordered 
      //     }
      //     if ($matchCount == $numExpected-1){ // the number of matched values will always be $numExpected-1 unless there is only one 
      //         return($matchedItemID);
      //     }else{
        
      //     }
      //     $prevVal = $val; // sets $prevVal for next loop  
          
      // }
      // echo "failed to find a match";
      // return(0);// returns a value to signify no ID 
  }
//----------------------------------------Main Code----------------------------------------
if (isset($_POST['find'])){
  $findItemTypeID = $_POST["ItemType"];
  $findSize = $_POST["Size"];
  if($findSize != "No Filter" and $findItemTypeID != 0  ){
    $findSizeArr = explode("/",$findSize);
    sizeFind($SizeArr, $con);

    $sql = "SELECT * FROM items WHERE ItemTypeID = ?;"; ///ahhh 
    $stmt = $conn->prepare($sql);
    $stmt->execute([$findItemTypeID]);
    $count = $stmt->rowCount();
    echo "I ran 1 <br>";

  }elseif ($findItemTypeID != 0 ){

    $sql = "SELECT * FROM items WHERE ItemTypeID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$findItemTypeID]);
    $count = $stmt->rowCount();
    echo "I ran 2 <br>";
  }elseif($findSize != "No Filter" ){
    $findSizeArr = explode("/",$findSize);
    sizeFind($findSizeArr, $conn);
    $sql = "SELECT * FROM items WHERE ItemTypeID = ?;"; ///ahhh 
    $stmt = $conn->prepare($sql);
    $stmt->execute([$findItemTypeID]);
    $count = $stmt->rowCount();
    echo "I ran 3 <br>";
  }else{
    $sql = "SELECT * FROM items;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    echo "I ran 4 <br>";
  }
}else{
// Qry to find all items
$sql = "SELECT * FROM items;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$count = $stmt->rowCount();
echo "I ran 2 <br>";
}
$empty = 0;
  if ($count == 0){
    $empty = 1;
  }else{

  }


  // initialising colum arrays
  $IDArr = [];
  $NSNArr = [];
  $ItemTypeIDArr = [];
  $NumIssuedArr = [];
  $NumInStoreArr = [];
  $NumReservedArr = [];
  $NumOrderedArr = [];
  
    
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
    //test
    // echo htmlspecialchars($row['ItemTypeID'])."<br>"; 
    // echo htmlspecialchars($row['NumOrdered'])."<br>"; 
    // echo htmlspecialchars($row['purpose'])."<br>"; 
    // echo htmlspecialchars($row['DateNeeded'])."<br>"; 
    // echo htmlspecialchars($row['DateRequested'])."<br>"; 
    // echo htmlspecialchars($row['status'])."<br>"; 
  }
  //var_dump($IDArr); // works 
  //var_dump($ItemTypeIDArr); // broken
  

  // Qry to find the sizes of their requests
  function sizesCompressionAdmin($ItemID,$con){
    $sql = "SELECT sizes.itemID, sizes.value 
    FROM sizes INNER JOIN items ON sizes.ItemID = items.ID  
    WHERE sizes.itemID = ?;";
    $stmt = $con->prepare($sql);
    $stmt->execute([$ItemID]);
    // Making the sizse into the format =~ xx/yy/zz
    $arr = []; //initialising
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      array_push($arr,$row['value']);
    }
    return(implode("/",$arr));
  }
  // get the look up table for Item Type
  $sql = "SELECT ItemTypeName FROM itemType;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //var_dump($result); // test 

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

//var_dump($ItemTypeNameArr); // test


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
              <input type="hidden" id="ID" name="ID" value="<?php echo $itemID; ?>"><br>
            <label for="ItemType">ItemType</label><br>
              <select id="ItemType" name="ItemType">
                <option value="0">No Filter</option>
                <option value="1">Shirt Combat</option>
                <option value="2">Smock</option>
                <option value="3">Undershirt(Fleece)</option>
                <option value="4">Static T-Shirt</option>
                <option value="5">Trousers Combat</option>
                <option value="7">Boots</option>
                <option value="8">Cap MTP</option>
                <option value="9">Beret</option>
              </select><br>
              <label for="Size">Nato Size</label><br>
              <input type="text" id="Size" name="Size" value="No Filter"><br>
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

                </tr>
                <?php 
                  $loop = 0;
                  //var_dump($IDArr); //test
                  // echo $empty; // test
              
                // actuly what displays 
                  while($loop < $count){ 
                  echo "<tr>";
                      echo "<td>" .  $IDArr[$loop] . "</td>" ;
                      echo "<td>" .  $NSNArr[$loop] . "</td>";
                      echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                      echo "<td>" .  $NumIssuedArr[$loop] . "</td>"; 
                      echo "<td>" .  $NumInStoreArr[$loop]. "</td>";  
                      echo "<td>" .  $NumReservedArr[$loop]. "</td>";
                      echo "<td>" .  $NumOrderedArr[$loop]. "</td>"; 
                      echo "<td>" . sizesCompressionAdmin($IDArr[$loop],$conn). "</td>";
                      echo "<td>
                      <form method='post' action ='editRow.php'>
                      <input type='hidden' id = 'editRow' name='editRow' value=' $IDArr[$loop] '/>
                      <input type='submit' name='eR' value='edit'/>
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