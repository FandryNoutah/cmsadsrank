<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
	<form enctype="multipart/form-data" method="post">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<?php $current_user = $this->ion_auth->user()->row(); ?>
				<input type="hidden" name="am" value="<?php echo $current_user->id ?>">
				<div class="modal-header">
					<h5 class="modal-title" id="formModalLabel">Statut GTM</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="donnee">Société</label>
						<select name="donnee" id="donnee" class="form-control">
							<?php foreach ($donnee as $d): ?>
								<?php if ($d->budget != 0) : ?>

									<option value="<?= $d->idclients; ?>"><?= $d->nom_client; ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="date_demande">Date de la demande</label>
						<input type="date" name="date_demande" id="date_demande" class="form-control">
					</div>

					<div class="form-group">
						<label for="invite_receipt">Invitation reçu</label>
						<input type="date" name="invite_receipt" id="invite_receipt" class="form-control">
					</div>

					<div class="form-group">
						<label for="mep_gtm">Mise en place GTM</label>
						<input type="text" name="mep_gtm" id="mep_gtm" class="form-control">
					</div>

					<div class="form-group">
						<label for="technique">Technique</label>
						<input type="text" name="technique" id="technique" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-dark px-3">Ajouter</button>
				</div>
			</div>
		</div>
	</form>
</div>
