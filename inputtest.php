<?php include "../inc/dbinfo.inc"; ?>


<html>

<head>

</head>

<title>testing</title>
<body>
<h1>don doing some testing</h1>
<?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);
?>


<form action = "testscript.php" method="post">
        <label for="name">Username/Email:</label><br>
        <input type="text" name="name"><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password"><br>
<input type="submit">
</form>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>



</body>
</html>
 
