<?php include "../inc/dbinfo.inc"; ?>

<html>

<head>
<style type="text/css">
table {
  margin-left: auto;
  margin-right: auto;
}
h1 {
  text-align: center;
}
tbody {}
td {
  background-color: powderblue;
  text-align: center;
}
th {
  background-color: cornflowerblue;
}
thead {}
tr {}
</style>
</head>

<title>About Page</title>
<body>
<h1>This is the about page for the driver incentive program!</h1>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <th style="width:100px">Team Number:</th>
    <th style="width:100px">Version Number:</th>
    <th style="width:150px">Release Date:</th>
    <th style="width:200px">Product Name:</th>
    <th style="width:300px">Product Description</th>
  </tr>

<?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $result = mysqli_query($connection, "SELECT * FROM about ORDER BY ID DESC LIMIT 1");
        $query_data = mysqli_fetch_row($result);

        echo "<tr style='height:250px'>";
        echo "<td>", $query_data[1], "</td>",
             "<td>", $query_data[2], "</td>",
             "<td>", $query_data[3], "</td>",
             "<td>", $query_data[4], "</td>",
             "<td>", $query_data[5], "</td>";
        echo "</tr>";
?>

</table>

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>
 
