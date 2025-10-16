<?php start_section('stylesheet'); ?>
<style>
.table-wrapper {
	border-spacing: 0 15px !important;
	border-collapse: separate !important;
}
.table-wrapper td,
.table-wrapper th {
	vertical-align: middle;
	border-bottom: 1px solid #dee2e6 !important;
}
.table-wrapper tbody tr td:first-child,
.table-wrapper thead tr th:first-child {
	border-left: 1px solid #dee2e6;
	border-top-left-radius: 4px;
	border-bottom-left-radius: 4px;
}
.table-wrapper tbody tr td:last-child,
.table-wrapper thead tr th:last-child {
	border-right: 1px solid #dee2e6;
	border-top-right-radius: 4px;
	border-bottom-right-radius: 4px;
}
.modal-dialog {
  max-width: 80%;
  margin: 1.75rem auto;
}

.modal-content {
  max-height: 90vh; /* hauteur max selon l’écran */
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.modal-body {
  overflow-y: auto; /* permet le scroll */
  flex: 1 1 auto;
  padding: 1.5rem;
}

.modal-footer {
  position: sticky;
  bottom: 0;
  background: white;
  border-top: 1px solid #dee2e6;
  z-index: 10;
}
	.budget{
		font-weight: 500;
	}


</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4 py-2">Onboarding</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?><?php end_section(); ?>

<?php start_section('content'); ?>
<?php //var_dump($onboarding); die(); ?>
<div class="container-fluid">
  <div class="row row-cols-2" style="position: sticky;">
					<div class="col" >
							<div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
                <label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="status_filter" value="all" checked>
                    All
                  </label>

                  <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="status_filter" value="nouveau">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #727272;"></i>
                    Nouveau client
                  </label>

                  <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="status_filter" value="upsell">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
                    Upsell
                  </label>

                  <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="status_filter" value="pause">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #B1AD1B;"></i>
                    Mise en pause
                  </label>

                  <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="status_filter" value="relance">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
                    Relance
                  </label>
             
						</div>
					</div>
					<div class="col" >
							<div class="form-group px-2" style="max-width: 300px;">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un client...">
					    </div>
				  </div>
        </div>


  
	<div class="tab-content" id="clientTabContent">
		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
			<div class="table-responsive">
				<table class="table table-wrapper">
					<thead class="bg-light text-muted">
						<tr>
							<th></th>
							<th>Client <img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
							<?php //if($current_users != 1): ?>
							<th>Déjà client ? <img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
							<th>Budget <img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
							<?php //endif; ?>
							<th>Member</th>
							<th>Gocardless</th>
							<th>Brief</th>
							<!-- <th>Envoi Str</th>
							<th>Validation Str</th> -->
							<th>Paiement</th>
							<!-- <th>Compte Ads</th> -->
							<th>DataStudio</th>
							<th>Annonce</th>
							<?php if($current_users != 1): ?>
								<th>Email</th>
								<th>Facturation</th>
							<?php endif; ?>
              <th>Status</th>
						</tr>
					</thead>
					<tbody>
            <?php //var_dump($onboarding); die(); ?>
						<?php foreach ($onboarding as $d): 
                  if (
                      $d->budget != 0 &&
                      !in_array($d->type_upsell, [10 , 5]) 
                  ):
              ?>

							<?php
              $status = 'unknown';
              if ($d->dejaclient == 0) {
                $status = 'nouveau';
              } else {
                switch ($d->type_upsell) {
                  case 1: $status = 'baisse'; break;
                  case 2: $status = 'upsell'; break;
                  case 4: $status = 'pause'; break;
                  case 5: $status = 'resiliation'; break; 
                  case 9: $status = 'relance'; break;
                  default: $status = 'autre'; break;
                }
              }
            ?>
            <tr data-type="<?= $status ?>">

								<!-- Menu actions -->
								<td>
									<div class="dropdown no-arrow">
										<a href="#" class="btn btn-light rounded-pill px-3 dropdown-toggle" data-toggle="dropdown">
											<i class="fa fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="#" 
												data-toggle="modal" data-target="#editModal"
												data-idclient="<?= $d->idclients; ?>"
                        data-idupsell="<?= $d->idupsell; ?>"
												data-idonboarding="<?= $d->idonboarding; ?>"
												data-nom="<?= htmlspecialchars($d->nom_client); ?>"
												data-site="<?= htmlspecialchars($d->site_client); ?>"

												
                        <?php if($d->budgets == 0): ?>
                         data-budget="<?= $d->budget; ?>"
                        <?php endif; ?>
                        <?php if($d->budgets != 0): ?>
                        data-budget="<?= $d->budgets; ?>"
                        <?php endif; ?>
                    
												data-secteur="<?= htmlspecialchars($d->secteur_activite); ?>"
												data-produit="<?= $d->idproduit; ?>"
												data-produit-label="<?= htmlspecialchars($d->label_produit); ?>"
												data-initiative="<?= htmlspecialchars($d->initiative); ?>"
												data-account-manager="<?= htmlspecialchars($d->account_manager); ?>"
												data-paiement="<?= $d->mis_en_place_paiement; ?>"
												data-brief="<?= $d->Brief; ?>"
												data-annonce="<?= $d->annonce; ?>"
												data-paiement-recu="<?= $d->paiement_recu; ?>"
												data-email-onboarding="<?= $d->email_onboarding; ?>"
												data-facturation="<?= $d->facturation; ?>"
												data-datastudio="<?= $d->datastudio; ?>"
                        data-statut_upsell="<?= $d->statut_upsell; ?>"
											>Modifier</a>
										</div>
									</div>
								</td>

								<!-- Client -->
								<td>
                  <?php //var_dump($d->type_upsell); ?>
									<a href="<?= base_url('Client/detail_client/' . $d->idclients) ?>"  class="d-flex align-items-center text-decoration-none text-dark">
										<img src="<?= $d->favicon ?>" class="img-thumbnail" width="28" height="28" alt="Favicon" style="margin-right:8px;">
										<?= htmlspecialchars($d->nom_client) ?>
									</a>
								</td>

								<?php //if($current_users != 1): ?>
								<td>
									<?php if ($d->dejaclient == 0): ?>
										<span class="badge alert-warning px-2 py-1" style="color: #727272; background-color: #eae7e79e">Nouveau client</span>
									<?php else: ?>
										<?php if ($d->type_upsell == 2): ?>
											<span class="badge alert-success px-2 py-1">Upsell</span>
										<?php elseif ($d->type_upsell == 1): ?>
											<span class="badge alert-danger px-2 py-1">Baisse</span>
                      <?php elseif ($d->type_upsell == 4): ?>
											<span class="badge alert-warning px-2 py-1">Mise en pause</span>
                      <?php elseif ($d->type_upsell == 5): ?>
											<span class="badge alert-danger px-2 py-1">Résiliation</span>
                      <?php elseif ($d->type_upsell == 9): ?>
											<span class="badge alert-success px-2 py-1">Relance</span>
										<?php endif; ?>
									<?php endif; ?>
								</td>


									<td>
                    <div class="budget">
                    <?php if($current_user->tech == 3): ?>
                    <?php if($d->budgets == 0): ?>
                    <?= round($d->budget, 2) ?> €
                    <?php endif; ?>
                    <?php if($d->budgets != 0): ?>
                    <?= round($d->budgets, 2) ?> €
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($current_user->tech != 3): ?>
                    <?php if($d->budgets == 0): ?>
                    <?= round(($d->budget / 2) / 30.6, 2) ?> €
                    <?php endif; ?>
                    <?php if($d->budgets != 0): ?>
                    <?= round(($d->budgets / 2) / 30.6, 2) ?> €
                    <?php endif; ?>
                    <?php endif; ?>
                    </div>  
                  </td>
								<td>
									<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->tech_photo_user)); ?>" width="28" height="28">
									<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d->am_photo_user)); ?>" width="28" height="28">
								</td>

								<td><?= (!empty($d->mis_en_place_paiement) && $d->mis_en_place_paiement != '0000-00-00') ? htmlspecialchars($d->mis_en_place_paiement) : '-' ?></td>

                <td><?= (!empty($d->Brief) && $d->Brief != '0000-00-00') ? htmlspecialchars($d->Brief) : '-' ?></td>

                <!-- <td>(!empty($d->date_validation_structure) && $d->date_validation_structure != '0000-00-00') ? htmlspecialchars($d->date_validation_structure) : '-' ?></td>

                <td> (!empty($d->validation_technique) && $d->validation_technique != '0000-00-00') ? anchor('Validation/validation_structure/' . $d->idclients, $d->validation_technique, ['target' => '_blank']) : '-' ?></td>
                -->        
                <td><?= $d->paiement_recu ? 'Oui' : 'Non' ?></td>

                <!-- <td> (!empty($d->Céation_compte_ads) && $d->Céation_compte_ads != '0000-00-00') ? htmlspecialchars($d->Céation_compte_ads) : 'Ajouter date' ?></td>
                -->       
                <td><?= $d->datastudio ? 'Oui' : 'Non' ?></td>

                <td><?= (!empty($d->annonce) && $d->annonce != '0000-00-00') ? htmlspecialchars($d->annonce) : '-' ?></td>

								<?php if($current_users != 1): ?>
									<td><?= $d->email_onboarding ? 'Oui' : 'Non' ?></td>
									<td><?= $d->facturation ? 'Oui' : 'Non' ?></td>
								<?php endif; ?>
                <td>
                  <?php if($d->statut_upsell == 0): ?>
                    <span class="badge alert-warning px-2 py-1">En attente</span>
                  <?php endif; ?> 
                  <?php if($d->statut_upsell == 1): ?>
                    <span class="badge alert-success px-2 py-1">En ligne</span>
                  <?php endif; ?>  
                </td>
							</tr>
						<?php endif; endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ÉDITION -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">

    <div class="modal-content">
      <form method="POST" action="<?= base_url('Onboarding/updateDonneeClient') ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Modifier Client</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_idclient" name="idclient">
          <input type="hidden" id="edit_idupsell" name="idupsell">
          <input type="hidden" id="edit_idonboarding" name="idonboarding">
          <div class="form-row">
            <div class="form-group col">
              <label>Nom</label>
              <input type="text" id="edit_Client" name="Client" class="form-control">
            </div>
            <div class="form-group col">
              <label>Site client</label>
              <input type="url" id="edit_Site_client" name="Site_client" class="form-control">
            </div>
          </div>
		  <!--
          <div class="form-row">
            <div class="form-group col">
              <label>Email</label>
              <input type="email" id="edit_Email_client" name="Email_client" class="form-control">
            </div>
            <div class="form-group col">
              <label>Numéro</label>
              <input type="text" id="edit_Numero_client" name="Numero_client" class="form-control">
            </div>
          </div>
		-->
            <div class="form-group">
              <label>Budget HT</label>
              <input type="number" id="edit_budget" name="budget" class="form-control">
            </div>
		  <!--
           <div class="form-group col">
              <label>Secteur d'activité</label>
              <input type="text" id="edit_secteur_activite" name="secteur_activite" class="form-control">
            </div>
            	 -->		
          <div class="form-group"  style="display: none;">
            <label>Produit</label>
            <select name="Produit" id="edit_Produit" class="form-control"></select>
          </div>
					
		  <div class="form-row" style="display: none;">
          <div class="form-group col">
            <label>Initiative</label>
            <select name="Initiative" id="edit_Initiative" class="form-control"></select>
          </div>
          <div class="form-group col">
            <label>Account Manager</label>
            <select name="Am" id="edit_Am" class="form-control"></select>
          </div>
		  </div>
     
          <div class="form-row">
            <div class="form-group col">
              <label>Mise en place paiement</label>
              <input type="date" id="edit_mis_en_place_paiement" name="mis_en_place_paiement" class="form-control">
            </div>
            <div class="form-group col">
              <label>Brief</label>
              <input type="date" id="edit_Brief" name="Brief" class="form-control">
            </div>
            <div class="form-group col">
              <label>Date de mise en ligne</label>
              <input type="date" id="edit_annonce" name="annonce" class="form-control">
            </div>
          </div>
		  <!--
          <div class="form-group">
            <label>Commentaire client</label>
            <textarea id="edit_commentaire_client" name="commentaire_client" class="form-control" rows="3"></textarea>
          </div>
								-->
          <div class="form-row">
            <div class="form-group col">
              <label>Paiement reçu</label>
              <select id="edit_paiement_recu" name="paiement_recu" class="form-control">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
            <div class="form-group col">
              <label>Email Onboarding</label>
              <select id="edit_email_onboarding" name="email_onboarding" class="form-control">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
            <div class="form-group col">
              <label>Facturation</label>
              <select id="edit_facturation" name="facturation" class="form-control">
                <option value="1">Oui</option>
                <option value="0">Non</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>DataStudio</label>
            <select id="edit_datastudio" name="datastudio" class="form-control">
              <option value="1">Oui</option>
              <option value="0">Non</option>
            </select>
          </div>
          <div class="form-group">
            <label>Statut</label>
            <select id="edit_statut_upsell" name="statut_upsell" class="form-control">
              <option value="0">En attente</option>
              <option value="1">En ligne</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark px-3">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const statusInputs = document.querySelectorAll('.status-select');
  const rows = document.querySelectorAll('tbody tr');
  const searchInput = document.getElementById('searchInput');

  function filterRows() {
    const selectedStatus = Array.from(statusInputs)
      .filter(input => input.checked)
      .map(input => input.value);

    const searchTerm = searchInput.value.toLowerCase();

    rows.forEach(row => {
      const type = row.getAttribute('data-type');
      const textContent = row.textContent.toLowerCase();

      const matchesStatus = selectedStatus.includes('all') || selectedStatus.includes(type);
      const matchesSearch = textContent.includes(searchTerm);

      if (matchesStatus && matchesSearch) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  statusInputs.forEach(input => {
    input.addEventListener('change', filterRows);
  });

  searchInput.addEventListener('input', filterRows);

  // Initial display
  filterRows();
});
</script>



<script>
$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var modal = $(this);

  modal.find('#edit_idclient').val(button.data('idclient'));
  modal.find('#edit_idupsell').val(button.data('idupsell'));
  modal.find('#edit_idonboarding').val(button.data('idonboarding'));
  modal.find('#edit_Client').val(button.data('nom'));
  modal.find('#edit_Site_client').val(button.data('site'));
  modal.find('#edit_budget').val(button.data('budget'));
  modal.find('#edit_secteur_activite').val(button.data('secteur'));

  modal.find('#edit_Produit').html(`<option value="${button.data('produit')}" selected>${button.data('produit-label')}</option>`);
  modal.find('#edit_Initiative').html(`<option value="${button.data('initiative')}" selected>${button.data('initiative')}</option>`);
  modal.find('#edit_Am').html(`<option value="${button.data('account-manager')}" selected>${button.data('account-manager')}</option>`);

  modal.find('#edit_mis_en_place_paiement').val(button.data('paiement'));
  modal.find('#edit_Brief').val(button.data('brief'));
  modal.find('#edit_annonce').val(button.data('annonce'));

  modal.find('#edit_paiement_recu').val(button.data('paiement-recu'));
  modal.find('#edit_email_onboarding').val(button.data('email-onboarding'));
  modal.find('#edit_facturation').val(button.data('facturation'));
  modal.find('#edit_datastudio').val(button.data('datastudio'));
  modal.find('#edit_statut_upsell').val(button.data('statut_upsell'));
});
</script>
<?php end_section(); ?>
