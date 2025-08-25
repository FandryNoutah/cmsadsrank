<div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="budgetModalLabel">Créer Upsell - Baisse</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url("Client/creer_upsell") ?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="budget_type">Type</label>
					<select name="type_upsell" id="budget_type" class="form-control">
						<option value="">Séléctionner type</option>
						<option value="1">Baisse de budget</option>
						<option value="2">Upsell - création de nouvelle campagne</option>
						<option value="3">Baisse de budget</option>
					</select>
				</div>
				<input type="hidden" value="<?php echo $donnees['idclients']; ?>" name="client">
				<div class="form-group">
					<label for="budget_client">Client</label>
					<input type="text" readonly value="<?php echo $donnees['nom_client']; ?>" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget_initial">Budget Initiale</label>
					<input type="text" readonly name="budget_initiale" id="budget_initial" class="form-control" value="<?php echo $budget_initial[0]->budgets; ?> €">
				</div>

				<div class="form-group">
					<label for="budget">Budget</label>
					<input type="number" name="budget_upsell" id="budget" class="form-control">
				</div>
				<div class="form-group">
					<label for="am_select">AM</label>
					<select name="am" id="budget_type" class="form-control">
						<?php foreach($users as $u): ?>
                                    <option value="<?php echo $u->id; ?>">
                                        <?php echo $u->first_name; ?> <?php echo $u->last_name; ?> 
                                    </option>
                        <?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="am_select">TM</label>
					<select name="tm" id="budget_type" class="form-control">
						<?php foreach($users as $u): ?>
                                    <option value="<?php echo $u->id; ?>">
                                        <?php echo $u->last_name; ?> <?php echo $u->first_name; ?>
                                    </option>
                        <?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="budget_date_demand">Date de demande</label>
					<input type="date" name="date_demande_upsell" id="budget_date_demand" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget_date_upsell">Date Upsell / Baisse</label>
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
				<input type="submit" class="btn btn-dark btn-block" value="Sauvegarder"></input>
			</div>
			</form>
		</div>
	</div>
</div>
