<?php
include_once('WUG-inc-year.php');	
echo '
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset='.$WUGcharset.'">
		<title>'.$BaroTran.$TperYear.$year.' - '.$gSubtitle.'</title>	
		<script type="text/javascript" src="'.$jQueryFile.'"></script>
		<script type="text/javascript" src="'.$jsPath.'highcharts.js"></script>
		
		<!--[if IE]>
			<script type="text/javascript" src="'.$jsPath.'excanvas.compiled.js"></script>
		<![endif]-->
';
?>
		<script type="text/javascript">
<?php echo $JSdata; ?>		
		//block errors for flat line (no data)
    function stopError() {
    return true;
    }
    window.onerror = stopError;
		
		$(document).ready(function() {
<?php echo $langChart; ?>
      var contHeight = $('#container').height(); // for dynamic labels position
      var chart = new Highcharts.Chart({
			   chart: {
			      renderTo: 'container',
			      defaultSeriesType: '<?php echo $spline ?>',
			      margin: [50,30,60,60],  // top, right, bottom, left
                  padding: [0,0,0,0],  // top, right, bottom, left
                  width: [625],  // top, right, bottom, left
                   height: [370],  // top, right, bottom, left
                  zoomType: 'x'
			   },
<?php 

echo '			   title: {
			      text: "'. $BaroTran.$TperYear . $year.'"
			   },
			   credits: {
			      enabled: '.$creditsEnabled.',
			      text: "'.$credits.'",
			      href: "'.$creditsURL.'"
			   },
			   subtitle: {
			      text: "'.$gSubtitle.'"
			   },
';
?>
			   xAxis: {
             type: 'datetime',
			       maxPadding: 0.005,
             minPadding: 0.005,
             maxZoom: <?php echo $maxZoomYear; ?> * 24 * 3600000
   },

			   yAxis: {
			      title: {
			         text: '<?php echo $BaroTran.' ( '.$TbaroUnits.' )'; ?>'
			      },
labels: { formatter: function() { return this.value +'' } }			      			   
<?php
$bHigh = '1040';
$bLow = '940';
$roundProblem = '';
if (!$metric) {
  $bHigh = round($bHigh/33.86, 2);
  $bLow = round($bLow/33.86, 2);
  $bcon = '/33.86';
  $roundProblem = '
  ,
  startOnTick: false,
  endOnTick: false
  ';
}
echo $roundProblem;
if ($baroMinMax) {
echo '      
';
}
?>
         },

			   tooltip: {
			      formatter: function() {
  			                return '<b>'+ this.series.name +'<\/b><br\/><span style="font-size:12pt;">'+ this.y +'<\/span> <b><?php echo $TbaroUnits; ?><\/b>'+'<br\/>'+ Highcharts.dateFormat('<?php echo $ttDateText[$ddFormat]; ?>', this.x);
			      }
			   },
      colors: [ '#f26c4f', '#66a1ba' ],
			  plotOptions: {
			      <?php echo $spline ?>: {
			         lineWidth: 1,
			         marker: {
			           enabled: false,
  			         states: {
  			            hover: {
  	                  enabled: true,
  	                  symbol: 'circle',
  	                  radius: 5
  			            }
			         }
			         }
			      }
			   },
			   series: 
            [{
			      name: '<?php echo $Tmax.mb_strtolower($BaroTran); ?>',
            visible: <?php echo $showMMBaro; ?>,
            data: comArr(maxBaro)	
			      },{
            name: '<?php echo $Tmin.mb_strtolower($BaroTran); ?>',
            visible: <?php echo $showMMBaro; ?>,
            data: comArr(minBaro)
            
			      }]
			});	
		});
		</script>
		

		<!-- 3. Add the container -->
<?php include_once('WUG-form.php')?>					
