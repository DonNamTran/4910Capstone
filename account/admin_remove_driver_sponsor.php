<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<?php 
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $driver_id = $_POST['driver_id'];
    $oragnization = $_POST['organization'];
    $sponsor_id = $_POST['sponsor_id'];
    echo $driver_id, $oragnization, $sponsor_id;


    $sql_remove_sponsor = "DELETE FROM driver_sponsor_assoc WHERE driver_id=? AND assoc_sponsor_id=?";
    $stmt_removed = $connection->prepare($sql_remove_sponsor);
    $stmt_removed->bind_param('ii', $driver_id, $sponsor_id);
    $stmt_removed->execute();

    $sql_next_sponsor = "SELECT * FROM driver_sponsor_assoc CROSS JOIN organizations 
    ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE driver_id=$driver_id;";
    $result = mysqli_query($connection, $sql_next_sponsor);
    $next_sponsor = ($result->fetch_assoc())['organization_username'];
    if($next_sponsor) {
        echo $next_sponsor;
    } else {
        echo 'None';
    }
?>