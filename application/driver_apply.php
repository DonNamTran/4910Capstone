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

select {
  width: 60%;
  height: 3%;
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

textarea {
  width: 60%;
  height: 30%;
  padding: 12px 20px;
  margin: 8px 0;
  font-family: Arial;
  box-sizing: border-box;
  resize: none;
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

<title>Driver Sponsor Application</title>
<body>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/">About</a>
  </div>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Driver</h1>
      <h1>Sponsor</h1>
      <h1>Application</h1>
    </div>
  </div>

<!-- Get User Input -->
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  $query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_archived=0");
?>
<form action="submit_driver_apply.php" method="POST">

  <label for="listsponsors">Sponsor you are applying to:</label><br>
  <select name="listsponsors" id="listsponsors">
    <?php
      while($rows=$query->fetch_assoc()) {
        echo "<option>" . $rows['organization_username'] . "</option>";
      }
    ?>
  </select><br>

  <label for="comments">Comments:</label><br>
  <textarea id="comments" name="comments" placeholder="Anything else we should know or other comments..."></textarea>

  <input type="submit" value="Submit"><br>
</form> 

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>
 
