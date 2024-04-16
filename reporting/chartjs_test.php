<!DOCTYPE html>
<html>
<?php
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js"></script>';
?>
<body>

<?php
echo 
'<canvas id="album_chart" style="width:100%;max-width:600px"></canvas>
<canvas id="movie_chart" style="width:100%;max-width:600px"></canvas>

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
    var categoryLabels = sales.map(function(d) {
      return d.Category;
    });
    var salesData = sales.map(function(d) {
      return +d.Sales;
    });
  
    var albumChart = new Chart(\'album_chart\', {
      type: "bar",
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Album Sales by Sponsor"
        },
        scales: {
          y: {
            title: {
              display: true,
              text: \'Sales in Dollars\'
            }
          },
          x: {
            title: {
              display: true,
              text: \'Sponsor\'
            }
          }
        }
      },
      data: {
        labels: sponsorLabels,
        datasets: [
          {
            label: [categoryLabels],
            backgroundColor: colors,
            data: salesData
          }
        ]
      }
    });

    var movieChart = new Chart(\'movie_chart\', {
      type: "bar",
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Movie Sales by Sponsor"
        },
        scales: {
          y: {
            title: {
              display: true,
              text: \'Sales in Dollars\'
            }
          },
          x: {
            title: {
              display: true,
              text: \'Sponsor\'
            }
          }
        }
      },
      data: {
        labels: sponsorLabels,
        datasets: [
          {
            label: [categoryLabels],
            backgroundColor: colors,
            data: salesData
          }
        ]
      }
    });
  }
  
  // Request data using D3
d3.csv("summaryAllSponsors.csv").then(makeChart);
</script>';
?>

</body>
</html>
