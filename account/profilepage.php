<?php
  session_start();
  if(!$_SESSION['login']) {
    echo "Invalid page.<br>";
    echo "Redirecting.....";
    sleep(2);
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
  }
  var_dump($_SESSION['user_data']);
?>
