<html>
<body>
    <?php
        session_start();
        if($_SESSION['login']) {
            echo "<h1>Welcome Driver!</h1>";
            //unset($_SESSION['login']);
        } else {
            echo "Invalid page.";
        }
    ?>
</body>
</html>