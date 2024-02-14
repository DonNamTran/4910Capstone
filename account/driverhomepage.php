<html>
<body>
    <?php
        session_start();
        if($_SESSION['login'] && strcmp($_SESSION['account_type'], "driver") == 0) {
            echo "<h1>Welcome Driver!</h1>";
            //unset($_SESSION['login']);
        } else {
            echo "Invalid page.<br>";
            echo "Redirecting.....";
            sleep(5);
            header( "Location: http://team05sif.cpsc4911.com/", true, 303);
            exit();
        }

        list($name, $password) = explode(':', $_COOKIE['remember_user']);
        echo "<script>console.log($name);console.log($password);</script>";
    ?>
</body>

</html>