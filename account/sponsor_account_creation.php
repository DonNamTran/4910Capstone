<?php include "../../../inc/dbinfo.inc"; ?>

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

<title>Sponsor Account Creation</title>
<body>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/">About</a>
  </div>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Sponsor</h1>
      <h1>Account</h1>
      <h1>Creation</h1>
    </div>
  </div>

<!-- Get User Input -->
<form action="sponsor_submit_account.php" method="POST">
  <label for="fname">First Name:</label><br>
  <input type="text" id="fname" name="fname" placeholder="Enter your first name..." required><br>

  <label for="lname">Last Name:</label><br>
  <input type="text" id="lname" name="lname" placeholder="Enter your last name..." required><br>

  <label for="username">User Name:</label><br>
  <input type="text" id="username" name="username" placeholder="Enter your username..." required><br>

  <label for="email">E-Mail Address:</label><br>
  <input type="text" id="email" name="email" placeholder="Enter your email address..." required><br>

  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" placeholder="Enter your password..." required><br>

  <button type="button" onclick="togglePasswordVisibility()">
    <span id="toggleLabel">Show Password</span>
  </button><br>

  <label for="phone">Phone Number:</label><br>
  <input type="text" id="phone" name="phone" placeholder="Enter your phone number..." required><br>

  <label for="birthday">Birthday (YYYY-MM-DD):</label><br>
  <input type="text" id="birthday" name="birthday" placeholder="Enter your birthday..." required><br>

<?php 
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  // Check whether account is admin viewing as sponsor or is an actual sponsor account
  if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $sponsor_name = $rows['sponsor_associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $sponsor_name = $rows['administrator_associated_sponsor'];
        }
    }
  }
?>

  <label for="associated_sponsor">Associated Sponsor:</label><br>
  <input type="text" id="associated_sponsor" name="associated_sponsor" value="<?php echo "$sponsor_name"?>" <?php if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) { echo "readonly"; }?>><br>

  <input type="submit" value="Submit"><br>
</form> 

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
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
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>