        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">Google Ads 
                        <?php foreach($donnees as $C): ?>
                            <?php //echo anchor("Googleads/editclient/".$C['idonnee'], '<h6 class="fas fa-edit"></h6><i class="button"></i>', 'data-edit="'.$C['idonnee'].'"'); ?>    
                            <?php echo anchor("Googleads/ajoutCampagne/".$C['idonnee'], '<h6 class="btn btn-warning mr-1">Ajout campagne</h6><i class="button"></i>', 'data-edit="'.$C['idonnee'].'"'); ?>
                            <?php echo anchor("Googleads/ajoutCampagne/".$C['idonnee'], '<h6 class="btn btn-secondary mr-2">Brouillon</h6><i class="button"></i>', 'data-edit="'.$C['idonnee'].'"'); ?>
                            <?php echo anchor("Googleads/ajoutCampagne/".$C['idonnee'], '<h6 class="btn btn-success mr-3">Save</h6><i class="button"></i>', 'data-edit="'.$C['idonnee'].'"'); ?>
                    
                            <?php endforeach; ?>
                    </h4>
      
        

        <div class="card-body collapse in">
            <div class="card-block">
                <form action="<?php echo site_url('Googleads/updateDonneeClient'); ?>" method="POST">
                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-6">
                        <h4 class="card-title" id="basic-layout-colored-form-control">Information Client</h4></br>
                            <?php foreach($client as $C): ?>
                                <?php foreach($donnees as $D): ?>
                                    <input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
                                    <input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
                                    <div class="form-group">
                                        <label for="fname">Client : <?php echo $C['nom_client']; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Logo client :</label>
                                        <a href="<?php echo ($C['logo_client'] != "") ? base_url($C['logo_client']) : "#"; ?>">
                                            <img class="media-object" src="<?php echo base_url($C['logo_client']); ?>" 
                                                 title="<?php echo $C['logo_client']; ?>" alt="<?php echo $C['logo_client']; ?>" 
                                                 style="width: 50px;height: 50px;" />
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">URL du site : <?php echo $C['site_client']; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Secteur d'activité:</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Budget Total : <?php echo $D['budget']; ?> €</label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">
                           

                            <h4 class="card-title" id="basic-layout-colored-form-control">Campagne</h4></br>
                            <?php foreach($campagne as $C): ?>
                                <?php if($C['type_campagne'] == 1): ?>




                                    <label for="fname">Type de campagne : <?php echo $C['nom_campagne']; ?></label>





                                    <?php foreach( $groupe_annonce as $G): ?>
                                        <div class="form-group">
                                            <?php echo anchor("Googleads/editclient/".$G['idgroupe_annonce'], '<h6 class="fas fa-edit"></h6><i class="button"></i>', 'data-edit="'.$G['idgroupe_annonce'].'"'); ?>    
                                            <?php echo anchor(
                                                "Googleads/ajoutCampagne/".$G['idgroupe_annonce'], 
                                                '<h6 class="fas fa-plus"></h6><i class="button"></i>', 
                                                ['data-edit' => $G['idgroupe_annonce'], 'target' => '_blank']
                                            ); ?>
                                            <?php echo anchor(
                                                "Googleads/VisualiserSearch/".$G['idgroupe_annonce'], 
                                                '<h6 class="fas fa-eye"></h6><i class="button"></i>', 
                                                ['data-edit' => $G['idgroupe_annonce'], 'target' => '_blank']
                                            ); ?>
                                        </div>
                                            <div class="form-group">
                                                <label for="fname">Titre : <?php echo $C['nom_campagne']; ?></label>
                                            </div>
                                        <div class="form-group">
                                            <label for="fname">Objectif campagne : <?php echo $C['objectif']; ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Répartition budget : <?php echo $C['repartition_budget']; ?> €</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Mots clé : <?php echo $G['mot_cle']; ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Nom groupe d'annonce : <?php echo $G['nom_groupe']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if($C['type_campagne'] == 3): ?>
                                    <label for="fname">Type de campagne : <?php echo $C['label_type_campagne']; ?></label>
                                    <?php foreach($groupe_annonce_pmax as $G): ?>
                                        <div class="form-group">
                                            <?php echo anchor("Googleads/editclient/".$G['idgroupe_annonce'], '<h6 class="fas fa-edit"></h6><i class="button"></i>', 'data-edit="'.$G['idgroupe_annonce'].'"'); ?>    
                                            <?php echo anchor("Googleads/ajoutCampagne/".$G['idgroupe_annonce'], '<h6 class="fas fa-plus"></h6><i class="button"></i>', 'data-edit="'.$G['idgroupe_annonce'].'"'); ?>
                                            <?php echo anchor("Googleads/Visualiser/".$G['idgroupe_annonce'], '<h6 class="fas fa-eye"></h6><i class="button"></i>', 'data-edit="'.$G['idgroupe_annonce'].'" target="_blank"'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Titre : <?php echo $G['titre']; ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Objectif campagne : <?php echo $C['objectif']; ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Descriptions : <?php echo $G['descriptions']; ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="fname">Mots clé : <?php echo $G['mot_cle']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function() {
        $("#enableFileUpdate").click(function() {
            if($(this).is(":checked")) {
                $("input#logo").removeAttr("disabled");
                $("input#logo").show();
            } else {
                $("input#logo").attr("disabled", "disabled");
                $("input#logo").hide();
            }
        });
    });
</script>
