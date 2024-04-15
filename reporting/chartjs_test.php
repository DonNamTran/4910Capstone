<!DOCTYPE html>
<html>
<?php
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js"></script>';
?>
<body>

<?php
echo 
'<canvas id="chart"></canvas>

<script>
function makeChart(sales) {  
    var sponsorLabels = sales.map(function(d) {
      return d.Name;
    });
    var salesData = sales.map(function(d) {
      return +d.Weeks;
    });
  
    var chart = new Chart(\'chart\', {
      type: "pie",
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        }
      },
      data: {
        labels: sponsorLabels,
        datasets: [
          {
            data: salesData
          }
        ]
      }
    });
  }
  
  // Request data using D3
d3.csv("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2814973/atp_wta.csv").then(makeChart);
</script>';
?>

</body>
</html>
