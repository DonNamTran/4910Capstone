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
      <h1>Point</h1>
      <h1>History</h1>
   </div>
</div>

<?php
    session_start();
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $result = mysqli_query($connection, "SELECT * FROM drivers");
    
    // Get the driver id
    $account_type = $_SESSION['account_type'];
    if($account_type == 'driver') {
      $username = $_SESSION['username'];
      while($rows=$result->fetch_assoc()) {
        if($rows['driver_username'] == $username) {
          $driver_id = $rows['id'];
        }
      }
    } else {
      $driver_id = $_POST['driver_id'];
    }

    $result2 = mysqli_query($connection, "SELECT * FROM drivers WHERE id = '$driver_id' AND driver_archived=0");

    // Check for invald info
    if(!($row=$result2->fetch_row())){
      echo '<script>alert("The Driver ID is invalid. \n\nPlease enter in a new ID number and retry...")</script>';
      echo '<script>window.location.href = "admin_enter_driver_id.php"</script>';
    }

    $result3 = mysqli_query($connection, "SELECT * FROM point_history WHERE point_history_driver_id = '$driver_id' ORDER BY point_history_date DESC;");
?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Total Points</th>
        <th class="sticky">Date</th>
        <th class="sticky">Reason for Change</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result3->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['point_history_points'];?></td>
        <td><?php echo $rows['point_history_date'];?></td>
        <td><?php echo $rows['point_history_reason'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>
</body>
</html>