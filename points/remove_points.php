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
  /*padding: 1.5%;*/
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

table {
  margin-left: auto;
  margin-right: auto;
}

td {
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 1px solid;
}

tr:nth-child(even) {
  background-color: #effad9;
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
}

.div_before_table {
    overflow:hidden;
    overflow-y: scroll;
    overscroll-behavior: none;
    height: 500px;
    width: 1200px;
    margin-top: 0.5%;
    margin-bottom: 2.5%;
    margin-left: auto;
    margin-right: auto;
    border: 4px solid;
    border-color: #ff5e6c;
}

.sticky {
  position: sticky;
  top: 0;
}

th {
  background-color: #ff5e6c;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 2px solid;
}
</style>
</head>
<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Add</h1>
      <h1>Points</h1>
      <h1>To</h1>
      <h1>Driver</h1>
   </div>
</div>

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

    $result2 = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_associated_sponsor = '$sponsor_name'");
?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Driver ID</th>
        <th class="sticky">First Name</th>
        <th class="sticky">Last Name</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result2->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['driver_id'];?></td>
        <td><?php echo $rows['driver_first_name'];?></td>
        <td><?php echo $rows['driver_last_name'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>

<?php

    // Check whether account is admin viewing as sponsor or is an actual sponsor account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      $result = mysqli_query($connection, "SELECT * FROM sponsors");

      // Get the sponsor id associated with the sponsor's username
      $username = $_SESSION['username'];
      while($rows=$result->fetch_assoc()) {
          if($rows['sponsor_username'] == $username) {
              $sponsor_name = $rows['associated_sponsor'];
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

    $result2 = mysqli_query($connection, "SELECT * FROM driving_behavior WHERE driving_behavior_associated_sponsor = '$sponsor_name' AND driving_behavior_archived=0 AND driving_behavior_point_val<0");
?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Driving Behavior ID</th>
        <th class="sticky">Description</th>
        <th class="sticky">Associated Point Value</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result2->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['driving_behavior_id'];?></td>
        <td><?php echo $rows['driving_behavior_desc'];?></td>
        <td><?php echo $rows['driving_behavior_point_val'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>

<!-- Get User Input -->
<form action="submit_remove_points.php" method="POST">
  <label for="driver_id">Driver ID:</label><br>
  <input type="text" id="driver_id" name="driver_id" placeholder="Enter in the associated ID number of driver you'd like give points." required><br>

  <label for="driving_behavior_id">Driving Behavior ID Number:</label><br>
  <input type="text" id="driving_behavior_id" name="driving_behavior_id" placeholder="Enter in the associated ID number of the action your driver has done." required><br>

  <input type="submit" value="Submit"><br>
</form> 

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>