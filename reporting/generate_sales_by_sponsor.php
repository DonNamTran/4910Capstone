<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $sponsor = $_POST['sponsor'];
    $start_range = $_POST['start_date'];
    $end_range = $_POST['end_date'];
    
    $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost)*organization_dollar2pt AS total_sales FROM orders 
	JOIN order_contents 
		ON orders.order_id = order_contents.order_id
    JOIN organizations 
		ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor='$sponsor' AND order_contents_removed = 0
        GROUP BY order_associated_sponsor";
    $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
    $result = $total_sales->fetch_assoc();
    var_dump($result);

    //$stmt_total_sales = $connection->prepare($total_sponsor_sales_query);
    //$stmt_total_sales->bind_param("s", $sponsor);
    
?>