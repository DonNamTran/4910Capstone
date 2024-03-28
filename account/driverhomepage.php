<?php include "../../../inc/dbinfo.inc"; ?>

<?php
        session_start();
        if(!$_SESSION['login'] && strcmp($_SESSION['account_type'], "driver") != 0) {
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
  margin: 20px 20px;
}

input[type=text], input[type=password] {
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
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/">About</a>
    <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a>
    <a href="/S24-Team05/order/order_history.php">Orders</a>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Switch Sponsor
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if (mysqli_connect_errno()) {  
            echo "Database connection failed.";  
        } 
        
        $username = $_SESSION['username'];
        $driver_id = mysqli_query($connection, "SELECT driver_id FROM drivers WHERE driver_username='$username' AND driver_archived=0");
        $driver_id = ($driver_id->fetch_assoc());
        var_dump($driver_id);

        echo("before assoc spons query");
        $assoc_spons_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc WHERE driver_id=$driver_id");

        echo("Before while loop");
        while($row = $assoc_spons_query->fetch_assoc()){
          $sponsor_id = $row['assoc_sponsor_id'];
          
          echo("Before spons name query");
          $sponsor_name = mysqli_query($connection, "SELECT organization_username FROM organizations WHERE organization_id=$sponsor_id");
          $sponsor_name = $sponsor_name->fetch_assoc();

          echo("Before echo");
          echo("<a href='/S24-Team05/account/switch_sponsor.php'>$sponsor_name</a>");
          echo("After echo");
        }
      ?>
    </div>
  </div>
</div>
<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Welcome</h1>
      <h1>Driver!</h1>
   </div>
</div>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_ways_to_gain_points.php">
  <input type="submit" class="link" value="See how you can gain points" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_ways_to_lose_points.php">
  <input type="submit" class="link" value="See how you can lose points" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_point_status.php">
  <input type="submit" class="link" value="Review Point Status" />
</form>

<form action="http://team05sif.cpsc4911.com/S24-Team05/points/point_history.php">
  <input type="submit" class="link" value="View Point History" />
</form>

</body>

</html>