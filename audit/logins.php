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
    height: 400px;
    margin-top: 2.5%;
    margin-bottom: 2.5%;
    margin-left: 5%;
    margin-right: 5%;
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
      <h1>Audit</h1>
      <h1>Log: </h1>
      <h1>Login</h1>
      <h1>Attempts</h1>
   </div>
</div>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $result = mysqli_query($connection, "SELECT * FROM audit_log_login ORDER BY audit_log_login_date DESC");
?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Event User</th>
        <th class="sticky">Event Time</th>
        <th class="sticky">Event Outcome</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['audit_log_login_username'];?></td>
        <td><?php echo $rows['audit_log_login_date'];?></td>
        <td><?php echo $rows['audit_log_login_s_or_f'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>
</body>
</html>