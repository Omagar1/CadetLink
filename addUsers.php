<?php session_start();?>
<html>
  <head>
    <title>CadetLink</title>
    <link href="main.css" rel="stylesheet" />
    <link href="loginSignup.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
      function showPwd() {
        var x = document.getElementById("PwdInput");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
    <?php
      $CnumUsed = false;
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
// ---------------------------------------------------functions---------------------------------------------------  
    
// -----------------------------------validation -----------------------------------
if (isset($_POST['submitAU'])){
  // getting the variables
  $Cnum = $_POST['Cnum'];
  $Pwd = $_POST['Pwd'];
  $rank = $_POST['rank'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $troop = $_POST['troop'];
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
  // send data to process page
    ?>
    <form Id = "AutoSendForm" action = "AUProcess.php" method="post">
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
  
// ---------------------------------------------------main code--------------------------------------------------- {

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
      <form action ="<?php
      if($_SESSION['troop']=="CFAV"){
        echo "manageUsers.php";
      }else{
        echo "mainPage.php";
      }
      ?>">
      <input type="submit" class = "smallButton" value="«" name="dashButton">
      </form>
    </div>
    <div id="container">
      
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
                      echo "<option value=".$row["troopName"]."selected>".$row["troopName"]."</option>";
                    }else{
                      echo "<option value=".$row["troopName"].">".$row["troopName"]."</option>";
                    }
                  }
                  ?>
                </select><br></td>
            <tr>
            </table>
            <input type="submit" name ="submitAU" class = "button" value="Add">

            </form>
          </fieldset>
      </div>
    </div>
    <div id="footer">

    </div>
  </body>
</html>