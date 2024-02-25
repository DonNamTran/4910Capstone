<?php
  session_start();
  if(!$_SESSION['login'] && strcmp($_SESSION['account_type'], "administrator") != 0) {
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
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 150px;
  background-color: #ff5e6c;
}

li a {
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
}

li a.active {
  background-color: #fff5d1;

}

li a:hover:not(.active) {
  background-color: #fff5d1;
}

.wrapper{
  display: flex;
  position: relative;
}

.wrapper .options{
  position: fixed;
  width: 150px;
  height: 100%;
  background: #ff5e6c;

}

.wrapper .content{
  width: 100%;
  margin-top: 1%;
  margin-left: 15%;
}

p {
  color: green;
  font-size: 30px;
  margin-left: 40%;
}

</style>
</head>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/">About</a>
  </div>
</div>


<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['account_type']."_first_name"], "</h1>";?>
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['account_type']."_last_name"], "</h1>";?>
   </div>
</div>

<div class ="wrapper">
  <div class="options">
    <ul>
      <li><a class="active" href="/S24-Team05/account/profilepage.php">User Info</a></li>
      <li><a href="#">Order History</a></li>
      <li><a href="#">Notifications</a></li>
      <li><a href="#">Archive Account</a></li>

    </ul>
  </div>
  <div class ="content">
    <img src ="/S24-Team05/images/Logo.png">
    <form action="updateaccountsettings.php" method="post">
      <label for="username">Username:</label><br>
      <input type="text" name="username" id="username" placeholder="Enter username..." value=<?php echo $_SESSION['user_data'][$_SESSION['account_type']."_username"];?>> <br>
      <label for="email">Email:</label><br>
      <input type="text" name="email" id="email" placeholder="Enter email..." value=<?php echo $_SESSION['user_data'][$_SESSION['account_type']."_email"];?>><br>
      <label for="Birthday">Birthday:</label><br>
      <input type="text" name="birthday" id="birthday" placeholder="Enter birthday..." value=<?php echo $_SESSION['user_data'][$_SESSION['account_type']."_birthday"];?>><br>
      <label for="username">Phone Number:</label><br>
      <input type="text" name="phone_number" id="phone_number" placeholder="Enter phone number..." value=<?php echo $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"];?>><br>
      <input type="submit" value="Update User Info"> <br>
    </form>
    <?php if(isset($_SESSION['errors']['user_info'])) {echo $_SESSION['errors']['user_info']; unset($_SESSION['errors']['user_info']);}?>
  </div>
</div>

<?php
    var_dump($_SESSION['login']);
    //echo "<p>", "Username: ", $_SESSION['user_data'][$_SESSION['account_type']."_username"], "</p>", "<br>";
    //echo "<p>", "Email: ", $_SESSION['user_data'][$_SESSION['account_type']."_email"], "</p>", "<br>";
    //echo "<p>","Birthday: ", $_SESSION['user_data'][$_SESSION['account_type']."_birthday"], "</p>","<br>";
    //echo "<p>","Phone-Number: ", $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"], "</p>","<br>";
  ?> 

</body>

</html>