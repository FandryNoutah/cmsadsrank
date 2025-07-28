<div class="card-block">
	<canvas id="bar-stacked-panneau" height="400"></canvas>
</div>  

<?php //datadump($data); ?>

<?php 
foreach ($data as $key => $value) {
	$labels[] = $key;
	$values[] = count($value);
} 

?>

<script type="text/javascript">
	$(function(){
		var $labelPanneau = $.parseJSON(`<?php echo json_encode($labels) ?>`);
		var $valuesPanneau = $.parseJSON(`<?php echo json_encode($values) ?>`);
		//alert($labels);
		//alert($values);

	    // Get the context of the Chart canvas element we want to select
	    var ctx = $("#bar-stacked-panneau");

	    // Chart Options
	    var chartOptions = {
	        title:{
	            display:false,
	            text:"Panneaux par région"
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
					barThickness: 13,
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
	        labels: $labelPanneau,
	        datasets: [{
	            label: "Nombre ",
	            //data: [82,6,35,19,14,42,24],
	            data: $valuesPanneau,
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