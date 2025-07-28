
<?php //datadump($post); ?>
<?php //datadump($filter); ?>
<?php //datadump(count($result)); ?>
<?php //exit(); ?>
<?php $count = count($result) > 1 ? count($result) . " items" : count($result) . " item"; ?>
<?php $this->session->set_flashdata('result', $result); ?>
<?php $this->session->set_flashdata('dataFilter', $dataFilter); ?>
<div class="card-header">
    <h4 class="card-title">Liste Panneaux <span id="countItem"><?php echo $count; ?></span></h4>
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
    <div class="card-block card-dashboard"></div>
    <div class="table-responsive" id="">
        <table id="tableData" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ref.</th>
                    <th>Format</th>
                    <th>Visuel actuel</th>
                    <th>Type</th>
                    <th>Province</th>
                    <th>Axe</th>
                    <th>Quartier</th>
                    <th>Régisseur</th>
                    <th>Date de pose</th>
                    <!-- <th>Emplacement</th> -->
                    <th class="all">Opérations</th>
                </tr>
            </thead>

            <tbody>     
                <?php foreach($result as $panneau): ?>
                    <tr>
                        <td><?php echo $panneau->id ?></td>
                        <td><?php echo $panneau->panneau_reference ?></td>
                        <td><?php echo $dataFilter["formats"][$panneau->panneau_format] ?></td>
                        <td><?php echo $panneau->panneau_visuel_actuel ?></td>
                        <td><?php echo $dataFilter["types"][$panneau->panneau_type] ?></td>
                        <td><?php echo $dataFilter["provinces"][$panneau->panneau_province] ?></td>
                        <td><?php echo $dataFilter["axes"][$panneau->panneau_axe] ?></td>
                        <td><?php echo $panneau->panneau_quartier ?></td>
                        <td><?php echo $dataFilter["regisseurs"][$panneau->panneau_regisseur] ?></td>
                        <!-- <td><?php //echo $panneau->panneau_emplacement ?></td> -->
                        <td><?php echo $panneau->panneau_date_pose ?></td>
                        <td>
                        	<?php echo anchor("panneau/view/".$panneau->id, '<i class="icon-eye" title="+ détails"></i>','data-view="'.$panneau->id.'"') ;?>&nbsp;
                        	<?php echo anchor("panneau/edit/".$panneau->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$panneau->id.'"') ;?>&nbsp;
                        	<?php echo anchor("panneau/delete/".$panneau->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$panneau->id.'" onclick="return false;"') ;?>

                        	<div class="modal fade text-xs-left" id="default-<?php echo $panneau->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            				  	<div class="modal-dialog" role="document">
            						<div class="modal-content">
            						  	<div class="modal-header">
            								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            								  <span aria-hidden="true">&times;</span>
            								</button>
            								<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
            						  	</div>
            						  	<div class="modal-body">
            								<p>Voulez-vous vraiment supprimer le panneau <b><?php echo $panneau->panneau_reference; ?></b> ?</p>
            						  	</div>
            						  	<div class="modal-footer">
            								<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
            								<a href="<?php echo base_url("panneau/delete/".$panneau->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
            						  	</div>
            						</div>
            				  	</div>
            				</div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="btnControls">
    <a href="<?php echo base_url("panneau/add") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouveau panneau</a>
    <a href="<?php echo base_url("panneau/export") ?>" target="_self" class="btn btn-success upgrade-to-pro" id="dataExport">Exporter XLS</a>
</div>

<!--<form class="form" id="exportdata">-->
    <input type="hidden" name="exportdata" value="<?php echo base64_encode(addslashes(json_encode($result))); ?>" />
<!--</form>-->
