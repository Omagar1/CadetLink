<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script>
        <?php
        //echo "<table style='border: solid 1px black;'>";
        //echo "<tr><th>Id</th><th>NSN</th><th>ItemTypeID</th><th>NumIssued</th><th>NumInStore</th><th>NumReserved</th><th>NumOrdered</th></tr>";

        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
            }

            function beginChildren() {
                echo "<tr>";
            }

            function endChildren() {
                echo "</tr>" . "\n";
            }
          }
        ?>
        </script>
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <div id="navbarDash">
        <h2 class ="navBarDashTxt"> welcome Sgt sleep paralysis demon</h2>
        <img class = "profilePic" src="images/SgtWagar.jpg" alt="SgtDefalt" width="auto" height="150">
      </div>
      <div id="container">
        
        <div id="main">
            <h2>Kit Request Page - Work in Progress </h2>
        <script>
          <?php
          $servername = "2-12.co.uk";
          $username = "jrowden";
          $password = "tjwa1234";
          $dbname = "CadetLinkDB";

          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM items");
            $stmt->execute();

            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
              echo $v;
            }
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
          echo "</table>";
          echo "this ran"
          ?>
          </script>

            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>