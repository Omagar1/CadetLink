<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="loginSignup.css" rel="stylesheet" />
      <link href="main.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <?php
      session_start();
      // system to destroy msg variable when its not wanted
      if (isset($_SESSION['previous'])) {
        if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
             unset($_SESSION['msg']);
        }else{

        }
      }else{

      }
      $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
      ?>
      <script>
        function processForm(){
          Cnum = document.getElementById("Cnum");
          
          CnumValue = String(Cnum.value);
          console.log(CnumValue);
          

          if (CnumValue.length < 8 ){
            
            msg = document.getElementById("msg");
            msg.innerHTML = "Cadet Number Too Short";

            Cnum.style.borderColor = "red";
            Cnum.style.backgroundColor = "pink";

            return false;
          }else{
            Cnum.style.borderColor = "";
            Cnum.style.backgroundColor = "";
            
            return true;
          }
        }
      </script>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
      </div>

      <div id="navbar">
        <ul class="navBarList">
          <li class = "inline"><a href="mainPage.php"class ="navBarTxt"> Example DashBoard</a></li>
          <li class = "inline"><a href="About.php" class ="navBarTxt" >What is Cadetlink?</a></li>
          <li class = "inline"><a href="test.php" class ="navBarTxt" >test</a></li>
        </ul>
      </div>
      <div id="container">
        
        <div id="mainSignUp">
          <fieldset>
            <Legend><b>Login</b></Legend>
            <form action = "LProcess.php" method="post" id = "logInForm" onsubmit = "return processForm(this) ">
                <label for="Cnum">CadetNumber</label><br>
                <input type="text" id="Cnum" name="Cnum" value=""><br>
                <label for="Pwd">Password</label><br>
                <input type="password" id="Pwd" name="Pwd" value=""><br>
                
              <input onclick ="processForm()" type="submit" class = "button">
              
            </form>

            <p id = "msg"><b class = "error"> <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
               ?></b></p>
            <button class ="button">Forgot your Cadet Number or Password?</button>
            <!-- onclick ="getElementById('reveil').innerHTML= "Contact Your CFAV to Reset your details" -->
            <p id="reveil">test</p>
          </fieldset>
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>
