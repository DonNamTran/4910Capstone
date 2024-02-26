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
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
      $_SESSION['errors']['user_info'] = "File is too large! Only files 1mb and below are supported.";
      $uploadOk = 0;
    }
    if($imageFileType !== "png" && $imageFileType !== "jpg" && $imageFileType != "jpeg") {
        $uploadOk = 0;
        $_SESSION['errors']['user_info'] = "File type not supported! Please upload a .png, .jpg, or .jpeg!";
        goto redirect;
    }
    var_dump("test");
    if($uploadOk == 1) {
      $imagick = new Imagick($_FILES["profilepic"]["tmp_name"]);
      $imagick->scaleImage(200, 200);
      $imagick->writeImage($target_file);
      $_SESSION['errors']['user_info'] = "Image sucessfully uploaded!";
    }
} else {
    header("Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
}
  redirect:
  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilechangepicture.php", true, 303);
  exit();

?>