<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);


  if(!$_SESSION['login']) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }


  if(isset($_POST['notifications'])) {
    $oldnotifications = intval($_SESSION['user_data'][$_SESSION['account_type']."_notifications"]);
    if(strcmp($_POST['notifications'], "Enabled") == 0) {
      $newnotifications = 1;
    } else {
      $newnotifications = 0;
    }
    if($oldnotifications != $newnotifications) {
      $queryOne = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_notifications = $newnotifications WHERE ".$_SESSION['account_type']."_notifications = $oldnotifications;";
      mysqli_query($connection, $queryOne);
      $_SESSION['errors']['user_info'] = "Information updated!";
    }
  }

  //Checks if the birthday was changed.
  if(isset($_POST['birthday']) && strcmp($_POST['birthday'], $_SESSION['user_data'][$_SESSION['account_type']."_birthday"]) != 0) {
    $oldbirthday = $_SESSION['user_data'][$_SESSION['account_type']."_birthday"];
    $newbirthday = $_POST['birthday'];
    $queryOne = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_birthday = '$newbirthday' WHERE ".$_SESSION['account_type']."_birthday = '$oldbirthday';";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the phone number was changed.
  if(isset($_POST['phone_number']) && strcmp($_POST['phone_number'], $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"]) != 0) {
    $oldphonenumber = $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"];
    $newphonenumber = $_POST['phone_number'];
    $queryOne = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_phone_number = '$newphonenumber' WHERE ".$_SESSION['account_type']."_phone_number = '$oldphonenumber';";;
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the email was changed.
  if(isset($_POST['email']) && strcmp($_POST['email'], $_SESSION['user_data'][$_SESSION['account_type']."_email"]) != 0) {
    $oldemail = $_SESSION['user_data'][$_SESSION['account_type']."_email"];
    $newemail = $_POST['email'];
    $queryOne = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_email = '$newemail' WHERE ".$_SESSION['account_type']."_email = '$oldemail';";
    $queryTwo = "UPDATE users SET user_email = '$newemail' WHERE user_email ='$oldemail'";
    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the username was changed.
  if(isset($_POST['username']) && strcmp($_SESSION['username'], $_POST['username']) != 0) {
    $newusername = $_POST['username'];
    $oldusername = $_SESSION['username'];
    $queryOne = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_username = '$newusername' WHERE ".$_SESSION['account_type']."_username = '$oldusername';";
    $queryTwo = "UPDATE users SET username = '$newusername' WHERE username ='$oldusername'";
    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $_SESSION['username'] = $newusername;
    $_SESSION['errors']['user_info'] = "Information updated!";
  }
  //Resets the session variable I have storing the user_data from a query.
  $queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  $result = mysqli_query($connection, $queryString);
  unset($_SESSION['user_data']);
  $_SESSION['user_data'] = mysqli_fetch_assoc($result);

  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profileuserinfo.php");
  exit();
?>