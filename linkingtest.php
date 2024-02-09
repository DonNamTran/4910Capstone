<?php include "../inc/dbinfo.inc"; ?>

<html>

<head>

<title>Password Reset</title>

<body>

<h1>Enter the email you would like for a reset link to be sent.</h1>

<?php
//$to	 = 'madduxrhodes@gmail.com';
//$subject = 'Password Reset';
//$message = 'this gonna be the link you click and type in the new thing';
//$message = wordwrap($message, 70, "\r\n");
//mail($to, $subject, $message);
?>

<?php
	$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	$database = mysqli_select_db($connection, DB_DATABASE);
	$result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESK LIMIT 1");
	$query_data = mysqli_fetch_row($result);
?>




</body>
