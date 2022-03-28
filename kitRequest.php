<!DOCTYPE html>
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
        <img class = "profilePic" src="images/SgtWagar.jpg" alt="SgtDefalt" width="auto" height="150">
      </div>
      <div id="container">
        
        <div id="main">
            <h2>Kit Request Page - Work in Progress </h2>
          <fieldset>
            <form action = "KRProcess.php" method="post">
              <label for="UniformType">UniformType</label><br>
              <select id="UniformType" name="UniformType">
                <option value="1">Shirt Combat</option>
                <option value="2">Smock</option>
                <option value="3">Undershirt(Fleece)</option>
                <option value="4">Static T-Shirt</option>
                <option value="5">Trousers Combat</option>
                <option value="7">Boots</option>
                <option value="8">Beret</option>
                <option value="9">Cap MTP</option>
              </select><br>

              <label for="Size">Nato Size</label><br>
              <input type="text" id="Size" name="Size" value=""><br>

              <label for="purpose">purpose</label><br>
              <select id="purpose" name="purpose">
                <option value="GOOK">Grown Out of Old Kit</option>
                <option value="NI">Was Never Issued</option>
                <option value="LOK">Lost Old Kit</option>
                <option value="OKWD">Old Kit Was Damged</option>
              </select><br>

              <select id="NumRequested" name="NumRequested">
                <option value="1">1</option>
                <option value="2">2</option>
              </select><br>
              <input type="submit" class = "button">
            </fieldset>
            </form>
          

            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>