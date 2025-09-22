<?php start_section('page_title'); ?>
<?php if ($is_compta != 2): ?>
	Liste des demandes de congé
<?php endif; ?>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<?php if ($is_compta != 2 && !$is_validator): ?>
	<button class="btn btn-primary" data-toggle="modal" data-target="#demandeModal">
		Faire une demande
	</button>
<?php endif; ?>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
	<div class="table-responsive">
		<table class="table table-wrapper">
			<thead class="bg-light">
				<tr>
					<th>Nom</th>
					<th>Date début</th>
					<th>Date fin</th>
					<th>Motif</th>
					<th>Nbr jours</th>
					<th>État</th>
					<?php if ($is_validator): ?>
						<th>Commentaire</th>
						<th>Action</th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php if ($is_compta == 2): ?>
					<?php foreach ($demandes_valider as $d): ?>
						<tr>
							<td><?= htmlspecialchars($d->first_name . ' ' . $d->last_name) ?></td>
							<td><?= htmlspecialchars($d->date_debut) ?></td>
							<td><?= htmlspecialchars($d->date_fin) ?></td>
							<td><?= htmlspecialchars($d->motif) ?></td>
							<td><?= htmlspecialchars($d->nbr_jour) ?></td>
							<td><?= htmlspecialchars($d->etat) ?></td>
							<?php if ($is_validator): ?>
								<td><?= htmlspecialchars($d->commentaire_validation ?? '-') ?></td>
								<?php if ($d->etat == "valide"): ?>
									<td>
										Validé
									</td>
								<?php endif; ?>
	
								<?php if ($d->etat != "valide"): ?>
									<td>
										<button type="button"
											class="btn btn-sm btn-info"
											data-toggle="modal"
											data-target="#validationModal"
											data-id="<?= $d->id ?>"
											data-nom="<?= htmlspecialchars($d->first_name . ' ' . $d->last_name, ENT_QUOTES) ?>"
											data-date_debut="<?= $d->date_debut ?>"
											data-date_fin="<?= $d->date_fin ?>"
											data-motif="<?= htmlspecialchars($d->motif, ENT_QUOTES) ?>"
											data-etat="<?= $d->etat ?>"
											data-commentaire="<?= htmlspecialchars($d->commentaire_validation ?? '', ENT_QUOTES) ?>">
											Valider
										</button>
									</td>
								<?php endif; ?>
	
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if ($is_compta != 2): ?>
					<?php foreach ($demandes as $d): ?>
						<tr>
							<td><?= htmlspecialchars($d->first_name . ' ' . $d->last_name) ?></td>
							<td><?= htmlspecialchars($d->date_debut) ?></td>
							<td><?= htmlspecialchars($d->date_fin) ?></td>
							<td><?= htmlspecialchars($d->motif) ?></td>
							<td><?= htmlspecialchars($d->nbr_jour) ?></td>
							<td><?= htmlspecialchars($d->etat) ?></td>
							<?php if ($is_validator): ?>
								<td><?= htmlspecialchars($d->commentaire_validation ?? '-') ?></td>
								<?php if ($d->etat == "valide"): ?>
									<td>
										Validé
									</td>
								<?php endif; ?>
	
								<?php if ($d->etat != "valide"): ?>
									<td>
										<button type="button"
											class="btn btn-sm btn-info"
											data-toggle="modal"
											data-target="#validationModal"
											data-id="<?= $d->id ?>"
											data-nom="<?= htmlspecialchars($d->first_name . ' ' . $d->last_name, ENT_QUOTES) ?>"
											data-date_debut="<?= $d->date_debut ?>"
											data-date_fin="<?= $d->date_fin ?>"
											data-nbr_jour="<?= $d->nbr_jour ?>"
											data-motif="<?= htmlspecialchars($d->motif, ENT_QUOTES) ?>"
											data-etat="<?= $d->etat ?>"
											data-commentaire="<?= htmlspecialchars($d->commentaire_validation ?? '', ENT_QUOTES) ?>">
											Valider
										</button>
									</td>
								<?php endif; ?>
	
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?php
	if (!$is_validator) {
		$this->load->view('layouts/conges/modal/validation'); 
	}
?>

<!-- Modal de validation -->
<?php $this->load->view('layouts/conges/modal/validation'); ?>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
	$(function() {

		$('#validationModal').on('show.bs.modal', function(event) {
			
			var button = $(event.relatedTarget);
			var id = button.data('id');
			var nom = button.data('nom');
			var date_debut = button.data('date_debut');
			var date_fin = button.data('date_fin');
			var nbr_jour = button.data('nbr_jour');
			var motif = button.data('motif');
			var etat = button.data('etat');
			var commentaire = button.data('commentaire');

			var modal = $(this);
			modal.find('#validationForm').attr('action', '<?= site_url('conges/valider/') ?>' + id);
			modal.find('#val_nom_demandeur').text(nom);
			modal.find('#val_date_debut').text(date_debut);
			modal.find('#val_date_fin').text(date_fin);
			modal.find('#nbr_jour').text(nbr_jour);
			modal.find('#val_motif').text(motif);
			modal.find('select[name="etat"]').val(etat);
			modal.find('textarea[name="commentaire"]').val(commentaire);
		});
	});
</script>
<?php end_section(); ?>
