<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();

  if(!$_SESSION['login']) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  $target_dir = "/var/www/html/S24-Team05/images/profilepictures/";
  $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $filename = $_SESSION['user_data'][$_SESSION['account_type']."_username"]."_profile_picture.".$imageFileType;
  $target_file = $target_dir . $filename;
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profilepic"]["tmp_name"]);
    //Makes sure the file is an image.
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $_SESSION['errors']['user_info'] = "File uploaded was not an image!";
        goto redirect;
    }
    if($imageFileType !== "png") {
        $uploadOk = 0;
        $_SESSION['errors']['user_info'] = "File type not supported! Please upload a .png";
        goto redirect;
    }
    if($uploadOk == 1) {
        var_dump($target_file);
        var_dump($_FILES["profilepic"]["tmp_name"]);
        echo $imageFileType, "<br>";
        if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["profilepic"]["name"])). " has been uploaded.";
            $_SESSION['errors']['user_info'] = "File sucessfully uploaded!";
          } else {
            echo ($_FILES["profilepic"]["error"]);
            $_SESSION['errors']['user_info'] = "There was an error uploading your file!";
          }
    }
} else {
    header("Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
}
  redirect:
  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilechangepicture.php", true, 303);
  exit();

?>