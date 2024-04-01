<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Check whether account is admin viewing as sponsor or is an actual sponsor account
if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $sponsor_name = $rows['associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $sponsor_name = $rows['administrator_associated_sponsor'];
        }
    }
}

// Get query variables from POST
$driver_id = $_POST['driver_id'];
$archived = 1;

$driver_id_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$driver_id' AND driver_archived=0 AND driver_associated_sponsor='$sponsor_name'");

// Check for invalid info
if(!($row=$driver_id_query->fetch_row())){
    echo '<script>alert("The Driver ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "sponsor_archive_driver_account.php"</script>';
} else{

    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_archived=? WHERE driver_id='$driver_id'";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $archived);

    if ($stmt_drivers->execute()) {
        echo '<script>alert("Account successfully archived!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/sponsor_archive_account.php"</script>';
    }
    else{
        echo '<script>alert("Failed to archive account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "sponsor_archive_driver_account.php"</script>';
    }
}
?>

</body>
</html>