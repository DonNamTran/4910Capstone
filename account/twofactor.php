<?php include "../../../inc/dbinfo.inc"; require "../sendnotification.php";?>


<!DOCTYPE html>
<body>

<?php
        session_start();
        $name = $_POST["name"];
        $password = $_POST["password"];
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $queryString = "SELECT * FROM users WHERE username = '$name' OR user_email = '$name'";
        $result = mysqli_query($connection, $queryString);
        $query_data = mysqli_fetch_row($result);
?>

<form method="POST">
    <input type="hidden" name="code" value="<?php echo $_POST['code'];?>">
</form>

<?php
        
        //Query to gather driver info to send the email to.
        $sql_user_info = "SELECT * FROM users WHERE username='" . $_POST["name"] . "';";
        $user_info = (mysqli_query($connection, $sql_user_info))->fetch_assoc();
        $user_email = $user_info['user_email'];
        $user_name = $user_info['username'];

        //Checks if the username exists in the database.
        if (strcmp($query_data[1], "") != 0) {
            
            $message_body = "Hello {$user_name},".PHP_EOL."Enter this code in the login page to authenticate your identity:".PHP_EOL. $_POST['code'];
            send_email('Two-Factor Authentication Code', $message_body, $user_email);
            $redirectpage = "submit_two_factor.php";
            echo '<script>alert("A code was sent to the email registered with your account.")</script>';
            echo '<script>window.location.href = "',$redirectpage,'"</script>';
        } else {
            $_SESSION['errors']['login'] = "Incorrect username or password!";
        }
        error_redirect:
        header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php", true, 303);
        exit();
?>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>