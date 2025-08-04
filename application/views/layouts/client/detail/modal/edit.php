<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editModalLabel">Modifier Client</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_name">Nom</label>
						<input type="text" value="Test" id="edit_name" name="edit_name" class="form-control">
					</div>
					<div class="form-group col">
						<label for="edit_email">Email</label>
						<input type="email" value="mavreen.bassin@adsrank.fr" id="edit_email" name="edit_email" class="form-control">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_number">Numéro</label>
						<input type="number" value="09999999" id="edit_number" name="edit_number" class="form-control">
					</div>
					<div class="form-group col">
						<label for="edit_site">Site client</label>
						<input type="url" value="fairlkink.fr" id="edit_site" name="edit_site" class="form-control">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_budget">Budget</label>
						<input type="number" value="4500" id="edit_budget" name="edit_budget" class="form-control">
					</div>
					<div class="form-group col">
						<label for="edit_activity_sector">Secteur d'activité</label>
						<input type="email" value="Entreprise de Travaux" id="edit_activity_sector" name="edit_activity_sector" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<label for="edit_commentaire">Commentaire client</label>
					<textarea name="edit_commentaire" id="edit_commentaire" rows="2" class="form-control">Campagne en pause</textarea>
				</div>

				<div class="form-group">
					<label for="edit_produit">Produit</label>
					<select name="edit_produit" id="edit_produit" class="form-control">
						<option value="">Google Ads (Actuellement)</option>
						<option value="">GTM</option>
					</select>
				</div>

				<div class="form-group">
					<label for="edit_initiative">Initiative</label>
					<select name="edit_initiative" id="edit_initiative" class="form-control">
						<option value="">Mavreen Bassin (Actuellement)</option>
						<option value="">Admin</option>
					</select>
				</div>

				<div class="form-group">
					<label for="edit_account_manager">Account Manager</label>
					<select name="edit_account_manager" id="edit_account_manager" class="form-control">
						<option value="">Audrey Adsrank (Actuellement)</option>
						<option value="">Admin</option>
					</select>
				</div>

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_payment_date">Mise en place paiement</label>
						<input type="month" name="edit_payment_date" id="edit_payment_date" class="form-control">
					</div>

					<div class="form-group col">
						<label for="edit_brief">Brief</label>
						<input type="month" name="edit_brief" id="edit_brief" class="form-control">
					</div>

					<div class="form-group col">
						<label for="edit_online_date">Date de mise en ligne</label>
						<input type="month" name="edit_online_date" id="edit_online_date" class="form-control">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_payment_received">¨Paiement reçu</label>
						<select name="edit_payment_received" id="edit_payment_received" class="form-control">
							<option value="">Non (Actuellement)</option>
							<option value="">Oui</option>
							<option value="">Non</option>
						</select>
					</div>
					<div class="form-group col">
						<label for="edit_email_onboarding">Email Onboarding</label>
						<select name="edit_email_onboarding" id="edit_email_onboarding" class="form-control">
							<option value="">Non (Actuellement)</option>
							<option value="">Oui</option>
							<option value="">Non</option>
						</select>
					</div>
					<div class="form-group col">
						<label for="edit_facturation">Facturation</label>
						<select name="edit_facturation" id="edit_facturation" class="form-control">
							<option value="">Non (Actuellement)</option>
							<option value="">Oui</option>
							<option value="">Non</option>
						</select>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-lg-4">
						<h5>Technique</h5>
						<label for="edit_datastudio">DataStudio</label>
						<select name="edit_datastudio" id="edit_datastudio" class="form-control">
							<option value="planifier">Planifier</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success rounded-pill px-3">Enregistrer</button>
			</div>
		</div>
	</div>
</div>
