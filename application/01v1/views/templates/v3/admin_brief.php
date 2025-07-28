<div class="row">
    <!-- Column 1: Google Ads Campaign Information -->
    <div class="col-md-6">
       
    <h4 class="card-title" id="basic-layout-colored-form-control">Google Ads</h4>
   

       
    </div>
    
    <!-- Column 2: Client Information -->
    <div class="col-md-6">
    <?php foreach($donnees as $D): ?>
            <!-- Display Campaign Status -->
            <?php if($D['campagne_actif'] == 0): ?>
                <p><br>Statut campagne client : <a style="color: orange"> Brouillon</a></p>
            <?php elseif($D['campagne_actif'] == 1): ?>
                <p><br>Statut campagne client : <a style="color: #37BC9B"> Actif</a></p>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <?php //echo anchor("Googleads/ajoutCampagne/".$D['idonnee'], '<h6 class="btn btn-warning mr-1">Ajout campagne</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
            
            <?php echo anchor("Googleads/information_client/".$D['idclients'], '<h6 class="btn btn-secondary mr-1">Information client</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
            
            <?php if($D['campagne_actif'] == 1): ?>
                <?php //echo anchor("Googleads/save_brouillon/".$D['idonnee'], '<h6 class="btn btn-secondary mr-2">Brouillon</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
            <?php endif; ?>
            
            <?php if($D['campagne_actif'] == 0): ?>
                <?php //echo anchor("Googleads/save_campagne/".$D['idonnee'], '<h6 class="btn btn-success mr-3">Publié</h6><i class="button"></i>', 'data-edit="'.$D['idonnee'].'"'); ?>
            <?php endif; ?>
            <?php echo anchor("Googleads/campagne/".$D['idclients'], 
                    '<h6 class="btn btn-success mr-3">Suivant</h6><i class="button"></i>', 
                    'data-edit="'.$D['idonnee'].'"'); ?>
            <?php // echo anchor("Googleads/validation_clients/".$D['idclients'], '<h6 class="btn btn-success mr-3">Validation client</h6><i class="button"></i>', 'data-edit="'.$D['idclients'].'"'); ?>
        <?php endforeach; ?>
        
    </div>
</div>
<div class="row">
    <!-- Column 1: Google Ads Campaign Information -->
    <div class="col-md-6">
       
    
   
    <h4 class="card-title" id="basic-layout-colored-form-control">Information Client</h4><br>
    <?php foreach($donnees as $D): ?>
    <?php foreach($client as $C): ?>
        <input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
        <input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
        
        <div class="form-group">
            <label for="fname"><strong>Client :</strong> <?php echo $C['nom_client']; ?></label>
        </div>
        <div class="form-group">
            <label for="fname"><strong>Logo client :</strong></label>
            <a href="<?php echo ($C['logo_client'] != "") ? base_url($C['logo_client']) : "#"; ?>">
                <img class="media-object" src="<?php echo base_url($C['logo_client']); ?>" 
                     title="<?php echo $C['logo_client']; ?>" alt="<?php echo $C['logo_client']; ?>" 
                     style="width: 50px;height: 50px;" />
            </a>
        </div>
        <div class="form-group">
            <label for="fname"><strong>URL du site :</strong> <?php echo $C['site_client']; ?></label>
        </div>
        <div class="form-group">
            <label for="fname"><strong>Secteur d'activité:</strong> <?php echo $D['secteur_activite']; ?></label> 
        </div>
        <div class="form-group">
            <label for="fname"><strong>Budget Total :</strong> <?php echo $D['budget']; ?> €</label>
        </div>
        <div class="form-group">
            <label for="fname"><strong>Information client :</strong> <?php echo nl2br($D['information_client']); ?>
            </label>
        </div>
        <div class="form-group">
            <label for="fname"><strong>Contexte client :</strong> <?php echo $D['contexte_client']; ?></label>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group" style="margin-top: 85px;">
            <label for="fname"><strong>Tracking GTM :</strong> <?php echo $D['tracking_gtm']; ?></label>
        </div>
        
        <div class="form-group">
            <label for="fname"><strong>Plan de taggage :</strong> <?php echo $D['commentaire']; ?></label>
        </div>
        <div class="form-group">
            <label for="fname"><strong>Information complémentaire :</strong> <?php echo $D['information_complementaire']; ?></label>
        </div>
        </div>

    <?php endforeach; ?>
<?php endforeach; ?>

       
    </div>
