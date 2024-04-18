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

// Get query variables from POST/SESSION
$driver_id = $_POST['driver_id'];
echo "" . $driver_id;
$reason = $_POST['reason'];
$_SESSION['point_val'] = 0;
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");

// Create query to see if driving behavior id exists
$driver_id_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$driver_id'");

// Get the new point value for the driver
while($rows=$driver_id_query->fetch_assoc()) {
    if(!($rows['driver_points'] == NULL)) {
        $_SESSION['point_val'] = $rows['driver_points'];
    }
    $sponsor_name = $rows['driver_associated_sponsor'];
}

$point_val = $_SESSION['point_val'] + $_POST['points'];

$driver_id_query2 = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$driver_id' AND driver_archived=0");

// Check for invald info
if(!($row=$driver_id_query2->fetch_row())){
    echo '<script>alert("The Driver ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "admin_update_driver_point_status.php"</script>';
} else{

    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_id=$driver_id";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $point_val);

    $point_change = "+" . $_POST['points'];
    $sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount, point_history_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_point_history = $conn->prepare($sql_point_history);
    $stmt_point_history->bind_param("ssisss", $regDate, $point_val, $driver_id, $reason, $point_change, $sponsor_name);

    $sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
    $stmt_audit = $conn->prepare($sql_audit);
    $point_change_reason = "Added: " . $reason;
    $stmt_audit->bind_param("ssss", $row[3], $regDate, $point_change_reason, $point_change);

    if ($stmt_drivers->execute() & $stmt_point_history->execute() && $stmt_audit->execute()) {
        echo '<script>alert("Points sucessfully added!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/administratorhomepage.php"</script>';
    }
    else{
        echo '<script>alert("Failed to add points...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "admin_update_driver_point_status.php"</script>';
    }
}
?>

</body>
</html>