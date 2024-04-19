<?php
  session_start();
  if(!$_SESSION['login']) {
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

<?php
  if(strcmp($_SESSION['account_type'], "administrator") == 0) {
    ?>
    <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/admin_about_page.php">About</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Audit Log 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/audit/logins.php">Login Attempts - All </a>
        <a href="/S24-Team05/audit/logins_all_drivers.php">Login Attempts - Drivers</a>
        <a href="/S24-Team05/audit/logins_all_sponsors.php">Login Attempts - Sponsors</a>
        <a href="/S24-Team05/audit/logins_all_admins.php">Login Attempts - Admins</a>
        <a href="/S24-Team05/audit/password_changes.php">Password Changes - All</a>
        <a href="/S24-Team05/audit/password_changes_all_drivers.php">Password Changes - Drivers</a>
        <a href="/S24-Team05/audit/password_changes_all_sponsors.php">Password Changes - Sponsors</a>
        <a href="/S24-Team05/audit/password_changes_all_admins.php">Password Changes - Admins</a>
        <a href="/S24-Team05/audit/point_changes_all_drivers.php">Point Changes - All Drivers</a>
        <a href="/S24-Team05/audit/email_changes.php">Email Changes - All</a>
        <a href="/S24-Team05/audit/username_changes.php">Username Changes - All</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Create Account
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/driver_account_creation.php">Driver Account</a>
        <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
        <a href="/S24-Team05/account/admin_account_creation.php">Admin Account</a>
      </div>
    </div>
    <div class="menu">
      <a href="/S24-Team05/account/admin_view_organizations.php">View Organizations</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Archive Accounts
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_archive_account.php">Archive Account</a>
        <a href="/S24-Team05/account/admin_unarchive_account.php">Unarchive Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Edit User
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_edit_driver_account.php">Edit Driver</a>
        <a href="/S24-Team05/account/admin_edit_sponsor_account.php">Edit Sponsor</a>
        <a href="/S24-Team05/account/admin_edit_admin_account.php">Edit Admin</a>
      </div>
    </div>
    </div>
    <?php
  }
  else if(strcmp($_SESSION['account_type'], "sponsor") == 0) {
    ?>
    <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/sponsor_about_page.php">About</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Catalog 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/sponsor_catalog_home.php">View Catalog</a>
        <a href="/S24-Team05/catalog/sponsor_add_to_catalog.php">Add to Catalog</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Audit Log 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/audit/logins_drivers_under_sponsor.php">Login Attempts</a>
        <a href="/S24-Team05/audit/password_changes_under_sponsor.php">Password Changes</a>
        <a href="/S24-Team05/audit/point_changes_under_sponsor.php">Point Changes</a>
        <a href="/S24-Team05/audit/email_changes_under_sponsor.php">Email Changes</a>
        <a href="/S24-Team05/audit/username_changes_under_sponsor.php">Username Changes</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Set Driving Behavior
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/points/set_behavior.php">Add New Behavior</a>
        <a href="/S24-Team05/points/remove_behavior.php">Remove Behavior</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Create Account
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Archive Accounts
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_archive_account.php">Archive Account</a>
        <a href="/S24-Team05/account/sponsor_unarchive_account.php">Unarchive Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Edit User
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_edit_driver_account.php">Edit Driver</a>
        <a href="/S24-Team05/account/sponsor_edit_sponsor_account.php">Edit Sponsor</a>
      </div>
    </div>
    </div>
    <?php
  } else {
    ?>
    <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/driver_about_page.php">About</a>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a> <?php } ?>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/order/order_history.php">Orders</a> <?php } ?>
    </div>
    </div>
    <?php
  }
?>


<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['real_account_type']."_first_name"], "</h1>";?>
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['real_account_type']."_last_name"], "</h1>";?>
   </div>
</div>

<div class ="wrapper">
  <div class="options">
    <ul>
      <li><a href="/S24-Team05/account/profileuserinfo.php">User Info</a></li>
      <li><a href="/S24-Team05/account/profilepassword.php">Change Password</a></li>
      <li><a class="active" href="/S24-Team05/account/profilechangepicture.php">Change Profile Picture</a></li>
      <?php if(strcmp($_SESSION['account_type'], 'driver') == 0) { echo '<li><a href="/S24-Team05/account/profileorderinfo.php">Orders</a></li>'; }?>
      <li><a href="/S24-Team05/account/profilearchiveaccount.php">Archive Account</a></li>
      <?php 
        if(strcmp($_SESSION['real_account_type'], 'administrator') == 0 || strcmp($_SESSION['real_account_type'], 'sponsor') == 0) {
            echo '<li><a href="/S24-Team05/view/change_view.php">Change View</a></li>'; 
        }
        ?>
    </ul>
  </div>
  <div class ="content">
    <?php
        //var_dump(file_exists("/var/www/html/S24-Team05/images/profilepictures/dntran_profile_picture.png"));
        if(file_exists("/var/www/html/S24-Team05/images/profilepictures/".$_SESSION['username']."_profile_picture.png")) {
            $picturepath = "/S24-Team05/images/profilepictures/".$_SESSION['username']."_profile_picture.png";
        } else {
            $picturepath = "/S24-Team05/images/Logo.png";
        }
    ?>
    <img src =<?php echo $picturepath?>>
    <form action="updateprofilepicture.php" method="post" enctype="multipart/form-data">
      <input type="file" name="profilepic" id="profilepic"><br>
      <input type="submit" value="Upload Image" name="submit">
    </form>

    <?php if(isset($_SESSION['errors']['user_info'])) {echo $_SESSION['errors']['user_info']; unset($_SESSION['errors']['user_info']);}?>
  </div>
</div>

<?php
    //var_dump($_SESSION['login']);
    //echo "<p>", "Username: ", $_SESSION['user_data'][$_SESSION['account_type']."_username"], "</p>", "<br>";
    //echo "<p>", "Email: ", $_SESSION['user_data'][$_SESSION['account_type']."_email"], "</p>", "<br>";
    //echo "<p>","Birthday: ", $_SESSION['user_data'][$_SESSION['account_type']."_birthday"], "</p>","<br>";
    //echo "<p>","Phone-Number: ", $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"], "</p>","<br>";
  ?> 

</body>

</html>