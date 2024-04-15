<!DOCTYPE html>
<html>
<?php
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>';
?>
<body>

<?php
echo 
'<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script>
const xValues = ["Amazon", "Subway", "Walmart", "Target", "USA Truckers"];
const yValues = [40572, 27819, 35019, 24229, 15178];
const barColors = ["yellow", "green","blue","red","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Sales by Sponsor: February 2024"
    }
  }
});
</script>';
?>

</body>
</html>
