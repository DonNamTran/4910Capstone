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

// Execute query on drivers table
$sql_drivers = "INSERT INTO drivers (first_name, last_name, username, email, password, birthday, phone_number, address, register_date, associated_sponsor, archived) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_drivers = $conn->prepare($sql_drivers);
$stmt_drivers->bind_param("ssssssssssi", $fname, $lname, $username, $email, $password, $birthday, $phone, $addr, $regDate, $sponsor, $archived);
if ($stmt_drivers->execute()) {  
    echo "Record successfully added to drivers db!";  
}
else{
    echo "Account was not created...";
}

// Execute query on users table
$sql_users = "INSERT INTO users (username, user_type) VALUES (?, ?)";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param("ss", $username, $user_type);
if ($stmt_users->execute()) {  
    echo "Record successfully added to users db!";  
}
else{
    echo "Account was not created...";
}
?>

</body>
</html>