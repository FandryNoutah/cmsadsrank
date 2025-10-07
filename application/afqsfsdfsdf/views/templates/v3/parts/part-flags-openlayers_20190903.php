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
<!-- <div class="card-body collapse in" id="ajax-gmaps-panneaux" style="height: 1092px; max-height:100%;"></div> -->
	
	
	
	<div id="map-canvas"></div>
	
	
	
	
</div>


<script>

	var plot_src = 'http://41.188.35.113/horsmedia_v3_2/assets/uploads/regisseurs/pin_J2.png';
	
	var locations = <?php echo json_encode($locations) ?>;
	
	//console.log(locations);
	
	
	/*var locations = [
      	["Statue Of Liberty", 40.6892534, -74.0446426, "the-statue-of-libety", "https://cdn.getyourguide.com/img/tour_img-739075-148.jpg", 1],
      	["Central Park", -18.8787395, 47.5096905, "central-park", "https://www.centralpark.com/downloads/7777/download/header.central-park-4.jpg?cb=c41c17ea856fbf7a49b80f2d2c0c6c99&w=640", 2],
      	["Rockefeller Center", 40.7562179,-73.9848441, "rockerfeller-center","https://www.nycgo.com/images/venues/106/_masthead_rockfellercenterspring_taggeryanceyiv_5990__x_large.jpg", 3]
      	];
	*/
	// Array of Icon features
	var iconFeatures=[];
	
	             // 421
	
	for (var i = 0; i < locations.length; i++) {
		
		longitude = parseFloat(locations[i][2]).toFixed(8);
		latitude = parseFloat(locations[i][1]).toFixed(8);
		console.log(longitude + " ====> " + latitude);
		
	  var iconFeature = new ol.Feature({
	  	type: 'click',
		desc: locations[i][0],
		url: locations[i][3],
		image: plot_src, 
		
		geometry: new ol.geom.Point(ol.proj.transform([47.5096905,-18.8787395], 'EPSG:4326', 'EPSG:3857')),
		//geometry1: new ol.geom.Point(ol.proj.transform([48.44950000 ,-18.8787395], 'EPSG:4326', 'EPSG:3857')),
	    //geometry: new ol.geom.Point(ol.proj.transform([parseFloat(locations[i][2]).toFixed(8),parseFloat(locations[i][1]).toFixed(8)], 'EPSG:4326', 'EPSG:3857')),
	  });

	  iconFeatures.push(iconFeature);
	  
	  
	  
	}

	var vectorSource = new ol.source.Vector({
		features: iconFeatures
	});

	// Custom image for marker
	var iconStyle = new ol.style.Style({
	    image: new ol.style.Icon({
	      anchor: [0.5, 0.5],
	      anchorXUnits: 'fraction',
	      anchorYUnits: 'fraction',
	      src: plot_src,
	      scale: 0.15
		    })
	});
	  
	var vectorLayer = new ol.layer.Vector({
	  source: vectorSource,
	  style: iconStyle,
	  updateWhileAnimating: true,
	  updateWhileInteracting: true,
	});

	// Create our initial map view
	//var mapCenter = ol.proj.fromLonLat([  -74.0446426, 40.6892534 ]);
	var mapCenter = ol.proj.fromLonLat([47.5096905,-18.8787395]);
	var view = new ol.View({
	  center: mapCenter,
	  zoom: 9
	});

	// Now create our map
	var map = new ol.Map({
	  target: 'map-canvas',
	  view: view,
	  layers: [
	    new ol.layer.Tile({
	      source: new ol.source.OSM(),
	    }),
	    vectorLayer,
	  ],
	  loadTilesWhileAnimating: true,
	});

	var popup = new ol.Overlay.Popup();
	map.addOverlay(popup);

	// Add an event handler for when someone clicks on a marker
	map.on('singleclick', function(evt) {

	    // Hide existing popup and reset it's offset
	    popup.hide();
	    popup.setOffset([0, 0]);

	    // Attempt to find a feature in one of the visible vector layers
	    var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
	        return feature;
	    });

	    if (feature) {
	        var coord = feature.getGeometry().getCoordinates();
	        var props = feature.getProperties();
	        var info = '<a style="color:black; font-weight:600; font-size:11px" href="http://www.somedomain.com/' + props.url + '">' + 
		'<img width="200" src="' +  props.image + '"  />' + 
		'<div style="width:220px; margin-top:3px">' + props.desc + '</div></a>';

	        // Offset the popup so it points at the middle of the marker not the tip
	        popup.setOffset([0, -22]);
	        popup.show(coord, info);
	    }
	});

	// Add an event handler for when someone hovers over a marker
	// This changes the cursor to a pointer
	map.on("pointermove", function (evt) {
	    var hit = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
	        return true;
	    }); 
	    if (hit) {
	        this.getTargetElement().style.cursor = 'pointer';
	    } else {
	        this.getTargetElement().style.cursor = '';
	    }
	});

</script>



