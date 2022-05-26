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
      // initializing variables
      $sizeFindUsed = false;
      $count = 0;
    
      
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

//----------------------------------------Main Code----------------------------------------

// initialising colum arrays
$IDArr = [];
$CnumArr = [];
$rankArr = [];
$fnameArr = [];
$lnameArr = [];
$troopArr = [];

// ---------------------------------------- sorting System ----------------------------------------
if (isset($_POST['find'])){
  // initializing Variables 
  $sql = "SELECT * FROM users WHERE ";
  $troop = $_POST["troop"];
  $rank = trim($_POST["rank"]);
  $fname = trim($_POST["fname"]);
  $lname = trim($_POST["lname"]);
  //testing 
  // echo $_POST["troop"];
  // echo $_POST["rank"];
  // echo $_POST["fname"];
  // echo $_POST["lname"];
  //SQL builder: adds the parts of the Sql only if it is filtered 
  if($troop != "No Filter"){
    $sql = $sql . "troop = ? AND ";
    //echo "<br> I Ran 1"; //test
  }else{
    $sql = $sql . "troop != ? AND "; // instead of not adding a bit of sql to $sql we add this line so I don't have to anything special for the Execute function
    //echo "<br> I Ran 2"; //test
  }
  if ($rank!= "No Filter"){;
    $sql = $sql . "rank = ? AND ";
  }else{
    $sql = $sql . "rank != ? AND ";
  }
  if ($fname != ""){
    $sql = $sql . "fname = ? AND ";
  }else{
    $sql = $sql . "fname != ? AND ";
  }
  if ($lname != ""){
    $sql = $sql . "lname = ? AND "; 
  }else{
    $sql = $sql . "lname != ? AND ";
  }
  echo "<br> sql1: ".  $sql;
  $lastAnd = strpos($sql, "AND", -4);
  echo "<br> lastAnd: ". $lastAnd;
  //$lenSql = strlen($sql);
  $sql = substr_replace($sql,"",$lastAnd,3);
  $sql = $sql . ";";
  echo"<br> sql2: ".  $sql;
  
  $stmt = $conn->prepare($sql);
  $stmt->execute([$troop, $rank, $fname, $lname]);
  $count = $stmt->rowCount();
}else{
// Qry to find all users 
$sql = "SELECT * FROM users;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$count = $stmt->rowCount();
//echo "I ran 2 <br>";
}
$empty = 0;
// Checks if the result of the qry is 0 
  if ($count == 0){
    $empty = 1;
  }else{

  }


// add the value in Each row's data to their respective columns Arrays this is done so data can be modified prior to display 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  //echo $row['ID'] . "<br>"; test
  array_push($IDArr,$row['ID']);
  array_push($CnumArr,$row['Cnum']);
  array_push($rankArr,$row['rank']);
  array_push($fnameArr,$row['fname']);
  array_push($lnameArr,$row['lname']);
  array_push($troopArr,$row['troop']);
}

?>
  </head>

  <body id = "test">
    <div id="header">
      <h1>CadetLink</h1>
    </div>

    <div id="navbarDash">
      <h2 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " "; // print out the users  rank and Name 
          echo $_SESSION['fname']. " ";
          echo $_SESSION['lname'];?></h2>
      <img class = "profilePic" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefalt" width="auto" height="150">
      <form action ="<?php // back button - checks if CFAV and what mainPage it should be Sent to 
      if($_SESSION['troop']=="CFAV"){
        echo "adminMainPage.php";
      }else{
        echo "mainPage.php";
      }
      ?>">
      <input type="submit" class = "smallButton" value="«" name="dashButton">
      </form>
    </div>
    <div id="container">
      
      <div id="main">
          <h2>User Management System - Work in Progress </h2>
          <fieldset>
          <?php // error message system
          if (isset($_SESSION["msg"]) != ""){
                echo $_SESSION['msg'];
                }else{
                
                }
            ?>
            <form action = "manageUsers.php" method="post">
            <label for="troop">Troop</label><br>
            <select id="troop" name="troop">
              <option value="No Filter">No Filter</option>
              <?php // qry to find the troop name then display them as a select option 
                $sql = "SELECT * FROM troops;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  if ($row["troopName"] == $troop){
                    echo "<option value='".$row["troopName"]."' selected>".$row["troopName"]."</option>";
                  }else{
                    echo "<option value='".$row["troopName"]."'>".$row["troopName"]."</option>";
                  }
                }
                ?>
              </select><br>
              <?php
              
              ?>
              <label >Rank and Name</label><br>
              <select id="rank" name="rank">
                <option value="No Filter">No Filter</option>
                <?php // qry to find the ranks then display them as a select option
                $sql = "SELECT * FROM ranks;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  if ($row["rank"] == $rank){
                    echo "<option value='".$row["rank"]."'selected>".$row["rank"]."</option>";
                  }else{
                    echo "<option value='".$row["rank"]."'>".$row["rank"]."</option>";
                  }
                }
              ?>
              </select><br></td>
              <input type="text" id="fname" name="fname" placeholder = "First Name" value="<?php
              // checks if the user has searched for something in this input box if so displays their input 
              if (isset($fname)){
                echo $fname; 
              }else{
                echo " "; 
              } ?>">
              <input type="text" id="lname" name="lname" placeholder = "Last Name" value="<?php
              // checks if the user has searched for something in this input box if so displays their input
               if (isset($lname)){
                echo $lname; 
               }else{
                 echo " "; 
               }?>">
              <br>
              <input type="submit" class = "button" value="find" name="find">
              
              
            </form>
              <table class = "tableDisplay">
                <tr>
                  <th>ID</th>
                  <th>Cadet Number</th>
                  <th>Rank</th>
                  <th>first name</th>
                  <th>last name</th>
                  <th>troop</th>
                  <th>Password reset</th>
                  <th>edit?</th>
                  <th>delete?</th>
                </tr>

                <form method='post' action ='addUsers.php'>
                <input type="submit" class="button" name="addNew" value="Add New"/>
                </form>

                <?php 
                  $loop = 0;
                  ////var_dump($IDArr); //test
                  // echo $empty; // test
              
                // table of users that displays 
                  while($loop < count($IDArr)){ 
                  echo "<tr>";
                      echo "<td>" .  $IDArr[$loop] . "</td>" ;
                      echo "<td>" .  $CnumArr[$loop] . "</td>";
                      echo "<td>" .  $rankArr[$loop] . "</td>";
                      echo "<td>" .  $fnameArr[$loop] . "</td>"; 
                      echo "<td>" .  $lnameArr[$loop] . "</td>";
                      echo "<td>" .  $troopArr[$loop]. "</td>";
                      // Reset Password button
                      echo "<td> <form method='post' action ='resetPWord.php'>
                      <input type='hidden' id = 'resetPWord' name='resetPWord' value=' $IDArr[$loop] '/>
                      <input type='submit' name='RP' value='Reset Password'/>
                      </form>";
                      // edit User button
                      echo "<td>
                      <form method='post' action ='editUser.php'>
                      <input type='hidden' id = 'editUser' name='editUser' value=' $IDArr[$loop] '/>
                      <input type='submit' name='eU' value='edit'/>
                      </form>
                      </td>";
                      // delete user button 
                      echo "<td>
                      <form method='post' action ='deleteUser.php'>
                      <input type='hidden' id = 'Xdata' name='Xdata' value=' $IDArr[$loop] '/>
                      <input type='submit' name='X' value='X'/>
                      </form>
                      </td>";
                  echo "</tr>";
                  
                  $loop = $loop + 1;// increments the loop index
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