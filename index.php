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
      ?>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
      </div>

      <div id="navbar">
        <ul class="navBarList">
          <li class = "inline"><a href="mainPage.php"class ="navBarTxt"> Example DashBoard</a></li>
          <li class = "inline"><a href="About.php" class ="navBarTxt" >What is Cadetlink?</a></li>
        </ul>
      </div>
      <div id="container">
        
        <div id="mainSignUp">
          <fieldset>
            <Legend><b>Login</b></Legend>
            <form action = "LProcess.php" method="post">
                <label for="Cnum">CadetNumber</label><br>
                <input type="text" id="Cnum" name="Cnum" value=""><br>
                <label for="Pwd">Password</label><br>
                <input type="password" id="Pwd" name="Pwd" value=""><br>
                
              <input type="submit" class = "button">
              <p> <?php echo $_SESSION['msg'];?></p>
            </form>
            <button class ="button" onclick ="getElementById('demo').innerHTML= Contact Your CFAV to Reset your details;">Forgot your Cadet Number or Password?</button>
            <p id="reveil"></p>
          </fieldset>
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>
