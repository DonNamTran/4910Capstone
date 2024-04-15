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

$pc = new C_PhpChartX(array($line1),'plot4');
$pc->add_plugins(array('canvasTextRenderer'));
$pc->set_title(array('text'=>'Sales by Sponsor'));
$pc->set_animate(true);
$pc->set_legend(array('show'=>true));
$pc->set_series_default(array('renderer'=> 'plugin::PieRenderer', 'rendererOptions'=> array('sliceMargin'=>8)));

$pc->draw(600,310);
?>

</body>
</html>