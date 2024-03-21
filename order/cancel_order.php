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

$order_status = "Cancelled";
$order_id = $_POST['order_id'];
$sql_orders = "UPDATE orders SET order_status=? WHERE order_id='$order_id'";
$stmt_orders = $connection->prepare($sql_orders);
$stmt_orders->bind_param("s", $order_status);

if ($stmt_orders->execute()) {
    echo '<script>alert("Order successfully cancelled!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/order/order_history.php"</script>';
}
?>