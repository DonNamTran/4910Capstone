<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$result = mysqli_query($connection, "SELECT * FROM sponsors");

// Get the sponsor id associated with the sponsor's username
$username = $_SESSION['username'];
while($rows=$result->fetch_assoc()) {
  if($rows['sponsor_username'] == $username) {
    $sponsor_name = $rows['associated_sponsor'];
  }
}

$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");
$username = $_SESSION['username'];

// Create query to get drivers points
$driver_query = mysqli_query($conn, "SELECT * FROM drivers");

// Get the new point value for the driver
while($rows=$driver_query->fetch_assoc()) {
    if($rows['driver_username'] == $username) {
        $driver_points = $rows['driver_points'];
        $driver_id = $rows['driver_id'];
        $driver_sponsor = $rows['driver_associated_sponsor'];
    }
}

$updated_points = $driver_points - $_POST['cart_price'];
$num_items = $_POST['cart_items_num'];
$itemInfo = $_POST['item_info'];
$reason = "{$username} checked out their cart";

    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_id=$driver_id";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $updated_points);

    $point_change = "-" . $_POST['cart_price'];
    $sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount) VALUES (?, ?, ?, ?, ?)";
    $stmt_point_history = $conn->prepare($sql_point_history);
    $stmt_point_history->bind_param("sssss", $regDate, $updated_points, $driver_id, $reason, $point_change);

    $sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
    $stmt_audit = $conn->prepare($sql_audit);
    $stmt_audit->bind_param("ssss", $username, $regDate, $reason, $point_change);

    $order_status = "Processing";
    $sql_order = "INSERT INTO orders (order_driver_id, order_associated_sponsor, order_status, order_date_ordered, order_total_cost) VALUES (?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("isssi", $driver_id, $sponsor_name, $order_status, $regDate, $point_change);

    if($stmt_order->execute()) {
        $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_driver_id='$driver_id' ORDER BY order_id DESC LIMIT 1");

        while($rows=$order_query->fetch_assoc()) {
            if($rows['order_driver_id'] == $driver_id) {
                $order_id = $rows['order_id'];
            }
        }

        for($i = 0; $i < count($itemInfo); $i++) {
         
            $itemInfo[$i] = str_replace('"', '', $itemInfo[$i]);
            $individualItemInfo = explode(",", $itemInfo[$i]);
  
            $item_name = $individualItemInfo[1];
            $artist_name = $individualItemInfo[2];
            $item_price = $individualItemInfo[3];
            $item_release_date = $individualItemInfo[4];
            $rating = $individualItemInfo[5];
            $item_type = $individualItemInfo[6];
  
            $item_image_url = str_replace('\\', '', $individualItemInfo[0]);

            $sql_order_contents = "INSERT INTO order_contents (order_id, order_contents_item_name, order_contents_item_cost, order_contents_item_image, order_contents_item_release_date, order_contents_item_rating, order_contents_item_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_order_contents = $conn->prepare($sql_order_contents);
            $stmt_order_contents->bind_param("isissss", $order_id, $item_name, $item_price, $item_image_url, $item_release_date, $rating, $item_type);
            $stmt_order_contents->execute();
        }

        
    } else {
        echo '<script>alert("Failed to purchase items...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }

    $sql_cart = "UPDATE cart SET cart_items=?, cart_point_total=0, cart_num_items=0 WHERE cart_driver_id=$driver_id";
    $cart_no_items = '';
    $stmt_cart = $conn->prepare($sql_cart);
    $stmt_cart->bind_param("s", $cart_no_items);

    //Increments the number of purchases by 1.
    /*$sql_update_purchase = "UPDATE catalog SET catalog_purchases = catalog_purchases + ? WHERE catalog_associated_sponsor=? AND catalog_item_name=?";
    $stmt_update_purchase = $conn->prepare($sql_update_purchase);
    $stmt_update_purchase->bind_param("iss", $num_items, $driver_sponsor, $_POST['current_item_name']);*/


    if ($stmt_drivers->execute() & $stmt_point_history->execute() && $stmt_audit->execute() && $stmt_cart->execute()) {
        echo '<script>alert("Cart checkout successful!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php"</script>';
    }
    else{
        echo '<script>alert("Failed to checkout cart...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }
?>

</body>
</html>