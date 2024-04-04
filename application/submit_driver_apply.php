<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

// Get query variables from POST
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$appDateTime = new DateTime('now');
$appDate = $appDateTime->format('Y-m-d');
$user_type = 'driver';

// Function to check for valid dates
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Check for invalid info
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<script>alert("Invalid email address format!\n\nPlease enter in a valid email address and retry...")</script>';
    echo '<script>window.location.href = "driver_apply.php"</script>';
} else {
    /*TO DO: Prepare query on application table
    $sql_apply = "INSERT INTO applications (driver_first_name, driver_last_name, driver_email, driver_phone_number, driver_app_date, driver_applied_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_apply = $conn->prepare($sql_apply);
    $stmt_apply->bind_param("ssssss", $fname, $lname, $email, $password, $phone, $appDate, $appSponsor);

    // Prepare query on users table
    $sql_users = "INSERT INTO users (username, user_type, user_email, user_view_type) VALUES (?, ?, ?, ?)";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("ssss", $username, $user_type, $email, $user_view_type);

    if ($stmt_drivers->execute() && $stmt_users->execute()) {
        echo '<script>alert("Your account is ready!\n\nRedirecting to login page...")</script>';
        echo '<script>window.location.href = "login.php"</script>';
    }
    else{
        echo '<script>alert("Failed to create account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "driver_account_creation.php"</script>';
    }
    */
}
?>

</body>
</html>