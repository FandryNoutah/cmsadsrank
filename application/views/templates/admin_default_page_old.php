<div class="content-header row"></div>
<div class="content-body"><!-- Statistics -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-camera7 font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Panneaux</h5>
                            <h5 class="text-bold-400"><?php echo count($panneaux) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-user1 font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Flags</h5>
                            <h5 class="text-bold-400"><?php echo count($flags) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-cart font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Régisseurs</h5>
                            <h5 class="text-bold-400"><?php echo count($regisseurs) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-banknote font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Kiosques</h5>
                            <h5 class="text-bold-400"><?php //echo count($kiosques) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-banknote font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>WLB</h5>
                            <h5 class="text-bold-400">5.6 M</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-banknote font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Mur</h5>
                            <h5 class="text-bold-400">5.6 M</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                            <i class="icon-banknote font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-teal white media-body">
                            <h5>Abribus & Totems</h5>
                            <h5 class="text-bold-400">5.6 M</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		-->
    </div>

    <section id="chartjs-pie-charts">
        <div class="row">
            <div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Stat panneau</h4>
                        
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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group card-header">
                                <form id="stat-panneau">
                                    <select name="stat-panneau" class="form-control">
                                        <option value="panneau_province">Province</option>
                                        <option value="panneau_sam">SAM</option>
                                        <option value="panneau_axe">Axe</option>
                                        <option value="panneau_regisseur">Régisseur</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse in" id="ajax-chart-panneaux">

                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Stat visuels</h4>
                        
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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group card-header">
                                <form id="stat-visuel">
                                    <select name="stat-visuel" class="form-control">
                                        <option value="0" selected="selected">Tout</option>
                                        <?php foreach($provinces as $key => $value) : ?>
                                            <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?php //echo form_dropdown("stat-visuel", $provinces, '', 'class="form-control"'); ?>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse in" id="ajax-chart-visuels">

                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<pre>
	<?php //print_r($panneaux_coords); ?>
	</pre>
	
	<?php 
	foreach($panneaux_coords as $key => $value) {
		unset($value["id"]);
		$panneaux_coords[$key] = array_values($value);
	}
	foreach($flag_coords as $key => $value) {
		unset($value["id"]);
		$flag_coords[$key] = array_values($value);
	}
	?>
	
	<pre>
	<?php //print_r($flag_coords); ?>
	</pre>
	
    <section id="gmaps">
        <div class="row">
            <div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Panneaux</h4>
                        
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
                    <div class="card-body collapse in" id="ajax-gmaps-panneaux" style="height: 450px; max-height:100%;" >
						
                    </div>
                </div>
            </div>
			
			<div class="col-xs-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Flags</h4>
                        
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
                    <div class="card-body collapse in" id="ajax-gmaps-flags" style="height: 450px; max-height:100%;" >
						
                    </div>
                </div>
            </div>
        </div>
    </section>

<script type="text/javascript">
    //ajax-chart-panneaux
    $(window).on("load", function(){
        loadPanneauChart();
        loadVisuelChart();

        $("#stat-panneau select").change(function() {
            loadPanneauChart();
        })

        $("#stat-visuel select").change(function() {
            loadVisuelChart();
        })
    });

    function loadPanneauChart() {
        var ajaxData = $("#stat-panneau select").serialize();
        //alert(ajaxData);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("stats/panneaux") ?>',
            data: ajaxData,
            success: function(data) {
                //alert("success");
                $("#ajax-chart-panneaux").html(data);
            },
            error: function(data) {
                alert("error");
            },
            done: function(data) {
                alert("done");
            }
        });
    }

    function loadVisuelChart() {
        var ajaxData = $("#stat-visuel select").serialize();
        //alert(ajaxData);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("stats/visuels") ?>',
            data: ajaxData,
            success: function(data) {
                //alert("success");
                $("#ajax-chart-visuels").html(data);
            },
            error: function(data) {
                alert("error");
            },
            done: function(data) {
                alert("done");
            }
        });
    }
</script>

<script>
      
  /*    var coords = [47,50904  -18,94549
47.49286  -18.86871 
47,50905  -18,94548
47.53685  -18.89236];
*/
    function initMap() {
        var locations = <?php echo json_encode($panneaux_coords) ?>;
        var locations_ = <?php echo json_encode($flag_coords) ?>;
		console.log(locations);
		console.log(locations_);
        		
        var map = new google.maps.Map(document.getElementById('ajax-gmaps-panneaux'), {
          zoom: 13,
          center: new google.maps.LatLng(-18.882238,47.513675), //Coords antananarivo
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
		
		var map_flags = new google.maps.Map(document.getElementById('ajax-gmaps-flags'), {
          zoom: 13,
          center: new google.maps.LatLng(-18.882238,47.513675), //Coords antananarivo
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;
        var markers = [];
		
        var marker_flags, j;
        var markers_flags = [];

        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][2], locations[i][1]),
            //animation:  google.maps.Animation.BOUNCE,
            map: map
          });

          markers.push(marker);
          
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent('<strong>' + locations[i][0] + '</strong><br/>Province: ' + locations[i][3] + '<br/>Régisseur: ' + locations[i][4] + '<br/>Emplacement: ' + locations[i][5]);
              infowindow.open(map, marker);
            }
          })(marker, i));
          
        }
		
		
		for (j = 0; j < locations_.length; j++) {  
          marker_flags = new google.maps.Marker({
            position: new google.maps.LatLng(locations_[j][1], locations_[j][2]),
            //animation:  google.maps.Animation.BOUNCE,
            map: map_flags
          });
		  
		  //alert(locations_.length);

          markers_flags.push(marker_flags);
          
          google.maps.event.addListener(marker_flags, 'click', (function(marker_flags, j) {
            return function() {
              infowindow.setContent('<strong>' + locations_flags[j][2] + '</strong><br/>Emplacement: ' + locations_flags[j][3] + '<br/>Arrondissement: ' + locations_flags[j][4]);
              infowindow.setContent('<strong>AAA</strong>');
              infowindow.open(map_flags, marker_flags);
            }
          })(marker_flags, j));
          
        }
		
      }
	  
	function initMapFlag() {
        var locations_ = <?php echo json_encode($flag_coords) ?>;
		console.log(locations_);
        		
		var map_flags = new google.maps.Map(document.getElementById('ajax-gmaps-flags'), {
          zoom: 13,
          center: new google.maps.LatLng(-18.882238,47.513675), //Coords antananarivo
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();
		
        var marker_flags, j;
        var markers_flags = [];	
		
		for (j = 0; j < locations_.length; j++) {  
          marker_flags = new google.maps.Marker({
            position: new google.maps.LatLng(locations_[j][1], locations_[j][2]),
            //animation:  google.maps.Animation.BOUNCE,
            map: map_flags
          });

          markers_flags.push(marker_flags);
          
          google.maps.event.addListener(marker_flags, 'click', (function(marker_flags, j) {
            return function() {
              infowindow.setContent('<strong>' + locations_flags[j][2] + '</strong><br/>Emplacement: ' + locations_flags[j][3] + '<br/>Arrondissement: ' + locations_flags[j][4]);
              infowindow.setContent('<strong>AAA</strong>');
              infowindow.open(map_flags, marker_flags);
            }
          })(marker_flags, j));
          
        }
      }
	  
	  /*
	  function initMapFlag(locations_){
		 for (j = 0; j < locations_.length; j++) {  
          marker_flags = new google.maps.Marker({
            position: new google.maps.LatLng(locations_[j][1], locations_[j][2]),
            //animation:  google.maps.Animation.BOUNCE,
            map: map_flags
          });
		  
		  alert(locations_.length);

          markers_flags.push(marker_flags);
          
          google.maps.event.addListener(marker_flags, 'click', (function(marker_flags, j) {
            return function() {
              //infowindow.setContent('<strong>' + locations_flags[j][2] + '</strong><br/>Emplacement: ' + locations_flags[j][3] + '<br/>Arrondissement: ' + locations_flags[j][4]);
              infowindow.setContent('<strong>AAA</strong>');
              infowindow.open(map_flags, marker_flags);
            }
          })(marker_flags, j));
          
        } 
	  }
	  */
	  
	  
	  
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWoyYEeBgShtby_29hP1KFmHO4jO6SEWM&callback=initMap">
    </script>
	<!--
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWoyYEeBgShtby_29hP1KFmHO4jO6SEWM&callback=initMapFlag">
    </script>
	-->