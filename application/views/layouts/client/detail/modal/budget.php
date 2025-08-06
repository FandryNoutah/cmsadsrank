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

				<div class="form-group">
					<label for="budget_type">Type</label>
					<select name="budget_type" id="budget_type" class="form-control">
						<option value="">Séléctionner type</option>
						<option value="1">Baisse de budget</option>
						<option value="2">Upsell - création de nouvelle campagne</option>
						<option value="3">Baisse de budget</option>
					</select>
				</div>

				<div class="form-group">
					<label for="budget_client">Client</label>
					<input type="text" readonly value="Client name" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget_initial">Budget Initiale</label>
					<input type="number" name="budget_initial" id="budget_initial" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget">Budget</label>
					<input type="number" name="budget" id="budget" class="form-control">
				</div>
				<div class="form-group">
					<label for="am_select">AM</label>
					<select name="am_select" id="budget_type" class="form-control">
						<?php foreach($users as $u): ?>
                                    <option value="<?php echo $u['id']; ?>">
                                        <?php echo $u['last_name']; ?> <?php echo $u['first_name']; ?>
                                    </option>
                        <?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="budget_date_demand">Date de demande</label>
					<input type="month" name="budget_date_demand" id="budget_date_demand" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget_date_upsell">Date Upsell / Baisse</label>
					<input type="month" name="budget_date_upsell" id="budget_date_upsell" class="form-control">
				</div>

				<div class="form-group">
					<label for="budget_information">Information</label>
					<textarea name="budget_information" id="budget_information" rows="2" class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label for="budget_status">Statut</label>
					<select name="budget_status" id="budget_status" class="form-control">
						<option value="planifier">Planifier</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark btn-block">Sauvegarder</button>
			</div>
		</div>
	</div>
</div>
