<?php 
session_start();
include "functions.php"

?>
<html>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
      $CnumUsed = false;
      // connects to database
      require_once "ConnectDB.php";
// ---------------------------------------------------functions---------------------------------------------------  
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitEU'])){
  // getting the variables
  $userID = $_POST['ID'];
  $Cnum = $_POST['Cnum'];
  $rank = $_POST['rank'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $troop = $_POST['troop'];
  // general validation
  // checks to see if there is a Cnum with the same number as it the user entered one apart from for that user ID
  if($Cnum != ""){
    $sql = "SELECT * FROM users WHERE Cnum =? AND ID !=?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$Cnum, $userID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result != false){
      $CnumUsed = true; 
    }else{

    }
    
  }else{

  }
  if ($Cnum == "" or $rank == ""  or $fname == ""  or $lname == ""  or $troop == ""){
    //echo "i Ran 1 <br>"; // test 
    $msg = "<p><b class = 'error'>Fields Must Not Be Empty </b></p>";
    $_SESSION['msg'] = $msg;
  }elseif(strlen($Cnum) < 8 ){
    $msg = "<p><b class = 'error'>Cnum Must be at least 8 character </b></p>";
    $_SESSION['msg'] = $msg;
    //echo "i Ran 2 <br>"; // test 
  }elseif($CnumUsed == true){
    $msg = "<p><b class = 'error'>Cnum Already Used</b></p>";
    $_SESSION['msg'] = $msg;
  }else{
  // send data to process page
    ?>
    <form Id = "AutoSendForm" action = "EUProcess.php" method="post">
    <input type="hidden" id="ID" name="ID" value="<?php echo $userID; ?>">
    <input type="hidden" id="Cnum" name="Cnum" value="<?php echo $Cnum; ?>">
    <input type="hidden" id="Pwd" name="Pwd" value="<?php echo $Pwd; ?>">
    <input type="hidden" id="rank" name="rank" value="<?php echo $rank;?>">
    <input type="hidden" id="fname" name="fname" value="<?php echo $fname; ?>">
    <input type="hidden" id="lname" name="lname" value="<?php echo $lname; ?>">
    <input type="hidden" id="troop" name="troop" value="<?php echo $troop; ?>">
    </form>

    <script type="text/javascript">
    document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php

  }
}else{
  
// ---------------------------------------------------main code--------------------------------------------------- 
$userID = $_POST['editUser'];
// Qry to find the rest of the data 

$sql = "SELECT * FROM users WHERE ID = ?;";
$stmt = $conn->prepare($sql);
$stmt->execute([$userID]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// initialising Column arrays
$Cnum = $result['Cnum'];
$rank = $result['rank'];
$fname = $result['fname'];
$lname = $result['lname'];
$troop = $result['troop'];
}

      
    ?>
  </head>

  <body id = "test">
    <div id="header">
      <h1>CadetLink</h1>
    </div>

    <?php NavBar(); ?>
      <div id="main">
          <h2>Add Users - Work in Progress </h2>
          <fieldset>
            <?php if (isset($_SESSION["msg"])){
                  echo $_SESSION['msg'];
                }else{
                  echo "";//test
                }
                
            ?>
            <table class = "tableDisplay">
            <tr>
                  <th>Column Name</th>
                  <th>Data</th>
            </tr>
            <form action = "editUser.php" method="post">
            <tr>
                <td>ID</td>
                <td><input type="text" id="ID" name="ID" value="<?php echo $userID;?>"readonly><br></td> <!-- cannot be edited -->
            <tr>
            <tr>
                <td>Cadet Number</td>
                <td><input type="text" id="Cnum" name="Cnum" placeholder = "e.g. 12345678" value="<?php
                if(isset($Cnum)){
                  echo $Cnum;
                }else{
                  echo"";
                }
                ?>">
                <br></td>
            <tr>
            <tr>
                <td>Password </td>
                <td> Reset - Coming Soon <br></td>
            <tr>
            <tr>
                <td>Rank</td>
                <td><select id="rank" name="rank">
                  <?php
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
            <tr>
            <tr>
                <td>First Name</td>
                <td><input type="text" id="fname" name="fname" value="<?php
                if(isset($fname)){
                  echo $fname;
                }else{
                  echo"";
                }
                ?>"><br></td>
            <tr>
            <tr>
                <td>Last Name</td>
                <td><input type="text" id="lname" name="lname" value="<?php
                if(isset($lname)){
                  echo $lname;
                }else{
                  echo"";
                }
                ?>"><br></td>
            <tr>
            <tr>
                <td>Troop</td>
                <td><select id="troop" name="troop">
                  <?php
                  $sql = "SELECT * FROM troops;";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if ($row["troopName"] == $troop){
                      echo "<option value='".$row["troopName"]."'selected>".$row["troopName"]."</option>";
                    }else{
                      echo "<option value='".$row["troopName"]."'>".$row["troopName"]."</option>";
                    }
                  }
                  ?>
                </select><br></td>
            <tr>
            </table>
            <input type="submit" name ="submitEU" class = "button" value="Save">

            </form>
          </fieldset>
      </div>
    <div id="footer">

    </div>
  </body>
</html>