<?php include "../../../inc/dbinfo.inc";



/*if(isset($_POST['remember'])){
        $cookie_name = "remember_user";
        $cookie_value = $name . ":" . $password;
        //seconds in a day * 30 days (sets remember cookie for 30 days)
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/');
}*/
?>
<html>
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
        $errors = [];
?>

<?php
        /*if(isset($_COOKIE['remember_user'])){
                list($name, $password) = explode(':', $_COOKIE['remember_user']);
                $result = mysqli_query($connection, "SELECT * FROM ".$_SESSION['account_type']."s WHERE username = '$name'");
                $resultE = mysqli_query($connection, "SELECT * FROM ".$_SESSION['account_type']."s WHERE email = '$name'");
                $query_data = mysqli_fetch_row($result);
                $query_dataE = mysqli_fetch_row($resultE);
                if(password_verify($password, $query_data[5]) || password_verify($password, $query_dataE[5])) {
                        $_SESSION['login'] = true;
                        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/".$_SESSION['account_type']."homepage.php");
                        exit();
                } else {
                        $_SESSION['errors']['login'] = "Incorrect username or password!";
                        goto error_redirect;
                }
        }*/
        
        //Checks if the username exists in the database.
        if (strcmp($query_data[1], "") != 0) {
                $_SESSION['account_type'] = $query_data[2];
                
                $query = "SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '$name'";
                $result = mysqli_query($connection, $query);
                //$resultE = mysqli_query($connection, "SELECT * FROM $query_data[2]s WHERE email = '$name'");
                $query_data = mysqli_fetch_row($result);
                //$query_dataE = mysqli_fetch_row($resultE);
                
                if(password_verify($password, $query_data[5]) /*|| password_verify($password, $query_dataE[5])*/) {
                        $_SESSION['login'] = true;
                        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/".$_SESSION['account_type']."homepage.php");
                        exit();
                } else {
                        $_SESSION['errors']['login'] = "Incorrect username or password!";
                        unset($_SESSION['account_type']);
                        goto error_redirect;
                }

        } else {
                $_SESSION['errors']['login'] = "Incorrect username or password!";
        }
        error_redirect:
        header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php", true, 303);
        exit();
?>

<script>
console.log($name);
console.log($password);
console.log($cookie_name);
console.log($cookie_value);
</script>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>