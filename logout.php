<?php
/* ---------------------------------------------------------------------------
 * filename    : logout.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program logs the user out by destroying the session
 * ---------------------------------------------------------------------------
 */
session_start();
session_destroy(); 
header("Location: login.php");
?>