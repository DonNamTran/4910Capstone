<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $sponsor = $_POST['sponsor'];

    //Formats the dates so they don't cause errors when naming the CSV file.
    $start_range = $_POST['start_date'];
    $start_range = (new DateTime($start_range))->format("Y-m-d");
    $end_range = $_POST['end_date'];
    
    //Adds 23:59:59 to the end range to make it include all orders on that day.
    $end_range_format = new DateTime($end_range);
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");
    
    $end_range = (new DateTime($end_range))->format("Y-m-d");

    //Opens the CSV file for writing, overwrites any existing one. 
    $test = fopen("csvs/{$start_range}_{$end_range}_summary_for_$sponsor.csv", 'w');
    fputcsv($test, array("Sponsor", "Category", "Sales"));
    if($sponsor === "All Sponsors") {

        //Grabs the total sales from ALL SPONSORS.
        $total_sponsor_sales_query = "SELECT *, SUM(order_contents_item_cost)*organization_dollar2pt AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username 
                WHERE order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'";
        $total_sales = mysqli_query($connection, $total_sponsor_sales_query);
        $result = $total_sales->fetch_assoc();
        $total_sales =  number_format($result['total_sales'], 2);

        //Grabs the total sales from ALL SPONSORS for each category of item.
        $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost) * organization_dollar2pt AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor LIKE '%' 
                AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY organization_username, order_contents_item_type";
        $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);

        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            
            //Stores the company, item_type, and sales by item in an array to be written to the CSV.
            $temp_array = array($row['organization_username'], $row['order_contents_item_type'], $sales_by_item);
            fputcsv($test, $temp_array);
            echo "{$row['organization_username']}: {$row['order_contents_item_type']}s have generated $$sales_by_item.<br>";
        }
        //fputcsv($test, array("All Sponsors", $total_sales));
        echo "All sponsors have generated $$total_sales. <br>";
    } else {
        //Grabs the total sales from the specified sponsor.
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
    
        //Grabs the total sales by item from the specified sponsor.
        $total_sponsor_sales_by_item_query = "SELECT *, SUM(order_contents_item_cost) * organization_dollar2pt AS total_sales FROM orders 
        JOIN order_contents 
            ON orders.order_id = order_contents.order_id
        JOIN organizations 
            ON orders.order_associated_sponsor=organizations.organization_username WHERE order_associated_sponsor='$sponsor' 
                AND order_contents_removed = 0 AND order_date_ordered BETWEEN '$start_range' AND '$end_range_format'
            GROUP BY order_contents_item_type";
        $total_by_item = mysqli_query($connection, $total_sponsor_sales_by_item_query);
        while($row=$total_by_item->fetch_assoc()) {
            $sales_by_item =  number_format($row['total_sales'], 2);
            $temp_array = array($row['organization_username'], $row['order_contents_item_type'], $sales_by_item);
            fputcsv($test, $temp_array);
            echo "{$row['organization_username']}: {$row['order_contents_item_type']}s have generated $$sales_by_item.<br>";
        }
        //fputcsv($test, array($sponsor, $total_sales));
        echo "$sponsor has generated $$total_sales. <br>";
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_summary_for_$sponsor.csv" ?>" download> Download csv... </a>