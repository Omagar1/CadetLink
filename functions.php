<?php 
// --------------------------------------------------Common lines of code that appear in multiple pages --------------------------------------------------
function head($pageName, $extra=null){
    ?>
    <head>
    <title>CadetLink Alpha 0.1</title>
    <link href="main.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="Validation.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <?php
    destroyUnwantedSession($pageName);
    echo $extra;
    //var_dump($_SESSION['previous']);//test 
    if(in_array($pageName, $_SESSION['previous']) != true){ // avoids repeats
        array_push($_SESSION['previous'],$pageName); //adds the current page to the top of the stack
    }else{

    }
}

function notLoggedIn(){
    //checks if not logged in 
    if(!isset($_SESSION["loggedIn"]) and ($_SESSION["loggedIn"] != true) ){
        header("location: index.php"); // if so redirects them to the loginpage page
      };
}

function destroyUnwantedSession($pageName) {
    //destroys unwanted error messages from other pages 
    if (isset($_SESSION['previous'])) {
        if ($pageName != end($_SESSION['previous'])) { // checks if this is the page the error was meant to display on 
             unset($_SESSION['msg']); // unset's the msg session if so 
        }else{

        }
    }else{

    }    
}
function NavBar($pageName=null){
?>
    <div id="navbarDash" class = "flexColumn">
        <h1 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " ";
            echo $_SESSION['fname']. " ";
            echo $_SESSION['lname'];?></h1>
        <!--<div class = "profilePicContainer flexColumn">-->
            <img class = "profilePic right" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefault" width="auto" height="150">
            <div class = "left">
            <a href ="StackPop.php" class ="button" id = "backButton" ><?php 
            $temp =  $_SESSION["previous"];
            //echo  end($temp);//test
            if (end($temp) == "mainPage.php" or end($temp) == "adminMainPage.php"  ){
                echo "log Out";
            }else{
                echo "«";
            }
            ?></a>
            </div>
        </div>
    </div>
    <form></form> <!-- to fix Chrome being Weird -->
<?php
}

function prevPageCheck(){ // not finnished 
    
    $prevPage = $_SESSION["previous"];
}

function swapDateFormat($orgDate){// changes date from YYYY-MM-DD to DD-MM-YYYY
    $newDate = date("d-m-Y", strtotime($orgDate));
    //echo $newDate; // test 
    return $newDate ;
}
function stackPopAndRedirect(){
    if(gettype($_SESSION["previous"]) == "array"){
        array_pop($_SESSION["previous"]); // delete the top of the stack, which should be the page which this page was called from pages
        //echo end($_SESSION["previous"]); // test 
        header("location: ".end($_SESSION["previous"])); // send them to the page at the now top of the stack, which should be the previous page     
    }else{
        header("location: LOProcess.php"); // if nothing in the stack then then users should not be logged in so this logs them out 
    }
}
?>
