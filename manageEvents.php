<?php session_start();
include "functions.php";
require_once "ConnectDB.php";
?>
<html>
    <?php
    $pageName = basename($_SERVER["PHP_SELF"]);// getting the name of the page so head can add it to the Previous stack
    head($pageName);// from functions.php, echoes out the head tags

    notLoggedIn(); // from functions.php, checks if user is logged in 

    destroyUnwantedSession($pageName);// from functions.php, destroys unwanted error messages from other pages 
    $CnumUsed = false;
    // connects to database
    require_once "ConnectDB.php";
    
// ---------------------------------------------------functions---------------------------------------------------  
    
// ---------------------------------------------------main code---------------------------------------------------
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
    ?>
  </head>

  <body id = "test">
    <div id="header">
      <h1>CadetLink</h1>
    </div>

    <?php NavBar(); ?>
      <div id="main">
          <h2>User Management - Work in Progress </h2>
          <a href=#manageEvents.php>
            <button class ="button buttonPressed">Manage Events</button>
          </a>
          <a href=addEvent.php >
            <button class ="button ">Add Event</button>
          </a> 
          <fieldset>
          <?php
             for($i = 0; $i < $count; $i++ ){
            ?>
            <div class = "events" style = "display: block">
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
              <form method='post' action ='editEvent.php'>
                <input type='hidden' id = 'editEvent' name='editEvent' value='<?php echo $eventIDArr[$i]?> '/>
                <input type='submit' class = "button" name='eE' value='edit'/>
              </form>
            </div>
            <?php
             } // close For loop 
            ?>
          </fieldset>
      </div>
    <div id="footer">

    </div>
  </body>
</html>