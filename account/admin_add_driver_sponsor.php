<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<?php 
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $driver_id = $_POST['driver_id'];
    $driver_name = $_POST['driver_name'];
    $oragnization = $_POST['sponsor'];
    //echo $driver_id, $oragnization, $sponsor_id;

    $get_sponsor_id = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username=$organization");
    $sponsor_id = ($get_sponsor_id->fetch_assoc())['organization_id'];
    
    //Query to remove the driver-sponsor association.
    $sql_remove_sponsor = "INSERT INTO driver_sponsor_assoc (driver_id, driver_username, assoc_sponsor_id, assoc_points) VALUES (?,?,?,?);";
    $stmt_removed = $connection->prepare($sql_remove_sponsor);
    $stmt_removed->bind_param('isii', $driver_id, $driver_name, $sponsor_id, 0);
    if($stmt_removed->execute()) {
        $redirectpage = "admin_edit_driver_account.php";
        echo '<script>alert("Succesfully added sponsor company to driver!")</script>';
        echo '<script>window.location.href = "',$redirectpage,'"</script>';
    }

?>