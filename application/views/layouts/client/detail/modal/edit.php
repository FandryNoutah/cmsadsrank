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
			<form method="post" action="<?= site_url('Client/update_info_client'); ?>">
			<input type="hidden" name="id_client" value="<?= $d['idclients']; ?>">
				<div class="form-row">
					<div class="form-group col">
						<label for="edit_name">Nom</label>
						<input type="text" value="<?= $d['nom_client']; ?>" id="edit_name" name="edit_name" class="form-control">
					</div>
					<div class="form-group col">
						<label for="edit_email">Email</label>
						<input type="email" value="<?= $d['email_client']; ?>" id="edit_email" name="edit_email" class="form-control">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col">
						<label for="edit_number">Numéro</label>
						<input type="number" value="<?= $d['numero_client']; ?>" id="edit_number" name="edit_number" class="form-control">
					</div>
					<div class="form-group col">
						<label for="edit_site">Site client</label>
						<input type="url" value="<?= $d['site_client']; ?>" id="edit_site" name="edit_site" class="form-control">
					</div>
				</div>


				<div class="form-group">
					<label for="edit_commentaire">Information client</label>
					<textarea name="info_base_client" id="info_base_client" rows="8" class="form-control"><?= $d['info_base_client']; ?></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-dark px-3" value="Enregistrer">

			</div>
			</form>
		</div>
	</div>
</div>
