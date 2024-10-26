<?php
ob_start();
session_start();
require_once "functions.php";

?>
<!DOCTYPE html>
  <html>
      <?php
      $_SESSION["previous"] = [];// initalising the Previous Stack
      $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
      head($pageName, "<link href='loginSignup.css' rel='stylesheet' />");// from functions.php, echoes out the head tags
      
      destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages  
      
      ?>
      <script>
       /*  // local validation -- can be turned off 
        function processForm(){
          Cnum = document.getElementById("Cnum");
          
          CnumValue = String(Cnum.value);
          console.log(CnumValue);
          
          // checks if the cadet number entered is not less than 8 
          if (CnumValue.length < 8 ){
            
            msg = document.getElementById("msg");
            msg.innerHTML = "Cadet Number Too Short";
            // changes the colour of that field if so  
            Cnum.style.borderColor = "red";
            Cnum.style.backgroundColor = "pink";

            return false;
          }else{
            // if not sets the colour as default 
            Cnum.style.borderColor = "";
            Cnum.style.backgroundColor = "";
            
            return true;
          }
        } */
      </script>
      <?php
// ---------------------------------------------------- Validation -------------------------------------------------
      if (isset($_POST['submitL'])){
        $uname = trim($_POST['Cnum']);
        $pword = trim($_POST['Pwd']);
        if ($uname == ""){
          $msg =  "<p id = 'msg'><b class = 'error'>Cadet Number Must Not be Empty</b></p>";
          $_SESSION['msg'] = $msg;
          //echo $msg;
          echo "<script>processForm('Cnum')</script>";
        }elseif($pword == ""){
          $msg =  "<p id = 'msg'><b class = 'error'>Password Must Not be Empty</b></p>";
          $_SESSION['msg'] = $msg;
          //echo $msg;
          echo "<script>processForm('Pwd')</script>"; 
        }elseif(strlen($uname)<8){
          $msg =  "<p id = 'msg'><b class = 'error'>Cadet Number Must Not Be Under 8 Characters in length </b></p>";
          $_SESSION['msg'] = $msg;
          //echo $msg;
          echo "<script>processForm('Cnum')</script>";
        }elseif(strlen($pword)>20){
          $msg =  "<p id = 'msg'><b class = 'error'>Password Must Not Be Over 20 Characters in length </b></p>";
          $_SESSION['msg'] = $msg;
          //echo $msg;
          echo "<script>processForm('Pwd')</script>";
        }else{
          //Passed Validation; passing data On to process page
          ?>
          <form id = "AutoSendForm" action = "LProcess.php" method="post">
              <input type="hidden" id="CnumAutoSendForm" name="Cnum" value="<?php echo $uname ?>"><br>
              <input type="hidden" id="PwdAutoSendForm" name="Pwd" value="<?php echo $pword ?>"><br>
        </form>
        <script type="text/javascript">
          document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
        </script><?php
        }
      }else{

      }

     ?>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
      </div>
        <!--Links for the Admin page  -->
      <div id="navbar">
        <ul class="navBarList">
          <li class = "inline"><a href="#mainPage.php"class ="navBarTxt"> Example DashBoard</a></li>
          <li class = "inline"><a href="About.php" class ="navBarTxt" >What is Cadetlink?</a></li>
          <li class = "inline"><a href="MainpagePureCSSTest.php" class ="navBarTxt" >test</a></li>
        </ul>
      </div>
        <div id="mainSignUp">
          <fieldset>
            <!-- Login Form  --> 
            <Legend><b>Login</b></Legend>
            <form action = "index.php" method="post" id = "logInForm" onsubmit = "//return processForm(this)">
              <label for="Cnum">CadetNumber</label><br>
              <input type="text" id="Cnum" name="Cnum" value=""><br>
              <label for="Pwd">Password</label><br>
              <input type="password" id="Pwd" name="Pwd" value=""><br>
              <input onclick ="//processForm()" type="submit" class = "button" value = "login" name ="submitL" >
              
            </form>
            <!-- Error message system  -->
            
            <p id = "msg"><b class = "error"> <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
               ?></b></p>
            <button class ="button" onclick ="getElementById('reveal').innerHTML = 'Contact Your CFAV to Reset your details'">Forgot your Cadet Number or Password?</button>
            <!-- onclick ="getElementById('reveal').innerHTML= "Contact Your CFAV to Reset your details" -->
            <p id="reveal">test</p>
          </fieldset>
        </div>
      
      <div id="footer">

      </div>
    </body>
  </html>
