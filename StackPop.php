<?php
session_start();
array_unique($_SESSION["previous"], SORT_STRING ); // makes it so that there can be no duplicates in array
var_dump($_SESSION["previous"]);//test
array_pop($_SESSION["previous"]); // delete the top of the stack, which should be the page which this page was called from pages
var_dump($_SESSION["previous"]);//test
echo end($_SESSION["previous"]);
header("location: " . end($_SESSION["previous"])); // send them to the page at the now top of the stack, which should be the previous page
?>