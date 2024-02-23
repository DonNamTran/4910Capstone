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

<title>Edit Driving Behavior</title>
<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Edit</h1>
      <h1>Driving</h1>
      <h1>Behavior</h1>
    </div>
  </div>

<!-- Get User Input -->
<form action="submit_set_behavior.php" method="POST">
  <label for="driving_behavior">New Driving Behavior:</label><br>
  <input type="text" id="driving_behavior" name="driving_behavior" placeholder="Ex. Driver goes over the speed limit." required><br>

  <label for="point_val">Associated Point Value:</label><br>
  <input type="text" id="point_val" name="point_val" placeholder="Ex. -15" required><br>

  <input type="submit" value="Submit"><br>
</form> 


<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>