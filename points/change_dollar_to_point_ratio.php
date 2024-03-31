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

form {
  text-align: center;
  margin: 20px 20px;
}

table {
  margin-left: auto;
  margin-right: auto;
}

input[type=text] {
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
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
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

<div class="navbar">
    <div class="menu">
        <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    </div>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Change</h1>
      <h1>Ratio</h1>
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

    $result2 = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username = '$sponsor_name'");
?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Your Organization</th>
        <th class="sticky">Dollar-to-Point Ratio</th>
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
        <td><?php echo $rows['organization_username'];?></td>
        <td><?php echo $rows['organization_dollar2pt'];?></td>
    </tr>
    <?php
        }
    ?>
</table>
</div>
<!-- Get User Input -->
<form action="submit_ratio.php" method="POST">
  <label for="point_ratio">Dollar-to-Point Ratio:</label><br>
  <input type="text" id="point_ratio" name="point_ratio" placeholder="Enter the new ratio for dollar-to-points you would like set for your organization..." required><br>

  <input type="submit" value="Submit"><br>
</form> 

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>