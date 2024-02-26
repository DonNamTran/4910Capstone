<?php include "../../../inc/dbinfo.inc"; ?>
<?php
        session_start();
        if(!$_SESSION['login'] != 0) {
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

.point_info {
  font-size: 16px;
  color: black;
  font-family: monospace;
  margin: 0;
  position: absolute; 
  top: 0px; 
  right: 5px;
}
</style>
</head>
<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
  </div>
</div>

<body>

<div class="point_info">
    <body>
    Your Points: 
    <?php 
        if(strcmp($_SESSION['account_type'], "driver") != 0) {
            echo "Unavailable";
        }else{
            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
            $database = mysqli_select_db($connection, DB_DATABASE);
            
            $username = $_SESSION['username'];
            
            $result2 = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username' AND driver_archived=0");
            
            while($info=$result2->fetch_assoc()) {
                echo $info['driver_points'];
            }
            
            
        }
    ?><br>
    Dollar->Point: 
    <?php 
        //get sponsor name
        $currSponsor = $_SESSION['user_data'][$_SESSION['account_type']."_associated_sponsor"];
        $username = $_SESSION['user_data'][$_SESSION['account_type']."_username"];
        //var_dump($currSponsor);
        //make new connection
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        
        $result2 = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username = '$currSponsor'");
        
        while($rows=$result2->fetch_assoc())
        {
            echo "$" . $rows['organization_dollar2pt'] . ":1";
        }
       
    ?>
    </body>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Catalog</h1>
   </div>
</div>

</body>

</html>