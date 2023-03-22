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
$CFAVArr = [];


if (isset($_POST['find'])){
  $troop = $_POST["troopArr"];
  $rank = trim($_POST["Size1"]);
  $fname = trim($_POST["Size2"]);
  $lname = trim($_POST["Size3"]);

  //with all
  if($rank != "" and $fname != "" and $lname != "" and $troop != 0){
    $sql = "SELECT * FROM users WHERE ID = ? AND `rank` = ? AND `fname` = ? AND `lname` = ? ;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$troop, $rank, $fname, $lname]);
    $count = $stmt->rowCount();
  //with troop
  }elseif ($troop != 0 /* */ and $rank == "" and $fname == "" and $lname == ""){
    $sql = "SELECT * FROM users WHERE ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$troop]);
    $count = $stmt->rowCount();
  }elseif($rank != "" and $fname != "" and $troop != 0 /* */ and $lname == ""){
    $sql = "SELECT * FROM users WHERE ID = ? AND `rank` = ? AND `fname` = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$troop, $rank, $fname]);
    $count = $stmt->rowCount();
  }elseif($rank != "" and $troop != 0 /* */and $fname == "" and $lname == ""){
    $sql = "SELECT * FROM users WHERE ID = ? AND `rank` = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$troop, $rank]);
    $count = $stmt->rowCount();
  // with rank and without troop
  }elseif($rank != "" and $fname != "" and $lname != "" and /* */ $troop == 0){
    $sql = "SELECT * FROM users WHERE `rank` = ? AND `fname` = ? AND `lname` = ? ;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$rank, $fname, $lname]);
    $count = $stmt->rowCount();
  }elseif($rank != "" and $fname != "" /* */and $lname == "" and $troop == 0){
    $sql = "SELECT * FROM users WHERE `rank` = ? AND `fname` = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$rank, $fname]);
    $count = $stmt->rowCount();
  }elseif($rank != ""  and /* */ $fname == "" and $lname == "" and $troop == 0){
    $sql = "SELECT * FROM users WHERE `rank` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$rank,]);
    $count = $stmt->rowCount();
  // with fname and without troop and Rank
  }elseif($fname != "" and $lname != "" and /* */ $rank == 1  and $troop == 0){
    $sql = "SELECT * FROM users WHERE `fname` = ? AND `lname` = ? ;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$fname, $lname]);
    $count = $stmt->rowCount();
  }elseif($fname != "" /* */and $rank == "" and $lname == "" and $troop == 0){
    $sql = "SELECT * FROM users WHERE`fname` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$fname,]);
    $count = $stmt->rowCount();
  // with lname 
  }elseif($lname != ""  /* */ and $rank == "" and $fname == ""  and $troop == 0){
    $sql = "SELECT * FROM users WHERE `lname` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$rank,]);
    $count = $stmt->rowCount();
  }else{
    $sql = "SELECT * FROM users;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount();
    //echo "I ran 4 <br>";
  }
}else{
// Qry to find all users 
$sql = "SELECT * FROM users;";
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


// add the value in Each row's data to their respective colums Arrays this is done so data can be modified prior to display 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  //echo $row['ID'] . "<br>"; test
  array_push($IDArr,$row['ID']);
  array_push($CnumArr,$row['Cnum']);
  array_push($rankArr,$row['rank']);
  array_push($fnameArr,$row['fname']);
  array_push($lnameArr,$row['lname']);
  array_push($troopArr,$row['troop']);
  array_push($CFAVArr,$row['CFAV']);
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
            <label for="troopArr">troopArr</label><br>
            <select id="troopArr" name="troopArr">
              <option value="0">No Filter</option>
              <?php
                $sql = "SELECT * FROM troops;";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  echo "<option value=".$row["troopName"].">".$row["troopName"]."</option>";
                }
                ?>
              </select><br>
              <?php

              ?>
              <label >Rank and Name</label><br>
              <input type="text" id="rank" name="rank" value="<?php 
              if (isset($rank)){
                echo $rank; 
              }else{
                echo "Rank"; 
              } ?>">
              <input type="text" id="fname" name="fname" value="<?php
              if (isset($fname)){
                echo $fname; 
              }else{
                echo "First Name"; 
              } ?>">
              <input type="text" id="lname" name="lname" value="<?php
               if (isset($lname)){
                echo $lname; 
               }else{
                 echo "Last Name"; 
               }?>">
              <br>
              <input type="submit" class = "button" value="find" name="find">


            </form>
              <table class = "tableDisplay">
                <tr>
                  <th>ID</th>
                  <th>Cnum</th>
                  <th>Rank</th>
                  <th>first name</th>
                  <th>last name</th>
                  <th>troop</th>
                  <th>CFAV</th>
                  <th>Password reset</th>
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
                      echo "<td>" .  $CnumArr[$loop] . "</td>";
                      echo "<td>" .  $rankArr[$loop] . "</td>";
                      echo "<td>" .  $fnameArr[$loop] . "</td>"; 
                      echo "<td>" .  $lnameArr[$loop] . "</td>";
                      echo "<td>" .  $troopArr[$loop]. "</td>";
                      echo "<td>" .  $CFAVArr[$loop]. "</td>"; 
                      echo "<td> Coming Soon</td>";
                      echo "<td>
                      <form method='post' action ='#editUsers.php'>
                      <input type='hidden' id = 'editRow' name='editRow' value=' $IDArr[$loop] '/>
                      <input type='submit' name='eR' value='edit'/>
                      </form>
                      </td>";
                      echo "<td>
                      <form method='post' action ='#deleteRowUsers.php'>
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