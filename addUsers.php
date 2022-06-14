<?php session_start();
require_once "ConnectDB.php";// connects to database
include "functions.php"?>
<html>
  <?php
    $prevPage = $_SESSION["previous"];
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
  ?>
    
    <?php
      $CnumUsed = false;
// ---------------------------------------------------functions---------------------------------------------------  
    
// -----------------------------------validation -----------------------------------

if (isset($_POST['submitAU']) or isset($_POST['submitAUA'])){
  // getting the variables
  $Cnum = $_POST['Cnum'];
  $Pwd = $_POST['Pwd'];
  $rank = $_POST['rank'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $troop = $_POST['troop'];
  // initialising variables
  $addAnother = 0;
  // general validation
  // checks to see if there is a Cnum with the same number as it the user entered one 
  if($Cnum != ""){
    $sql = "SELECT * FROM users WHERE Cnum =?;";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$Cnum]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result != false){
      $CnumUsed = true; 
    }else{

    }
    
  }else{

  }
  if ($Cnum == ""  or $Pwd == ""or $rank == ""  or $fname == ""  or $lname == ""  or $troop == ""){
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
  // hashes password
  $PwdHashed = password_hash($Pwd, PASSWORD_DEFAULT);
  //check to see if user want to add another
    if(isset($_POST['submitAU'])){ 
      $addAnother = 0;
    }elseif(isset($_POST['submitAUA'])){
      $addAnother = 1;
    }
  // send data to process page
    ?>
    <form Id = "AutoSendForm" action = "AUProcess.php" method="post">
    <input type="hidden" id="Cnum" name="Cnum" value="<?php echo $Cnum; ?>">
    <input type="hidden" id="Pwd" name="Pwd" value="<?php echo $PwdHashed; ?>">
    <input type="hidden" id="rank" name="rank" value="<?php echo $rank;?>">
    <input type="hidden" id="fname" name="fname" value="<?php echo $fname; ?>">
    <input type="hidden" id="lname" name="lname" value="<?php echo $lname; ?>">
    <input type="hidden" id="troop" name="troop" value="<?php echo $troop; ?>">
    <input type="hidden" id="addAnother" name="addAnother" value="<?php echo $addAnother; ?>">
    </form>

    <script type="text/javascript">
    document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php

  }
}else{
  
// ---------------------------------------------------main code--------------------------------------------------- {

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
            <form action = "addUsers.php" method="post">
            <tr>
                <td>ID</td>
                <td><input type="text" id="ID" name="ID" value="Auto Generated"readonly><br></td> <!-- cannot be edited -->
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
                <td>Password <input type="checkbox" onclick="showPwd()" class= "button" value = "👁"></td>
                <td><input type="password" id="PwdInput" name="Pwd" value="<?php
                if(isset($Pwd)){
                  echo $Pwd;
                }else{
                  echo"Password";
                }
                ?>"><br></td>
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
                      echo "<option value=".$row["rank"]."selected>".$row["rank"]."</option>";
                    }else{
                      echo "<option value=".$row["rank"].">".$row["rank"]."</option>";
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
                      echo "<option value='".$row["troopName"]."' selected>".$row["troopName"]."</option>";
                    }else{
                      echo "<option value='".$row["troopName"]."'>".$row["troopName"]."</option>";
                    }
                  }
                  ?>
                </select><br></td>
            <tr>
            </table>
            <input type="submit" name ="submitAU" class = "button" value="Add">
            <input type="submit" name ="submitAUA" class = "button" value="Add and Add Another">
            </form>
          </fieldset>
      </div>
    <div id="footer">

    </div>
  </body>
</html>