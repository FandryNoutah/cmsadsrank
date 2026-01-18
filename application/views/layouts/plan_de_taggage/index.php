<?php start_section('stylesheet'); ?>
<style>
.table-wrapper {
    width: 100%;
    border-collapse: separate !important;
    border-spacing: 0 12px !important;
}

.table-wrapper tbody tr {
    background: #fff;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    border-radius: 12px;
}

.table-wrapper td,
.table-wrapper th {
    vertical-align: middle;
    padding: 15px;
    text-align: left;
}

.table-wrapper tbody tr td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.table-wrapper tbody tr td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

/* Style du menu 3 points */
.task-menu i {
    font-size: 18px;
    cursor: pointer;
}

.dropdown-menu {
    border-radius: 10px !important;
    box-shadow: 0 3px 12px rgba(0,0,0,0.1) !important;
}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4 py-2">Plan de taggage</h1>
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-dark" onclick="openAddPopup()">Ajouter une ligne</button>
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-wrapper">
            <thead class="bg-light text-muted">
                <tr>
                    <th>Conversion</th>
                    <th>Actions</th>
                    <th>Types</th>
                    <th>Remarque</th>
                    <th>État</th>
                    <th>Conditions</th>
                    <th>Conversion ID</th>
                    <th>Conversion Label</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plan_taggage as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['conversion']) ?></td>
                    <td><?= htmlspecialchars($p['actions']) ?></td>
                    <td><?= htmlspecialchars($p['types']) ?></td>
                    <td><?= htmlspecialchars($p['remarque']) ?></td>
                    <td>
						<?php if($p['etat'] == 1): ?>
							<span class="badge alert-success px-2 py-1">Implémenté</span>
                            <?php elseif($p['etat'] == 2): ?>
							<span class="badge alert-danger px-2 py-1">Erreur</span>
						<?php else: ?>
							<span class="badge alert-warning px-2 py-1">À définir</span>
						<?php endif; ?>
					</td>

                    <td><?= htmlspecialchars($p['conditions']) ?></td>
                    <td><?= htmlspecialchars($p['conversion_id']) ?></td>
                    <td><?= htmlspecialchars($p['extensions_appel']) ?></td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item"
                                        onclick="openEditPopup(
                                            <?= $p['idplan_de_taggage'] ?>,
                                            `<?= htmlspecialchars($p['conversion'], ENT_QUOTES) ?>`,
                                            `<?= htmlspecialchars($p['actions'], ENT_QUOTES) ?>`,
                                            `<?= htmlspecialchars($p['types'], ENT_QUOTES) ?>`,
                                            `<?= htmlspecialchars($p['remarque'], ENT_QUOTES) ?>`,
                                            `<?= $p['etat'] ?>`,
                                            `<?= htmlspecialchars($p['conditions'], ENT_QUOTES) ?>`,
                                            `<?= htmlspecialchars($p['conversion_id'], ENT_QUOTES) ?>`,
                                            `<?= htmlspecialchars($p['extensions_appel'], ENT_QUOTES) ?>`
                                    )">
                                        <i class="fa fa-edit me-2"></i> Modifier
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="<?= base_url('Gtm/delete_row/'.$p['idplan_de_taggage'].'/'.$idclients) ?>" 
                                       class="dropdown-item"
                                       onclick="return confirm('Supprimer cette ligne ?');">
                                        <i class="fa fa-trash me-2"></i> Supprimer
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php end_section(); ?>

<!-- ===========================
       POPUP : ÉDITION
=========================== -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= base_url('Gtm/update_row') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier une ligne</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="idplan_de_taggage">
                    <input type="hidden" name="idclients" value="<?= $idclients ?>">
                    <div class="row g-3">
                        <?php foreach ([
                            'conversion' => 'Conversion',
                            'actions' => 'Actions',
                            'types' => 'Types',
                            'remarque' => 'Remarque',
                            'etat' => 'État',
                            'conditions' => 'Conditions',
                            'conversion_id' => 'Conversion ID',
                            'conversion_label' => 'Conversion Label'
                        ] as $name => $label): ?>
                            <div class="col-6">
                                <label><?= $label ?></label>
                               <?php if($name === 'etat'): ?>
                                   <select id="edit_etat" name="<?= $name ?>" class="form-control etat-select">

                                        <option value="0">À définir</option>
                                        <option value="1">Implémenté</option>
                                        <option value="2">Erreur</option>
                                    </select>


                                <?php else: ?>
                                        <textarea id="edit_<?= $name ?>" name="<?= $name ?>" class="form-control"></textarea>
                                    <?php endif; ?>


                            </div>
                        <?php endforeach; ?>
                        <div class="row g-3 mt-2 d-none" id="error_type_group">
                            <div class="col-6">
                                <label>Type d'erreur</label>
                                <select class="form-control" name="error_title" id="error_type">
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

                            <div class="col-6 d-none" id="error_description_group">
                                <label>Description de l'erreur</label>
                                <textarea class="form-control" name="error_description" id="error_description" rows="4"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark">Enregistrer</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===========================
       POPUP : AJOUT
=========================== -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= base_url('Gtm/add_row') ?>">
                <input type="hidden" name="idclients" value="<?= $idclients ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une ligne</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <?php foreach ([
                            'conversion' => 'Conversion',
                            'actions' => 'Actions',
                            'types' => 'Types',
                            'remarque' => 'Remarque',
                            'etat' => 'État',
                            'conditions' => 'Conditions',
                            'conversion_id' => 'Conversion ID',
                            'conversion_label' => 'Conversion Label'
                        ] as $name => $label): ?>
                            <div class="col-6">
                                <label><?= $label ?></label>
                                <?php if($name === 'etat'): ?>
                                    <select name="<?= $name ?>" class="form-control">
                                        <option value="0">À définir</option>
                                        <option value="1">Implémenté</option>
                                    </select>
                                <?php else: ?>
                                    <textarea name="<?= $name ?>" class="form-control"></textarea>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark">Ajouter</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS Bundle (avec Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php start_section('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const etatSelects = document.querySelectorAll('.etat-select');
    const errorTypeGroup = document.getElementById('error_type_group');
    const errorType = document.getElementById('error_type');
    const errorDescriptionGroup = document.getElementById('error_description_group');
    const errorDescription = document.getElementById('error_description');

    const errorMessages = {
        gtm: "Google Tag Manager non installé ou mal configuré.",
        tracking: "Les balises de tracking (Google Ads / GA4 / conversions) ne déclenchent pas correctement.",
        url: "Modification d’URL impactant le tracking ou les redirections (risque de perte de conversions).",
        href: "Liens mal renseignés (href manquant, incorrect ou non cliquable).",
        cmp: "Consent Management Platform défaillante (cookies non déclenchés selon le consentement).",
        thankyou: "Impossible de configurer correctement le suivi de conversion sans cette URL.",
        contact: "Dysfonctionnement technique empêchant le tracking – Demande de mise en relation."
    };

    etatSelects.forEach(select => {
        select.addEventListener('change', function () {
            if (this.value == 2) {
                errorTypeGroup.classList.remove('d-none');
            } else {
                errorTypeGroup.classList.add('d-none');
                errorDescriptionGroup.classList.add('d-none');
                errorType.value = '';
                errorDescription.value = '';
            }
        });
    });

    errorType.addEventListener('change', function () {
        if (this.value && errorMessages[this.value]) {
            errorDescription.value = errorMessages[this.value];
            errorDescriptionGroup.classList.remove('d-none');
        } else {
            errorDescription.value = '';
            errorDescriptionGroup.classList.add('d-none');
        }
    });

});
</script>

<script>
function openAddPopup() {
    new bootstrap.Modal(document.getElementById("addModal")).show();
}

function openEditPopup(id, conversion, actions, types, remarque, etat, conditions, conv_id, label) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_conversion").value = conversion;
    document.getElementById("edit_actions").value = actions;
    document.getElementById("edit_types").value = types;
    document.getElementById("edit_remarque").value = remarque;
    document.getElementById("edit_etat").value = etat;
    document.getElementById("edit_conditions").value = conditions;
    document.getElementById("edit_conversion_id").value = conv_id;
    document.getElementById("edit_conversion_label").value = label;

    new bootstrap.Modal(document.getElementById("editModal")).show();
}
</script>
<?php end_section(); ?>
