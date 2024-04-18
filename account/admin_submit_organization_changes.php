<?php include "../../../inc/dbinfo.inc"; ?>
<html>
<body>
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
$org_name = $_POST['new_org_name'];
$org_ratio = $_POST['ratio'];

$org_details_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id=$org_id");
$org_details = $org_details_query->fetch_assoc();

  if(isset($_POST['org_name'])) {
    $oldname = $org_details['organization_username'];
    $duplicate_check = "SELECT 1 FROM organizations WHERE organization_username=?";
    $stmt_dupe = $connection->prepare($duplicate_check);
    $stmt_dupe->bind_param("s", $org_name);
    $stmt_dupe->execute();
    $result = $stmt_dupe->get_result();
    //var_dump($org_name);
    if($result->fetch_assoc()) {
      echo '<script>alert("Error, duplicate organization name entered, please try again!")</script>';
      echo '<script>window.location.href = "admin_view_organizations.php"</script>';
    }
    //$queryOne = "UPDATE ".$account_type."s SET ".$account_type."_notifications = $newnotifications WHERE ".$account_type."_id = $account_id;";
    //$sql_update_organizations = "UPDATE";
    //mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  /*
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
  */

  //Resets the session variable I have storing the user_data from a query.
  //$queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  //$result = mysqli_query($connection, $queryString);
  //unset($_SESSION['user_data']);
  //$_SESSION['user_data'] = mysqli_fetch_assoc($result);

  //if($account_type == "administrator") {
    //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_admin_account.php");
  //} else {
    //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_".$account_type."_account.php");
 // }
  //exit()
?>
</body>
</html>