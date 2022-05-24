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
     //checks if not logged in
     if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
      header("location: index.php"); // if so redirects them to the loginpage page
    }
    // system to destroy msg variable when its not wanted
    if (isset($_SESSION['previous'])) {
      if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
          unset($_SESSION['msg']);
      }else{

      }
    }else{

    }
    $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
    // ---------------------------------------------------- Validation -------------------------------------------------
    if (isset($_POST['submitUO'])){
      // getting variables
      echo "i Ran 0 <br>"; //test
      $targetDir = "temp/";
      $tmpName = $_FILES["fileToUpload"]["tmp_name"]; // finding temporary name
      $UploadedName = $_FILES["fileToUpload"]["name"]; 
      $fileSize = $_FILES["fileToUpload"]["size"];
      $fileType = $_FILES["fileToUpload"]["type"];
      $fileError = $_FILES["fileToUpload"]["error"];
      $fileNameFinal = $_POST["fileNameFinal"];
      $dateFor = $_POST["dateFor"];
      $fileExtension = strtolower(pathinfo($UploadedName,PATHINFO_EXTENSION));

      // echo variables for testing
      echo "<br> tmpName: " . $tmpName;
      echo "<br> UploadedName: " . $UploadedName;
      echo "<br> fileSize: " . $fileSize;
      echo "<br> fileType: " . $fileType;
      echo "<br> fileError: " . $fileError;
      echo "<br> fileNameFinal: " . $fileNameFinal;
      echo "<br> dateFor: " . $dateFor;
      echo "<br> fileExtension: " . $fileExtension; 
      echo "<br>";
      $targetDir = "temp/";
      //$targetFileBaseName = $_FILES["fileToUpload"]["name"];
      $fileTempLocation = $targetDir . $fileNameFinal;
      move_uploaded_file($tmpName, $fileTempLocation);




      

     
      if($fileNameFinal == "" or $dateFor ==""){
        $msg = "Fields must Not Be Empty";
        $_SESSION['msg'] = $msg;
        echo "i Ran 1";
      }elseif(strlen($fileNameFinal)>20){ // limits namelength to less than 20 
        $msg = "File Name To Large";
        $_SESSION['msg'] = $msg;
        echo "i Ran 2";
      }elseif (file_exists($fileNameFinal)) { // Check if file already exists
        $msg =  "<p id = 'msg'><b class = 'error'>Sorry, file already exists</b></p>";
        $_SESSION['msg'] = $msg;
        echo $msg;
      }elseif ($_FILES["fileToUpload"]["size"] > 500000) { // Check file size
        $msg =  "<p id = 'msg'><b class = 'error'>Sorry, your file is too large</b></p>";
        $_SESSION['msg'] = $msg;
        echo $msg;
      }elseif($fileExtension != "txt" and $fileExtension != "docx" and $fileExtension != "doc" and $fileExtension != "pdf" ) { //only allow certain file formats
        $msg =  "<p id = 'msg'><b class = 'error'>Sorry, only txt, docx, doc and pdf files are allowed</b></p>";
        $_SESSION['msg'] = $msg;
        echo $msg;
      }else{// if no error in has been found it submits it to the process page 
        ?><form Id = "AutoSendForm" action = "UOProcess.php" method="post">
        <input type="hidden" id="fileNameFinal" name="fileNameFinal" value="<?php echo $fileNameFinal; ?>">
        <input type="hidden" id="dateFor" name="dateFor" value="<?php echo $dateFor; ?>">
        <input type="hidden" id="fileType" name="fileType" value="<?php echo $fileType; ?>">
        <input type="hidden" id="fileTempLocation" name="fileTempLocation" value="<?php echo $tmpName; ?>">
        </form>

        <script type="text/javascript">
          //document.getElementById("AutoSendForm").submit(); // auto submits form                        ^
        </script><?php
        echo "i Ran 3";
      }
    
    }else{
      echo "i Ran 4";
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
            echo $_SESSION['lname'];?></h2></h2>
        <img class = "profilePic" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefalt" width="auto" height="150">
        <form action ="<?php
        if($_SESSION['troop']=="CFAV"){
          echo "adminMainPage.php";
        }else{
          echo "mainPage.php";
        }
        ?>">
        <input type="submit" class = "smallButton" value="«" name="dashButton">
        </form>
      </div>
        
        <div id="main">
          <h2>Orders Page - Work in Progress </h2>
          <?php if (isset($_SESSION["msg"]) != ""){
               echo $_SESSION['msg'];
              }else{

              }
          ?>
          <form action="ordersAdmin.php" method="post" enctype="multipart/form-data">
          <label for = "fileNameFinal">File Name</label><br>
          <input type = "text" name = "fileNameFinal" id = "fileNameFinal"><br>
          <label for = "dateFor">Date For</label><br>
          <input type = "date" min="<?php echo date("Y-m-d");?>" name = "dateFor" id = "dateFor"><br>

          <label for = "fileToUpload">Upload File</label>
          <input type = "file" name = "fileToUpload" id="fileToUpload">
          <br>
          <input type="submit" name="submitUO" value="Upload">
          </form>
            
        </div>
      </div>
      <div id="footer">

      </div>
    </body>
  </html>
