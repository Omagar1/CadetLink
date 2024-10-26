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
      if(isset($_SESSION["loggedIn"]) or ($_SESSION["loggedIn"] != true) ){
        //header("location: index.php"); // if so redirects them to the loginpage page
      };
  
      // Qry to find items in database
      
      $sql = "SELECT * FROM items;";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $count = $stmt->rowCount();
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
        // Making the sizes into the format =~ xx/yy/zz
        $arr = []; //initialising
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          array_push($arr,$row['value']);
        }
        return(implode("/",$arr));
      }


      // ---------------------------------------------------main code---------------------------------------------------

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
    //loops through the items in the database, then loops through the item type list to match the ItemTypeID to an ID of the list
    while ($loop < $lenItemTypeIDArr){
      while ($loopID <= $lenItemTypeNameArr){
        if ($ItemTypeIDArr[$loop] == $loopID){
          //echo $ItemTypeIDArr[$loop] . "<br>"; // test 
          $ItemTypeIDArr[$loop] = $ItemTypeNameArr[$loopID]; // then sets teh correct name 
          //echo $ItemTypeIDArr[$loop] . "<br>"; // test 
          break; 
        }else{
          $loopID = $loopID + 1;
        }
      }
      $loop = $loop + 1;// incrementing loop var
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
      <img class = "profilePic" src="images/defaltProfilePic.jpg" alt="SgtDefalt" width="auto" height="150">
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
              <table class = "tableDisplay">
                <tr>
                  <th>ID</th>
                  <th>NSN</th>
                  <th>ItemType</th>
                  <th>Size</th>
                  <th>NumIssued</th>
                  <th>NumInStore</th>
                  <th>NumOrdered</th>
                  <th>NumReserved</th>
                  
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
                      echo "<td>" . sizesCompressionAdmin($IDArr[$loop],$conn). "</td>";
                      echo "<td>" .  $NumIssuedArr[$loop] . "</td>"; 
                      echo "<td>" .  $NumInStoreArr[$loop]. "</td>";  
                      echo "<td>" .  $NumReservedArr[$loop]. "</td>";
                      echo "<td>" .  $NumOrderedArr[$loop]. "</td>"; 
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