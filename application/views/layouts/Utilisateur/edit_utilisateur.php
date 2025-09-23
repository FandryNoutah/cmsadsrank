<?php start_section('stylesheet'); ?>

<?php end_section(); ?>

<?php start_section('page_title'); ?>
<p class="my-2">
	Edit utilisateur
</p>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
			<form id="validationForm" action="<?= site_url('Utilisateur/modifier'); ?>" method="post" enctype="multipart/form-data">

				<?php foreach ($users as $u): ?>
					<div class="form-row">
						<input type="hidden" name="id" value="<?= $u['id']; ?>">

						<div class="form-group col">
							<label for="edit_first_name">Prénom</label>
							<input type="text" id="edit_first_name" name="first_name" value="<?= htmlspecialchars($u['first_name']); ?>" class="form-control">
						</div>

						<div class="form-group col">
							<label for="edit_last_name">Nom</label>
							<input type="text" id="edit_last_name" name="last_name" value="<?= htmlspecialchars($u['last_name']); ?>" class="form-control">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="edit_username">Login</label>
							<input type="text" id="edit_username" name="username" value="<?= htmlspecialchars($u['username']); ?>" class="form-control">
						</div>

						<div class="form-group col">
							<label for="edit_email">Email</label>
							<input type="email" id="edit_email" name="email" value="<?= htmlspecialchars($u['email']); ?>" class="form-control">
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col">
							<label for="edit_phone">Numéro</label>
							<input type="tel" id="edit_phone" name="phone" value="<?= htmlspecialchars($u['phone']); ?>" class="form-control">
						</div>

						<div class="form-group col">
							<label for="edit_color">Couleur actuelle</label>
							<div class="d-flex align-items-center">
								<input type="color" id="edit_color" name="couleur"
									value="<?= htmlspecialchars($u['couleur']); ?>" class="form-control" style="width: 60px; padding: 0;">
								<div style="width: 30px; height: 30px; background-color: <?= htmlspecialchars($u['couleur']); ?>; margin-left: 10px; border: 1px solid #ccc;"></div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label for="photo">Photo de profil</label>
							<input type="file" name="photo_users" id="photo" class="form-control-file">

							<?php if (!empty($u['photo_users'])): ?>
								<div class="mt-2">
									<img src="<?= base_url('assets/images' . $u['photo_users']); ?>" alt="Photo actuelle" style="max-height: 100px;">
								</div>
							<?php endif; ?>
						</div>

					</div>			
					<div class="modal-footer">
						<button type="submit" class="btn btn-dark px-3">Enregistrer</button>
					</div>
				<?php endforeach; ?>
			</form>

			</div>

<?php end_section(); ?>
