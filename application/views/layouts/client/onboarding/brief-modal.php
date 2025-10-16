<div class="modal fade" id="briefModal" tabindex="-1" aria-labelledby="briefModalLabel" aria-hidden="true">
	<form action="<?= base_url("Client/ajout_brief") ?>" enctype="multipart/form-data" method="POST">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="briefModalLabel"><?= empty($d['information_client']) ? "Ajouter Brief" : "Modifier Brief" ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<input type="hidden" name="idclients" value="<?= $donnees[0]['idclients'] ?>">
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="brief">Brief</label>
						<textarea name="information_client" id="brief" rows="10" class="form-control"><?php if (!empty($d['information_client'])) echo $d['information_client']; ?></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">
						<?= empty($d['information_client']) ? "Ajouter" : "Modifier" ?>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
