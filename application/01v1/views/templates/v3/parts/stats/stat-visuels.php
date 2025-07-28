<div class="card-block">
	<canvas id="bar-stacked-visuels" height="450"></canvas>
</div>

<?php 
foreach ($data as $key => $value) {
	$labels[] = $value->visuel;
	$values[] = $value->datacount;	
}

?>

<script type="text/javascript">
	$(function(){

		var $labelsVisuels = $.parseJSON(`<?php echo json_encode($labels) ?>`);
		var $valuesVisuels = $.parseJSON(`<?php echo json_encode($values) ?>`);
		//alert($labels);
		//alert($values);

	    // Get the context of the Chart canvas element we want to select
	    var ctx = $("#bar-stacked-visuels");
		ctx.height(5000);
	    // Chart Options
	    var chartOptions = {
	        title:{
	            display:true,
	            text: `<?php echo $title ?>`,
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
						offsetGridLines: true,
	                },
	                scaleLabel: {
	                    display: true,
	                }
	            }],
	            yAxes: [{
	                stacked: true,
	                display: true,
					barThickness: 13,					
					maxBarThickness: 13,					
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
	        //type: 'verticalBar',

	        // Chart Options
	        options : chartOptions,

	        data : chartData
	    };

	    // Create the chart
	    var lineChart = new Chart(ctx, config);

	});
</script>