<?php
session_start();
if(gettype($_SESSION["previous"]) == "array"){
    array_pop($_SESSION["previous"]); // delete the top of the stack, which should be the page which this page was called from pages
    //echo end($_SESSION["previous"]);
    header("location: ".end($_SESSION["previous"])); // send them to the page at the now top of the stack, which should be the previous page     
}else{
    header("location: LOProcess.php");
}
?>
