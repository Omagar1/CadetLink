<?php
session_start();
require_once "ConnectDB.php";
include "functions.php"
?>

<!DOCTYPE html>
  <html>
    
      <?php
      $prevPage = $_SESSION["previous"];
      //echo $prevPage; // testing 
      head();// from functions.php, echoes out the head tags

      notLoggedIn(); // from functions.php, checks if user is logged in 

      destroyUnwantedSession();// from functions.php, destroys unwanted error messages from other pages 

      //qry to find number of requests for notification 
      $sql = "SELECT ID FROM itemRequest;";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $requestCount = $stmt->rowCount();


      // gets all events stored in database ordered by closest date to 
      $sql = "SELECT * FROM events ORDER BY startDate, startTime;";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
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
        array_push($eventStartDateArr,$row['startDate']);
        array_push($eventEndDateArr,$row['endDate']);
        array_push($eventStartTimeArr,$row['startTime']);
        array_push($eventEndTimeArr,$row['endTime']);
      }
      //formatting the dates into display format
      $dateDisplayArr = [];
      for($i = 0; $i < $count; $i++ ){
        if($eventEndDateArr[$i] != "" ){
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
      NavBar("DashBoard", $prevPage);
      ?>
        <div id="main">
            <h2>Your Dashboard</h2>
            
            <?php
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
            ?>
            
            <!-- dashboard buttons -->
            <div>
                <ul class="no-bullets">
                <li class ="dashbordSection dashboard" class = "inline"><a href = "manageUsers.php" class = "dasbordTxt">Manage Users</a></li>
                <li class ="dashbordOrders dashboard"><a href = "events.php" class = "dasbordTxt">Events</a></li>
                <li class ="dashbordKitRequest dashboard"><a href = "virtualStores.php"class = "dasbordTxt">Virtual Stores<?php
                if($requestCount > 0){
                  echo "<span class = 'notification'>$requestCount</span>";
                }else{

                }
                ?></a></li>
                <li class ="dashbordKitRequest dashboard"><a href = "kitRequest.php"class = "dasbordTxt">kit Request</a></li>
                <li class ="dashbordTrips dashboard"><a href = "trips.php"class = "dasbordTxt">Trips</a></li>
                <li class ="dashbordVPB dashboard"><a href = "#VPB"class = "dasbordTxt">Virtual Pocket Book</a></li>
                </ul>


 

                <!-- new dash board not implemented yet
                <ul class="no-bullets">
                <li class ="dashbordKitRequest" class ="dashbord"><a href = "kitRequest.php"class = "dasbordTxt">kit Request</a></li>
                <li class ="dashbordTrips" class ="dashbord"><a href = "trips.php"class = "dasbordTxt">Trips</a></li>
                <li class ="dashbordVPB" class ="dashbord"><a href = "#VPB"class = "dasbordTxt">Virtual Pocket Book</a></li>
                </ul>
                <ul class="no-bullets">
                <li class = "">
                <form action = "manageUsers.php">
                <input type = "submit" value ="Manage Users" class = "button dashbord BenBlue"/>
                </form> 
                </li>
                <li class = "">
                <form action = "virtualStores.php">
                <input type = "submit" value ="Virtual Stores <?php/* 
                if($requestCount > 0){
                  echo "<span class = 'notification'>$requestCount</span>";
                }else{

                }
                */?>" class = "button dashbord tjwaRed"/> 
                </form>
                </li>
                <li class = "">
                <form action = "ordersAdmin.php">
                <input type = "submit" value ="ordersAdmin" class = "button dashbord armyGreen"/> -->

                </form>
                </li>
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
