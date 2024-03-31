<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<?php 
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $driver_id = $_POST['driver_id'];
    $oragnization = $_POST['organization'];
    $sponsor_id = $_POST['sponsor_id'];
    echo $driver_id, $oragnization, $sponsor_id;
?>