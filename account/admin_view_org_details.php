<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start(); ?>
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
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}
</style>
</head>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
  </div>
</div>

<body>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $org_id = $_POST['organization_id'];
    $org_name = $_POST['organization_name'];

    //$query = "SELECT * FROM {$account_type}s WHERE id=$account_id;";
    $result = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id=$org_id;");
    $query = mysqli_fetch_assoc($result);

?>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Edit</h1>
      <h1><?php echo $org_name?></h1>
   </div>
</div>

<?php

?>
<!-- Get User Input -->
<form action="admin_submit_organization_changes.php" method="POST">
  <!--<label for="new_org_name">Organization Name:</label><br>
  <input type="text" name="new_org_name" id="new_org_name" placeholder="Enter Organization Name..." value=<?php //echo $query['organization_username'];?>> <br>-->
  <label for="ratio">Organization Point Ratio:</label><br>
  <input type="text" name="ratio" id="ratio" placeholder="Enter new ratio..." value=<?php echo $query['organization_dollar2pt'];?>> <br>
  <input type="hidden" name="org_id" value="<?=$org_id?>">
  <input type="hidden" name="org_name" value="<?=$org_name?>">
  <input type="submit" value="Update Organization"> <br>
</form> 

<?php if($query['organization_archived'] == 0) { ?> 
    <form action="http://team05sif.cpsc4911.com/S24-Team05/account/admin_submit_archive_sponsor_company.php" method="post">
        <input type="hidden" name="organization_id" value="<?= $query['organization_id'] ?>">
        <input type="submit" class="remove" value="Archive Sponsor"/>
    </form>
<?php } else { ?>
    <form action="http://team05sif.cpsc4911.com/S24-Team05/account/admin_submit_unarchive_sponsor_company.php" method="post">
        <input type="hidden" name="organization_id" value="<?= $query['organization_id'] ?>">
        <input type="submit" class="remove" value="Unarchive Sponsor"/>
    </form>
<?php } ?>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>