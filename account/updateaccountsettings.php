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
    $oldnotifications = intval($_SESSION['user_data'][$_SESSION['real_account_type']."_notifications"]);
    if(strcmp($_POST['notifications'], "Enabled") == 0) {
      $newnotifications = 1;
    } else {
      $newnotifications = 0;
    }
    if($oldnotifications != $newnotifications) {
      $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_notifications = $newnotifications WHERE ".$_SESSION['real_account_type']."_username = '{$_SESSION['username']}'";
      mysqli_query($connection, $queryOne);
      $_SESSION['errors']['user_info'] = "Information updated!";
    }
  }

  //Checks if the address was changed.
  if(isset($_POST['shipping']) && strcmp($_POST['shipping'], $_SESSION['user_data'][$_SESSION['real_account_type']."_address"]) != 0) {
    $oldaddress = $_SESSION['user_data'][$_SESSION['real_account_type']."_address"];
    $newaddress = $_POST['shipping'];
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_address = '$newaddress' WHERE ".$_SESSION['real_account_type']."_address = '$oldaddress' AND ".$_SESSION['real_account_type']."_username = '{$_SESSION['username']}';";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the birthday was changed.
  if(isset($_POST['birthday']) && strcmp($_POST['birthday'], $_SESSION['user_data'][$_SESSION['real_account_type']."_birthday"]) != 0) {
    $oldbirthday = $_SESSION['user_data'][$_SESSION['real_account_type']."_birthday"];
    $newbirthday = $_POST['birthday'];
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_birthday = '$newbirthday' WHERE ".$_SESSION['real_account_type']."_birthday = '$oldbirthday';";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the phone number was changed.
  if(isset($_POST['phone_number']) && strcmp($_POST['phone_number'], $_SESSION['user_data'][$_SESSION['real_account_type']."_phone_number"]) != 0) {
    $oldphonenumber = $_SESSION['user_data'][$_SESSION['real_account_type']."_phone_number"];
    $newphonenumber = $_POST['phone_number'];
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_phone_number = '$newphonenumber' WHERE ".$_SESSION['real_account_type']."_phone_number = '$oldphonenumber';";;
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the email was changed.
  if(isset($_POST['email']) && strcmp($_POST['email'], $_SESSION['user_data'][$_SESSION['real_account_type']."_email"]) != 0) {
    $result = mysqli_query($connection, "SELECT * FROM users");

    while($rows=$result->fetch_assoc()) {
      if($rows['username'] == $_SESSION['username']) {
        $account_id = $rows['id'];
      }
    }

    $oldemail = $_SESSION['user_data'][$_SESSION['real_account_type']."_email"];
    $newemail = $_POST['email'];
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_email = '$newemail' WHERE ".$_SESSION['real_account_type']."_email = '$oldemail';";
    $queryTwo = "UPDATE users SET user_email = '$newemail' WHERE user_email ='$oldemail'";

    $eventTime = new DateTime('now');
    $eventTime = $eventTime->format("Y-m-d H:i:s");
    $emailAuditQuery = "INSERT INTO audit_log_email_changes (audit_log_email_changes_old_email, audit_log_email_changes_new_email, audit_log_email_changes_date, audit_log_email_changes_account_id) VALUES (?, ?, ?, ?)";
    $stmt_emailAudit = $connection->prepare($emailAuditQuery);
    $stmt_emailAudit->bind_param("sssi", $oldemail, $newemail, $eventTime, $account_id);

    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $stmt_emailAudit->execute();
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the username was changed.
  if(isset($_POST['username']) && strcmp($_SESSION['username'], $_POST['username']) != 0) {
    $result = mysqli_query($connection, "SELECT * FROM users");

    while($rows=$result->fetch_assoc()) {
      if($rows['username'] == $_SESSION['username']) {
        $account_id = $rows['id'];
      }
    }

    $newusername = $_POST['username'];
    $oldusername = $_SESSION['username'];
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_username = '$newusername' WHERE ".$_SESSION['real_account_type']."_username = '$oldusername';";
    $queryTwo = "UPDATE users SET username = '$newusername' WHERE username ='$oldusername'";

    $eventTime = new DateTime('now');
    $eventTime = $eventTime->format("Y-m-d H:i:s");
    $usernameAuditQuery = "INSERT INTO audit_log_username_changes (audit_log_username_changes_old_username, audit_log_username_changes_new_username, audit_log_username_changes_date, audit_log_username_changes_account_id) VALUES (?, ?, ?, ?)";
    $stmt_usernameAudit = $connection->prepare($usernameAuditQuery);
    $stmt_usernameAudit->bind_param("sssi", $oldusername, $newusername, $eventTime, $account_id);

    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $stmt_usernameAudit->execute();
    $_SESSION['username'] = $newusername;
    $_SESSION['errors']['user_info'] = "Information updated!";
  }
  //Resets the session variable I have storing the user_data from a query.
  $queryString ="SELECT * FROM ".$_SESSION['real_account_type']."s WHERE ".$_SESSION['real_account_type']."_username = '".$_SESSION['username']."'";
  $result = mysqli_query($connection, $queryString);
  unset($_SESSION['user_data']);
  $_SESSION['user_data'] = mysqli_fetch_assoc($result);

  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profileuserinfo.php");
  exit();
?>