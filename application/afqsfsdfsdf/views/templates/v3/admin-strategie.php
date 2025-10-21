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
		color: #4EA5FE;
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
		border-color: #4EA5FE;
		background-color: #f1faff;
	}

	/* Button styling */
	.form-btn {
		background-color: #4EA5FE;
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
		border-color: #4EA5FE;
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


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



<div class="row">
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
				<h4 class="card-title">Team task - Adsrank<span id="countItem"><?php  ?></span></h4>

			</div>
			<div class="card-body collapse in" style="margin-left: 25px; margin-top: 20px; margin-right: 25px">
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
						<h4 class="card-title">Team Task en cours <span class="count-item"></span></h4>
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
								<?php foreach ($tache_team_non_complete as $ttnc): ?>
									<tr data-task-id="<?php echo $ttnc->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="u_team_task_details_<?php echo $ttnc->idtask; ?>"><?php echo htmlspecialchars($ttnc->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($ttnc->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($ttnc->AM_photo); ?>"></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($ttnc->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($ttnc->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($ttnc->date_demande); ?></td>
										<td><?php echo htmlspecialchars($ttnc->date_due); ?></td>
										<td><?php echo htmlspecialchars($ttnc->nom_client); ?></td>
										<td><?php echo htmlspecialchars($ttnc->title); ?></td>

										<td>
											<?php
											$statusStyles = [
												0 => 'background-color: #FFE177; color: #817E25 !important;',
												1 => 'background-color: #64D5FE; color: #2079B0 !important;',
												2 => 'background-color: #6CF5C2; color: #008767 !important;',
												3 => 'background-color: #F56C93; color: #870055 !important;'
											];
											$statusText = ['Plannifier', 'En cours', 'Complète', 'Validation'];
											$style = $statusStyles[$ttnc->Statuts_technique] ?? '';
											$ttncext = $statusText[$ttnc->Statuts_technique] ?? '';
											?>
											<span style="padding: 10px 25px; <?php echo $style; ?> border-radius: 4px;"><?php echo $ttncext; ?></span>
										</td>
										<td><?php echo htmlspecialchars($ttnc->note_technique); ?></td>

									</tr>
									<div id="u_team_task_details_<?php echo $ttnc->idtask; ?>" class="task-details client-details">
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $ttnc->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($ttnc->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($ttnc->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($ttnc->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($ttnc->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($ttnc->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($ttnc->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($ttnc->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($ttnc->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Date création:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($ttnc->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Date due :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($ttnc->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $ttnc->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $ttnc->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<?php //if($current_user->id != $ttnc->assigned_to):  ?>					
											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($ttnc->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($ttnc->description); ?></textarea>
											<?php //endif; ?>				

											<?php //if($current_user->id == $ttnc->assigned_to):  ?>		
											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($ttnc->note_technique); ?></textarea>
											<?php //endif; ?>		
											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
										</form>
									</div>

								<?php endforeach; ?>
							</tbody>
						</table>

						<br>

						<!-- TEMPORAIRE NON COMPLETED -->
						<h4 class="card-title">Tâche Temporaire en cours <span id="countItem"><?php  ?></span></h4>
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
								<?php foreach ($temporaire_non_complete as $tpnc): ?>
									<tr data-task-id="<?php echo $tpnc->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="temporaire_task_details_<?php echo $tpnc->idtask; ?>"><?php echo htmlspecialchars($tpnc->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tpnc->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tpnc->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tpnc->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tpnc->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($tpnc->date_demande); ?></td>
										<td><?php echo htmlspecialchars($tpnc->date_due); ?></td>
										<td><?php echo htmlspecialchars($tpnc->nom_client); ?></td>
										<td><?php echo htmlspecialchars($tpnc->title); ?></td>


										<?php if ($tpnc->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($tpnc->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($tpnc->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($tpnc->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($tpnc->note_technique); ?></td>


									</tr>
									<div id="temporaire_task_details_<?php echo $tpnc->idtask; ?>" class="task-details client-details">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $tpnc->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($tpnc->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($tpnc->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($tpnc->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($tpnc->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($tpnc->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($tpnc->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($tpnc->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($tpnc->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Debut promo:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($tpnc->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Fin promo :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($tpnc->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tpnc->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tpnc->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>






											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($tpnc->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($tpnc->description); ?></textarea>



											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($tpnc->note_technique); ?></textarea>

											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
										</form>
									</div>

								<?php endforeach; ?>

							</tbody>
						</table>

						<br>

						<h4 class="card-title">Tâche GTM en cours <span id="countItem"><?php  ?></span></h4>
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
								<?php foreach ($gtm_non_complete as $tgnc): ?>
									<tr data-task-id="<?php echo $tgnc->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="gtm_non_task_details_<?php echo $tgnc->idtask; ?>"><?php echo htmlspecialchars($tgnc->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tgnc->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tgnc->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tgnc->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tgnc->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($tgnc->date_demande); ?></td>
										<td><?php echo htmlspecialchars($tgnc->date_due); ?></td>
										<td><?php echo htmlspecialchars($tgnc->nom_client); ?></td>
										<td><?php echo htmlspecialchars($tgnc->title); ?></td>

										<?php if ($tgnc->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($tgnc->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($tgnc->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($tgnc->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($tgnc->note_technique); ?></td>

									</tr>
									<div id="gtm_non_task_details_<?php echo $tgnc->idtask; ?>" class="task-details client-details">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $tgnc->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($tgnc->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($tgnc->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($tgnc->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($tgnc->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($tgnc->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($tgnc->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($tgnc->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($tgnc->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Date création:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($tgnc->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Date due :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($tgnc->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tgnc->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tgnc->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($tgnc->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($tgnc->description); ?></textarea>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($tgnc->note_technique); ?></textarea>

											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
										</form>
									</div>
								<?php endforeach; ?>
							</tbody>
						</table>

						<br>

						<!-- ALL TASKS NON COMPLETED -->

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
													<select name="idclients" id="all_task_clients">
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
													<select name="assigned_to" id="assigned_to">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Titre tâche</label>
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
													<button type="submit" class="btn btn-primary col-md-12" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Ajouter</button>
													</br>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Onglet 1 - Teams Task -->
					<div class="tab-pane fade" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
						</br></br>
						<h4 class="card-title">Team task <span id="countItem"></span></h4>
						<a href="#" data-toggle="modal" data-target="#inlineNewTab1" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">
						Nouveau tâche
						</a>

						<table id="tableData5" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0" style="margin-top: 25px; margin-right: 25px; margin-bottom: 20px;">
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
								<?php foreach ($tache_team as $tmt): ?>
									<tr data-task-id="<?php echo $tmt->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="teams_task_details_<?php echo $tmt->idtask; ?>"><?php echo htmlspecialchars($tmt->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tmt->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tmt->AM_photo); ?>"></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tmt->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tmt->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($tmt->date_demande); ?></td>
										<td><?php echo htmlspecialchars($tmt->date_due); ?></td>
										<td><?php echo htmlspecialchars($tmt->nom_client); ?></td>
										<td><?php echo htmlspecialchars($tmt->title); ?></td>

										<td>
											<?php
											$statusStyles = [
												0 => 'background-color: #FFE177; color: #817E25 !important;',
												1 => 'background-color: #64D5FE; color: #2079B0 !important;',
												2 => 'background-color: #6CF5C2; color: #008767 !important;',
												3 => 'background-color: #F56C93; color: #870055 !important;'
											];
											$statusText = ['Plannifier', 'En cours', 'Complète', 'Validation'];
											$style = $statusStyles[$tmt->Statuts_technique] ?? '';
											$tmtext = $statusText[$tmt->Statuts_technique] ?? '';
											?>
											<span style="padding: 10px 25px; <?php echo $style; ?> border-radius: 4px;"><?php echo $tmtext; ?></span>
										</td>
										<td><?php echo htmlspecialchars($tmt->note_technique); ?></td>
									</tr>
									<div id="teams_task_details_<?php echo $tmt->idtask; ?>" class="task-details client-details">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $tmt->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($tmt->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($tmt->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($tmt->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($tmt->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($tmt->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($tmt->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($tmt->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($tmt->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Date création:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($tmt->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Date due :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($tmt->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tmt->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tmt->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($tmt->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($tmt->description); ?></textarea>


											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($tmt->note_technique); ?></textarea>

											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
										</form>
									</div>

									
								<?php endforeach; ?>
							</tbody>
						</table>

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
													
													<select name="idclients" id="teamtask_clients">
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
													<button type="submit" class="btn btn-primary col-md-12" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Ajouter</button>
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

						<a href="#" data-toggle="modal" data-target="#inlineNewTab2" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">Nouveau tâche</a>
							<table style="margin-top: 25px; margin-right: 25px; margin-bottom: 20px;" id="tableData6" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
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
								<?php foreach ($temporaire as $tmpt): ?>
									<tr data-task-id="<?php echo $tmpt->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="temporaires_task_details_<?php echo $tmpt->idtask; ?>"><?php echo htmlspecialchars($tmpt->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tmpt->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tmpt->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($tmpt->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($tmpt->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($tmpt->date_demande); ?></td>
										<td><?php echo htmlspecialchars($tmpt->date_due); ?></td>
										<td><?php echo htmlspecialchars($tmpt->nom_client); ?></td>

										<td><?php echo htmlspecialchars($tmpt->title); ?></td>
										<?php if ($tmpt->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($tmpt->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($tmpt->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($tmpt->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($tmpt->note_technique); ?></td>


									</tr>
									<div id="temporaires_task_details_<?php echo $tmpt->idtask; ?>" class="task-details client-details">

										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $tmpt->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($tmpt->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($tmpt->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($tmpt->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($tmpt->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($tmpt->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($tmpt->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($tmpt->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($tmpt->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Date création:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($tmpt->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Date due :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($tmpt->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tmpt->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $tmpt->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>

											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($tmpt->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($tmpt->description); ?></textarea>

											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($tmpt->note_technique); ?></textarea>

											<button type="submit" class="form-btn style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;"">Mettre à jour</button>
										</form>
									</div>

									<div id="temp_task_details_<?php echo $tmpt->idtask; ?>" class="task-details client-details">
			
										<?php ?>
										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $tmpt->idtask); ?>" method="POST" class="task-form">
											<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($tmpt->idtask); ?>" />
											<label for="date_demande" class="form-label">Date de la demande :</label>
											<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($tmpt->date_demande); ?>" required />
			
											<label for="date_due" class="form-label">Date due :</label>
											<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($tmpt->date_due); ?>" required />
			
											<label for="AM" class="form-label">Account Manager :</label>
											<select name="AM" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $tmpt->AM) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>
			
											<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
											<select name="assigned_to" class="form-input" required>
												<?php foreach ($users as $d):
													$selected = ($d->id == $tmpt->assigned_to) ? 'selected' : ''; ?>
													<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
														<?php echo $d->first_name . " " . $d->last_name ?>
													</option>
												<?php endforeach; ?>
											</select>
			
											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($tmpt->title); ?>" required />
			
											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($tmpt->description); ?></textarea>
			
											<label for="Statuts_technique" class="form-label">Status Technique :</label>
											<select name="Statuts_technique" class="form-input">
												<option value="0" <?php echo ($tmpt->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
												<option value="1" <?php echo ($tmpt->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
												<option value="2" <?php echo ($tmpt->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
												<option value="3" <?php echo ($tmpt->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
												<option value="4" <?php echo ($tmpt->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
											</select>
			
											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($tmpt->note_technique); ?></textarea>
			
											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
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
													<select name="idclients" id="temporaire_clients">
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
													<select name="assigned_to" id="assigned_to">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Titre tâche</label>
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
													<button type="submit" class="btn btn-primary col-md-12" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Ajouter</button>
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

						<a href="#" data-toggle="modal" data-target="#inlineNewTab3" style="display: inline-block; text-align: center; line-height: 41px; font-size: 16px; font-weight: 500; margin-top: 20px; margin-left: 0px; width: 180px; height: 41px; background-color: #4EA5FE; color: white; border-radius: 20px; text-decoration: none;">Nouveau tâche</a>

						<table style="margin-top: 25px; margin-right: 25px; margin-bottom: 20px;" id="tableData3" class="tableData table table-hover mb-0 table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
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
								<?php foreach ($gtm as $gtmt): ?>
									<tr data-task-id="<?php echo $gtmt->idtask; ?>" class="task-row">
										<td><a href="javascript:void(0);" class="client-name" data-task-target="gtm_task_details_<?php echo $gtmt->idtask; ?>"><?php echo htmlspecialchars($gtmt->reference); ?></a></td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($gtmt->AM_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($gtmt->AM_photo); ?>">
										</td>
										<td><img src="<?php echo base_url(IMAGES_PATH . htmlspecialchars($gtmt->assigned_to_photo)); ?>" alt="Tech Avatar" style="width: 40px;" class="avatar-image" data-id="<?php echo htmlspecialchars($gtmt->assigned_to_photo); ?>"></td>

										<td><?php echo htmlspecialchars($gtmt->date_demande); ?></td>
										<td><?php echo htmlspecialchars($gtmt->date_due); ?></td>
										<td><?php echo htmlspecialchars($gtmt->nom_client); ?></td>
										<td><?php echo htmlspecialchars($gtmt->title); ?></td>

										<?php if ($gtmt->Statuts_technique == 0): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #FFE177; color: #817E25! important; border-radius: 4px;">Plannifier</span></td>
										<?php endif; ?>
										<?php if ($gtmt->Statuts_technique == 1): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #64D5FE; color: #2079B0! important; border-radius: 4px;">En cours</span></td>
										<?php endif; ?>
										<?php if ($gtmt->Statuts_technique == 2): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #6CF5C2; color: #008767! important; border-radius: 4px;">Complète</span></td>
										<?php endif; ?>
										<?php if ($gtmt->Statuts_technique == 3): ?>
											<td> <span style="padding-top: 10px; padding-bottom: 10px; padding-left: 25px; padding-right: 25px; background-color: #F56C93; color: #870055! important; border-radius: 4px;">Validation</span></td>
										<?php endif; ?>
										<td><?php echo htmlspecialchars($gtmt->note_technique); ?></td>

									</tr>

									<div id="gtm_task_details_<?php echo $gtmt->idtask; ?>" class="task-details client-details">


										<h3>Détails de la tâche</h3>
										<form action="<?php echo site_url('Strategie/update_task/' . $gtmt->idtask); ?>" method="POST" class="task-form">
											<div class="row">

												<h2 style="text-align: center"><b><?php echo htmlspecialchars($gtmt->title); ?></b></br></h2>
												<div class="col-lg-10">
													<label for="Statuts_technique" class="form-label">Tâche :</label></br>
													<p><?php echo nl2br($gtmt->description); ?></p>

												</div>
												<div class="col-lg-2">
													<label for="Statuts_technique" class="form-label">Status :</label>
													<select name="Statuts_technique" class="form-input">
														<option value="0" <?php echo ($gtmt->Statuts_technique == 0 ? 'selected' : ''); ?>>Planifier</option>
														<option value="1" <?php echo ($gtmt->Statuts_technique == 1 ? 'selected' : ''); ?>>En cours</option>
														<option value="2" <?php echo ($gtmt->Statuts_technique == 2 ? 'selected' : ''); ?>>Tâches complètes</option>
														<option value="3" <?php echo ($gtmt->Statuts_technique == 3 ? 'selected' : ''); ?>>Validation par l'account manager</option>
														<option value="4" <?php echo ($gtmt->Statuts_technique == 4 ? 'selected' : ''); ?>>Refusé par l'équipe technique</option>
													</select>
													<input type="hidden" name="idtask" class="form-input" value="<?php echo htmlspecialchars($gtmt->idtask); ?>" />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="date_demande" class="form-label">Date création:</label>
													<input type="date" name="date_demande" class="form-input" value="<?php echo htmlspecialchars($gtmt->date_demande); ?>" required />

												</div>
												<div class="col-lg-4">
													<label for="date_due" class="form-label">Date due :</label>
													<input type="date" name="date_due" class="form-input" value="<?php echo htmlspecialchars($gtmt->date_due); ?>" required />

												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<label for="AM" class="form-label">Account Manager :</label>
													<select name="AM" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $gtmt->AM) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="col-lg-4">
													<label for="assigned_to" class="form-label">Utilisateur assigné :</label>
													<select name="assigned_to" class="form-input" required>
														<?php foreach ($users as $d):
															$selected = ($d->id == $gtmt->assigned_to) ? 'selected' : ''; ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>" <?php echo $selected; ?>>
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>






											<label for="leviers_marketing" class="form-label">Titre:</label>
											<input type="text" name="title" class="form-input" value="<?php echo htmlspecialchars($gtmt->title); ?>" required />

											<label for="description" class="form-label">Description :</label>
											<textarea name="description" class="form-textarea"><?php echo htmlspecialchars($gtmt->description); ?></textarea>



											<label for="note_technique" class="form-label">Notes Équipes Techniques :</label>
											<textarea name="note_technique" class="form-textarea"><?php echo htmlspecialchars($gtmt->note_technique); ?></textarea>

											<button type="submit" class="form-btn" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Mettre à jour</button>
										</form>
									</div>
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
													<select name="idclients" id="gtm_clients">
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
													<select name="assigned_to" id="assigned_to">
														<!-- La liste déroulante sera remplie dynamiquement avec les produits -->
														<?php foreach ($users as $d): ?>
															<option value="<?php echo htmlspecialchars($d->id); ?>">
																<?php echo $d->first_name . " " . $d->last_name ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label for="exampleInputEmail1">Titre tâche</label>
													<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" value="GTM">
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
													<button type="submit" class="btn btn-primary col-md-12" style="font-size: 16px; font-weight: 500;background-color: #4EA5FE;">Ajouter</button>
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Ajouter l'overlay
    $('body').append('<div id="overlay" class="overlay"></div>');

    // Affichage des détails tâche en cliquant sur le nom du client
    $(".client-name").click(function() {
        var taskTarget = $(this).data("task-target");
        $('#' + taskTarget).addClass("show");
        $('#overlay').show();
    });

    // Fermer les détails quand on clique en dehors
    $('#overlay').click(function() {
        $('.task-details').removeClass("show");
        $('#overlay').hide();
    });

    // Ne pas fermer si on clique dans le bloc
    $('.task-details').click(function(event) {
        event.stopPropagation();
    });

    // Initialisation des DataTables pour tous les tableaux
    $('#tableData1, #tableData2, #tableData3, #tableData4, #tableData5, #tableData6, #tableData7').DataTable({
        destroy: true,
        responsive: true,
        paging: false,
        searching: true,
        scrollX: true,
        language: {
            "search": "Rechercher:",
            "info": ""
        },
        order: [[1, 'asc']]
    });

    // Corriger l’alignement des colonnes lors du changement d’onglet
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        setTimeout(function() {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }, 200); // petit délai pour que le DOM soit bien prêt
    });

    // Initialisation des Select2 dans chaque tab
    $('#all_task_clients').select2({
        placeholder: "Sélectionner un client",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#inlineNewTab4')
    });

    $('#temporaire_clients').select2({
        placeholder: "Sélectionner un client",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#inlineNewTab2')
    });

    $('#gtm_clients').select2({
        placeholder: "Sélectionner un client",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#inlineNewTab3')
    });
	$('#teamtask_clients').select2({
        placeholder: "Sélectionner un client",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#inlineNewTab1')
    });
});
</script>

</body>

</html>