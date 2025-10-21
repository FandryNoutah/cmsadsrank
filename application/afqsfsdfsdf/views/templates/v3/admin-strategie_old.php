<?php //var_dump($tache_team); die(); ?>
<style>
	/* Fond sombre avec opacité pour le reste de l'écran */
	/* Fenêtre de détails avec transition */
	.client-details {
		position: fixed;
		top: 0;
		right: -50%;
		/* Commence hors de l'écran */
		width: 50%;
		/* Occupe la moitié de l'écran */
		height: 100vh;
		background-color: rgba(255, 255, 255, 0.9);
		box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
		transition: right 0.5s ease-in-out;
		/* Transition pour ouvrir et fermer */
		padding: 20px;
		overflow-y: auto;
		z-index: 1000;
		/* Assurez-vous que la fenêtre de détails soit au-dessus de l'overlay */
	}

	/* Fenêtre de détails affichée */
	.client-details.show {
		right: 0;
		/* Le bloc devient visible lorsqu'il est activé */
	}

	/* Overlay avec fond sombre */
	.overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		/* Opacité noire */
		z-index: 999;
		/* Assurez-vous que l'overlay soit derrière la fenêtre de détails */
		display: none;
		/* Par défaut, il est caché */
	}


	.task-details {
		display: none;
		/* Par défaut, tous les blocs de détails sont cachés */
	}

	/* Global form styling */
	.task-form {
		width: 100%;
		margin: 50px auto;
		background-color: #f9f9f9;
		padding: 30px;
		border-radius: 8px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	}

	/* Title styling */
	.form-title {
		font-size: 24px;
		font-weight: 700;
		color: #333;
		margin-bottom: 20px;
		text-align: center;
		color: #007bff;
		/* Met en valeur le titre en bleu */
	}

	/* Label styling */
	.form-label {
		font-size: 16px;
		color: #555;
		margin-bottom: 10px;
		display: block;
	}

	/* Input and Select fields */
	.form-input,
	.form-textarea {
		width: 100%;
		padding: 10px;
		margin-bottom: 2px;
		border: 1px solid #ccc;
		border-radius: 5px;
		box-sizing: border-box;
		font-size: 14px;
	}

	/* Styling for the textarea */
	.form-textarea {
		height: 100px;
		resize: vertical;
	}

	/* Highlight the description textarea */
	.form-textarea:focus {
		border-color: #007bff;
		background-color: #f1faff;
	}

	/* Button styling */
	.form-btn {
		background-color: #007bff;
		color: #fff;
		padding: 12px 20px;
		font-size: 16px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		width: 100%;
	}

	.form-btn:hover {
		background-color: #0056b3;
	}

	/* Focus styling for input fields */
	.form-input:focus {
		border-color: #007bff;
		outline: none;
		box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
	}

	/* Center the form elements with some spacing */
	.form-input,
	.form-btn,
	.form-textarea {
		margin-top: 10px;
	}

	/* Add some spacing between each label and input/textarea */
	.form-label {
		margin-top: 10px;
	}

	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="card" >

			<div class="card-header">
				<h4 class="card-title">Team task - Adsrank<span id="countItem"><?php  ?></span></h4>

			</div>
			<div class="card-body collapse in" style="margin-left: 25px; margin-top: 20px">
				<!-- Onglets -->
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">ALL TASK</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">TEAMS TASK</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">TEMPORAIRE</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">GTM</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">

					<!-- Onglet 4 - All Task -->
					<div class="tab-pane show active" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
						<br>

						<!-- TEAM TASKS NON COMPLETED -->
						<h4 class="card-title">Team Task Non-Completé <span class="count-item"></span></h4>
						<table id="tableData5" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Date création</th>
									<th style="width: 150px;">Date due</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tache_team_non_complete as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>"></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>
										
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										<td><?php echo htmlspecialchars($T->title); ?></td>

										<td>
											<?php
											$statusStyles = [
												0 => 'background-color: #FFE177; color: #817E25 !important;',
												1 => 'background-color: #64D5FE; color: #2079B0 !important;',
												2 => 'background-color: #6CF5C2; color: #008767 !important;',
												3 => 'background-color: #F56C93; color: #870055 !important;'
											];
											$statusText = ['Plannifier', 'En cours', 'Complète', 'Validation'];
											$style = $statusStyles[$T->Statuts_technique] ?? '';
											$text = $statusText[$T->Statuts_technique] ?? '';
											?>
											<span style="padding: 10px 25px; <?php echo $style; ?> border-radius: 4px;"><?php echo $text; ?></span>
										</td>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>
									</tr>
									<div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
											<!-- Form content remains the same -->
										</form>
									</div>
								<?php endforeach; ?>
							</tbody>
						</table>
						<br>

						<!-- TEMPORAIRE NON COMPLETED -->
						<h4 class="card-title">Tâche Temporaire Non-Completé <span id="countItem"><?php  ?></span></h4>
						<table id="tableData6" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
							<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Debut promo</th>
									<th style="width: 150px;">Fin promo</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($temporaire_non_complete as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>
										
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>	
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										
										<td><?php echo htmlspecialchars($T->title); ?></td>
										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>


									</tr>
									<div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
											<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
											<label for="date_demande" class="form-label">Date de la demande :</label>
											<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

											<label for="date_due" class="form-label">Date due :</label>
											<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

											<label for="AM" class="form-label">Account Manager :</label>
											<select name="AM" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
											<select name="assigned_to" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

											<label for="Statuts_technique" class="form-label">Status Technique :</label>
											<select name="Statuts_technique" class="form-input">
												<option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
												<option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
												<option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
												<option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
												<option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
											</select>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

											<button type="submit" class="form-btn">Mettre à jour</button>
										</form>
									</div>

								<?php endforeach; ?>
							</tbody>
						</table>
						<br>

						<h4 class="card-title">Tâche GTM Non-Completé <span id="countItem"><?php  ?></span></h4>
						<table id="tableData7" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
							<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Date création</th>
									<th style="width: 150px;">Date due</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($gtm_non_complete as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>
										
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										<td><?php echo htmlspecialchars($T->title); ?></td>

										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>
									
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<br>

						<!-- ALL TASKS NON COMPLETED -->
						<h4 class="card-title">Tout les tâches non completer <span id="countItem"><?php  ?></span></h4>
						<table id="tableData4" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Référence</th>
									<th>AM</th>
									<th>TM</th>
									<th>Date de la demande</th>
									<th>Date due</th>
									<th>Client</th>
									
									<th>Titre de la tâche</th>
									<th>Tâches</th>
									<th>Status Technique</th>
									<th>Notes équipes techniques</th>
									<th>Priorité</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($All_task_non_complete as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a style="text-decoration: none; color: #373a3c" href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>
										
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										<td><?php echo htmlspecialchars($T->title); ?></td>
										<td><?php echo htmlspecialchars($T->description); ?></td>
										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>
										<td><?php echo htmlspecialchars($T->priorite); ?></td>
									</tr>
									<div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
											<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
											<label for="date_demande" class="form-label">Date de la demande :</label>
											<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

											<label for="date_due" class="form-label">Date due :</label>
											<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

											<label for="AM" class="form-label">Account Manager :</label>
											<select name="AM" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
											<select name="assigned_to" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

											<label for="Statuts_technique" class="form-label">Status Technique :</label>
											<select name="Statuts_technique" class="form-input">
												<option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
												<option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
												<option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
												<option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
												<option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
											</select>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

											<button type="submit" class="form-btn">Mettre à jour</button>
										</form>
									</div>


								<?php endforeach; ?>
							</tbody>
						</table>

						<!-- Modal spécifique à l'onglet All Task -->
						<div class="modal fade text-xs-left" id="inlineNewTab4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau tâche | All task</h2>
									</div>
									<div id="modal-form-new">
										<form style="padding: 30px;" action="<?php echo base_url("Strategie/insert_tache") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
											<fieldset>
												<div class="form-group">

													<div class="form-group">
														<label for="exampleInputEmail1">Date de la demande</label>

														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_demande">
													</div>

													<script>
														// Fonction pour obtenir la date au format 'YYYY-MM-DD'
														function setDefaultDate() {
															const today = new Date();
															const yyyy = today.getFullYear();
															let mm = today.getMonth() + 1; // Mois commence à 0
															let dd = today.getDate();

															// Ajouter un zéro devant si le mois ou le jour sont inférieurs à 10
															if (mm < 10) mm = '0' + mm;
															if (dd < 10) dd = '0' + dd;

															const formattedDate = yyyy + '-' + mm + '-' + dd;

															// Définir la date par défaut dans l'input
															document.getElementById('exampleInputEmail1').value = formattedDate;
														}

														// Appeler la fonction dès que la page est chargée
														window.onload = setDefaultDate;
													</script>

													<div class="form-group">
														<label for="exampleInputEmail1">Date due</label>
														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_due">
													</div>
													<label for="exampleInputEmail1">Client </label>
													<select name="idclients" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($donnee as $d): ?>
															<option value="<?php echo htmlspecialchars($d->idclients); ?>">
																<?php echo htmlspecialchars($d->nom_client); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">AM </label>
													Utilisateur connecté: <?php echo $current_user->first_name . " " . $current_user->last_name ?>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="AM" value="<?php echo $current_user->id ?>">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">TM</label>
													<select name="assigned_to" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Leviers marketing</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="Google Ads">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Tâches </label>
													<textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="tache"></textarea>
												</div>
												<div class="form-group">
													<label> Status</label>
													<select name="Statuts_technique" required>
														<option value="0">Planifier</option>
														<option value="1">En cours</option>
														<option value="2">Tâches complètes</option>
														<option value="3">Validation par l'account manager</option>
														<option value="4">Refusé par l'équipe technique</option>
													</select></br></br>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="type_tache" value="1">
													<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
													</br>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Onglet 1 - Teams Task -->
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
						</br></br>
						<h4 class="card-title">Team task <span id="countItem"><?php  ?></span></h4>
						<button class="actions action-edit" data-toggle="modal" data-target="#inlineNewTab1"><i class="far fa-plus-square"></i>Nouveau</button>
						<table id="tableData1" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
							<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Date création</th>
									<th style="width: 150px;">Date due</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tache_team as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">

										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										
										<td><?php echo htmlspecialchars($T->title); ?></td>
										<td><?php echo htmlspecialchars($T->description); ?></td>
										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>
										<td><?php echo htmlspecialchars($T->priorite); ?></td>
									</tr>
									<div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
											<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
											<label for="date_demande" class="form-label">Date de la demande :</label>
											<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

											<label for="date_due" class="form-label">Date due :</label>
											<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

											<label for="AM" class="form-label">Account Manager :</label>
											<select name="AM" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
											<select name="assigned_to" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

											<label for="Statuts_technique" class="form-label">Status Technique :</label>
											<select name="Statuts_technique" class="form-input">
												<option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
												<option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
												<option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
												<option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
												<option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
											</select>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

											<button type="submit" class="form-btn">Mettre à jour</button>
										</form>
									</div>

								<?php endforeach; ?>
							</tbody>
						</table>

						<!-- Modal spécifique à l'onglet Teams Task -->
						<div class="modal fade text-xs-left" id="inlineNewTab1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau tâche | TEAMS TASK</h2>
									</div>
									<div id="modal-form-new">
										<form style="padding: 30px;" action="<?php echo base_url("Strategie/insert_tache") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
											<fieldset>
												<div class="form-group">

													<div class="form-group">
														<label for="exampleInputEmail1">Date de la demande</label>

														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_demande">
													</div>

													<script>
														// Fonction pour obtenir la date au format 'YYYY-MM-DD'
														function setDefaultDate() {
															const today = new Date();
															const yyyy = today.getFullYear();
															let mm = today.getMonth() + 1; // Mois commence à 0
															let dd = today.getDate();

															// Ajouter un zéro devant si le mois ou le jour sont inférieurs à 10
															if (mm < 10) mm = '0' + mm;
															if (dd < 10) dd = '0' + dd;

															const formattedDate = yyyy + '-' + mm + '-' + dd;

															// Définir la date par défaut dans l'input
															document.getElementById('exampleInputEmail1').value = formattedDate;
														}

														// Appeler la fonction dès que la page est chargée
														window.onload = setDefaultDate;
													</script>

													<div class="form-group">
														<label for="exampleInputEmail1">Date due</label>
														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_due">
													</div>
													<label for="exampleInputEmail1">Client </label>
													<select name="idclients" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($donnee as $d): ?>
															<option value="<?php echo htmlspecialchars($d->idclients); ?>">
																<?php echo htmlspecialchars($d->nom_client); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">AM </label>
													Utilisateur connecté: <?php echo $current_user->first_name . " " . $current_user->last_name ?>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="AM" value="<?php echo $current_user->id ?>">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">TM</label>
													<select name="assigned_to" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Leviers marketing</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="Google Ads">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Tâches </label>
													<textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="tache"></textarea>
												</div>
												<div class="form-group">
													<label> Status</label>
													<select name="Statuts_technique" required>
														<option value="0">Planifier</option>
														<option value="1">En cours</option>
														<option value="2">Tâches complètes</option>
														<option value="3">Validation par l'account manager</option>
														<option value="4">Refusé par l'équipe technique</option>
													</select></br></br>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="type_tache" value="1">
													<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
													</br>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Onglet 2 - Temporaire -->
					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
						</br></br>
						<h4 class="card-title">Tâche temporaire<span id="countItem"><?php  ?></span></h4>
						<button class="actions action-edit" data-toggle="modal" data-target="#inlineNewTab2"><i class="far fa-plus-square"></i>Nouveau</button>
						<table id="tableData2" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
							<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Date création</th>
									<th style="width: 150px;">Date due</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($temporaire as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										<td><?php echo htmlspecialchars($T->title); ?></td>
										

										<td><?php echo htmlspecialchars($T->description); ?></td>
										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>


									</tr>
									<div id="task-details-<?php echo $T->idtask; ?>" class="task-details client-details" style="display:none;">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $T->idtask); ?>" method="POST" class="task-form">
											<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($T->idtask); ?>" />
											<label for="date_demande" class="form-label">Date de la demande :</label>
											<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($T->date_demande); ?>" required />

											<label for="date_due" class="form-label">Date due :</label>
											<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($T->date_due); ?>" required />

											<label for="AM" class="form-label">Account Manager :</label>
											<select name="AM" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->AM) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
											<select name="assigned_to" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $T->assigned_to) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($T->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($T->description); ?></textarea>

											<label for="Statuts_technique" class="form-label">Status Technique :</label>
											<select name="Statuts_technique" class="form-input">
												<option value="0" <?php echo ($T->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
												<option value="1" <?php echo ($T->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
												<option value="2" <?php echo ($T->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
												<option value="3" <?php echo ($T->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
												<option value="4" <?php echo ($T->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
											</select>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($T->note_technique); ?></textarea>

											<button type="submit" class="form-btn">Mettre à jour</button>
										</form>
									</div>

								<?php endforeach; ?>
							</tbody>
						</table>

						<!-- Modal spécifique à l'onglet Temporaire -->
						<div class="modal fade text-xs-left" id="inlineNewTab2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau tâche | Temporaire</h2>
									</div>
									<div id="modal-form-new">
										<form style="padding: 30px;" action="<?php echo base_url("Strategie/insert_tache_temporaire") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
											<fieldset>
												<div class="form-group">

													<div class="form-group">
														<label for="exampleInputEmail1">Début promo</label>

														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_demande">
													</div>

													<script>
														// Fonction pour obtenir la date au format 'YYYY-MM-DD'
														function setDefaultDate() {
															const today = new Date();
															const yyyy = today.getFullYear();
															let mm = today.getMonth() + 1; // Mois commence à 0
															let dd = today.getDate();

															// Ajouter un zéro devant si le mois ou le jour sont inférieurs à 10
															if (mm < 10) mm = '0' + mm;
															if (dd < 10) dd = '0' + dd;

															const formattedDate = yyyy + '-' + mm + '-' + dd;

															// Définir la date par défaut dans l'input
															document.getElementById('exampleInputEmail1').value = formattedDate;
														}

														// Appeler la fonction dès que la page est chargée
														window.onload = setDefaultDate;
													</script>

													<div class="form-group">
														<label for="exampleInputEmail1">Fin promo</label>
														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_due">
													</div>
													<label for="exampleInputEmail1">Client </label>
													<select name="idclients" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($donnee as $d): ?>
															<option value="<?php echo htmlspecialchars($d->idclients); ?>">
																<?php echo htmlspecialchars($d->nom_client); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">AM </label>
													Utilisateur connecté: <?php echo $current_user->first_name . " " . $current_user->last_name ?>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="AM" value="<?php echo $current_user->id ?>">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">TM</label>
													<select name="assigned_to" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Leviers marketing</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" Value="Temporaire">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Information </label>
													<textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="tache"></textarea>
												</div>
												<div class="form-group">
													<label> Status</label>
													<select name="Statuts_technique" required>
														<option value="0">Planifier</option>
														<option value="1">En cours</option>
														<option value="2">Tâches complètes</option>
														<option value="3">Validation par l'account manager</option>
														<option value="4">Refusé par l'équipe technique</option>
													</select></br></br>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="type_tache" value="2">
													<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
													</br>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Onglet 3 - GTM -->
					<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
						</br></br>
						<h4 class="card-title">Tâche GTM <span id="countItem"><?php  ?></span></h4>
						<button class="actions action-edit" data-toggle="modal" data-target="#inlineNewTab3"><i class="far fa-plus-square"></i>Nouveau</button>
						<table id="tableData3" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
							<thead>
							<tr>
									<th style="width: 150px;">Référence</th>
									<th style="width: 50px;">AM</th>
									<th style="width: 50px;">TM</th>
									<th style="width: 180px;">Date création</th>
									<th style="width: 150px;">Date due</th>
									<th style="width: 250px;">Client</th>
									
									<th style="width: 250px;">Tâches</th>
									<th style="width: 180px;">Status</th>
									<th style="width: 250px;">Commentaire</th>
								
								</tr>
							</thead>
							<tbody>
								<?php foreach ($gtm as $T): ?>
									<tr data-task-id="<?php echo $T->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-id="<?php echo $T->idtask; ?>"><?php echo htmlspecialchars($T->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($T->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($T->assigned_to_photo); ?>"></td>
										
										<td><?php echo htmlspecialchars($T->date_demande); ?></td>
										<td><?php echo htmlspecialchars($T->date_due); ?></td>
										<td><?php echo htmlspecialchars($T->nom_client); ?></td>
										<td><?php echo htmlspecialchars($T->title); ?></td>
										<td><?php echo htmlspecialchars($T->description); ?></td>
										<?php if ($T->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($T->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($T->note_technique); ?></td>
										<td><?php echo htmlspecialchars($T->priorite); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<!-- Modal spécifique à l'onglet GTM -->
						<div class="modal fade text-xs-left" id="inlineNewTab3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h2 class="modal-title text-text-bold-300" id="myModalLabel33">Nouveau tâche | GTM</h2>
									</div>
									<div id="modal-form-new">
										<form style="padding: 30px;" action="<?php echo base_url("Strategie/insert_tache_gtm") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
											<fieldset>
												<div class="form-group">

													<div class="form-group">
														<label for="exampleInputEmail1">Date de la demande</label>

														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_demande">
													</div>

													<script>
														// Fonction pour obtenir la date au format 'YYYY-MM-DD'
														function setDefaultDate() {
															const today = new Date();
															const yyyy = today.getFullYear();
															let mm = today.getMonth() + 1; // Mois commence à 0
															let dd = today.getDate();

															// Ajouter un zéro devant si le mois ou le jour sont inférieurs à 10
															if (mm < 10) mm = '0' + mm;
															if (dd < 10) dd = '0' + dd;

															const formattedDate = yyyy + '-' + mm + '-' + dd;

															// Définir la date par défaut dans l'input
															document.getElementById('exampleInputEmail1').value = formattedDate;
														}

														// Appeler la fonction dès que la page est chargée
														window.onload = setDefaultDate;
													</script>

													<div class="form-group">
														<label for="exampleInputEmail1">Date due</label>
														<input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_due">
													</div>
													<label for="exampleInputEmail1">Client </label>
													<select name="idclients" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($donnee as $d): ?>
															<option value="<?php echo htmlspecialchars($d->idclients); ?>">
																<?php echo htmlspecialchars($d->nom_client); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">AM </label>
													Utilisateur connecté: <?php echo $current_user->first_name . " " . $current_user->last_name ?>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="AM" value="<?php echo $current_user->id ?>">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">TM</label>
													<select name="assigned_to" id="product-choice">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Leviers marketing</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="Google Ads">
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Tâches </label>
													<textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="tache"></textarea>
												</div>
												<div class="form-group">
													<label> Status</label>
													<select name="Statuts_technique" required>
														<option value="0">Planifier</option>
														<option value="1">En cours</option>
														<option value="2">Tâches complètes</option>
														<option value="3">Validation par l'account manager</option>
														<option value="4">Refusé par l'équipe technique</option>
													</select></br></br>
													<input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="type_tache" value="3">
													<button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
													</br>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<script>
		$(document).ready(function() {
			// Ajouter l'overlay
			$('body').append('<div id="overlay" class="overlay"></div>');

			// Lorsqu'on clique sur le nom du client
			$(".client-name").click(function() {
				var taskId = $(this).data("task-id");
				console.log(taskId);

				// Cacher tous les blocs de détails
				$(".task-details").hide();

				// Afficher le formulaire de détails de la tâche spécifique
				$('#task-details-' + taskId).show();

				// Afficher l'overlay et le formulaire de modification
				$('#overlay').show();
				$('#task-details-' + taskId).addClass('show');
			});

			// Fermeture lorsque l'on clique sur l'overlay
			$('#overlay').click(function() {
				$('.task-details').removeClass('show');
				$('#overlay').hide();

				setTimeout(function() {
					$('.task-details').hide();
				}, 500);
			});

			// Empêche la fermeture si l'on clique à l'intérieur du bloc de détails
			$('.task-details').click(function(event) {
				event.stopPropagation();
			});

			// Initialiser DataTables pour chaque tableau
			$('#tableData1, #tableData2, #tableData3, #tableData4').DataTable({
				destroy: true,
				responsive: true,
				paging: false,
				searching: true,
				scrollX: true,
				language: {
					"search": "Rechercher:",
					"info": ""
				},
				order: [
					[1, 'asc']
				]
			});

		});
	</script>
	</body>

	</html>