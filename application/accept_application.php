<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$driver_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$_POST['account_id']'");

while($rows=$driver_query->fetch_assoc()) {
    if($rows['driver_associated_sponsor'] == "none") {
        $curr_sponsor = "none";
    }
}

// Update associated sponsor in drivers table if they have no sponsor
if($curr_sponsor == "none") {
    $sql_drivers = "UPDATE drivers SET driver_associated_sponsor=? WHERE driver_id='$_POST['account_id']'";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("s", $_POST['organization_name']);
    $stmt_drivers->execute();
}

// Check if organization is already associated with sponsor
$assoc_query = mysqli_query($conn, "SELECT * FROM driver_sponsor_assoc");
$org_is_assoc = false;

while($rows=$assoc_query->fetch_assoc()) {
    if($rows['assoc_sponsor_id'] == $_POST['organization_id'] && $rows['driver_id'] == $_POST['driver_id']) {
        $org_is_assoc = true;
        $assoc_id = $rows['id'];
    }
}

if($org_is_assoc) {
    $archived = 0;
    $sql_assoc = "UPDATE driver_sponsor_assoc SET driver_sponsor_assoc_archived=? WHERE id = '$assoc_id'";
    $stmt_assoc = $conn->prepare($sql_assoc);
    $stmt_assoc->bind_param("i", $archived);  
}
else {
    $driver_points = 0;
    $sql_assoc = "INSERT INTO driver_sponsor_assoc (driver_id, driver_username, assoc_sponsor_id, driver_points) VALUES (?, ?, ?, ?)";
    $stmt_assoc = $conn->prepare($sql_assoc);
    $stmt_assoc->bind_param("isii", $_POST['account_id'], $_POST['driver_username'], $_POST['organization_id'], $driver_points);
}

if ($stmt_assoc->execute()) {
    echo '<script>alert("Application accepted!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/sponsor_view_applications.php"</script>';
}
else{
    echo '<script>alert("Failed to accept application...redirecting")</script>';
    echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php""</script>';
}
    
?>

</body>
</html>