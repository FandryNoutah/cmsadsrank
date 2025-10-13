<div class="modal fade" id="briefModal" tabindex="-1" aria-labelledby="briefModalLabel" aria-hidden="true">
	<form  action="<?php echo base_url("Client/ajout_brief") ?>" enctype="multipart/form-data" method="post">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="briefModalLabel">Ajouter Brief</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<input type="hidden" name="idclients" value="<?= $donnees[0]['idclients'] ?>">
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="brief">Brief</label>
						<textarea name="information_client" id="brief" rows="2" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">Ajouter</button>
				</div>
			</div>
		</div>
	</form>
</div>
