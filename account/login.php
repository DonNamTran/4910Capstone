<?php include "../../inc/dbinfo.inc"; ?>


<html>

<head>

</head>

<title>Login Page</title>
<body>
<h1>Login!</h1>

<?php
        session_start();
        //var_dump($_SERVER['REQUEST METHOD']);
        /*
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo "testing";
                //header( "Location: {$_SERVER['REQUEST_URI']}", true, 303);
                //exit();
        } elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
                echo "hello";
                if(isset($_GET['name'])) {
                        echo $_GET['name'];
                }
        }
        */
        //$name = $_POST['name'];
        //$password = $_POST["password"];
        //echo "test", "<br>";
        //if(isset($name) && isset($password)) {
        //        echo "wow that's crazy", "<br>";
        // }

?>

<?php

        echo '<form action="loginvalidation.php" method="post">
                <label for="name">Username/Email:</label><br>
                <input type="text" name="name"><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password"><br>';

        if(isset($_SESSION['errors']['blank'])) {
                echo $_SESSION['errors']['blank'], "<br>";
                unset($_SESSION['errors']['blank']);
        }
        if(isset($_SESSION['errors']['login'])) {
                echo $_SESSION['errors']['login'], "<br>";
                unset($_SESSION['errors']['login']);
        }
        echo '<input type="submit"> <br>
                </form>';

?>
<!-- Clean up. -->


</body>
</html>
 
