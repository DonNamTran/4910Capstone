<?php include "../../inc/dbinfo.inc"; ?>

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
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // this hashes the password. use password_verify to compare hash to password
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$addr = $_POST['address'];
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format('Y-m-d');
$sponsor = 'none';
$archived = 0;
$user_type = 'driver';

// Create queries to check for taken account info (username, email, etc)
$username_query = "SELECT * FROM users"; // this isnt finished

// Check for taken account info
if ($result = mysqli_query($conn, $username_query)){
    echo '<script>alert("This username is already taken!\n\nPlease choose a different username and retry...")</script>';
    echo '<script>window.location.href = "accountcreation.php"</script>';
}
// Create new entry in database with user data if nothing taken
else{
    // Prepare query on drivers table
    $sql_drivers = "INSERT INTO drivers (first_name, last_name, username, email, password, birthday, phone_number, address, register_date, associated_sponsor, archived) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("ssssssssssi", $fname, $lname, $username, $email, $password, $birthday, $phone, $addr, $regDate, $sponsor, $archived);

    // Prepare query on users table
    $sql_users = "INSERT INTO users (username, user_type) VALUES (?, ?)";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("ss", $username, $user_type);

    if ($stmt_drivers->execute() && $stmt_users->execute()) {
        echo '<script>alert("Your account is ready!\n\nRedirecting to login page...")</script>';
        echo '<script>window.location.href = "login.php"</script>';
    }
    else{
        echo '<script>alert("Failed to create account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "accountcreation.php"</script>';
    }
}
?>

</body>
</html>