<?php foreach ($donnees as $d): ?>
	<form action="<?= base_url("Client/creer_upsell") ?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">

		<input type="hidden" value="<?= $d['idclients']; ?>" name="client">

		<div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="budgetModalLabel">Demande Upsell - Baisse</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="budget_type">Type</label>
							<select name="type_upsell" id="budget_type" class="form-control" required>
								<option value="">Séléctionner type</option>
								<option value="2">Upsell - création de nouvelle campagne</option>
								<option value="1">Baisse de budget</option>
								<option value="3">Booster (NE FONCTIONNE PAS ENCORE)</option>
							</select>

						</div>

						<div class="form-group">
							<label for="budget_client">Client</label>
							<input type="text" readonly value="<?= $d['nom_client']; ?>" class="form-control">
						</div>

						<div class="form-group">
							<label for="budget_initial">Budget Initiale</label>
							<?php if(empty($budget_initial[0]->budgets)): 
								$budget_initial = $d['budget']; 
							endif;  ?>
							<?php if(!empty($budget_initial[0]->budgets)): 
								$budget_initial = $budget_initial[0]->budgets; 
							endif;  ?>
							<input type="text" readonly name="budget_initiale" id="budget_initial" class="form-control" value="<?= $budget_initial; ?> €">
						</div>

						<div class="form-group">
							<label for="budget">Budget</label>
							<input type="number" name="budget_upsell" id="budget" class="form-control">
						</div>

						<div class="form-group" style="display: none">
							<label for="am_select">AM</label>
							<select name="am" id="budget_type" class="form-control">
								<option value="<?= $d['account_manager'] ?>">AM></option>
							</select>
						</div>

						<div class="form-group" style="display: none">
							<label for="am_select">TM</label>
							<select name="tm" id="budget_type" class="form-control">
								<option value="<?= $d['initiative'] ?>">TM></option>
								<?php foreach ($users as $u): ?>
									<option value="<?= $d->tm; ?>">
										<?= $u->first_name; ?> <?= $u->last_name; ?>
									</option>
									<?php if($u->tech == 1): ?>
									<option value="<?= $d->account_manager; ?>">
										<?= $u->first_name; ?> <?= $u->last_name; ?>
									</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="budget_date_demand">Date de mise en place du paiement</label>
							<input type="date" name="date_demande_upsell" id="budget_date_demand" class="form-control">
						</div>
						<script>
							document.addEventListener("DOMContentLoaded", function () {
								const today = new Date().toISOString().split('T')[0];
								document.getElementById("budget_date_demand").value = today;
							});
						</script>
						<div class="form-group">
							<label for="budget_date_demand">Date Brief</label>
							<input type="date" name="date_brief" id="budget_date_demand" class="form-control">
						</div>			
						<div class="form-group">
							<label for="budget_date_upsell">Date annonce en ligne</label>
							<input type="date" name="date_upsell" id="budget_date_upsell" class="form-control">
						</div>

						<div class="form-group">
							<label for="budget_information">Information</label>
							<textarea name="information_upsell" id="budget_information" rows="2" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="budget_status">Statut</label>
							<select name="statut_upsell" id="budget_status" class="form-control">
								<option value="planifier">Planifier</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-dark btn-block">Sauvegarder</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php endforeach; ?>
