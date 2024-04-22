<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  error_reporting(E_ALL);
  ini_set('display_errors',1);
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

  $user_id = $_SESSION['user_id'];
  $new_notifications = $_POST['notifications'];
  $new_birthday = $_POST['birthday'];
  $new_phone = $_POST['phone_number'];
  $new_email = $_POST['email'];
  $new_username = $_POST['username'];
 
  if(isset($_POST['shipping'])) {
    $new_shipping = $_POST['shipping'];
  }
  //Validates email and birthday
  function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

  if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Invalid email address format!\n\nPlease enter in a valid email address and retry...")</script>';
    echo '<script>window.location.href = "profileuserinfo.php"</script>';
    goto exit_redirect;
  }
  if(validateDate($new_birthday) == false) {
    echo '<script>alert("Invalid birthdate entered!\n\nPlease enter in a valid birthdate and retry...")</script>';
    echo '<script>window.location.href = "profileuserinfo.php"</script>';
    goto exit_redirect;
  }
  $account_type = $_SESSION['real_account_type'];

  $result = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id=$user_id"));
  $old_username = $result['username'];
  $old_email = $result['user_email'];

  $account_results = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM {$account_type}s WHERE {$account_type}_username='$old_username'"));
  $account_id = $account_results["{$account_type}_id"];
  $old_phone = $account_results["{$account_type}_phone_number"];

  if($old_phone !== $new_phone) {
    $check_dupe_number = "SELECT 1 FROM {$account_type}s WHERE {$account_type}_phone_number=?";
    $sql_number = $connection->prepare($check_dupe_number);
    $stmt_number->bind_param("s", $new_phone);
    $stmt_number->execute();
    $number_result = $stmt_number->get_result();

    if($number_result->fetch_assoc()) {
      echo '<script>alert("This phone number is already in use!\n\nPlease choose a different number and retry...")</script>';
      echo '<script>window.location.href = "profileuserinfo.php"</script>';
      goto exit_redirect;
    } 
  }

  //Verifies non-duplicate emails and usernames were entered.
  if($old_email !== $new_email) {
    $check_dupe_email = "SELECT 1 FROM users WHERE user_email=?";
    $stmt_email = $connection->prepare($check_dupe_email);
    $stmt_email->bind_param("s", $new_email);
    $stmt_email->execute();
    $email_result = $stmt_email->get_result();

    if($email_result->fetch_assoc()) {
      echo '<script>alert("This email is already in use!\n\nPlease choose a different email and retry...")</script>';
      echo '<script>window.location.href = "profileuserinfo.php"</script>';
      goto exit_redirect;
    } else {
      $eventTime = new DateTime('now');
      $eventTime = $eventTime->format("Y-m-d H:i:s");
      $emailAuditQuery = "INSERT INTO audit_log_email_changes (audit_log_email_changes_old_email, audit_log_email_changes_new_email, audit_log_email_changes_date, audit_log_email_changes_account_id) VALUES (?, ?, ?, ?)";
      $stmt_emailAudit = $connection->prepare($emailAuditQuery);
      $stmt_emailAudit->bind_param("sssi", $old_email, $new_email, $eventTime, $user_id);
      $stmt_emailAudit->execute();
      
    }
  }
  
  if($old_username !== $new_username) {
    $check_dupe_username = "SELECT 1 FROM users WHERE username=?";
    $stmt_username = $connection->prepare($check_dupe_username);
    $stmt_username->bind_param("s", $new_username);
    $stmt_username->execute();
    $username_result = $stmt_username->get_result();

    if($username_result->fetch_assoc()) {
      echo '<script>alert("This username is already in use!\n\nPlease choose a different username and retry...")</script>';
      echo '<script>window.location.href = "profileuserinfo.php"</script>';
      goto exit_redirect;
    } else {
      $eventTime = new DateTime('now');
      $eventTime = $eventTime->format("Y-m-d H:i:s");
      $usernameAuditQuery = "INSERT INTO audit_log_username_changes (audit_log_username_changes_old_username, audit_log_username_changes_new_username, audit_log_username_changes_date, audit_log_username_changes_account_id) VALUES (?, ?, ?, ?)";
      $stmt_usernameAudit = $connection->prepare($usernameAuditQuery);
      $stmt_usernameAudit->bind_param("sssi", $old_username, $new_username, $eventTime, $user_id);
      $stmt_usernameAudit->execute();
    }
  }

  $sql_notifications = "UPDATE {$account_type}s SET {$account_type}_notifications=? WHERE {$account_type}_id=?";
  $sql_birthday = "UPDATE {$account_type}s SET {$account_type}_birthday=? WHERE {$account_type}_id=?";
  $sql_phone = "UPDATE {$account_type}s SET {$account_type}_phone_number=? WHERE {$account_type}_id=?";
  $sql_email_users = "UPDATE users SET user_email=? WHERE id=?";
  $sql_username_users = "UPDATE users SET username=? WHERE id=?";
  $sql_email_account = "UPDATE {$account_type}s SET {$account_type}_email=? WHERE {$account_type}_id=?";
  $sql_username_account = "UPDATE {$account_type}s SET {$account_type}_username=? WHERE {$account_type}_id=?";
  
  $stmt_notifications = $connection->prepare($sql_notifications);
  $stmt_birthday = $connection->prepare($sql_birthday);
  $stmt_phone = $connection->prepare($sql_phone);
  $stmt_email_users = $connection->prepare($sql_email_users);
  $stmt_username_users = $connection->prepare($sql_username_users);
  $stmt_email_account = $connection->prepare($sql_email_account);
  $stmt_username_account = $connection->prepare($sql_username_account);

  $stmt_notifications->bind_param("ii", $new_notifications, $account_id);
  $stmt_birthday->bind_param("si", $new_birthday, $account_id);
  $stmt_phone->bind_param("si", $new_phone, $account_id);
  $stmt_email_users->bind_param("si", $new_email, $user_id);
  $stmt_username_users->bind_param("si", $new_username, $user_id);
  $stmt_email_account->bind_param("si", $new_email, $account_id);
  $stmt_username_account->bind_param("si", $new_username, $account_id);

  if($stmt_notifications->execute() && $stmt_birthday->execute() && 
  $stmt_phone->execute() && $stmt_email_users->execute() && 
  $stmt_username_users->execute() && $stmt_email_account->execute() && $stmt_username_account->execute()) {
    echo '<script>alert("Account settings successfully updated!")</script>';
    echo '<script>window.location.href = "profileuserinfo.php"</script>';
  }

  /*
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
    $queryOne = "UPDATE ".$_SESSION['real_account_type']."s 
    SET ".$_SESSION['real_account_type']."_address=?
    WHERE ".$_SESSION['real_account_type']."_address=? AND ".$_SESSION['real_account_type']."_username=?;";
    $stmt_addr = $connection->prepare($queryOne);
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
  */
  //Resets the session variable I have storing the user_data from a query.
  $queryString ="SELECT * FROM ".$_SESSION['real_account_type']."s WHERE ".$_SESSION['real_account_type']."_username = '".$_SESSION['username']."'";
  $result = mysqli_query($connection, $queryString);
  unset($_SESSION['user_data']);
  $_SESSION['user_data'] = mysqli_fetch_assoc($result);
  exit_redirect:
  //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profileuserinfo.php");
  exit();
?>