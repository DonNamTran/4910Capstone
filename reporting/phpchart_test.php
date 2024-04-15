<?php
require_once("../phpChart_Lite/conf.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales by Sponsor</title>
</head>
<body>
   
<?php
$line1 = array(array('Amazon', 3), array('Subway', 7), array('Microsoft', 2.5), array('Publix', 6),array('Walmart', 5),array('Wendys', 4));

$pc = new C_PhpChartX($line1,'chart2');

$pc->set_title(array('text'=>'Sales by Sponsor'));

$pc->set_axes(array(
    'xaxis'  => array(
        'label'=>'Sponsor',
    'yaxis'  => array(
        'autoscale'=>true,
        'label'=>'Sales'
));

$pc->draw();
?>

</body>
</html>