<div class="card">
	<div class="card-header">
		<h4 class="card-title">Map</h4>
		<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
				<li><a data-action="reload"><i class="icon-reload"></i></a></li>
				<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
				<li><a data-action="close"><i class="icon-cross2"></i></a></li>
			</ul>
		</div>
	</div>
	<div class="card-body collapse in" id="ajax-gmaps-panneaux" style="height: 1092px; max-height:100%;"></div>
</div>
<?php //datadump($locations); ?>
<script type="text/javascript">
function initMap() {
	var locations = <?php echo json_encode($locations) ?>;
    var infowindow = new google.maps.InfoWindow;
    var marker, i;
	var image = {
		url: 'http://41.188.35.113/horsmedia_v3_2/assets/uploads/regisseurs/pin_J1.png',
		//size: new google.maps.Size(100, 120),
		
		origin: new google.maps.Point(0,0),
		anchor: new google.maps.Point(0, 20)
		
	};
	
    var map = new google.maps.Map(document.getElementById('ajax-gmaps-panneaux'), {
         zoom: 7,
         center: new google.maps.LatLng(-18.882238,47.513675),
         mapTypeId: google.maps.MapTypeId.ROADMAP
		 
    });


    for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
             
			 
			 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
             map: map,
			 icon: image
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
             return function() {
                 infowindow.setContent(locations[i][0]);
                 infowindow.open(map, marker);
             }
        })(marker, i));
    }
}

</script>
 https://developers.google.com/maps/docummentation/javascript/

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWoyYEeBgShtby_29hP1KFmHO4jO6SEWM&callback=initMap">
</script>