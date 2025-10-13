<?php start_section('stylesheet'); ?>
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border: border;
		border-bottom: 1px solid #dee2e6 !important;
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
</style>
<?php end_section(); ?>
<?php start_section('page_title'); ?>
<h1 class="h4 py-2">GTM</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" type="button" id="gtm_tab" data-toggle="tab" data-target="#gtm" type="button" role="tab" aria-controls="list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
			Google Task Manager
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" type="button" id="optimisation_tab" data-toggle="tab" data-target="#optimisation" type="button" role="tab" aria-controls="kanban" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
			Optimisation
		</a>
	</li>
</ul>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">

	<div class="tab-content" id="clientTabContent">
                <div class="tab-pane fade show active mb-5" id="gtm" role="tabpanel" aria-labelledby="gtm_tab">
                    <div class="table-responsive">
                        <table class="table table-wrapper">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th>Société<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>URL<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>AM<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>Date de la demande<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>Invitation reçu<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>GTM<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>Status<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gtm as $d): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('Client/detail_client/' . $d['idclients']) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                            <img src="<?= $d['favicon'] ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
                                            <?= htmlspecialchars($d['nom_client']) ?>
                                        </a>
                                    </td>
                                    <td class="text-muted"><?= $d['site_client'] ?></td>
                                    <td>
                                        <img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d['photo_users'])); ?>" width="28" height="28" alt="Client Image">
                                    </td>
                                    <td class="text-muted">
                                        <i class="fa fa-calendar"></i> <?= htmlspecialchars($d['date_demande']) ?>
                                    </td>
                                    <td>
                                        <?php if ($d['invitation_reçu'] == null || $d['invitation_reçu'] == "0000-00-00"): ?>
                                        <span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Non reçu
                                        </span>
                                        <?php else: ?>
                                        <span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Invitation reçu
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (empty($d['tracking_gtm'])): ?>
                                        <span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Non installé
                                        </span>
                                        <?php else: ?>
                                        <span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Installé
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($d['statut'] == "En_attente"): ?>
                                        <span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> En attente
                                        </span>
                                        <?php elseif ($d['statut'] == "Annulé"): ?>
                                        <span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Annulé
                                        </span>
                                        <?php elseif ($d['statut'] == "Implémenté"): ?>
                                        <span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Implémenté
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown no-arrow">
                                            <a href="javascript:void(0);" class="text-decoration-none text-muted taREMOVEDmenu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $d['id_gtm']; ?>">
                                                    <i class="fa fa-eye mr-2"></i> Détails
                                                </button>
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $d['id_gtm']; ?>">
                                                    <i class="fa fa-edit mr-2"></i> Modifier
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="formModalLabel">Modifier les informations GTM</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="gtmEditForm" action="<?= base_url('Gtm/update_gtm') ?>" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_gtm" id="id_gtm_modal">
                                            <input type="hidden" name="idclients" id="idclients_modal">
                                            <div class="form-group">
                                                <label for="date_demande_modal">Date de la demande</label>
                                                <input type="date" class="form-control" name="date_demande" id="date_demande_modal">
                                            </div>
                                            <div class="form-group">
                                                <label for="invitation_recu_modal">Date de l'invitation reçue</label>
                                                <input type="date" class="form-control" name="invitation_reçu" id="invitation_recu_modal">
                                            </div>
                                            <div class="form-group">
                                                <label for="gtm_modal">GTM installé ?</label>
                                                <select class="form-control" name="gtm" id="gtm_modal">
                                                    <option value="">Non installé</option>
                                                    <option value="1">Installé</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="statut_modal">Statut</label>
                                                <select class="form-control" name="statut" id="statut_modal">
                                                    <option value="En_attente">En attente</option>
                                                    <option value="Annulé">Annulé</option>
                                                    <option value="Implémenté">Implémenté</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="optimisation" role="tabpanel" aria-labelledby="optimisation_tab">
                    <div class="table-responsive">
                        <table class="table table-wrapper">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th>client<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>Débogage<img src="<?= base_url('assets/images/icons/figma/icon-caretdoublevertical-5.svg') ?>" class="ml-2"></th>
                                    <th>Mois</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($optimisation_gtm as $d): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('Client/detail_client/' . $d['idclients']) ?>" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                            <img src="<?= $d['favicon'] ?>" class="img-thumbnail" width="28" height="28" alt="Client Image" style="margin-right: 8px;">
                                            <?= htmlspecialchars($d['nom_client']) ?>
                                        </a>
                                    </td>
                                        <td>
                                        <?php if ($d['Débogage'] == "à vérifier"): ?>
                                        <span class="badge alert-warning rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> à vérifier
                                        </span>
                                        <?php elseif ($d['Débogage'] == "Erreur"): ?>
                                        <span class="badge alert-danger rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Erreur
                                        </span>
                                        <?php elseif ($d['Débogage'] == "Implémenté"): ?>
                                        <span class="badge alert-success rounded-pill px-2 py-1" style="font-size: 12px; font-weight: 500;">
                                            <i class="fa fa-circle mr-1" style="font-size: 10px;"></i> Implémenté
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted">
                                        <i class="fa fa-calendar"></i> <?= htmlspecialchars($d['mois']) ?>
                                    </td>
                                    <td>
                                        <div class="dropdown no-arrow">
                                            <a href="javascript:void(0);" class="text-decoration-none text-muted taREMOVEDmenu dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#detailModal" data-id="<?= $d['id_optimisation_gtm']; ?>">
                                                    <i class="fa fa-eye mr-2"></i> Détails
                                                </button>
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $d['id_optimisation_gtm']; ?>">
                                                    <i class="fa fa-edit mr-2"></i> Modifier
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</div>
<?php end_section(); ?>

<?php start_section('script'); ?>

<script>
$(document).ready(function () {
    $(document).on('click', '[data-target="#formModal"]', function () {
        const id = $(this).data('id');

        $.ajax({
            url: '<?= base_url("Gtm/get_gtm_by_id/") ?>' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (!data) {
                    alert("Aucune donnée reçue.");
                    return;
                }

                $('#id_gtm_modal').val(data.id_gtm);
                $('#idclients_modal').val(data.idclients);
                $('#date_demande_modal').val(data.date_demande);
                $('#invitation_recu_modal').val(data.invitation_reçu);
                $('#gtm_modal').val(data.gtm);
                $('#statut_modal').val(data.statut);
            },
            error: function () {
                alert('Erreur lors du chargement des données');
            }
        });
    });
});
</script>
<?php end_section(); ?>
