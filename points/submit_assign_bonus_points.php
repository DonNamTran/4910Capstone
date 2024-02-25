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

$result = mysqli_query($connection, "SELECT * FROM sponsors");

// Get the sponsor id associated with the sponsor's username
$username = $_SESSION['username'];
while($rows=$result->fetch_assoc()) {
  if($rows['sponsor_username'] == $username) {
    $sponsor_name = $rows['associated_sponsor'];
  }
}

// Get query variables from POST/SESSION
$driver_id = $_POST['driver_id'];
$driving_behavior_id = $_POST['driving_behavior_id'];
$_SESSION['point_val'] = 0;

// Create query to see if driving behavior id exists
$driver_id_query = mysqli_query($conn, "SELECT * FROM drivers WHERE id='$driver_id' AND driver_associated_sponsor='$sponsor_name'");

// Get the new point value for the driver
while($rows=$driver_id_query->fetch_assoc()) {
    if(!($rows['driver_points'] == NULL)) {
        $_SESSION['point_val'] = $rows['driver_points'];
    }
}

$point_val = $_SESSION['point_val'] + $POST['points'];

$driver_id_query2 = mysqli_query($conn, "SELECT * FROM drivers WHERE id='$driver_id' AND driver_associated_sponsor='$sponsor_name'");

// Check for invald info
if(!($driver_id_query2->fetch_row())){
    echo '<script>alert("The Driver ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "assign__bonus_points.php"</script>';
} else{

    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE id=$driver_id";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $point_val);


    if ($stmt_drivers->execute()) {
        echo '<script>alert("Points sucessfully added!\n")</script>';
           echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/sponsorhomepage.php"</script>';
       }
       else{
           echo '<script>alert("Failed to add points...\n\nCheck your information and retry...")</script>';
           echo '<script>window.location.href = "assign_bonus_points.php"</script>';
       }
}
?>

</body>
</html>