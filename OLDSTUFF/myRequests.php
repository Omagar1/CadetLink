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
      // connects to database
      require_once "ConnectDB.php";
      //checks if not logged in  - broken 
      if(isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };
      // Qry to find requests of this User
      $currentUserID = $_SESSION['UserID'];
      $sql = "SELECT * FROM itemRequest WHERE userID = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$currentUserID]);
      $count = $stmt->rowCount();
      $empty = 0;
      if ($count == 0){
        $empty = 1;
      }else{
      }
      
      // initialising colum arrays
      $IDArr = [];
      $ItemTypeIDArr = [];
      $NumRequestedArr = [];
      $purposeArr = [];
      $DateNeededArr = [];
      $DateRequestedArr = [];
      $statusArr = [];
       
      // add the value in Each row's data to their respective colums Arrays this is done so data can be modified prior to display 
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //echo $row['ID'] . "<br>"; test
        array_push($IDArr,$row['ID']);
        //var_dump($IDArr); test
        //echo "<br>"; test
        array_push($ItemTypeIDArr,$row['ItemTypeID']);
        array_push($NumRequestedArr,$row['NumRequested']);
        array_push($purposeArr,$row['purpose']);
        //array_push($DateNeededArr,$row['DateNeeded']);
        array_push($DateRequestedArr,$row['DateRequested']);
        array_push($statusArr,$row['status']);
        //test
        // echo htmlspecialchars($row['ItemTypeID'])."<br>"; 
        // echo htmlspecialchars($row['NumRequested'])."<br>"; 
        // echo htmlspecialchars($row['purpose'])."<br>"; 
        // echo htmlspecialchars($row['DateNeeded'])."<br>"; 
        // echo htmlspecialchars($row['DateRequested'])."<br>"; 
        // echo htmlspecialchars($row['status'])."<br>"; 
      }
     //var_dump($IDArr); // works 
     //var_dump($ItemTypeIDArr); // broken
     
     // Qry to find the sizes of their requests
     function sizesCompression($UserID,$ItemID,$con){
      $sql = "SELECT sizesRequest.itemID, sizesRequest.value 
      FROM sizesRequest INNER JOIN itemRequest ON sizesRequest.ItemID = itemRequest.ID  
      WHERE itemRequest.userID = ? AND sizesRequest.itemID = ?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$UserID,$ItemID]);
      // Making the sizse into the format =~ xx/yy/zz
      $arr = []; //initialising
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row['value']);
      }
      return(implode("/",$arr));
     }
     // get the look up table for Item Type
     $sql = "SELECT ItemTypeName FROM itemType";
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
        array_push($ItemTypeNameArr,$temp );
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
        <img class = "profilePic" src="images/defaltProfilePic.jpg" alt="SgtDefalt" width="auto" height="150">
        <button onclick="history.go(-1);">Back </button>
      </div>
      <div id="container">

        <div id="main">
            <h2>Kit Request Page - Work in Progress </h2>
            <a href=kitRequest.php >
              <button class ="button ">Make A Request</button>
            </a>
            <a href=#myRequests.php >
              <button class ="button buttonPressed">My Requests</button>
            </a>
            <fieldset>
            <?php
               if ($empty == 1){
                 echo "<b class ='error'> you have no Requests<b>";
               }else{
            ?>
              <table class = "tableDisplay">
                
                <tr>
                  <th>ID</th>
                  <th>ItemTypeID</th>
                  <th>NumRequested</th>
                  <th>purpose</th>
                  <!-- <th>DateNeeded</th> -->
                  <th>DateRequested</th>
                  <th>status</th>
                  <th>size</th>
                  <th>Remove?</th>
                </tr>
                
                <?php 
                $loop = 0;
                //var_dump($IDArr); //test
                // echo $empty; // test
                
                while($loop < $count){ 
                echo "<tr>";
                   echo "<td>" .  $IDArr[$loop] . "</td>" ;
                   echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                   echo "<td>" .  $NumRequestedArr[$loop] . "</td>"; 
                   echo "<td>" .  $purposeArr[$loop]. "</td>"; 
                   //echo "<td>" .  $DateNeededArr[$loop]. "</td>"; 
                   echo "<td>" .  $DateRequestedArr[$loop]. "</td>"; 
                   echo "<td>" . $statusArr[$loop]. "</td>";
                   echo "<td>" . sizesCompression($currentUserID,$IDArr[$loop],$conn). "</td>";
                   echo "<td>
                   <form method='post' action ='deleteRow.php'>
                   <input type='hidden' id = 'Xdata' name='Xdata' value=' $IDArr[$loop] '/>
                   <input type='submit' name='X' value='X'/>
                   </form>
                   </td>";
                   //echo "<td><a href=deleteRow.php> <button class ='button'>X</button </a></td>";// Old button
                echo "</tr>";
                
                $loop = $loop + 1;
                }
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