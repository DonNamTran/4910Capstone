<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<?php 
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $driver_id = $_POST['driver_id'];
    $organization = $_POST['organization'];
    $sponsor_id = $_POST['sponsor_id'];
    //echo $driver_id, $oragnization, $sponsor_id;

    //Query to remove the driver-sponsor association.
    $sql_remove_sponsor = "DELETE FROM driver_sponsor_assoc WHERE driver_id=? AND assoc_sponsor_id=?";
    $stmt_removed = $connection->prepare($sql_remove_sponsor);
    $stmt_removed->bind_param('ii', $driver_id, $sponsor_id);
    $stmt_removed->execute();

    //Query to grab the next sponsor the driver has.
    $sql_next_sponsor = "SELECT * FROM driver_sponsor_assoc CROSS JOIN organizations 
    ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE driver_id=$driver_id;";
    $result = mysqli_query($connection, $sql_next_sponsor);
    $next_sponsor = $result->fetch_assoc();
    if($next_sponsor) {
        $next_sponsor_company = $next_sponsor['organization_username'];
        $next_points = $next_sponsor['assoc_points'];

        $sql_update_driver = "UPDATE drivers SET driver_associated_sponsor=?, driver_points=? WHERE driver_id=?";
        $stmt_update_driver = $connection->prepare($sql_update_driver);
        $stmt_update_driver->bind_param('sii', $next_sponsor_company, $next_points, $driver_id);
        if($stmt_update_driver->execute()) {
            $redirectpage = "admin_edit_driver_account.php";
            echo '<script>alert("Succesfully removed sponsor company from driver!")</script>';
            echo '<script>window.location.href = "',$redirectpage,'"</script>';
        } else {
            echo '<script>alert("Failed to remove the sponsor company...")</script>';
        }
    } else {
        $next_sponsor_company = 'none';
        $next_points = 0;

        $sql_update_driver = "UPDATE drivers SET driver_associated_sponsor=?, driver_points=? WHERE driver_id=?";
        $stmt_update_driver = $connection->prepare($sql_update_driver);
        $stmt_update_driver->bind_param('sii', $next_sponsor_company, $next_points, $driver_id);
        if($stmt_update_driver->execute()) {
            $redirectpage = "admin_edit_driver_account.php";
            echo '<script>alert("Succesfully removed sponsor company from driver! Driver has no sponsor...")</script>';
            echo '<script>window.location.href = "',$redirectpage,'"</script>';
        } else {
            echo '<script>alert("Failed to remove the sponsor company...")</script>';
        }
    }
?>