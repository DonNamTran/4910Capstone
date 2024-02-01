<?php include "../inc/dbinfo.inc"; ?>

<html>
<title>About Page</title>
<body>
<h1>This is the about page for the driver incentive program!</h1>

<?php
	$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	$database = mysqli_select_db($connection, DB_DATABASE);
	echo "created connection and selected database!";	
?>

</body>
</html>
