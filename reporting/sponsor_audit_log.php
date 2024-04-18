<?php
  session_start();
  if(!$_SESSION['login'] || strcmp($_SESSION['account_type'], "sponsor") != 0) {
    echo "Invalid page.<br>";
    echo "Redirecting.....";
    sleep(2);
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
    //unset($_SESSION['login']);
  }
?>

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
  margin: 10px 20px;
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
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  align: center;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
  cursor: pointer;
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

.navbar {
  overflow: hidden;
  background-color: #FEF9E6;
  font-family: "Monaco", monospace;
  margin-bottom: -2.5%;
}

.navbar a {
  float: left;
  font-size: 16px;
  font-family: "Monaco", monospace;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #fff5d1;
;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.menu { 
  float: none;
  color: black;
  font-size: 16px;
  margin: 0;
  text-decoration: none;
  display: block;
  text-align: left;
} 
.menu a{ 
  float: left;
  overflow: hidden;
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
} 
</style>
</head>

<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Audit</h1>
      <h1>Log</h1>
      <h1>Reports</h1>
   </div>
</div>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $username = $_SESSION['username'];
    $sponsor_name_query = mysqli_query($connection, "SELECT * from sponsors WHERE sponsor_username='$username'");
    while($rows=$sponsor_name_query->fetch_assoc()) {
      $sponsor_name = $rows['sponsor_associated_sponsor'];
    }

    $organization_id_query = mysqli_query($connection, "SELECT * from organizations WHERE organization_username='$sponsor_name'");
    while($rows=$organization_id_query->fetch_assoc()) {
      $sponsor_id = $rows['organization_id'];
    }

    $driver_sponsor_assoc = mysqli_query($connection, "SELECT * from driver_sponsor_assoc WHERE assoc_sponsor_id=$sponsor_id"); 
?>
<form action="http://team05sif.cpsc4911.com/S24-Team05/reporting/sponsor_generate_audit_log.php" method="POST">
  <label for="driver">Select Driver:</label><br>
        <select name="driver" id="driver">
            <option value="All Drivers">All Drivers</option>
          <?php  while($rows=$driver_sponsor_assoc->fetch_assoc()) { ?>
            <option value="<?= $rows['driver_username'] ?>"> <?=$rows['driver_username']?></option>;
          <?php } ?>   
        </select><br>

  <label for="audit_type">Select Audit Log Category:</label><br>
        <select name="audit_type" id="audit_type">
            <option value="Driver Applications">Driver Applications</option>
            <option value="Point Changes">Point Changes</option>
            <option value="Password Changes">Password Changes</option>
            <option value="Login Attempts">Login Attempts</option>  
        </select><br>
  <label for="start_date">Starting Date:</label><br>
  <input type="text" name="start_date" class="datepicker"><br>
  <label for="end_date">Ending Date:</label><br>
  <input type="text" name="end_date" class="datepicker"><br>
  <input type="submit" value="Generate Report"><br>
</form>
</body>
</html>