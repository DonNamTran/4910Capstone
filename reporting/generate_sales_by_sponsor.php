<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $sponsor = $_POST['sponsor'];
    $start_range = $_POST['start_date'];
    $end_range = $_POST['end_date'];

    $end_range_format = new DateTime($end_range);;
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");;

    $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost)*organization_dollar2pt AS total_sales FROM orders 
	JOIN order_contents 
		ON orders.order_id = order_contents.order_id
    JOIN organizations 
		ON orders.order_associated_sponsor=organizations.organization_username 
            WHERE order_associated_sponsor='$sponsor' AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
        GROUP BY order_associated_sponsor";
    $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
    $result = $total_sales->fetch_assoc();
    $total_sales =  number_format(  $result['total_sales'], 2);

    $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost) * organization_dollar2pt AS total_sales FROM orders 
	JOIN order_contents 
		ON orders.order_id = order_contents.order_id
    JOIN organizations 
		ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor='Subway' 
            AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
        GROUP BY order_contents_item_type"
    $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);
    while($row=$total_by_item->fetch_assoc()) {
        $sales_by_item =  number_format($row['total_sales'], 2);
        echo "$row['order_contents_item_type']s have generated $$sales_by_item between $strang_range and $end_range for $sponsor <br>"
    }

    echo "$sponsor has generated $$total_sales between $start_range and $end_range";
    //var_dump($result);

    //$stmt_total_sales = $connection->prepare($total_sponsor_sales_query);
    //$stmt_total_sales->bind_param("s", $sponsor);
    
?>