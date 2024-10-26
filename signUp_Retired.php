<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link href="loginSignup.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com"> 
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <script>
        function backgroundChange() {
          document.getElementById("p2").style.color = "blue";
        }
      </script>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
      </div>

      <div id="navbar">

      </div>
      <div id="container">
        
        <div id="mainSignUp">
          <fieldset>
            <Legend><b>sign up</b></Legend>
            <form>
              <label for="fname">First name:</label><br>
              <input type="text" id="fname" name="fname" value=""><br>
              <label for="lname">Last name:</label><br>
              <input type="text" id="lname" name="lname" value="">
              <div id = "radio">
              <input type="radio" id="CFAV" name="role" value="CFAV">
              <label for="CFAV" class="inline">CFAV</label><br>
              <input type="radio" id="cadet" name="role" value="cadet">
              <label for="cadet" class="inline">cadet</label><br>
              </div>
              <select id = rank >
                <option value="Cdt" class = "cadet">Cadet</option>
                <option value="l/Cpl" class = "cadet">Lance Corpral</option>
                <option value="Cpl" class = "cadet">Corpral</option>
                <option value="Sgt" class = "cadet">Sergent</option>
                <option value="Ssgt" class = "cadet">Staf Sergent</option>
                <option value="W02" class = "cadet">Warrengt Oficer class 2</option>
                <option value="W01" class = "cadet">Warrengt Oficer class 1</option>
                <option value="SgtCFAV" class = "CFAV">CFAV Sergent</option>
                <option value="2lt" class = "CFAV" > 2nd Lieutenant</option>
                <option value="lt" class = "CFAV"> Lieutenant</option>
                <option value="Cpt" class = "CFAV">Captian</option>
                <option value="Maj" class = "CFAV"> Major</option>

              </select>
              <input type="submit" class = "button"> 
            </form>
          </fieldset>
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>
