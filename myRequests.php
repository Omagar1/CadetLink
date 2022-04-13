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

      // get the look up table for Item Type
      $sql = "SELECT * FROM itemType";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      // Qry to find requests of this User
      $currentUserID = $_SESSION['UserID'];
      $sql = "SELECT * FROM itemRequest WHERE userID = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$currentUserID]);
      $count = $stmt->rowCount();
      
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
        array_push($DateNeededArr,$row['DateNeeded']);
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
     //var_dump($IDArr); 

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

            <a href=kitRequest.php >
              <button class ="button ">Make A Request</button>
            </a>
            <a href=#myRequests.php >
              <button class ="button buttonPressed">My Requests</button>
            </a>
            <fieldset>
              <table class = "tableDisplay">

                <tr>
                  <th>ID</th>
                  <th>ItemTypeID</th>
                  <th>NumRequested</th>
                  <th>purpose</th>
                  <th>DateNeeded</th>
                  <th>DateRequested</th>
                  <th>status</th>
                  <th>size</th>
                </tr>
                
                <?php 
                $loop = 0;
                
                while($loop < $count){ 
                echo "<tr>";
                   echo "<td>" .  $IDArr[$loop] . "</td>";
                   echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                   echo "<td>" .  $NumRequestedArr[$loop] . "</td>"; 
                   echo "<td>" .  $purposeArr[$loop]. "</td>"; 
                   echo "<td>" .  $DateNeededArr[$loop]. "</td>"; 
                   echo "<td>" .  $DateRequestedArr[$loop]. "</td>"; 
                   echo "<td>" . $statusArr[$loop]. "</td>";
                   echo "<td>" . sizesCompression($currentUserID,$IDArr[$loop],$conn). "</td>";
                echo "<tr>";
                
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