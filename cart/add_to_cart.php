<?php include "../../../inc/dbinfo.inc"; ?>
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

h2 {
    font-family: "Monaco", monospace;
    text-align: left;
    /*font-size: 1.25em;*/
    font-size: 1.25vmax;
    color: #0A1247;
    margin-left: 10%;
}

p {
  font-family: "Monaco", monospace;
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
  margin-left: 10%
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

.grid-container {
  display: grid;
  grid-template-columns: 30% 48%;
  gap: 30px;
  background-color: #fff5d1;
  padding: 10px;
}

.grid-container > div {
  background-color: #fff5d1/*FEF9E6*/;
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

form {
  text-align: left;
  margin: 20px 75px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 30%;
  padding: 12px 20px;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
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
</style>
</head>
<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/">About</a>
    <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a>
  </div>
</div>
<body>

<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);

    session_start();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $image_data = $_POST['item_image'];
    $item_name = $_POST['item_name'];
    $item_artist = $_POST['item_artist'];
    $item_price = $_POST['item_price'];
    $item_release_date = $_POST['item_release_date'];
    $advisory_rating = $_POST['advisory_rating'];
    $item_type = $_POST['item_type'];


    // Get driver username and ID
    $username = $_SESSION['username'];
    $driverIDResult = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username'");
    $driverID = $driverIDResult->fetch_assoc();
    $driverID = $driverID['driver_id'];

    // Store item info in a JSON object
    $itemInfo = array($image_data, $item_name, $item_artist, $item_price, $item_release_date, $advisory_rating, $item_type);
    $itemInfoJSON = json_encode($itemInfo);

    // Check if driver cart already exists
    $cartQuery = mysqli_query($connection, "SELECT * FROM cart WHERE cart_driver_id='$driverID'");
    
    // Add item info to cart
    if($cartQuery->num_rows == 0){
      $sql_itemInfo = "INSERT INTO cart (cart_driver_id, cart_driver_username, cart_items, cart_point_total) VALUES (?, ?, ?, ?)";
      $stmt_itemInfo = $connection->prepare($sql_itemInfo);
      $stmt_itemInfo->bind_param("issi", $driverID, $username, $itemInfoJSON, $item_price);
      $stmt_itemInfo->execute();
    }
    else{
      while($rows = $cartQuery->fetch_assoc()){
        $cartItems = $rows['cart_items'] . $itemInfoJSON;
        $cartTotal = (int)$rows['cart_point_total'] + (int)$itemPrice;

        $sql_itemInfo = "UPDATE cart SET cart_items=?, cart_point_total=? WHERE cart_driver_id=$driverID";
        $stmt_itemInfo = $connection->prepare($sql_itemInfo);
        $stmt_itemInfo->bind_param("si", $cartItems, $cartTotal);
        $stmt_itemInfo->execute();
      }
    }
    
    echo '<script>alert("Item successfully added to cart!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php"</script>';
?>

</body>
</html>