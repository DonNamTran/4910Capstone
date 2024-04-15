<?php
require_once("../conf.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<title>phpChart - Meter Gauge</title>
 <style type="text/css">

.plot {
    margin-bottom: 30px;
    margin-left: auto;
    margin-right: auto;
}

#chart0 .jqplot-meterGauge-label {
    font-size: 10pt;
}

#chart1 .jqplot-meterGauge-tick {
    font-size: 6pt;
}

#chart2 .jqplot-meterGauge-tick {
    font-size: 8pt;
}

#chart3 .jqplot-meterGauge-tick, #chart0 .jqplot-meterGauge-tic {
    font-size: 10pt;
}

#chart4 .jqplot-meterGauge-tick, #chart4 .jqplot-meterGauge-label {
    font-size: 12pt;
}
</style>

    </head>
    <body>
        <div><span> </span><span id="info1b"></span></div>


<?php
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 0 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $s1 = array(1);
    
    $pc = new C_PhpChartX(array($s1),'chart0');
    $pc->set_title(array('text'=>'Network Speed'));
    $pc->set_series_default(array(
			'renderer'=>'plugin::MeterGaugeRenderer',
			'rendererOptions'=>array('label'=>'MB/s')));

    $pc->draw(600,300);
/*    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 1 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $s1 = array(1);
    
    $pc = new C_PhpChartX(array($s1),'chart1');
    $pc->set_series_default(array(
			'renderer'=>'plugin::MeterGaugeRenderer',
			'rendererOptions'=>array(
				'showTickLabels'=>false,
				'intervals'=>array(2,3,4),
				'intervalColors'=>array('#66cc66', '#E7E658', '#cc6666'))));

    $pc->draw(120,75);
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 2 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $s1 = array(322);
    
    $pc = new C_PhpChartX(array($s1),'chart2');
    $pc->set_series_default(array(
			'renderer'=>'plugin::MeterGaugeRenderer',
			'rendererOptions'=>array(
				'max'=>500,
				'min'=>100,
				'intervals'=>array(200,300,400,500),
				'intervalColors'=>array('#66cc66', '#93b75f', '#E7E658', '#cc6666'))));

    $pc->draw(600,300);    

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Chart 3 Example
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $s1 = array(322);
    
    $pc = new C_PhpChartX(array($s1),'chart3');
    $pc->set_series_default(array(
		'renderer'=>'plugin::MeterGaugeRenderer',
        'rendererOptions'=>array(
			'label'=>'Metric Tons per Year',
			'labelPosition'=>'bottom',
			'labelHeightAdjust'=>-5,
			'intervalOuterRadius'=>85,
			'intervals'=>array(22000,55000,70000),
			'ticks'=>array(10000, 30000, 50000, 70000),
			'intervalColors'=>array('#66cc66', '#E7E658', '#cc6666'))));

    $pc->draw(600,300);    
*/ 
    ?>

    </body>
</html>