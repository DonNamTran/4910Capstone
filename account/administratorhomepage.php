<html>
<body>
    <?php
        session_start();
        if($_SESSION['login'] && strcmp($_SESSION['account_type'], "administrator") == 0) {
            echo "<h1>Welcome Admin!</h1>";
            //unset($_SESSION['login']);
        } else {
            echo "Invalid page.<br>";
            echo "Redirecting.....";
            sleep(5);
            header( "Location: http://team05sif.cpsc4911.com/", true, 303);
            exit();
        }
    ?>
</body>
</html>