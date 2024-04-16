<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  if(!$_SESSION['login'] || strcmp($_SESSION['account_type'], "administrator") != 0) {
    echo "Invalid page.<br>";
    echo "Redirecting.....";
    sleep(2);
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
    //unset($_SESSION['login']);
  }
?>
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

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #FF0000;
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

form {
  text-align: center;
  margin: 10px 20px;
}

input[type=text] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  align: center;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
  cursor: pointer;
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
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
} 

.div_before_table {
    overflow:hidden;
    overflow-y: scroll;
    overscroll-behavior: none;
    width: 1200px;
    height: 400px;
    margin-left: auto;
    margin-right: auto;
    border: 4px solid;
    border-color: #ff5e6c;
}

.container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40%; 
        }

table {
            margin: 0 auto; /* Center the table horizontally */
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            padding: 12px 20px;
        }
        /* Alternating row colors */
        tbody tr:nth-child(even) {
            background-color: #add8e6;
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
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
  position: absolute;
    top: 300px; left: 50px;
}
</style>
</head>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
  </div>
</div>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Generate</h1>
      <h1>Invoice</h1>
      <h1>For</h1>
      <h1>All</h1>
      <h1>Sponsors</h1>
      </div>
</div>

<body>

<div id="container">
<div id="div_before_table">
<table>
    <thead>
        <tr>
            <th>Driver ID</th>
            <th>Sponsor</th>
            <th>Date</th>
            <th>Item</th>
            <!--<th>Description</th> -->
            <th>Points</th>
            <th>Dollar Amount</th>
        </tr>
    </thead>
        
<?php 

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$orders = mysqli_query($connection, "SELECT * FROM orders WHERE order_status != 'Cancelled'");
$user = $_SESSION['username'];
$test = fopen("csvs/invoice_for_all_sponsors_for_$user.csv", 'w');

$header_array = array("Invoice For All Sponsors - {$user}");
fputcsv($test, $header_array);
fputcsv($test, array("Driver ID", "Sponsor", "Date", "Item", "Points", "Dollar Amount"));
$total = 0;
$totalFees = 0;
?>
<tbody>
<?php
while($order_info=$orders->fetch_assoc()) {
  $currentOrder = $order_info['order_id'];
  $queryString = "SELECT * FROM order_contents WHERE order_id=$currentOrder";
    $order_contents = mysqli_query($connection, $queryString);
    
    $currentSponsor = $order_info['order_associated_sponsor'];
    
    $sponsor_info = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$currentSponsor'");
    while($dollar2pt = $sponsor_info->fetch_assoc()){
      $ratio = $dollar2pt['organization_dollar2pt'];
    }
    
?>
    <tr>
        <td><?php echo $order_info['order_driver_id'];?></td>
        <td><?php echo $order_info['order_associated_sponsor'];?></td>
        <td><?php echo $order_info['order_date_ordered'];?></td>
        <td><?php while($items = $order_contents->fetch_assoc()){ ?>
        <?php echo $items['order_contents_item_name'] . " - " . $items['order_contents_item_type'] . " || ";?>
        <?php }?></td>
        <td><?php echo $order_info['order_total_cost']; 
        $total += $order_info['order_total_cost'];
        ?></td>
        <?php 
            $dollar_amount = $order_info['order_total_cost'] * $ratio;
            $totalFees += $dollar_amount * 0.01
        ?>  
        <td><?php echo $dollar_amount;?></td>
<?php 
$temp_array = array($order_info['order_driver_id'], $order_info['order_associated_sponsor'], $order_info['order_date_ordered'], $items['order_contents_item_name'] . " - " . $items['order_contents_item_type'] . " || ", $order_info['order_total_cost'], $dollar_amount);
//fputcsv($test, array("Driver ID", "Sponsor", "Date", "Item", "Points", "Dollar Amount"));
fputcsv($test, $temp_array);
}
?>
</tr>

</tbody>
</div>
</div>
</table>

<table>
  <thead>
    <tr>
      <th>Total</th>
      <th>Total Fees</th>
    </tr>
  </thead>
  <tbody>
    <td><?php echo $total . " Points";?></td>
    <td><?php echo "$" . $totalFees;?></td>
  </tbody>
</table>

<?php 
fputcsv($test, array("  "));
fputcsv($test, array("Total", "Total Fees"));


fputcsv($test, array($total, $totalFees));

fclose($test);
?>

<div id="hyperlink-wrapper">
<a id="hyperlink" href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/invoice_for_all_sponsors_for_$user.csv" ?>" download> Download csv... </a>
</div>

</body>