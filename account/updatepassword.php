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
  if(isset($_POST['newpassword']) && isset($_POST['confirm_password']) && isset($_POST['oldpassword'])) {
    $oldpassword = $_POST['oldpassword'];
    $passwordOne = $_POST['newpassword'];
    $passwordTwo = $_POST['confirm_password'];

    //Verifies they inputted the correct old password and if they inputted the new password in correctly twice.
    if(!password_verify($oldpassword, $_SESSION['user_data'][$_SESSION['account_type']."_password"])) {
        $_SESSION['errors']['user_info'] = "Your old password is incorrect!";
        goto redirect;
    } else if(strcmp($passwordOne, $passwordTwo) != 0) {
        $_SESSION['errors']['user_info'] = "Passwords do not match!";
        goto redirect;
    }

    //Updates the password in the database.
    $newpassword = password_hash($passwordOne, PASSWORD_DEFAULT);
    $query = "UPDATE ".$_SESSION['account_type']."s SET ".$_SESSION['account_type']."_password = '$newpassword' WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
    mysqli_query($connection, $query);
    $_SESSION['errors']['user_info'] = "Sucessfully updated password!";
  }

  //Resets the session variable I have storing the user_data from a query.
  $queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  $result = mysqli_query($connection, $queryString);
  unset($_SESSION['user_data']);
  $_SESSION['user_data'] = mysqli_fetch_assoc($result);
  redirect:
  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilepassword.php", true, 303);
  exit();

?>