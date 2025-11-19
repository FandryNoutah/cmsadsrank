<div class="modal fade" id="changestatutbudget" tabindex="-1" role="dialog" aria-labelledby="changestatutbudgetLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-header bg-primary text-white">
		<h5 class="modal-title" id="changestatutbudgetLabel">
		  <i class="fa fa-exchange-alt mr-2"></i> Changer le statut du budget
		</h5>
		<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>

	  <form id="formChangeStatut" method="post" action="<?= site_url('Client/change_statut_budget'); ?>">

		<div class="modal-body">
		  <input type="hidden" name="idupsell" id="idupsell">

		  <div class="form-group">
			<label for="statut_actif">Nouveau statut :</label>
			<select name="statut_actif" id="statut_actif" class="form-control" required>
			  <option value="">-- Sélectionner un statut --</option>
			  <option value="2">Programmer</option>
			  <option value="0">En attente</option>
			  <option value="1">En ligne</option>
			</select>
		  </div>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
		  <button type="submit" class="btn btn-primary">Enregistrer</button>
		</div>
	  </form>
	</div>
  </div>
</div>

