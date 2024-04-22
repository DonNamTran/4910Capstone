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

        function generateRandomCode() {
            // Define the characters to be used for the alphanumeric code
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            // Get the length of the character set
            $characters_length = strlen($characters);
            
            // Initialize the code variable
            $code = '';
            
            // Generate a random character 6 times and append it to the code
            for ($i = 0; $i < 6; $i++) {
                $random_index = mt_rand(0, $characters_length - 1);
                $code .= $characters[$random_index];
            }
            
            return $code;
        }
?>

<?php
        
        //Query to gather driver info to send the email to.
        $sql_user_info = "SELECT * FROM users WHERE username='" . $_POST["name"] . "';";
        $user_info = (mysqli_query($connection, $sql_user_info))->fetch_assoc();
        $user_email = $user_info['user_email'];
        $user_name = $user_info['username'];

        //Checks if the username exists in the database.
        if (strcmp($query_data[1], "") != 0) {
            $message_body = "Hello {$user_name},".PHP_EOL."Enter this code in the login page:".PHP_EOL. generateRandomCode();
            send_email('Sponsor Removed From Account', $message_body, $driver_email);
            $redirectpage = "admin_edit_driver_account.php";
            echo '<script>alert("Succesfully removed sponsor company from driver!")</script>';
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