<?php include "../../../inc/dbinfo.inc"; ?>


<html>
<body>

<?php
        session_start();
        $name = $_POST["name"];
        $password = $_POST["password"];
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$name'");
        $query_data = mysqli_fetch_row($result);
        $errors = [];
?>

<?php
        if(strcmp($name, "") == 0 || strcmp($password, "") == 0) {
                $_SESSION['errors']['blank'] = "Username or password field is empty!";
                goto error_redirect;
        }
        if (strcmp($query_data[1], "") != 0 && !isset($_SESSION['errors']['password']) && !isset($_SESSION['errors']['name'])) {

                $result = mysqli_query($connection, "SELECT * FROM $query_data[2]s");
                $query_data = mysqli_fetch_row($result);
                
                if(strcmp($query_data[5], $password) == 0) {
                        $_SESSION['login'] = true;
                        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php");
                        exit();
                } else {
                        $_SESSION['errors']['login'] = "Incorrect username or password!";
                        goto error_redirect;
                }

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