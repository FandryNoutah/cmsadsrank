<!-- CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Style personnalisé -->
<style>
	#tableData td {
		text-align: center;
		vertical-align: middle;
	}
	#upsell_client {
		z-index: 9999;
	}
	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
	.board {
		display: flex;
		flex-wrap: nowrap;
		overflow-x: auto;
		padding: 20px;
		gap: 10px;
	}
	.column {
		background-color: #F3F3F3;
		padding: 10px;
		border-radius: 8px;
		width: 300px;
		min-height: 500px;
		flex-shrink: 0;
	}
	.column h2 {
		text-align: center;
		font-size: 16px;
	}
	.task {
		background-color: white;
		margin: 10px 0;
		padding: 10px;
		border-radius: 5px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
	.plus-btn {
		position: absolute;
		top: 10px;
		right: 10px;
		background-color: #28a745;
		color: white;
		border: none;
		border-radius: 50%;
		width: 25px;
		height: 25px;
		font-size: 18px;
		cursor: pointer;
	}
	.popup-overlay {
		display: none;
		position: fixed;
		top: 0; left: 0; right: 0; bottom: 0;
		background: rgba(0,0,0,0.5);
		justify-content: center;
		align-items: center;
		z-index: 9999;
	}
	.popup {
		background: white;
		padding: 20px;
		border-radius: 8px;
		width: 300px;
		max-width: 90%;
		box-shadow: 0 0 10px rgba(0,0,0,0.3);
	}
	.popup h3 {
		margin-top: 0;
	}
	.popup button {
		margin-top: 10px;
		background: #dc3545;
		color: white;
		border: none;
		padding: 5px 10px;
		border-radius: 4px;
		cursor: pointer;
	}
</style>

<!-- Messages -->
<?php if ($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?= $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>

<div id="messageBox" style="display: none; padding: 10px; margin-top: 20px; border-radius: 5px; background-color: #6CF5C2 !important;"></div>

<!-- Contenu principal -->
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Task <span id="countItem"><?php ?></span></h4>
			</div>

			<div class="card-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist" style="margin-left: 20px;">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Team Task</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tab2" role="tab">GTM</a>
					</li>
				</ul>
				<a href="#"  data-toggle="modal" data-target="#inlineNew1" ><div  id="task1" style="text-align: center; font-size: 16px; padding-top: 2px;padding-bottom: 2px; background-color: #e0e0e0; border: 1px solid grey; color: grey; border-radius: 5px; width: 120px; margin-left: 20px; margin-top: 20px;">Ajouter tâche</div></a>
				<!-- Tab panes -->
				<div class="tab-content mt-3">
					<!-- Tab 1 -->
					<div class="tab-pane active" id="tab1" role="tabpanel">
						<div class="board">
							<div class="column">
								<h2 class="text-left"><b>Plannifier</b></h2>
                                    <div class="task" id="task1">
                                    <div style="margin-top: 10px;"></div>
									<span class="badge" style="margin-left: 0px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important; padding-top: 3px; padding-bottom: 3px;"><b>Team Task</b></span>
									<span class="badge" style="margin-left: 10px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important;padding-top: 3px; padding-bottom: 3px; "><b>Urgent</b></span>
									<br><br>
									<b>Vérification de GTM</b><br><br>
									<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—minimal calendar icon vector_21233134.png"); ?>"> Date Due 18/07/2025
									<span style="margin-left: 25px;">
										<img width="8%" src="<?= base_url("assets/images/ico/discount-shape 1.png"); ?>"> 10/124
									</span>
									<br>
									<div class="mt-2">
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($Campgagne_en_attente_envoye[0]->am_photo_user)); ?>" style="width: 20px;" class="avatar-image"> -><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($Campgagne_en_attente_envoye[1]->am_photo_user)); ?>" style="width: 20px;" class="avatar-image">
										<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—vector message icon_4083513.png"); ?>" style="margin-left: 155px;">12
									</div>
								</div>
							</div>

                            <div class="column">
								<h2 class="text-left"><b>En cours</b></h2>
                                     <div class="task" id="task1">
                                    <div style="margin-top: 10px;"></div>
									<span class="badge" style="margin-left: 0px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important; padding-top: 3px; padding-bottom: 3px;"><b>Team Task</b></span>
									<span class="badge" style="margin-left: 10px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important;padding-top: 3px; padding-bottom: 3px; "><b>Urgent</b></span>
									<br><br>
									<b>Vérification de GTM</b><br><br>
									<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—minimal calendar icon vector_21233134.png"); ?>"> Date Due 18/07/2025
									<span style="margin-left: 25px;">
										<img width="8%" src="<?= base_url("assets/images/ico/discount-shape 1.png"); ?>"> 10/124
									</span>
									<br>
									<div class="mt-2">
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($Campgagne_en_attente_envoye[0]->am_photo_user)); ?>" style="width: 20px;" class="avatar-image">
										<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—vector message icon_4083513.png"); ?>" style="margin-left: 190px;">12
									</div>
								</div>

                                <div class="task" id="task1">
                                    <div style="margin-top: 10px;"></div>
									<span class="badge" style="margin-left: 0px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important; padding-top: 3px; padding-bottom: 3px;"><b>Team Task</b></span>
									<span class="badge" style="margin-left: 10px;background-color: #6355e7; padding: 5px;padding-left: 5px;padding-right: 5px; border-radius: 5px; color: white! important;padding-top: 3px; padding-bottom: 3px; "><b>Urgent</b></span>
									<br><br>
									<b>Vérification de GTM</b><br><br>
									<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—minimal calendar icon vector_21233134.png"); ?>"> Date Due 18/07/2025
									<span style="margin-left: 25px;">
										<img width="8%" src="<?= base_url("assets/images/ico/discount-shape 1.png"); ?>"> 10/124
									</span>
									<br>
									<div class="mt-2">
										<img src="<?= base_url(IMAGES_PATH . htmlspecialchars($Campgagne_en_attente_envoye[0]->am_photo_user)); ?>" style="width: 20px;" class="avatar-image">
										<img width="8%" src="<?= base_url("assets/images/ico/—Pngtree—vector message icon_4083513.png"); ?>" style="margin-left: 190px;">12
									</div>
								</div>
							</div>
						</div>
						
					<div class="modal fade" id="inlineNew1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content p-3">
								<div class="modal-header">
									<h2 class="modal-title" id="myModalLabel33">Tâche GTM</h2>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div id="modal-form-new">
									<form action="<?= base_url("Upsell/creer_upsell") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
										<fieldset>
											<input type="hidden" name="demmande_upsell" value="<?= $current_user->id; ?>" class="form-control">
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
					</div>

					<!-- Tab 2 -->
					<div class="tab-pane" id="tab2" role="tabpanel">
						<div class="board">
							<div class="column">
								<h2 class="text-left"><b>Plannifier</b></h2>
								<div class="task" id="task2">
									qsdqsdqsd
								</div>
							</div>
						</div>
					</div>
				</div> <!-- /.tab-content -->
			</div> <!-- /.card-body -->
		</div> <!-- /.card -->
	</div> <!-- /.col-lg-12 -->
</div> <!-- /.row -->

<!-- Modals -->
<div class="modal fade" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-3">
			<div class="modal-header">
				<h2 class="modal-title" id="myModalLabel33">Ajouter un tâche</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="modal-form-new">
				<form action="<?= base_url("Upsell/creer_upsell") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
					<fieldset>
						<input type="hidden" name="demmande_upsell" value="<?= $current_user->id; ?>" class="form-control">
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
