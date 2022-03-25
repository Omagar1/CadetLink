<!DOCTYPE html>
  <html>
    <head>
      <title>CadetLink</title>
      <link href="main.css" rel="stylesheet" />
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <?php
      session_start();
      echo "<table class = 'tableDisplay' >";
      echo "<tr><th>Id</th><th>NSN</th><th>ItemTypeID</th><th>NumIssued</th><th>NumInStore</th><th>NumReserved</th><th>NumOrdered</th><th>itemID</th><th>sizetypeID</th><th>value</th><th>unit</th></tr>";

      class TableRows extends RecursiveIteratorIterator {
          function __construct($it) {
              parent::__construct($it, self::LEAVES_ONLY);
          }

          function current() {
              return "<td>" . parent::current(). "</td>";
          }

          function beginChildren() {
              echo "<tr>";
          }

          function endChildren() {
              echo "</tr>" . "\n";
          }
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
        <img class = "profilePic" src="images/SgtWagar.jpg" alt="SgtDefalt" width="auto" height="150">
      </div>
      <div id="container">
          <div id="main">
            <h1>Virtual Stores</h1>
          </div>
          <?php
          $servername = "2-12.co.uk";
          $username = "jrowden";
          $password = "tjwa1234";
          $dbname = "CadetLinkDB";

          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("
            SELECT *
            FROM items
            INNER JOIN sizes
            ON items.ID = sizes.itemID;");
            $stmt->execute();

            // set the resulting array to associative
            //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            var_dump($result);
           
            foreach ($result as $k => $v) {
             echo $k;
             echo "<br>";
             echo $v[1];
             echo "<br><br>";
             }

            // setup table and heading row

            // foreach - echo out each row
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
              echo $v;
            }

            // end the table here

          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
          echo "</table>";
      
          //style='width: 150px; border: 1px solid black; background-color: rgb(0, 43, 23, 0.938);'
          //style='border: solid 1px black;'
          ?>

            
        
      </div>
      <div id="footer">

      </div>
    </body>
  </html>