<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" style="max-width: 600px;">
		<div class="modal-content p-3">
			<div class="card overflow-auto">
				<div class="modal-header">
					<h5 class="modal-title" id="clientModalLabel" style="font-size: 20px;">Ajouter client</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Nom client</label>
						<input type="text" class="form-control h-auto py-3" placeholder="Entrer nom client" id="name" name="name">
					</div>
					<div class="form-group">
						<label for="website">Site internet</label>
						<input type="text" class="form-control h-auto py-3" placeholder="Entrer l'url du client" id="website" name="website">
					</div>
					<div class="form-group">
						<label for="email">Email client</label>
						<input type="email" class="form-control h-auto py-3" placeholder="Entrer l'adresse email du client" id="email" name="email">
					</div>
					<div class="form-group">
						<label for="budget">Budget</label>
						<input type="number" class="form-control h-auto py-3" placeholder="Entrer le budget du client" id="budget" name="budget">
					</div>
					<div class="form-group">
						<label for="product">Produit</label>
						<select class="form-control h-auto py-3" name="product" id="product">
							<option>Google Ads</option>
							<option>GTM</option>
							<option>Microsoft Ads</option>
							<option>Social Media</option>
						</select>
					</div>
					<div class="form-group">
						<label for="initiative">Initiative</label>
						<select class="form-control h-auto py-3" name="initiative" id="initiative">
							<option selected disabled>Sélectionner Initiative</option>
							<option>Admin</option>
							<option>Michael</option>
							<option>Mavreen</option>
						</select>
					</div>
					<div class="form-group">
						<label for="initiative">Account manager</label>
						<select class="form-control h-auto py-3" name="initiative" id="initiative">
							<option selected disabled>Sélectionner AM</option>
							<option>Admin</option>
							<option>Michael</option>
							<option>Mavreen</option>
						</select>
					</div>
					<div class="form-group">
						<label for="payment_date">Date de mise en place du paiement</label>
						<input type="date" class="form-control h-auto py-3" name="payment_date" id="payment_date">
					</div>
					<div class="form-group">
						<label for="brief_date">Date Brief</label>
						<input type="date" class="form-control h-auto py-3" name="brief_date" id="brief_date">
					</div>
					<div class="form-group">
						<label for="announce_date">Date annonce en ligne</label>
						<input type="date" class="form-control h-auto py-3" name="announce_date" id="announce_date">
					</div>

					<div class="row">
						<div class="col">
							<button class="btn btn-light btn-block">Annuler</button>
						</div>
						<div class="col">
							<button class="btn btn-dark btn-block">Confirmer</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
