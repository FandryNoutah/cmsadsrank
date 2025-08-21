
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
				<form action="<?php echo base_url("Client/insert_client") ?>" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Nom client</label>
						<input type="text" class="form-control" placeholder="Entrer nom client" id="name" name="client">
					</div>
					<div class="form-group">
						<label for="website">Site internet</label>
						<input type="text" class="form-control" placeholder="Entrer l'url du client" id="website" name="site_client">
					</div>
					<div class="form-group">
						<label for="email">Email client</label>
						<input type="email" class="form-control" placeholder="Entrer l'adresse email du client" id="email" name="email_client">
					</div>
					<div class="form-group">
						<label for="email">Numéro du client</label>
						<input type="numero_client" class="form-control" placeholder="Entrer le numéro du client" id="numero_client" name="numero_client">
					</div>
					<div class="form-group">
						<label for="budget">Budget</label>
						<input type="number" class="form-control" placeholder="Entrer le budget du client" id="budget" name="budget">
					</div>
					<div class="form-group">
						<label for="product">Produit</label>
						<select class="form-control" name="product_choice" id="product">
							<?php foreach($produit as $d): ?>
							<option value="<?php echo $d->idproduit ?>"><?php echo $d->label_produit ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="initiative">Initiative</label>
						<select class="form-control" name="initiative" id="initiative">
							<option selected disabled>Sélectionner Initiative</option>
							<?php foreach($users as $u): ?>
							<option value="<?php echo $u->id ?>"><?php echo $u->first_name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="initiative">Account manager</label>
						<select class="form-control" name="am" id="initiative">
							<option selected disabled>Sélectionner AM</option>
							<?php foreach($users as $u): ?>
							<option value="<?php echo $u->id ?>"><?php echo $u->first_name ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="payment_date">Date de mise en place du paiement</label>
						<input type="date" class="form-control" name="date_mis_en_place" id="payment_date">
					</div>
					<div class="form-group">
						<label for="brief_date">Date Brief</label>
						<input type="date" class="form-control" name="date_brief" id="brief_date">
					</div>
					<div class="form-group">
						<label for="announce_date">Date annonce en ligne</label>
						<input type="date" class="form-control" name="date_annonce" id="announce_date">
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
				</form>
			</div>
		</div>
	</div>
</div>
