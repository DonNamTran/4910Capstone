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

<title>Login Page</title>
<body>
<div id="flex-container-header">
    <div id="flex-container-child">
      <h1>Login!</h1>
    </div>
  </div>

<?php

        echo '<form action="loginvalidation.php" method="post">
                <label for="name">Username/Email:</label><br>
                <input type="text" name="name" placeholder="Enter username or email..." required><br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="passwordField" placeholder="Enter password..." required><br>
                <button type="button" onclick="togglePasswordVisibility()">
                    <span id="toggleLabel">Show Password</span>
                </button><br>
                <label for="remember">Remember Me</label><br>
                <input type="checkbox" name="remember"><br>';

        if(isset($_SESSION['errors']['blank'])) {
                echo "<p>", $_SESSION['errors']['blank'], "</p>", "<br>";
                unset($_SESSION['errors']['blank']);
        }
        if(isset($_SESSION['errors']['login'])) {
                echo "<p>", $_SESSION['errors']['login'], "</p>", "<br>";
                unset($_SESSION['errors']['login']);
        }
        echo '<input type="submit"> <br>
              </form>';
?>

<!-- Hyperlink to account creation php -->
<div id="hyperlink-wrapper">
  <a id="hyperlink" href="accountcreation.php">Sign Up</a>
</div>

<div id="hyperlink-wrapper">
  <a id="hyperlink" href="passwordreset.php">Forgot Password?</a>
</div>

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("passwordField");
    var toggleLabel = document.getElementById("toggleLabel");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleLabel.textContent = "Hide Password";
    } else {
        passwordField.type = "password";
        toggleLabel.textContent = "Show Password";
    }
}
</script>

<!-- Clean up. -->

</body>
</html>