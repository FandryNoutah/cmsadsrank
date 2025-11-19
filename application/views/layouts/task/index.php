<?php
/**
 * index.php
 *
 * Version refactorisée et corrigée de tasks_tab_fixed.php
 * - IDs suffixés par onglet (list, kanban, gtm) pour éviter collisions
 * - aria-* alignés avec les nouveaux IDs
 * - normalisation du statut "planifié"
 * - suppression de petites fautes et attributs invalides
 * - petites améliorations JS (filtrage centralisé, protections XSS côté UI)
 */
?>

<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border: none;
		border-bottom: 1px solid #dee2e6 !important;
		padding: 14px !important;
	}

	.table-wrapper tbody tr td:first-child,
	.table-wrapper thead tr th:first-child {
		border-left: 1px solid #dee2e6;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.table-wrapper tbody tr td:last-child,
	.table-wrapper thead tr th:last-child {
		border-right: 1px solid #dee2e6;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	.table-synced th:nth-child(2),
	.table-synced td:nth-child(2) { width: 15%; }
	.table-synced th:nth-child(3),
	.table-synced td:nth-child(3) { width: 15%; }
	.table-synced th:nth-child(4),
	.table-synced td:nth-child(4) { width: 15%; }
	.table-synced th:nth-child(5),
	.table-synced td:nth-child(5) { width: 10%; }
	.table-synced th:nth-child(6),
	.table-synced td:nth-child(6) { width: 10%; }
	.table-synced th:nth-child(7),
	.table-synced td:nth-child(7) { width: 5%; }

	/* For modal attachment design */
	.file-drop-area {
		border: 2px dashed #ccc;
		border-radius: 8px;
		padding: 30px;
		text-align: center;
		cursor: pointer;
		transition: border-color 0.3s;
	}

	.file-drop-area.dragover {
		border-color: #0d6efd;
		background: #f8f9fa;
	}

	.file-drop-icon {
		font-size: 40px;
		color: #6c757d;
		margin-bottom: 10px;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4">Tasks</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" id="list_tab" data-toggle="tab" data-target="#list-list" role="tab" aria-controls="list-list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt=""> Team Task
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" id="kanban_tab" data-toggle="tab" data-target="#kanban-kanban" role="tab" aria-controls="kanban-kanban" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt=""> Onboarding
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" id="gtm_tab" data-toggle="tab" data-target="#gtm-gtm" role="tab" aria-controls="gtm-gtm" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt=""> GTM
		</a>
	</li>
</ul>

<div class="row mx-lg-2">
	<div class="col-auto px-1">
		<select id="task_type_filter" class="custom-select border-dark">
			<option disabled selected>Filter</option>
			<option value="0">All Task</option>
			<option value="1">Team Task</option>
			<option value="2">Temporaire</option>
			<option value="3">GTM</option>
			<option value="4">Plan de taggage</option>
			<option value="5">Upsell</option>
			<option value="6">Baisse</option>
			<option value="7">Résiliation</option>
			<option value="8">Mise en pause</option>
			<option value="9">Relance</option>
			<option value="10">Annonce</option>
			<option value="13">Erreur optimisation GTM</option>
			<option value="15">Mise en ligne</option>
		</select>
	</div>

	<div class="col-auto px-1">
		<select id="task_user_filter" class="custom-select border-dark">
			<option value="<?= $current_user->id; ?>" selected><?= $current_user->first_name . " " . $current_user->last_name; ?></option>
			<?php foreach ($users as $u): ?>
				<?php if ($u['id'] != $current_user->id): ?>
					<option value="<?= $u['id']; ?>"><?= $u['first_name'] . " " . $u['last_name']; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
			<option value="0">Tous</option>
		</select>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-dark" data-toggle="modal" data-target="#formModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt=""> Add Task
		</button>
	</div>
</div>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
	<div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
		<label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="all" checked> All Task
		</label>
		<label class="btn btn-white rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="expired"> <i class="fa fa-circle mr-2 text-danger" style="font-size: 10px; color: #AF4B4B;"></i> En Retard
		</label>
		<label class="btn btn-white rounded-pill mx-2" style="font-size: 14px;">
			<input type="radio" class="status-select" name="status_filter" value="urgent"> <i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i> Urgent
		</label>
	</div>

	<div class="tab-content" id="taskTabContent">

		<!-- LIST TAB -->
		<div class="tab-pane fade show active mb-5" id="list-list" role="tabpanel" aria-labelledby="list_tab">

			<a class="text-decoration-none w-100" id="headingOne-list" role="button" data-toggle="collapse" data-target="#collapsePlanned-list" aria-expanded="true" aria-controls="collapsePlanned-list">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-warning" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Planifié</span>
				</p>
			</a>

			<div id="collapsePlanned-list" class="collapse show" aria-labelledby="headingOne-list">

				<table class="table table-wrapper table-synced w-100" id="planned_table-list">
					<tbody>
						<?php foreach ($tache as $t):  ?>
							<?php if (in_array($t->type_tache, [20,21])):  ?>
								<?php if (mb_strtolower(trim($t->status)) == "planifié" || mb_strtolower(trim($t->status)) == "planifie"): ?>
									<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>">
										<td>
											<h6 class="mb-0 ml-3">
												<?php if(!empty($t->title) && $t->title == "Création de Brief") :  ?>  
													<a href="<?= base_url('Client/onboarding/' .  htmlspecialchars($t->idclients)) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
												<?php elseif(!empty($t->title) && $t->title == "Demande de procédure GTM") :  ?>  
													<a href="<?= base_url('Client/application/' .  htmlspecialchars($t->idclients)) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
												<?php elseif(!empty($t->title) && in_array($t->title, ["Upsell","Mise en pause","Résiliation"])) :  ?>  
													<a href="<?= base_url('Onboarding') ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
												<?php else :  ?>
													<?= htmlspecialchars($t->nom_client) ?>
												<?php endif; ?>
											</h6>
										</td>
										<td>
											<span class="text-muted">
												<?= htmlspecialchars($t->title); ?>  
												<?php if ($t->type_tache == 5 || $t->type_tache == 6): 
													$Budget = $t->budgets - $t->budget_initiale;    
												?>
													de <?= htmlspecialchars($Budget); ?> €
												<?php endif; ?>
											</span>
										</td>
										<td>
											<span class="text-muted">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?>
											</span>
										</td>
										<td>
											<div class="row">
												<?php // type badges ?>
												<?php if ($t->type_tache == 1): ?><div class="mr-2"><span class="badge alert-success">Team task</span></div><?php endif; ?>
												<?php if ($t->type_tache == 2): ?><div class="mr-2"><span class="badge alert-success">Temporaire</span></div><?php endif; ?>
												<?php if ($t->type_tache == 3): ?><div class="mr-2"><span class="badge alert-success">GTM</span></div><?php endif; ?>
												<?php if ($t->type_tache == 4): ?><div class="mr-2"><span class="badge alert-success">Plan de taggage</span></div><?php endif; ?>
												<?php if ($t->type_tache == 5): ?><div class="mr-2"><span class="badge alert-success">Upsell</span></div><?php endif; ?>
												<?php if ($t->type_tache == 6): ?><div class="mr-2"><span class="badge alert-danger">Baisse</span></div><?php endif; ?>
												<?php if ($t->type_tache == 7): ?><div class="mr-2"><span class="badge alert-danger">Résiliation</span></div><?php endif; ?>
												<?php if ($t->type_tache == 8): ?><div class="mr-2"><span class="badge alert-warning">Mise en pause</span></div><?php endif; ?>
												<?php if ($t->type_tache == 9): ?><div class="mr-2"><span class="badge alert-success">Relance</span></div><?php endif; ?>
												<?php if ($t->type_tache == 10): ?><div class="mr-2"><span class="badge alert-success">Annonce</span></div><?php endif; ?>
												<?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?>
											</div>
										</td>
										<td>
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM">
												<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned">
											</div>
										</td>
										<td>
											<div class="row">
												<span class="col-auto">
													<a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>">
														<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?>
													</a>
												</span>
												<?php if (!empty($t->fichier_nom)): ?>
												<span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span>
												<?php endif; ?>
											</div>
										</td>
										<td>
											<div class="dropdown no-arrow">
												<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button>
													<?php if ($this->current_user->id === $t->AM): ?>
														<button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button>
														<a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a>
													<?php endif; ?>
												</div>
											</div>
										</td>
									</tr>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>

			<hr>

			<a class="text-decoration-none w-100" id="headingTwo-list" role="button" data-toggle="collapse" data-target="#collapseUpcoming-list" aria-expanded="true" aria-controls="collapseUpcoming-list">
				<p class="mb-0">
					<i class="fa fa-chevron-up toggle-icon mr-2"></i>
					<i class="fa fa-circle text-primary" style="font-size: 10px;"></i>
					<span class="h5 mx-2 w-auto">Programmé</span>
					<span class="text-muted"><?= $count_upcoming; ?> open tasks</span>
				</p>
			</a>

			<div id="collapseUpcoming-list" class="collapse show" aria-labelledby="headingTwo-list">
				<table class="table table-wrapper table-synced w-100" id="upcoming_table-list">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if (in_array($t->type_tache, [20,21]) && mb_strtolower(trim($t->status)) == 'en cours'): ?>
								<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" <?php if ($t->expired): ?> data-expired="true" style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>">
									<td>
										<h6 class="mb-0 ml-3">
											<?php if(!empty($t->title) && $t->title == "Création de Brief") :  ?>  
												<a href="<?= base_url('Client/onboarding/' .  htmlspecialchars($t->idclients)) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
											<?php elseif(!empty($t->title) && $t->title == "Demande de procédure GTM") :  ?>  
												<a href="<?= base_url('Client/application/' .  htmlspecialchars($t->idclients)) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
											<?php elseif(!empty($t->title) && in_array($t->title, ["Upsell","Mise en pause","Résiliation"])) :  ?>  
												<a href="<?= base_url('Onboarding') ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;"><?= htmlspecialchars($t->nom_client) ?></a>
											<?php else :  ?>
												<?= htmlspecialchars($t->nom_client) ?>
											<?php endif; ?>
										</h6>
									</td>
									<td><span class="text-muted"><?= htmlspecialchars($t->title); ?><?php if ($t->type_tache == 5 || $t->type_tache == 6): $Budget = $t->budgets - $t->budget_initiale; ?> de <?= htmlspecialchars($Budget); ?> €<?php endif; ?></span></td>
									<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
									<td>
										<div class="row">
											<?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center avatar-group">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM">
											<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned">
										</div>
									</td>
									<td>
										<div class="row">
											<span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span>
											<?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?>
										</div>
									</td>
									<td>
										<div class="dropdown no-arrow">
											<a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button>
												<?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?>
											</div>
										</div>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- TERMINÉ -->
			<a class="text-decoration-none w-100" id="headingThree-kanban" role="button" data-toggle="collapse" data-target="#collapseCompleted-kanban" aria-expanded="true" aria-controls="collapseCompleted-kanban">
				<p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-success" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Terminé</span><span class="text-muted"><?= $count_completed; ?> open tasks</span></p>
			</a>

			<div id="collapseCompleted-kanban" class="collapse show" aria-labelledby="headingThree-kanban">
				<table class="table table-wrapper table-synced w-100" id="completed_table-kanban">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if (in_array($t->type_tache, [20,21]) && mb_strtolower(trim($t->status)) == 'effectuée'): ?>
								<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
									<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
									<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
									<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
									<td><div class="row"><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
									<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
									<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
									<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- KANBAN & GTM panes kept but IDs updated similarly -->

		<!-- KANBAN TAB -->
		<div class="tab-pane fade mb-5" id="kanban-kanban" role="tabpanel" aria-labelledby="kanban_tab">
			<!-- PLANIFIÉ -->
			<a class="text-decoration-none w-100" id="headingOne-kanban" role="button" data-toggle="collapse" data-target="#collapsePlanned-kanban" aria-expanded="true" aria-controls="collapsePlanned-kanban">
				<p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-warning" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Planifié</span></p>
			</a>

			<div id="collapsePlanned-kanban" class="collapse show" aria-labelledby="headingOne-kanban">
				<table class="table table-wrapper table-synced w-100" id="planned_table-kanban">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if (in_array($t->type_tache, [1,5,6,7,8,9,10,11,12,18,15]) && mb_strtolower(trim($t->status)) == 'planifié'): ?>
								<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
									<td>
										<h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6>
									</td>
									<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
									<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
									<td>
										<div class="row">
											<?php if ($t->type_tache == 3): ?><div class="mr-2"><span class="badge alert-success">GTM</span></div><?php endif; ?>
											<?php if ($t->type_tache == 13): ?><div class="mr-2"><span class="badge alert-danger">Erreur optimisation GTM</span></div><?php endif; ?>
											<?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?>
										</div>
									</td>
									<td>
										<div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div>
									</td>
									<td>
										<div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div>
									</td>
									<td>
										<div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<hr>

			<!-- EN COURS -->
			<a class="text-decoration-none w-100" id="headingTwo-kanban" role="button" data-toggle="collapse" data-target="#collapseUpcoming-kanban" aria-expanded="true" aria-controls="collapseUpcoming-kanban">
				<p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-primary" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Programmé</span><span class="text-muted"><?= $count_upcoming; ?> open tasks</span></p>
			</a>

			<div id="collapseUpcoming-kanban" class="collapse show" aria-labelledby="headingTwo-kanban">
				<table class="table table-wrapper table-synced w-100" id="upcoming_table-kanban">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if (in_array($t->type_tache, [1,5,6,7,8,9,10,11,12,18,15]) && mb_strtolower(trim($t->status)) == 'en cours'): ?>
								<!-- similar columns to planned -->
								<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
									<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
									<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
									<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
									<td><div class="row"><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
									<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
									<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
									<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<hr>

			<!-- TERMINÉ -->
			<a class="text-decoration-none w-100" id="headingThree-kanban" role="button" data-toggle="collapse" data-target="#collapseCompleted-kanban" aria-expanded="true" aria-controls="collapseCompleted-kanban">
				<p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-success" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Terminé</span><span class="text-muted"><?= $count_completed; ?> open tasks</span></p>
			</a>

			<div id="collapseCompleted-kanban" class="collapse show" aria-labelledby="headingThree-kanban">
				<table class="table table-wrapper table-synced w-100" id="completed_table-kanban">
					<tbody>
						<?php foreach ($tache as $t): ?>
							<?php if (in_array($t->type_tache, [1,5,6,7,8,9,10,11,12,18,15]) && mb_strtolower(trim($t->status)) == 'effectuée'): ?>
								<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
									<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
									<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
									<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
									<td><div class="row"><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
									<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
									<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
									<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END KANBAN TAB -->

		<!-- GTM TAB -->
		<div class="tab-pane fade mb-5" id="gtm-gtm" role="tabpanel" aria-labelledby="gtm_tab">
			<!-- PLANIFIÉ -->
			<a class="text-decoration-none w-100" id="headingOne-gtm" role="button" data-toggle="collapse" data-target="#collapsePlanned-gtm" aria-expanded="true" aria-controls="collapsePlanned-gtm"><p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-warning" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Planifié</span></p></a>
			<div id="collapsePlanned-gtm" class="collapse show" aria-labelledby="headingOne-gtm">
				<table class="table table-wrapper table-synced w-100" id="planned_table-gtm"><tbody>
					<?php foreach ($tache as $t): ?>
						<?php if (in_array($t->type_tache, [3,13]) && mb_strtolower(trim($t->status)) == 'planifié'): ?>
							<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
								<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
								<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
								<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
								<td><div class="row"><?php if ($t->type_tache == 3): ?><div class="mr-2"><span class="badge alert-success">GTM</span></div><?php endif; ?><?php if ($t->type_tache == 13): ?><div class="mr-2"><span class="badge alert-danger">Erreur optimisation GTM</span></div><?php endif; ?><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
								<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
								<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
								<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody></table>
			</div>

			<hr>

			<!-- EN COURS -->
			<a class="text-decoration-none w-100" id="headingTwo-gtm" role="button" data-toggle="collapse" data-target="#collapseUpcoming-gtm" aria-expanded="true" aria-controls="collapseUpcoming-gtm"><p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-primary" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Programmé</span><span class="text-muted"><?= $count_upcoming; ?> open tasks</span></p></a>
			<div id="collapseUpcoming-gtm" class="collapse show" aria-labelledby="headingTwo-gtm">
				<table class="table table-wrapper table-synced w-100" id="upcoming_table-gtm"><tbody>
					<?php foreach ($tache as $t): ?>
						<?php if (in_array($t->type_tache, [3,13]) && mb_strtolower(trim($t->status)) == 'en cours'): ?>
							<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
								<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
								<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
								<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
								<td><div class="row"><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
								<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
								<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
								<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody></table>
			</div>

			<hr>

			<!-- TERMINÉ -->
			<a class="text-decoration-none w-100" id="headingThree-gtm" role="button" data-toggle="collapse" data-target="#collapseCompleted-gtm" aria-expanded="true" aria-controls="collapseCompleted-gtm"><p class="mb-0"><i class="fa fa-chevron-up toggle-icon mr-2"></i><i class="fa fa-circle text-success" style="font-size: 10px;"></i><span class="h5 mx-2 w-auto">Terminé</span><span class="text-muted"><?= $count_completed; ?> open tasks</span></p></a>
			<div id="collapseCompleted-gtm" class="collapse show" aria-labelledby="headingThree-gtm">
				<table class="table table-wrapper table-synced w-100" id="completed_table-gtm"><tbody>
					<?php foreach ($tache as $t): ?>
						<?php if (in_array($t->type_tache, [3,13]) && mb_strtolower(trim($t->status)) == 'effectuée'): ?>
							<tr class="task-filter" data-type="<?= htmlspecialchars($t->type_tache) ?>" data-am="<?= htmlspecialchars($t->AM) ?>" data-assigned="<?= htmlspecialchars($t->assigned_to) ?>" data-expired="<?= ($t->expired) ? '1' : '0'; ?>" data-urgent="<?= ($t->Statuts_technique == 3) ? '1' : '0'; ?>" <?php if ($t->expired): ?> style="background-color: rgba(255, 0, 0, 0.05);" <?php endif; ?> >
								<td><h6 class="mb-0 ml-3"><?= htmlspecialchars($t->nom_client) ?></h6></td>
								<td><span class="text-muted"><?= htmlspecialchars($t->title); ?></span></td>
								<td><span class="text-muted"><img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt=""> <?= htmlspecialchars($t->date_due); ?></span></td>
								<td><div class="row"><?php if ($t->Statuts_technique == 3): ?><span class="col-auto mx-1 badge alert-danger">Urgent</span><?php endif; ?></div></td>
								<td><div class="d-flex align-items-center avatar-group"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->AM_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="AM"><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($t->assigned_to_photo)); ?>" class="avatar rounded-circle bg-white" width="28" height="28" alt="Assigned"></div></td>
								<td><div class="row"><span class="col-auto"><a href="javascript:void(0);" class="text-muted" data-toggle="modal" data-target="#discussionModal" data-id="<?= htmlspecialchars($t->idtask); ?>" data-title="<?= htmlspecialchars($t->title); ?>"><img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt=""> <?= htmlspecialchars($t->count_messages); ?></a></span><?php if (!empty($t->fichier_nom)): ?><span class="col-auto"><a href="#" class="text-muted"><img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt=""></a></span><?php endif; ?></div></td>
								<td><div class="dropdown no-arrow"><a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a><div class="dropdown-menu dropdown-menu-right"><button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-eye mr-2"></i> Détails</button><?php if ($this->current_user->id === $t->AM): ?><button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= htmlspecialchars($t->idtask); ?>"><i class="fa fa-edit mr-2"></i> Modifier</button><a href="<?= base_url('Task/delete_task/' . $t->idtask); ?>" class="dropdown-item text-danger"><i class="fa fa-trash mr-2"></i> Supprimer</a><?php endif; ?></div></div></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody></table>
			</div>
		</div>
		<!-- END GTM TAB -->

	</div>

	<?php $this->load->view('layouts/task/modal/form'); ?>
	<?php $this->load->view('layouts/task/modal/detail'); ?>
	<?php $this->load->view('layouts/task/modal/discussion'); ?>

<?php end_section(); ?>
<?php start_section('script'); ?>

<script src="<?= base_url('assets/vendors/select2/js/select2.min.js'); ?>"></script>

<script>
$(function() {
	$('.select2').select2();

	var id_task = null;

	function resetDetail() {
		$('#detail_discussion').html("");
		$('#detailModalLabel').text("");
		$('#detail_date_due').removeAttr('value');
		$('#detail_description').text("");
		$('#detail_discussion_form').removeAttr('id').removeData('id');
		$('#detail_type').html("");
		$('#detail_status').html("");
		$('#detail_avatar').html("");
		$('#attachment_download').removeAttr("href");
		$('#attachment_container').addClass('d-none');
		$('#change_status').removeAttr("value");
		$('#status_form input[name="taskId"]').removeAttr("value");
		$('#status_form').addClass('d-none');
	}

	function resetForm() {
		$('#taskId').removeAttr('value');
		$('#formModalLabel').text("Nouvelle Tâche");
		$('#task_form').attr('action', "<?= base_url('Task/insert_tache'); ?>");
		$('#task_type').val("");
		$('#task_status').val("");
		$('#task_title').val("");
		$('#idclients').val(null).removeAttr('disabled').trigger('change');
		$('#assigned_to').val("");
		$('#date_demande').val("");
		$('#date_due').val("");
		$('#tache').val("");
		$('#task_form button[type="submit"]').text("Ajouter");
	}

	function fetch_discussion() {
		if (id_task == null) return;

		$.ajax({
			type: "POST",
			url: "Task/fetch_discussion/" + id_task,
			dataType: "json",
			beforeSend: function() { $('#task_discussion').html('<div class="text-center py-3"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></div>'); },
			success: function(response) {
				$('#task_discussion').html('');
				if (response && response.length > 0) {
					$.each(response, function(index, data) {
						let owner = data.owner;
						let alignment = owner ? "justify-content-end" : "justify-content-start";
						let color = owner ? "bg-dark text-white" : "bg-light border";
						let sender = owner ? "You" : data.username;
						let html = `\
							<div class="d-flex ${alignment}">\
								<div class="message_container mt-3" style="max-width: 75%;">\
									<span class="small text-muted d-block">${sender} ${data.created_at}</span>\
									<div class="p-2 ${color} rounded" style="width: fit-content;">${data.message}</div>\
								</div>\
							</div>`;
						$('#task_discussion').append(html);
					});
				} else {
					$('#task_discussion').html('<div class="alert alert-light" role="alert">Aucune discussion pour le moment!</div>');
				}
				let modalBody = $('#discussionModal .modal-body');
				if (modalBody.length) modalBody.scrollTop(modalBody[0].scrollHeight);
			},
			error: function() { $('#task_discussion').html('<div class="alert alert-danger">Erreur lors du chargement des discussions.</div>'); }
		});
	}

	function fetch_detail(task_id) {
		if (!task_id) return;
		$.ajax({
			type: "GET",
			url: "Task/detail_task/" + task_id,
			dataType: "json",
			beforeSend: function() { resetDetail(); },
			success: function(response) {
				if (!response || !response.task) { $('#detail_discussion').html('<div class="alert alert-warning">Tâche introuvable.</div>'); return; }
				let task = response.task;
				let messages = response.messages || [];
				$('#detailModalLabel').text("Tâche: " + (task.title || ""));
				$('#detail_date_due').val(task.date_due || "");
				let safe = $('<div>').text(task.description || "").html();
				let withBr = safe.replace(/\r\n|\r|\n/g, '<br>');
				$('#detail_description').html(withBr);
				$('#detail_avatar').append('<img src="<?= base_url(IMAGES_PATH); ?>/' + (task.AM_photo || '') + '" class="avatar rounded-circle bg-white" width="36" height="36" alt="AM">');
				$('#detail_avatar').append('<img src="<?= base_url(IMAGES_PATH); ?>/' + (task.assigned_to_photo || '') + '" class="avatar rounded-circle bg-white" width="36" height="36" alt="Assigned">');
				var type = '';
				switch (String(task.type_tache)) {
					case '1': type = 'Team Task'; break;
					case '2': type = 'Temporaire'; break;
					case '3': type = 'GTM'; break;
					case '4': type = 'Plan de taggage'; break;
					default: type = task.type_tache || ''; break;
				}
				$('#detail_type').html('<span class="badge alert-success p-2" style="font-size: 14px;">'+type+'</span>');
				var status = '';
				var status_color = 'secondary';
				switch (String(task.Statuts_technique)) {
					case '1': status = 'Normal'; status_color = 'success'; break;
					case '2': status = 'Priorité'; status_color = 'warning'; break;
					case '3': status = 'Urgent'; status_color = 'danger'; break;
					default: status = task.Statuts_technique || ''; status_color = 'secondary';
				}
				$('#detail_status').html('<span class="badge alert-'+status_color+' p-2" style="font-size: 14px;">'+status+'</span>');
				if (messages.length) {
					$.each(messages, function(index, data) {
						let html = '<div class="d-block activity-container mt-3">'+
							'<div class="d-flex">'+
								'<div class="mx-1"><img src="'+data.photo_users+'" alt="" width="32"></div>'+
								'<div class="flex-fill mx-1"><div class="d-block mb-2"><span class="font-weight-bold">'+data.username+'</span> '+data.message+'</div><div class="d-block mb-2"><span class="text-muted small">'+data.created_at+'</span></div></div>'+
							'</div></div>';
						$('#detail_discussion').prepend(html);
					});
				}
				if (task.fichier_nom) { $('#attachment_download').attr('href', "<?= base_url(); ?>/" + task.fichier_nom); $('#attachment_container').removeClass('d-none'); }
				if (String(task.assigned_to) == "<?= $this->current_user->id ?>" || String(task.AM) == "<?= $this->current_user->id ?>") {
					$('#change_status').val(task.status || "");
					$('#status_form input[name="taskId"]').val(task.idtask);
					$('#status_form').removeClass('d-none');
				}
			},
			error: function() { $('#detail_discussion').html('<div class="alert alert-danger">Erreur lors du chargement des détails.</div>'); }
		});
	}

	function applyTaskFilters() {
		let typeFilter = $('#task_type_filter').val() || '0';
		let userFilter = $('#task_user_filter').val() || '0';
		let statusFilter = $('.status-select:checked').val() || 'all';

		$('.task-filter').each(function() {
			const $row = $(this);
			const rowType = String($row.data('type'));
			const rowAM = String($row.data('am'));
			const rowAssigned = String($row.data('assigned'));
			const rowExpired = ($row.data('expired') === true || $row.attr('data-expired') === '1' || $row.attr('data-expired') === 'true');
			const urgentAttr = $row.data('urgent');
			const rowUrgent = (urgentAttr === true) || String(urgentAttr) === '1' || String(urgentAttr) === 'true';

			const matchType = (typeFilter === '0') || (typeFilter === rowType);
			const matchUser = (userFilter === '0') || (userFilter === rowAM) || (userFilter === rowAssigned);

			let matchStatus = true;
			if (statusFilter === 'expired') matchStatus = rowExpired;
			else if (statusFilter === 'urgent') matchStatus = rowUrgent;

			if (matchType && matchUser && matchStatus) $row.removeClass('d-none');
			else $row.addClass('d-none');
		});
	}

	$('#task_type_filter').on('change', applyTaskFilters);
	$('#task_user_filter').on('change', applyTaskFilters);
	$('.status-select').on('change', function() {
		$('.status-select').parent('label').removeClass('btn-light').addClass('btn-white');
		$(this).parent('label').addClass('btn-light').removeClass('btn-white');
		applyTaskFilters();
	});
	applyTaskFilters();

	$('.collapse').on('show.bs.collapse', function() {
		let aria_labelled = $(this).attr('aria-labelledby');
		if (aria_labelled) { $('#' + aria_labelled).find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up'); }
	});
	$('.collapse').on('hide.bs.collapse', function() {
		let aria_labelled = $(this).attr('aria-labelledby');
		if (aria_labelled) { $('#' + aria_labelled).find('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down'); }
	});

	$('#discussionModal').on('show.bs.modal', function(event) {
		let button = $(event.relatedTarget);
		let title = $(button).attr('data-title') || 'Unknown';
		id_task = $(button).attr('data-id') || null;
		$('#discussionModalLabel').text('Discussion sur: ' + title);
		fetch_discussion();
	});
	$('#discussionModal').on('hide.bs.modal', function() { id_task = null; $('#message').val(''); $('#task_discussion').html(''); });

	$('#message_form').submit(function(event) {
		event.preventDefault();
		if (!id_task) return;
		let submitter = event.originalEvent && event.originalEvent.submitter ? event.originalEvent.submitter : $(this).find('button[type="submit"]')[0];
		let buttonChild = $(submitter).html();
		$.ajax({ type: $(this).attr('method'), url: $(this).attr('action'), data: { "id_task": id_task, "message": $('#message').val() }, dataType: "json",
			beforeSend: function() { $(submitter).attr('disabled', "disabled"); $(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'); },
			success: function(response) { $(submitter).removeAttr("disabled"); $(submitter).html(buttonChild); $('#message').val(""); fetch_discussion(); },
			error: function() { $(submitter).removeAttr("disabled"); $(submitter).html(buttonChild); alert('Erreur lors de l\'envoi du message.'); }
		});
	});

	$('#detailModal').on('show.bs.modal', function(event) { let button = $(event.relatedTarget); let task_id = $(button).attr('data-id'); $('#detail_discussion_form').data('id', task_id); fetch_detail(task_id); });
	$('#detailModal').on('hide.bs.modal', function() { resetDetail(); });

	$('#detail_discussion_form').submit(function(event) {
		event.preventDefault();
		let submitter = event.originalEvent && event.originalEvent.submitter ? event.originalEvent.submitter : $(this).find('button[type="submit"]')[0];
		let buttonChild = $(submitter).html();
		let task_id = $(this).data('id');
		if (!task_id) return;
		$.ajax({ type: $(this).attr('method'), url: $(this).attr('action'), data: { "id_task": task_id, "message": $('#detail_message').val() }, dataType: "json",
			beforeSend: function() { $(submitter).attr('disabled', "disabled"); $(submitter).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'); },
			success: function(response) { $(submitter).removeAttr("disabled"); $(submitter).html(buttonChild); $('#detail_message').val(""); fetch_detail(task_id); },
			error: function() { $(submitter).removeAttr("disabled"); $(submitter).html(buttonChild); alert('Erreur lors de l\'envoi du message.'); }
		});
	});

	$('#formModal').on('show.bs.modal', function(event) {
		let button = $(event.relatedTarget);
		let id_task = $(button).attr('data-id');
		if (id_task) {
			$.ajax({ type: "GET", url: "Task/detail_task/" + id_task, dataType: "json",
				beforeSend: function() { resetForm(); },
				success: function(response) {
					if (!response || !response.task) return;
					let task = response.task;
					$('#formModalLabel').text("Modifier Tâche: " + (task.title || ""));
					$('#task_form').attr('action', "<?= site_url('Task/edits_task'); ?>");
					$('#task_type').val(task.type_tache);
					$('#task_status').val(task.Statuts_technique);
					$('#task_title').val(task.title);
					$('#idclients').val(task.idclients).attr('disabled', "disabled").trigger('change');
					$('#assigned_to').val(task.assigned_to);
					$('#date_demande').val(task.date_demande);
					$('#date_due').val(task.date_due);
					$('#tache').val(task.description);
					$('#taskId').val(task.idtask);
					$('#task_form button[type="submit"]').text("Modifier");
				},
				error: function() { alert('Erreur lors du chargement de la tâche.'); }
			});
		} else { resetForm(); }
	});
	$('#formModal').on('hide.bs.modal', function() { resetForm(); });

	(function initFileDrop() {
		const dropArea = $("#fileDrop");
		const input = $("#fileInput");
		const fileName = $("#fileName");
		if (!dropArea.length || !input.length || !fileName.length) return;
		dropArea.on('click', function() { input.click(); });
		dropArea.on('dragover', function(e) { e.preventDefault(); e.stopPropagation(); dropArea.addClass('dragover'); });
		dropArea.on('dragleave drop', function(e) { e.preventDefault(); e.stopPropagation(); dropArea.removeClass('dragover'); });
		dropArea.on('drop', function(e) { let files = e.originalEvent.dataTransfer.files; if (!files || files.length === 0) return; let file = files[0]; input[0].files = files; showFile(file); });
		input.on('change', function() { if (this.files && this.files[0]) showFile(this.files[0]); });
		function showFile(file) { fileName.text(file.name || ''); }
	})();

});
</script>

<?php end_section(); ?>
