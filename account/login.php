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
  color: #FEF9E6
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

input[type=text] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=password] {
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
</style>
</head>

<title>Login Page</title>
<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Login!</h1>
    </div>
  </div>




<?php

        echo '<form action="loginvalidation.php" method="post">
                <label for="name">Username/Email:</label><br>
                <input type="text" name="name" placeholder="Enter username or email..." required><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" placeholder="Enter password..." required><br>';

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
 
