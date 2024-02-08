<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d7;
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

h2 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 2em;*/
  font-size: 2vmax;
}

h3 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #ff5e6c
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-description {
  display: flex;
  margin-top: 1%;
  margin-left: 2%;
  margin-right: 2%;
  background-color: #FEF9E6;
}

#flex-container-team-info {
  display: flex;
  /*height: 15%;*/
  width: auto;
  background-color: #FEF9E6;
  margin-top: 1%;
  margin-left: 5%;
  margin-right: 2%;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
}

#flex-container-child-2 {
  display: flex;
  flex: 1;
  justify-content: left;
  align-items: center;
  padding: 3.5%;
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

<title>Account Creation</title>
<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Account</h1>
      <h1> </h1>
      <h1>Creation</h1>
    </div>
  </div>

<!-- Get User Input -->
<form action="submit_account.php" method="POST">
  <label for="fname">First Name:</label><br>
  <input type="text" id="fname" name="fname" placeholder="Enter your first name..."><br>

  <label for="lname">Last Name:</label><br>
  <input type="text" id="lname" name="lname" placeholder="Enter your last name..."><br>

  <label for="username">User Name:</label><br>
  <input type="text" id="username" name="username" placeholder="Enter your username..."><br>

  <label for="email">E-Mail Address:</label><br>
  <input type="text" id="email" name="email" placeholder="Enter your email address..."><br>

  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" placeholder="Enter your password..."><br>

  <label for="phone">Phone Number:</label><br>
  <input type="text" id="phone" name="phone" placeholder="Enter your phone number..."><br>

  <label for="birthday">Birthday (YYYY-MM-DD):</label><br>
  <input type="text" id="birthday" name="birthday" placeholder="Enter your birthday..."><br>

  <label for="address">Address:</label><br>
  <input type="text" id="address" name="address" placeholder="Enter your home address..."><br><br>

  <input type="submit" value="Submit"><br>
</form> 

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>
 
