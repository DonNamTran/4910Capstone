<?php include "../inc/dbinfo.inc"; ?>


<html>

<head>

</head>

<title>testing</title>
<body>
<h1>don doing some testing</h1>

<?php
        echo $_SERVER['REQUEST METHOD'];
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
        //$name = $_POST['name'];
        //$password = $_POST["password"];
        //echo "test", "<br>";
        //if(isset($name) && isset($password)) {
        //        echo "wow that's crazy", "<br>";
        // }

?>

<form method="post">
        <label for="name">Username/Email:</label><br>
        <input type="text" name="name"><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password"><br>
        <input type="submit">
</form>
<!-- Clean up. -->


</body>
</html>
 
