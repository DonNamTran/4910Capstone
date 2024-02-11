<?php include "../../../inc/dbinfo.inc"; ?>


<html>
<body>

<?php
session_start();

// Check if the remember user cookie is set
if (isset($_COOKIE['remember_user'])) {
    // If set, extract the saved username and hashed password from the cookie
    list($savedUsername, $savedPassword) = explode(':', $_COOKIE['remember_user']);

    // Connect to the database
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    // Perform a query to fetch user data by username
    $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$savedUsername'");
    $query_data = mysqli_fetch_row($result);

    // Check if the username exists in the database
    if ($query_data) {
        // Check if the saved hashed password matches the hashed password in the database
        if (password_verify($savedPassword, $query_data[1])) {
            // Passwords match, set session login and redirect to homepage
            $_SESSION['login'] = true;
            header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php");
            exit();
        } else {
            // Incorrect password, redirect to login page with an error message
            $_SESSION['errors']['login'] = "Incorrect username or password!";
            header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php");
            exit();
        }
    } else {
        // Username not found, redirect to login page with an error message
        $_SESSION['errors']['login'] = "Incorrect username or password!";
        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php");
        exit();
    }

    // Clean up
    mysqli_free_result($result);
    mysqli_close($connection);
} else {
    // Remember user cookie not set, continue with regular login validation logic
    $name = $_POST["name"];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($_POST['remember'])) {
        $cookie_name = "remember_user";
        $cookie_value = $name . ":" . $password;
        // Set remember user cookie for 30 days
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }

    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$name'");
    $query_data = mysqli_fetch_row($result);

    if ($query_data) {
        $result = mysqli_query($connection, "SELECT * FROM $query_data[2]s WHERE username = '$name'");
        $resultE = mysqli_query($connection, "SELECT * FROM $query_data[2]s WHERE email = '$name'");
        $query_data = mysqli_fetch_row($result);
        $query_dataE = mysqli_fetch_row($resultE);
        if (strcmp($query_data[5], $password) == 0 || strcmp($query_dataE[5], $password) == 0) {
            $_SESSION['login'] = true;
            header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php");
            exit();
        } else {
            $_SESSION['errors']['login'] = "Incorrect username or password!";
            header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php");
            exit();
        }
    } else {
        $_SESSION['errors']['login'] = "Incorrect username or password!";
        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php");
        exit();
    }

    mysqli_free_result($result);
    mysqli_close($connection);
}
?>

</body>
</html>