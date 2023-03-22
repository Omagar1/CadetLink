<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <?php 
      // starts session
      session_start();
      ?>
      <link href="loginSignup.css" rel="stylesheet" />
      <link href="main.css" rel="stylesheet" />
      <link href='loginSignup.css' rel='stylesheet' />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    
    </head>
    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
      </div>
      <div id="navbar">
        <ul class="navBarList">
          <li class = "inline"><a href="#home" class ="navBarTxt">Home</a></li>
          <li class = "inline"><a href="mainPage.htm"class ="navBarTxt">DashBoard</a></li>
          <li class = "inline"><a href="#contact" class ="navBarTxt">Contact an NCO</a></li>
          <li class = "inline"><a href="about.htm" class ="navBarTxt" > About</a></li>
        </ul>
      </div>
      <div id="container">
        
        <div id="mainSignUp">
          <fieldset>
            <Legend><b>Login</b></Legend>
            <form action = "LProcess.php" method="post">
                <label for="fname">CadetNumber</label><br>
                <input type="text" id="Cnum" name="Cnum" value=""><br>
                <label for="Pwd">Password</label><br>
                <input type="password" id="Pwd" name="Pwd" value=""><br>

              <input type="submit" class = "button">
            </form>
              <!-- Error message system  -->
            
              <p id = "msg"><b class = "error"> <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
              ?></b></p>
          </fieldset>
        </div>
      </div>
      <div id="footer">
      </div>
    </body>
  </html>