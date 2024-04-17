<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  /*
  if(!$_SESSION['login'] || !isset($_SESSION['user_edited']['query'])) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  */
$org_id = $_POST['org_id'];
$org_name = $_POST['org_name'];


  if(isset($_POST['username'])) {
    $oldnotifications = intval($user_info[$account_type."_notifications"]);
    if(strcmp($_POST['notifications'], "Enabled") == 0) {
      $newnotifications = 1;
    } else {
      $newnotifications = 0;
    }
    if($oldnotifications != $newnotifications) {
      $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_notifications = $newnotifications WHERE ".$account_type."_id = $account_id;";
      mysqli_query($connection, $queryOne);
      $_SESSION['errors']['user_info'] = "Information updated!";
    }
  }

  if(isset($_POST['ratio'])) {
    $oldnotifications = intval($user_info[$account_type."_notifications"]);
    if(strcmp($_POST['notifications'], "Enabled") == 0) {
      $newnotifications = 1;
    } else {
      $newnotifications = 0;
    }
    if($oldnotifications != $newnotifications) {
      $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_notifications = $newnotifications WHERE ".$account_type."_id = $account_id;";
      mysqli_query($connection, $queryOne);
      $_SESSION['errors']['user_info'] = "Information updated!";
    }
  }

  //Resets the session variable I have storing the user_data from a query.
  //$queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  //$result = mysqli_query($connection, $queryString);
  //unset($_SESSION['user_data']);
  //$_SESSION['user_data'] = mysqli_fetch_assoc($result);

  if($account_type == "administrator") {
    header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_admin_account.php");
  } else {
    header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_".$account_type."_account.php");
  }
  exit()
?>