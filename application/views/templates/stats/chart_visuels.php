
        <div class="card-block">
            <canvas id="bar-stacked-visuels" height="450"></canvas>
        </div>
    

<?php //datadump(count($data)); ?>

<?php 
$all = 0;
foreach ($data as $key => $value) {
	//$values = array();
	$count = 0;
	$labels[] = $key;
	if($post == 0) {
		$values[] = count($value);
	} elseif(count($value) == 0) $values[] = 0;
	else {
		foreach ($value as $k => $v) {
			if ($v->panneau_province == $post) {
				$count += 1;
			}
		}
		$values[] = $count;
		$all += 1;
	}
	//echo "key = $key => Count => " . $count . "<br/>";
	
	
}
//datadump($all);
//datadump($labels);
//datadump($values);
//die();
?>

<script type="text/javascript">
	$(function(){

		var $labelsVisuels = $.parseJSON('<?php echo json_encode($labels) ?>');
		var $valuesVisuels = $.parseJSON('<?php echo json_encode($values) ?>');
		//alert($labels);
		//alert($values);

	    // Get the context of the Chart canvas element we want to select
	    var ctx = $("#bar-stacked-visuels");

	    // Chart Options
	    var chartOptions = {
	        title:{
	            display:true,
	            text:"Visuels par région"
	        },
	        tooltips: {
	            mode: 'label'
	        },
	        responsive: true,
	        maintainAspectRatio: false,
	        responsiveAnimationDuration:500,
	        scales: {
	            xAxes: [{
	                stacked: true,
	                display: true,
	                gridLines: {
	                    color: "#f3f3f3",
	                    drawTicks: false,
	                },
	                scaleLabel: {
	                    display: true,
	                }
	            }],
	            yAxes: [{
	                stacked: true,
	                display: true,
	                gridLines: {
	                    color: "#f3f3f3",
	                    drawTicks: false,
	                },
	                scaleLabel: {
	                    display: true,
	                }
	            }]
	        }
	    };

	    // Chart Data
	    var chartData = {
	        //labels: ["Antananarivo","Antsirabe","Antsiranana","Fianarantsoa","Mahajanga","Toamasina","Toliara"],
	        labels: $labelsVisuels,
	        datasets: [{
	            label: "Nombre ",
	            //data: [82,6,35,19,14,42,24],
	            data: $valuesVisuels,
	            backgroundColor: "#00BFA5",
	            hoverBackgroundColor: "rgba(0,191,165,.8)",
	            borderColor: "transparent"
	        }]
	    };

	    var config = {
	        type: 'horizontalBar',

	        // Chart Options
	        options : chartOptions,

	        data : chartData
	    };

	    // Create the chart
	    var lineChart = new Chart(ctx, config);

	});
</script>