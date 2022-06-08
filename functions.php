<?php 
// --------------------------------------------------Common lines of code that appear in multiple pages --------------------------------------------------
function head(){
    ?>
    <head>
    <title>CadetLink</title>
    <link href="main.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="Validation.js"></script>
    </head>
    <?php
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
        if ($pageName != $_SESSION['previous'][-1]) { // checks if this is the page the error was meant to display on 
             unset($_SESSION['msg']); // unset's the msg session if so 
        }else{

        }
    }else{

    }
    array_push($_SESSION['previous'],$pageName); //sets current page as previous for next page which uses this function
    
}
function NavBar($pageType, $prevPage){
?>
    <div id="navbarDash" class = "flexColumn">
        <h1 class ="navBarDashTxt"> welcome <?php echo $_SESSION['rank']. " ";
            echo $_SESSION['fname']. " ";
            echo $_SESSION['lname'];?></h1>
        <!--<div class = "profilePicContainer flexColumn">-->
            <img class = "profilePic right" src="images/<?php echo $_SESSION['profilePicURL'];?>" alt="SgtDefault" width="auto" height="150">
            <?php
            if($pageType == "DashBoard"){?>
                <form method="get" action="LOProcess.php">
                    <button type="submit" class = "button navButton">LogOut</button>
                </form>
            <?php
            }elseif ($pageType == "action"){?>
                <form action ="<?php
                if($_SESSION['troop']=="CFAV"){
                    echo "adminMainPage.php";
                }else{
                    echo "mainPage.php";
                }
                ?>">
                <input type="submit" class = "smallButton" value="«" name="dashButton">
                <?php
            }elseif ($pageType == "action2nd"){?>
                <form action ="<?php
                    echo $prevPage;
                ?>">
                <input type="submit" class = "smallButton" value="«" name="dashButton">
                <?php
            }
            ?>
        </div>
    </div>
    <form></form> <!-- to fix Chrome being Weird -->
<?php
}

function prevPageCheck(){ // not finnished 
    
    $prevPage = $_SESSION["previous"];
}

?>