<div class="content-header row">
    <div class="content-header-left col-md-6 col-xs-12 mb-1">
        <h2 class="content-header-title">Détails</h2>
    </div>
</div>

<div class="content-body">
    <section class="card">
        <div id="invoice-template" class="card-block">
        <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                    <img src="<?php echo base_url(IMAGES_PATH.'/logo/logo-telma.png') ?>" alt="Telma" class=""/>
                    <ul class="px-0 list-unstyled">
                        <li class="text-bold-800"></li>
                        <li><strong>SAM : </strong><?php echo $sam[$panneau->panneau_sam]; ?></li>
                        <li><strong>Province : </strong><?php echo $provinces[$panneau->panneau_province]; ?></li>
                        <li><strong>Axe : </strong><?php echo $axes[$panneau->panneau_axe]; ?></li>
                        <li><strong>Région : </strong><?php echo $panneau->panneau_region; ?></li>
                        <?php if($panneau->panneau_date_pose): ?>
                        <li><strong>Date pose : </strong><?php echo format_date($panneau->panneau_date_pose); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                    <h2>Réf. <?php echo $panneau->panneau_reference ?></h2>
                    <p class="pb-3"></p>
                    <ul class="px-0 list-unstyled">
                        <li class="lead text-bold-800">Ar <?php echo number_format($totalPrice, 2, ",", "."); ?></li>
                        <p><span class="text-muted">Date :</span> <?php echo date("d/M/Y"); ?></p>
                    </ul>
                </div>
            </div>
            <!--/ Invoice Company Details -->

        <!-- Invoice Items Details -->
            <div id="invoice-items-details" class="pt-2">
                <div class="row match-height">
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-block">
                                    <h4 class="card-title">Emplacement</h4>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Emplacement : </strong><?php echo $panneau->panneau_emplacement; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Quartier : </strong><?php echo $panneau->panneau_quartier; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Proximité : </strong><?php echo $panneau->panneau_proximite; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-block">
                                    <h4 class="card-title">Type</h4>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Format : </strong><?php echo $formats[$panneau->panneau_format]; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Type : </strong><?php echo $types[$panneau->panneau_type]; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Régisseur : </strong><?php echo $regisseurs[$panneau->panneau_regisseur]; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-block">
                                    <h4 class="card-title">Couverture</h4>
                                    <?php $couv4g   = $panneau->panneau_couverture_4g == 1 ? "Oui" : "Non"; ?>
                                    <?php $couvFO   = $panneau->panneau_couverture_fo == 1 ? "Oui" : "Non"; ?>
                                    <?php $couvAdsl = $panneau->panneau_couverture_adsl == 1 ? "Oui" : "Non"; ?>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Couverture FO : </strong><?php echo $couvFO; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Couverture ADSL : </strong><?php echo $couvAdsl; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Couverture 4G : </strong><?php echo $couv4g; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
<!--
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Basic Map</h4>
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
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div id="basic-map" class="height-400"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
-->
                <section id="image-gallery" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Visuels</h4>
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
                <div class="card-body collapse in">
                      
                    <div class="card-block my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
                        <div class="row">
                            
                            <figure class="col-md-4 col-xs-12" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                <h3 class="text-muted">Visuel actuel</h3>
                                <a href="<?php echo base_url($panneau->panneau_visuel_actuel_path) ?>" itemprop="contentUrl" data-size="480x360">
                                    <img class="img-thumbnail img-fluid" src="<?php echo base_url($panneau->panneau_visuel_actuel_path); ?>" itemprop="thumbnail" alt="<?php echo base_url($panneau->panneau_visuel_actuel); ?>" />
                                </a>
                            </figure>

                            <div class="col-md-8 col-xs-12">
                                <div class="table-responsive">
                                    <h3>Coûts</h3>
                                    <table class="table">
                                        <tbody>
                                            <?php $grandTotal = 0; ?>
                                            <pre>
                                            <?php $exif = @exif_read_data(base_url($panneau->panneau_visuel_actuel_path), 0, true); ?>ssss
                                            

                                            <?php print_r($exif); ?>
                                            zzzz
                                            </pre>
                                            <tr>
                                                <td>Coût impression</td>
                                                <td class="text-xs-right">Ar <?php echo number_format($panneau->panneau_cout_impression, 2, ",", "."); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Coût pose et finition</td>
                                                <td class="text-xs-right">Ar <?php echo number_format($panneau->panneau_cout_pose_finition, 2, ",", "."); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Coût location</td>
                                                <td class="text-xs-right">Ar <?php echo number_format($panneau->panneau_cout_location, 2, ",", "."); ?></td>
                                            </tr>
                                            <tr>
                                                <?php $total = sizeof($maj_panneaux) >= 1 ? "Sous-total" : "Total";  ?>
                                                <td class="text-bold-800"><?php echo $total; ?></td>
                                                <td class="text-bold-800 text-xs-right">Ar <?php echo number_format($totalPrice, 2, ",", "."); ?></td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php if(sizeof($maj_panneaux) >= 1): ?>
                            <?php foreach($maj_panneaux as $maj_panneau): ?>
                            <?php $soustotal = intval($maj_panneau->panneau_maj_date_pose + $maj_panneau->panneau_maj_cout_impression + $maj_panneau->panneau_maj_cout_deplacement); ?>
                            <div class="row">

                                <figure class="col-md-4 col-xs-12" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                    <h3 class=""><?php echo $maj_panneau->panneau_maj_visuel ?></h3><p><?php echo format_date($maj_panneau->panneau_maj_date_pose); ?></p>
                                    <a href="<?php echo base_url($maj_panneau->panneau_maj_visuel_path) ?>" itemprop="contentUrl" data-size="480x360">
                                        <img class="img-thumbnail img-fluid" src="<?php echo base_url($maj_panneau->panneau_maj_visuel_path); ?>" itemprop="thumbnail" alt="<?php echo base_url($maj_panneau->panneau_maj_visuel_path); ?>" />
                                    </a>
                                </figure>

                                <div class="col-md-8 col-xs-12">
                                    <div class="table-responsive">
                                        <h3>Coûts</h3>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Coût impression</td>
                                                    <td class="text-xs-right">Ar <?php echo number_format($maj_panneau->panneau_maj_cout_impression, 2, ",", "."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Coût pose et finition</td>
                                                    <td class="text-xs-right">Ar <?php echo number_format($maj_panneau->panneau_maj_cout_pose, 2, ",", "."); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Coût location</td>
                                                    <td class="text-xs-right">Ar <?php echo number_format($maj_panneau->panneau_maj_cout_deplacement, 2, ",", "."); ?></td>
                                                </tr>
                                                <tr>
                                                    <?php $total = sizeof($maj_panneaux) >= 1 ? "Sous-total" : "Total";  ?>
                                                    <td class="text-bold-800"><?php echo $total; ?></td>
                                                    <td class="text-bold-800 text-xs-right">Ar <?php echo number_format($soustotal, 2, ",", "."); ?></td>
                                                </tr>
                                                <?php $grandTotal +=  $soustotal; ?>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                  </div>
                  <!--/ PhotoSwipe -->
                </section>

                <div class="row">
                    <div class="col-md-4 col-sm-12 text-xs-center text-md-left">
                        
                        
                                <a type="button" class="btn btn-success btn-block" href="<?php echo base_url("panneau/maj/$panneau->id"); ?>">Modifier visuel actuel</a>
                                <a type="button" class="btn btn-success btn-block" href="<?php echo base_url("panneau/maj/$panneau->id"); ?>">Ajouter patch</a>
                            
                        
                    </div>
                    <div class="col-md-8 col-sm-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    /*
    function init_map() {
        var var_location = new google.maps.LatLng(45.430817,12.331516);
        var var_mapoptions = {
            center: var_location,
            zoom: 14
        };
        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title:"Venice"
        });
        var var_map = new google.maps.Map(document.getElementById("basic-map"),var_mapoptions);
        var_marker.setMap(var_map); 
    }
    google.maps.event.addDomListener(window, 'load', init_map);
    */
    function myMap() {
        var mapCanvas = document.getElementById("basic-map");
        var mapOptions = {
            center: new google.maps.LatLng(45.430817, 12.331516),
            zoom: 10
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
    }
    
</script>