<?php include "../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d1;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}

h1 {
  text-align: left;
  margin-left: 5%;
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6;
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #FF0000;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
  margin-left: 2%
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
}
</style>
</head>

<title>Password Reset</title>

<body>

<body>
<div id="flex-container-header">
    <div id="flex-container-child">
      <h1>Enter your email for password reset</h1>
    </div>
  </div>

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
