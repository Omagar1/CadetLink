<?php session_start();
include "functions.php";
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
    
// -----------------------------------validation -----------------------------------

if (isset($_POST['submitAE']) or  isset($_POST['submitAEA'])){
  // getting variables
  echo "i Ran 0 <br>"; //test
  $eventName = $_POST["Name"];
  $eventLocation = $_POST["Location"];
  $eventStartDate = $_POST["startDate"];
  $eventEndDate = $_POST["endDate"];
  $eventStartTime = $_POST["startTime"];
  $eventEndTime = $_POST["endTime"];
  // file variables 
  $tmpName = $_FILES["fileToUpload"]["tmp_name"]; // finding temporary name
  $UploadedName = $_FILES["fileToUpload"]["name"]; 
  $fileSize = $_FILES["fileToUpload"]["size"];
  $fileType = trim($_FILES["fileToUpload"]["type"]);
  $fileError = $_FILES["fileToUpload"]["error"];
  $fileExtension = strtolower(pathinfo($UploadedName,PATHINFO_EXTENSION));
  
  // echo variables for testing
  echo "<br> tmpName: " . $tmpName;
  echo "<br> UploadedName: " . $UploadedName;
  echo "<br> fileSize: " . $fileSize;
  echo "<br> fileType: " . $fileType;
  echo "<br> fileError: " . $fileError;
  echo "<br> fileExtension: " . $fileExtension; 
  echo "<br>";
  $errors = 0;
  $currentDate = date("Y-m-d");
  $currentDateArr = explode("-",$currentDate);
  $eventStartDateArr = explode("-",$eventStartDate);
  if ($eventEndDate  == null){
    $eventEndDate = "9999-12-31"; // sets End date to highest possible for comparisons 
  }
  $eventEndDateArr = explode("-",$eventEndDate);
  //Other Variables Validation
  if($eventName == "" or $eventLocation == "" or $eventStartDate == "" or $eventStartTime == "" or $eventEndTime == ""){
    $msg = "Required Fields must Not Be Empty";
    $_SESSION['msg'] = $msg;
    echo "i Ran 1";
    $errors = 1;
  }
  // checks if the  Start date is in the past  
  if($errors != 1){
    // compares years first then Months then Days  
    for($i = 0; $i>3; $i++){
      if(intval($eventStartDateArr[$i]) < intval($currentDateArr[$i])){
        $msg = "Start Date Must Not be in the Past";
        $_SESSION['msg'] = $msg;
        $errors = 1;
        break;
      }else{

      }
    }
  }
  //checks if End date is Earlier than Start date 
  if($errors != 1){
    // compares years first then Months then Days 
    for($i = 0; $i>3; $i++){
      if(intval($eventStartDateArr[$i]) < intval($eventEndDateArr[$i])){
        $msg = "End Date Must Not be Earlier than Start Date ";
        $_SESSION['msg'] = $msg;
        $errors = 1;
        break;
      }else{
  
      }//sdjao
  }

  // file validation
  if ($_FILES["fileToUpload"]["size"] > 2000000 and $errors != 1) { // Check file size
    $msg =  "<p id = 'msg'><b class = 'error'>Sorry, your file is too large</b></p>";
    $_SESSION['msg'] = $msg;
    echo $msg;
    $errors = 1;
  }elseif($fileExtension == "txt" or $fileExtension == " docx" or $fileExtension == "doc" or $fileExtension == "pdf" and $fileExtension != "") { //only allow certain file formats
    $msg =  "<p id = 'msg'><b class = 'error'>Sorry, only txt, docx, doc and pdf files are allowed</b></p>";
    $_SESSION['msg'] = $msg;
    echo $msg;
    $errors = 1;
  }elseif ($errors != 1) { 
    // if(file_exists($fileNameFinal)){// Check if file already exists
    //   $msg =  "<p id = 'msg'><b class = 'error'>Sorry, file already exists</b></p>";
    //   $_SESSION['msg'] = $msg;
    //   echo $msg;
    //   $errors = 1;
    //}else{
    // if no error in has been found it submits it to the process page
      // testing 
      // $targetDir = "temp/";
      // $tempFinalLocation = $targetDir . $fileNameFinal;
      // $moved = move_uploaded_file($tempName, $tempFinalLocation);
    ?>
    <form Id = "AutoSendForm" action = "AEProcess.php" method="post">
      <!-- Events Variables -->
      <input type="hidden" id="eventName" name="eventName" value="<?php echo $eventName; ?>">
      <input type="hidden" id="eventLocation" name="eventLocation" value="<?php echo $eventLocation; ?>">
      <input type="hidden" id="eventStartDate" name="eventStartDate" value="<?php echo $eventStartDate; ?>">
      <input type="hidden" id="eventEndDate" name="eventEndDate" value="<?php echo $eventEndDate; ?>">
      <input type="hidden" id="eventStartTime" name="eventStartTime" value="<?php echo $eventStartTime; ?>">
      <input type="hidden" id="eventEndTime" name="eventEndTime" value="<?php echo $eventEndTime; ?>">
      <!-- File Variables -->
      <input type="hidden" id="fileType" name="fileType" value="<?php echo $fileType; ?>">
      <input type="hidden" id="fileTempLocation" name="fileTempLocation" value="<?php echo $tmpName; ?>">
    </form>

    <script type="text/javascript">
      document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
    </script><?php
    echo "i Ran 3";
    }
  }
}else{
  echo "i Ran 4";
}

// ---------------------------------------------------main code--------------------------------------------------- {

//}

      
    ?>
  </head>

  <body id = "test">
    <div id="header">
      <h1>CadetLink</h1>
    </div>

    <?php NavBar(); ?>
      <div id="main">
          <h2>User Management - Work in Progress </h2>
          <a href=manageEvents.php>
            <button class ="button">Manage Events</button>
          </a>
          <a href=#AddEvent.php >
            <button class ="button buttonPressed">Add Event</button>
          </a> 
          <fieldset>
            <?php if (isset($_SESSION["msg"])){
                  echo "<b class = error>" . $_SESSION['msg'] ."</b>";
                }else{
                  echo "";//test
                }
                
            ?>
            <table class = "tableDisplay">
            <form action="addEvent.php" method="post" enctype="multipart/form-data">
            <tr>
                  <th>Column Name</th>
                  <th>Data</th>
            </tr>
            <tr>
              <td>Name<br></td>
              <td><input type = "text" name = "Name" id = "Name" value = ""><br></td>
            </tr>
            <tr>
              <td>Location<br></td>
              <td><input type = "text" name = "Location" id = "Location" value = ""><br></td>
            </tr>
            <tr>
              <td>Start Date<br></td>
              <td><input type = "date" min="<?php echo date("Y-m-d");?>" name = "startDate" id = "startDate"><br></td>
            </tr>
            <tr>
              <td>End Date<br></td>
              <td><input type = "date" min="<?php echo date("Y-m-d");?>" name = "endDate" id = "endDate"><br></td>
            </tr>
            <tr>
              <td>Start Time<br></td>
              <td><input type = "time" name = "startTime" id = "startTime" value = ""><br></td>
            </tr>
            <tr>
              <td>End Time<br></td>
              <td><input type = "time" name = "endTime" id = "endTime" value = ""><br></td>
            </tr>
            <tr>
              <td>Orders<br></td>
              <td><input type = "file" name = "fileToUpload" id="fileToUpload"><br></td>
            </tr>
            </table>
            <input type="submit" name ="submitAE" class = "button" value="Add">
            </form>
          </fieldset>
      </div>
    <div id="footer">

    </div>
  </body>
</html>