<?php
session_start();
 include "functions.php";
 require_once "ConnectDB.php"
?>

<html>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 

        // Qry to find requests of this User
        
        $sql = "SELECT * FROM itemRequest;";
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
        $StockIDArr = [];
        $UserIDArr = [];
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
          array_push($StockIDArr,$row['StockID']);
          array_push($UserIDArr,$row['UserID']);
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
      //var_dump($IDArr); // works 
      //var_dump($ItemTypeIDArr); // broken
      

      // Qry to find the sizes of their requests
      function sizesCompressionAdmin($ItemID,$con){
        $sql = "SELECT sizesRequest.itemID, sizesRequest.value 
        FROM sizesRequest INNER JOIN itemRequest ON sizesRequest.ItemID = itemRequest.ID  
        WHERE sizesRequest.itemID = ?;";
        $stmt = $con->prepare($sql);
        $stmt->execute([$ItemID]);
        // Making the sizse into the format =~ xx/yy/zz
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

            <a href=#Requests.php >
              <button class ="button buttonPressed">Requests</button>
            </a>
            <a href=Stock.php >
              <button class ="button ">Stock</button>
            </a>
            <?php
               if ($empty == 1){
                 echo "<b class ='error'> There Are No Requests</b>";
               }else{
            ?>
              <table class = "tableDisplay">
                

                <tr>
                  <th>ID</th>
                  <th>StockID</th>
                  <th>UserID</th>
                  <th>Name</th>
                  <th>ItemTypeID</th>
                  <th>size</th>
                  <th>NumRequested</th>
                  <th>purpose</th>
                  <!--<th>DateNeeded</th>-->
                  <th>DateRequested</th>
                  <th>status</th>
                  <th>Issued?</th>
                  <th>Remove?</th>
                </tr>
                
                <?php 
                $loop = 0;
                //var_dump($IDArr); //test
                // echo $empty; // test
              
                
                while($loop < $count){ 
                  echo "<tr>";
                    echo "<td>" .  $IDArr[$loop] . "</td>" ;
                    echo "<td>" .  $StockIDArr[$loop] . "</td>";
                    echo "<td>" .  $UserIDArr[$loop] . "</td>";
                    echo "<td>" .  findName($UserIDArr[$loop], $conn). "</td>";
                    echo "<td>" .  $ItemTypeIDArr[$loop] . "</td>";
                    echo "<td>" . sizesCompressionAdmin($IDArr[$loop],$conn). "</td>";
                    echo "<td>" .  $NumRequestedArr[$loop] . "</td>"; 
                    echo "<td>" .  $purposeArr[$loop]. "</td>"; 
                    //echo "<td>" .  $DateNeededArr[$loop]. "</td>"; 
                    echo "<td>" .  $DateRequestedArr[$loop]. "</td>"; 
                    echo "<td>" . $statusArr[$loop]. "</td>";
                    echo "<td>
                    <form method='post' action ='IProcess.php'>
                    <input type='hidden' id = 'Idata' name='Idata' value=' $IDArr[$loop] '/>
                    <input type='submit' name='I' value='✓'/>
                    </form>
                    </td>";
                    echo "<td>
                    <form method='post' action ='deleteRowRequests.php'>
                    <input type='hidden' id = 'Xdata' name='Xdata' value=' $IDArr[$loop] '/>
                    <input type='submit' name='X' value='X'/>
                    </form>
                    </td>";
                  echo "</tr>";
                  
                  $loop = $loop + 1;
                  }
                }
                ?>
              </table>              
        </div>
      <div id="footer">

      </div>
    </body>
  </html>