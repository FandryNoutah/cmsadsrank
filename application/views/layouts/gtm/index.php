<?php start_section('stylesheet'); ?>
<style>
.table-wrapper {
    border-spacing: 0 15px !important;
    border-collapse: separate !important;
    table-layout: fixed; /* largeur fixe */
    width: 100%;
}
.table-wrapper td,
.table-wrapper th {
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6 !important;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Première et dernière colonnes arrondies */
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

/* Largeurs fixes pour chaque colonne */
.table-wrapper th:nth-child(1),
.table-wrapper td:nth-child(1) { width: 200px; } /* Société / Client */
.table-wrapper th:nth-child(2),
.table-wrapper td:nth-child(2) { width: 150px; } /* URL / Débogage */
.table-wrapper th:nth-child(3),
.table-wrapper td:nth-child(3) { width: 80px; }  /* AM */
.table-wrapper th:nth-child(4),
.table-wrapper td:nth-child(4) { width: 120px; } /* Date de la demande / Mois */
.table-wrapper th:nth-child(5),
.table-wrapper td:nth-child(5) { width: 120px; } /* Invitation reçu */
.table-wrapper th:nth-child(6),
.table-wrapper td:nth-child(6) { width: 100px; } /* GTM */
.table-wrapper th:nth-child(7),
.table-wrapper td:nth-child(7) { width: 120px; } /* Status */
.table-wrapper th:nth-child(8),
.table-wrapper td:nth-child(8) { width: 50px; }  /* Actions */
/* Désactiver l'overflow HIDDEN uniquement sur la colonne Actions */
.table-wrapper td:last-child,
.table-wrapper th:last-child {
    overflow: visible !important;
}
.table-wrapper td:last-child {
    position: relative !important;
}

</style>
<?php end_section(); ?>


<?php start_section('page_title'); ?>
<h1 class="h4 py-2">GTM</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
    <li class="nav-item">
        <a class="nav-link py-3 active" id="gtm_tab" data-toggle="tab" data-target="#gtm" role="tab" aria-controls="list" aria-selected="true">
            <img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
            Google Task Manager
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-3" id="optimisation_tab" data-toggle="tab" data-target="#optimisation" role="tab" aria-controls="kanban" aria-selected="false">
            <img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
            Optimisation
        </a>
    </li>
</ul>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid">
    <div class="tab-content" id="clientTabContent">
        <!-- GTM Tab -->
        <div class="tab-pane fade show active mb-5" id="gtm" role="tabpanel" aria-labelledby="gtm_tab">
            <input type="text" class="form-control mb-3" id="searchGtm" placeholder="Rechercher un client...">

           <div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
            <label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
                <input type="radio" class="status-select" name="gtm_status_filter" value="0" checked>
                All Companies
            </label>
            <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                <input type="radio" class="status-select" name="gtm_status_filter" value="1">
                <i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
                Active
            </label>
            <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                <input type="radio" class="status-select" name="gtm_status_filter" value="2">
                <i class="fa fa-circle mr-2" style="font-size: 10px; color: #B1AD1B;"></i>
                En attente
            </label>
            <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                <input type="radio" class="status-select" name="gtm_status_filter" value="3">
                <i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i>
                Non reçu
            </label>
        </div>

            <div class="table-responsive">
                <table class="table table-wrapper" id="gtmTable">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Société</th>
                            <th>URL</th>
                            <th>AM</th>
                            <th>Date de la demande</th>
                            <th>Invitation reçu</th>
                            <th>GTM</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gtm as $d): ?>
                        <?php
                            // Déterminer le statut global pour le filtre : 1=Vert, 2=En attente, 3=Rouge
                            $invitationRed = ($d['invitation_reçu'] == null || $d['invitation_reçu']=="0000-00-00" || $d['invitation_reçu']=='') ? true : false;
                            $gtmRed = empty($d['tracking_gtm']);
                            $statutRed = ($d['statut'] == 'Annulé');
                            if($invitationRed || $gtmRed || $statutRed) {
                                $row_status = 3; // Rouge
                            } elseif ($d['statut'] == "En_attente") {
                                $row_status = 2; // En attente
                            } else {
                                $row_status = 1; // Vert
                            }
                        ?>
                        <tr data-status="<?= $row_status ?>">
                            <td>
                                <a href="<?= base_url('GTM/Plan_de_taggage/' . $d['idclients']) ?>" class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="<?= $d['favicon'] ?>" class="img-thumbnail mr-2" width="28" height="28">
                                    <?= htmlspecialchars($d['nom_client']) ?>
                                </a>
                            </td>
                            <td class="text-muted"><?= $d['site_client'] ?></td>
                            <td><img src="<?= base_url(IMAGES_PATH . htmlspecialchars($d['photo_users'])); ?>" width="28" height="28"></td>
                            <td class="text-muted"><?= htmlspecialchars($d['date_demande']) ?></td>
                            <td>
                                <?php if ($invitationRed): ?>
                                    <span class="badge alert-danger rounded-pill px-2 py-1">Non reçu</span>
                                <?php else: ?>
                                    <span class="badge alert-success rounded-pill px-2 py-1"><?= $d['invitation_reçu'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($gtmRed): ?>
                                    <span class="badge alert-danger rounded-pill px-2 py-1">Non installé</span>
                                <?php else: ?>
                                    <span class="badge alert-success rounded-pill px-2 py-1">Installé</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($d['statut'] == "En_attente"): ?>
                                    <span class="badge alert-warning rounded-pill px-2 py-1">En attente</span>
                                <?php elseif ($d['statut'] == "Annulé"): ?>
                                    <span class="badge alert-danger rounded-pill px-2 py-1">Annulé</span>
                                     <?php elseif ($d['statut'] == "Erreur"): ?>
                                    <span class="badge alert-danger rounded-pill px-2 py-1">Erreur</span>
                                <?php else: ?>
                                    <span class="badge alert-success rounded-pill px-2 py-1">Implémenté</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dropdown no-arrow">
                                    <a href="javascript:void(0);" class="text-decoration-none text-muted task-menu dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#formModal" data-id="<?= $d['id_gtm']; ?>" data-am="<?= $d['am']; ?>">
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

            <!-- Modal GTM -->
            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier les informations GTM</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <form id="gtmEditForm" action="<?= base_url('Gtm/update_gtm') ?>" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id_gtm" id="id_gtm_modal">
                                <input type="hidden" name="idclients" id="idclients_modal">
                                <input type="hidden" name="am" id="am">
                                <div class="form-group">
                                    <label>Date de la demande</label>
                                    <input type="date" class="form-control" name="date_demande" id="date_demande_modal">
                                </div>
                                <div class="form-group">
                                    <label>Date de l'invitation reçue</label>
                                    <input type="date" class="form-control" name="invitation_reçu" id="invitation_recu_modal">
                                </div>
                                <!-- Statut -->
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select class="form-control" name="statut" id="statut_modal">
                                        <option value="En_attente">En attente</option>
                                        <option value="Annulé">Annulé</option>
                                        <option value="Implémenté">Implémenté</option>
                                        <option value="Erreur">Erreur</option>
                                    </select>
                                </div>

                                <!-- Type d'erreur -->
                                <div class="form-group" id="gtm_error_type_group" style="display:none;">
                                    <label>Type d'erreur</label>
                                    <select class="form-control" name="error_title" id="gtm_error_type">
                                        <option value="">-- Sélectionner une erreur --</option>
                                        <option value="gtm">Bug Mise en place GTM</option>
                                        <option value="tracking">Problème tracking balises</option>
                                        <option value="url">Changement d’URL</option>
                                        <option value="href">Problème lien href</option>
                                        <option value="cmp">Problème CMP</option>
                                        <option value="thankyou">URL page de remerciement incorrecte</option>
                                        <option value="contact">Problème demande mise en relation</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="form-group" id="gtm_error_description_group" style="display:none;">
                                    <label>Description de l'erreur</label>
                                    <textarea
                                        class="form-control"
                                        name="error_description"
                                        id="gtm_error_description"
                                        rows="4">
                                    </textarea>
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

        <!-- Optimisation Tab -->
        <div class="tab-pane fade" id="optimisation" role="tabpanel" aria-labelledby="optimisation_tab">
            <input type="text" class="form-control mb-3" id="searchOptim" placeholder="Rechercher un client...">

            <div class="btn-group btn-group-toggle my-4" data-toggle="buttons">
                <label class="btn btn-light rounded-pill mx-2" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="optim_status_filter" value="0" checked>
                    All Companies
                </label>
                <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="optim_status_filter" value="1">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #589E67;"></i>
                    Implémenté
                </label>
                <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="optim_status_filter" value="2">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #B1AD1B;"></i>
                    à verifier
                </label>
                <label class="btn btn-white rounded-pill mx-2 text-muted" style="font-size: 14px;">
                    <input type="radio" class="status-select" name="optim_status_filter" value="3">
                    <i class="fa fa-circle mr-2" style="font-size: 10px; color: #AF4B4B;"></i>
                    Erreur
                </label>
            </div>

            <div class="mb-3">
                <label for="filterMonth">Filtrer par mois :</label>
                <input type="month" id="filterMonth" class="form-control w-auto d-inline-block">
            </div>

            <div class="table-responsive">
                <table class="table table-wrapper" id="optimTable">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Client</th>
                            <th>Débogage</th>
                            <th>Mois</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($optimisation_gtm as $d): ?>
                        <?php
                            $optim_status = 1; // Vert par défaut
                            if($d['Débogage']=='Erreur') $optim_status=3;
                            elseif($d['Débogage']=='à vérifier') $optim_status=2;
                        ?>
                        <tr data-month="<?= date('Y-m', strtotime($d['mois'])) ?>" data-status="<?= $optim_status ?>">
                            <td>
                                <a href="<?= base_url('Client/detail_client/' . $d['idclients']) ?>" class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="<?= $d['favicon'] ?>" class="img-thumbnail mr-2" width="28" height="28">
                                    <?= htmlspecialchars($d['nom_client']) ?>
                                </a>
                            </td>
                            <td>
                                <?php if($d['Débogage']=='à vérifier'): ?>
                                    <span class="badge alert-warning rounded-pill px-2 py-1">à vérifier</span>
                                <?php elseif($d['Débogage']=='Erreur'): ?>
                                    <span class="badge alert-danger rounded-pill px-2 py-1">Erreur</span>
                                <?php else: ?>
                                    <span class="badge alert-success rounded-pill px-2 py-1">Implémenté</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($d['mois']) ?></td>
                            <td>
                                <div class="dropdown no-arrow">
                                    <a href="javascript:void(0);" class="text-muted dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#optimisationModal" data-id="<?= $d['id_optimisation_gtm']; ?>">
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

<!-- Modal Optimisation -->
<div class="modal fade" id="optimisationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Modifier Optimisation GTM</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="optimisationEditForm" action="<?= base_url('Gtm/update_optimisation') ?>" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id_optimisation_gtm" id="id_optimisation_modal">

                    <!-- Débogage -->
                    <div class="form-group">
                        <label>Débogage</label>
                        <select class="form-control" name="debougage" id="debougage_modal">
                            <option value="à vérifier">à vérifier</option>
                            <option value="Erreur">Erreur</option>
                            <option value="Implémenté">Implémenté</option>
                        </select>
                    </div>

                    <!-- Type d'erreur -->
                    <div class="form-group" id="error_type_group" style="display:none;">
                        <label>Type d'erreur</label>
                        <select class="form-control" name="error_title" id="error_type_modal">
                            <option value="">-- Sélectionner une erreur --</option>
                            <option value="gtm">Bug Mise en place GTM</option>
                            <option value="tracking">Problème tracking balises</option>
                            <option value="url">Changement d’URL</option>
                            <option value="href">Problème lien href</option>
                            <option value="cmp">Problème CMP</option>
                            <option value="thankyou">URL page de remerciement incorrecte</option>
                            <option value="contact">Problème demande mise en relation</option>
                        </select>
                    </div>


                    <!-- Description -->
                    <div class="form-group" id="error_description_group" style="display:none;">
                        <label>Description de l'erreur</label>
                        <textarea
                            class="form-control"
                            name="error_description"
                            id="error_description_modal"
                            rows="4">
                        </textarea>
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
<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const debougage = document.getElementById("debougage_modal");
    const errorTypeGroup = document.getElementById("error_type_group");
    const errorType = document.getElementById("error_type_modal");
    const errorDescriptionGroup = document.getElementById("error_description_group");
    const errorDescription = document.getElementById("error_description_modal");

    const errorMessages = {
        gtm: "Google Tag Manager non installé ou mal configuré.",
        tracking: "Les balises de tracking (Google Ads / GA4 / conversions) ne déclenchent pas correctement.",
        url: "Modification d’URL impactant le tracking ou les redirections (risque de perte de conversions).",
        href: "Liens mal renseignés (href manquant, incorrect ou non cliquable).",
        cmp: "Consent Management Platform défaillante (cookies non déclenchés selon le consentement).",
        thankyou: "Impossible de configurer correctement le suivi de conversion sans cette URL.",
        contact: "Dysfonctionnement technique empêchant le tracking – Demande de mise en relation."
    };

    debougage.addEventListener("change", function () {
        if (this.value === "Erreur") {
            errorTypeGroup.style.display = "block";
        } else {
            errorTypeGroup.style.display = "none";
            errorDescriptionGroup.style.display = "none";
            errorType.value = "";
            errorDescription.value = "";
        }
    });

    errorType.addEventListener("change", function () {
        if (this.value && errorMessages[this.value]) {
            errorDescription.value = errorMessages[this.value];
            errorDescriptionGroup.style.display = "block";
        } else {
            errorDescription.value = "";
            errorDescriptionGroup.style.display = "none";
        }
    });

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const statut = document.getElementById("statut_modal");
    const errorTypeGroup = document.getElementById("gtm_error_type_group");
    const errorType = document.getElementById("gtm_error_type");
    const errorDescriptionGroup = document.getElementById("gtm_error_description_group");
    const errorDescription = document.getElementById("gtm_error_description");

    const errorMessages = {
        gtm: "Google Tag Manager non installé ou mal configuré.",
        tracking: "Les balises de tracking (Google Ads / GA4 / conversions) ne déclenchent pas correctement.",
        url: "Modification d’URL impactant le tracking ou les redirections (risque de perte de conversions).",
        href: "Liens mal renseignés (href manquant, incorrect ou non cliquable).",
        cmp: "Consent Management Platform défaillante (cookies non déclenchés selon le consentement).",
        thankyou: "Impossible de configurer correctement le suivi de conversion sans cette URL.",
        contact: "Dysfonctionnement technique empêchant le tracking – Demande de mise en relation."
    };

    statut.addEventListener("change", function () {
        if (this.value === "Erreur") {
            errorTypeGroup.style.display = "block";
        } else {
            errorTypeGroup.style.display = "none";
            errorDescriptionGroup.style.display = "none";
            errorType.value = "";
            errorDescription.value = "";
        }
    });

    errorType.addEventListener("change", function () {
        if (this.value && errorMessages[this.value]) {
            errorDescription.value = errorMessages[this.value];
            errorDescriptionGroup.style.display = "block";
        } else {
            errorDescription.value = "";
            errorDescriptionGroup.style.display = "none";
        }
    });

});
</script>



<script>
$(document).ready(function(){

    // --- Modal GTM ---
    $(document).on('click', '[data-target="#formModal"]', function(){
        const id = $(this).data('id');
        $.getJSON('<?= base_url("Gtm/get_gtm_by_id/") ?>'+id, function(data){
            $('#id_gtm_modal').val(data.id_gtm);
            $('#idclients_modal').val(data.idclients);
            $('#am').val(data.tm);
            $('#date_demande_modal').val(data.date_demande);
            $('#invitation_recu_modal').val(data.invitation_reçu);
            $('#statut_modal').val(data.statut);
        });
    });

    // --- Modal Optimisation ---
    $(document).on('click', '[data-target="#optimisationModal"]', function(){
        const id = $(this).data('id');
        $.getJSON('<?= base_url("Gtm/get_optimisation_by_id/") ?>'+id, function(data){
            $('#id_optimisation_modal').val(data.id_optimisation_gtm);
            $('#debougage_modal').val(data['Débogage']);
        });
    });

    // --- Filtre GTM par statut ---
    $('input[name="gtm_status_filter"]').on('change', function(){
        const filter = $(this).val();
        $('#gtmTable tbody tr').each(function(){
            const status = $(this).data('status');
            $(this).toggle(filter=='0' || filter==status.toString());
        });
    });

    // --- Filtre Optimisation par statut et mois ---
    $('input[name="optim_status_filter"]').on('change', filterOptim);
    $('#filterMonth').on('change', filterOptim);

    function filterOptim(){
        const statusFilter = $('input[name="optim_status_filter"]:checked').val();
        const monthFilter = $('#filterMonth').val();
        $('#optimTable tbody tr').each(function(){
            const rowStatus = $(this).data('status');
            const rowMonth = $(this).data('month');
            const show = (statusFilter=='0' || statusFilter==rowStatus.toString())
                         && (monthFilter=='' || monthFilter==rowMonth);
            $(this).toggle(show);
        });
    }

    // --- Recherche GTM ---
    $('#searchGtm').on('keyup', function(){
        const val = $(this).val().toLowerCase();
        $('#gtmTable tbody tr').each(function(){
            $(this).toggle($(this).find('td:first').text().toLowerCase().includes(val));
        });
    });

    // --- Recherche Optimisation ---
    $('#searchOptim').on('keyup', function(){
        const val = $(this).val().toLowerCase();
        $('#optimTable tbody tr').each(function(){
            $(this).toggle($(this).find('td:first').text().toLowerCase().includes(val));
        });
    });

    // --- Initialisation mois Optimisation ---
    const currentMonth = new Date().toISOString().slice(0,7);
    $('#filterMonth').val(currentMonth).trigger('change');

    // --- Initialisation GTM ---
    $('input[name="gtm_status_filter"]:checked').trigger('change');
});
</script>
<?php end_section(); ?>
