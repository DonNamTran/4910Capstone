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
const colors = [
    "rgba(0,0,255,1.0)",
    "rgba(0,0,255,0.8)",
    "rgba(0,0,255,0.6)",
    "rgba(0,0,255,0.4)",
    "rgba(0,0,255,0.2)",
];

function makeChart(sales) {  
    var sponsorLabels = sales.map(function(d) {
      return d.Sponsor;
    });
    var salesData = sales.map(function(d) {
      return +d.Sales;
    });
    var categoryLabels = sales.map(function(d) {
      return d.Category;
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
            backgroundColor: colors,
            data: salesData
          }
        ]
      }
    });
  }
  
  // Request data using D3
d3.csv("/summaryAllSponsors.csv").then(makeChart);
</script>';
?>

</body>
</html>
