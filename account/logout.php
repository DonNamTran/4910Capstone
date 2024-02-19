<?php
    session_start();
    session_unset();
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
?>