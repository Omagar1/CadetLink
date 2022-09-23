<?php
session_start();
require_once "ConnectDB.php";
include "functions.php"
?>

<!DOCTYPE html>
  <html>
    
      <?php
      $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
      head($pageName);// from functions.php, echoes out the head tags

      notLoggedIn(); // from functions.php, checks if user is logged in 

      destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 

      //qry to find number of requests for notification 
      $sql = "SELECT ID FROM itemRequest;";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $requestCount = $stmt->rowCount();


      // gets all events stored in database that are not past ordered by closest date to
      $currentDate = date("Y-m-d");
      $sql = "SELECT * FROM events  WHERE endDate > ? ORDER BY startDate, startTime;";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$currentDate]);
      $count = $stmt->rowCount();
      // inisalising arrays 
      $eventIDArr        = [];
      $eventNameArr      = [];
      $eventLocationArr  = [];
      $eventStartDateArr = [];
      $eventEndDateArr   = [];
      $eventStartTimeArr = [];
      $eventEndTimeArr   = [];
      //putting data into arrays from qry 
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($eventIDArr,$row['ID']);
        array_push($eventNameArr,$row['name']);
        array_push($eventLocationArr,$row['location']);
        array_push($eventStartDateArr,swapDateFormat($row['startDate']));
        array_push($eventEndDateArr,swapDateFormat($row['endDate']));
        array_push($eventStartTimeArr,$row['startTime']);
        array_push($eventEndTimeArr,$row['endTime']);
      }
      //formatting the dates into display format
      $dateDisplayArr = [];
      for($i = 0; $i < $count; $i++ ){
        if($eventEndDateArr[$i] != "31-12-9999" ){
          array_push($dateDisplayArr, $eventStartDateArr[$i] . " to " . $eventEndDateArr[$i]);
        }else{
          array_push($dateDisplayArr, $eventStartDateArr[$i]);
        }
      }
      //formatting the times into display format
      $timeDisplayArr = [];
      for($i = 0; $i < $count; $i++ ){
        array_push($timeDisplayArr, $eventStartTimeArr[$i] . " to " . $eventEndTimeArr[$i]);
      }
      // testing 
      //var_dump($eventNameArr);
      ?>
      
    </head>

    <body id = "test">
      <div id="header">
        <h1>CadetLink</h1>
        
      </div>

      <?php
      NavBar();
      ?>
        <div id="main">
            <h2>Your Dashboard</h2>
            
            <?php
            if($count > 0){
             for($i = 0; $i < $count; $i++ ){
            ?>
            <div class = "events fade">
              <h3 class = "navBarDashTxt"><?php echo $eventNameArr[$i];?></h3>
              <table class = "eventTable tableDisplay">
                <tr>
                  <td class = "eventTd">Location:</td>
                  <td class = "eventTd"><?php echo $eventLocationArr[$i];?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Date:</td>
                  <td class = "eventTd"><?php echo $dateDisplayArr[$i];?></td>
                </tr>
                <tr>
                  <td class = "eventTd">Time:</td>
                  <td class = "eventTd"><?php echo $timeDisplayArr[$i];?></td>
                </tr>
                <tr>
                  <td class = "eventTd" >Orders:</td>
                  <td class = "eventTd">Work in Progress</td>
                </tr>
                <tr>
                  <td class = "eventTd">Notes:</td>
                  <td class = "eventTd">Work in Progress</td>
                </tr>
              </table>
              <a class="prev fade left  " onclick="plusSlides(-1)">❮</a>
              <a class="next fade right" onclick="plusSlides(1)">❯</a>
            </div>
            <?php
             }
            }else{
               echo "<div class = 'events fade'><h3 class = 'navBarDashTxt'>There are no Upcoming Events</h3><br><p style = 'color:Black'>If they were they would appear here</p></div>";
            }
            ?>
            <div>
                <ul class="no-bullets">
                  <li><a href = "#troop"><button class ="BenBlue dashboard dasbordTxt">Troop: <?php echo $_SESSION["troop"]?></button></a></li>
                  <li><a href = "events.php"><button class ="tjwaRed dashboard dasbordTxt">Events</button></a></li>
                  <li><a href = "kitRequest.php"><button class ="purple dashboard dasbordTxt">kit Request</button></a></li>
                  <li><a href = "resetPWord.php"><button class ="paleGreen dashboard dasbordTxt">Change Password</button></a></li>
                  <!-- <li><a href = "help.php"><button class ="paleGreen dashboard dasbordTxt">HELP!</button></a></li> -->
                </ul>
            </div>
            <script> // script to make the slide show of events work
        let slideIndex = 1;// the number of slide displayed 
        showSlides(slideIndex);

        function plusSlides(n) {
          showSlides(slideIndex += n);
        }

        function currentSlide(n) { // not used 
          showSlides(slideIndex = n);
        }

        function showSlides(n) {
          let i;
          let slides = document.getElementsByClassName("events");
          console.log(slides.length);
          if (n > slides.length) {
            slideIndex = 1;
          }else if (n < 1) {
            slideIndex = slides.length;
          }
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          slides[slideIndex-1].style.display = "block";  
        }
        </script>   
        </div>
      
      <div id="footer">

      </div>
    </body>
  </html>
