<?php include "../inc/dbinfo.inc"; ?>


<html>
<body>


<?php
        $name = $_POST["name"];
        $password = $_POST["password"];
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM users WHERE username = '$name'");
        $query_data = mysqli_fetch_row($result);

        // echo $query_data[2], "<br>";
?>

<?php
        if(strcmp($query_data[1], "") == 0) {
                echo "No username detected. Please try again!", "<br>";
        } else {
                $result = mysqli_query($connection, "SELECT * FROM $query_data[2]s");
                $query_data = mysqli_fetch_row($result);
                echo $query_data[5];
        }
?>
<?php //echo "Welcome ", $name; ?><br>
<?php //echo "Your email address is: $password"; ?>


<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>