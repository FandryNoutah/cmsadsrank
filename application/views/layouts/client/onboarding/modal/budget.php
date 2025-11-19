<?php foreach ($donnees as $d): ?>
    <!-- id unique pour chaque modal -->
    <div class="modal fade" id="budgetModal-<?= $d['idclients'] ?>" tabindex="-1" aria-labelledby="budgetModalLabel-<?= $d['idclients'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Placer le form DANS la modale (optionnel) ou maintenir autour de la modale si tu veux -->
                <form action="<?= base_url('Client/repatition_budget') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="client" value="<?= $d['idclients']; ?>">
                    <input type="hidden" name="type_upsell" value="<?= isset($last_type_upsell) ? htmlspecialchars($last_type_upsell, ENT_QUOTES) : '' ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="budgetModalLabel-<?= $d['idclients'] ?>">Répartition Budget</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h5>Budget Client: <?= $d['budget'] ?> €</h5>
                        <?php $totalCampagne = array_sum(array_column($campagnes, 'repartition_budget')); ?>
                        <h5>Budget total campagne : <?= $totalCampagne ?> €</h5>

                        <div class="form-group boosterSection" data-budget="<?= $d['budget'] ?>">
                           <?php foreach($campagnes as $c): ?>
                            <p>Campagne : <?= htmlspecialchars($c['nom_campagne']) ?> (<?= $c['repartition_budget'] ?> €)</p>

                            <!-- nouveau montant éditable -->
                            <input type="number"
                                class="booster_input form-control"
                                name="campagne[<?= $c['idcampagne'] ?>]"
                                value="<?= $c['repartition_budget'] ?>">

                            <!-- ancien montant envoyé en hidden pour éviter SELECT côté serveur -->
                            <input type="hidden" name="campagne_old[<?= $c['idcampagne'] ?>]" value="<?= $c['repartition_budget'] ?>">

                            <!-- nom de la campagne -->
                            <input type="hidden" name="campagne_name[<?= $c['idcampagne'] ?>]" value="<?= htmlspecialchars($c['nom_campagne'], ENT_QUOTES) ?>">
                        <?php endforeach; ?>

                            <small class="budgetMessage text-muted"></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark btn-block">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const boosterSections = document.querySelectorAll('.boosterSection');

    boosterSections.forEach(section => {
        const boosterInputs = section.querySelectorAll('.booster_input');
        const budgetMessage = section.querySelector('.budgetMessage');
        const budgetClient = parseFloat(section.dataset.budget) || 0;

        function calculateBudget() {
            let totalCampagnes = 0;
            boosterInputs.forEach(input => {
                totalCampagnes += parseFloat(input.value) || 0;
            });

            if(totalCampagnes < budgetClient) {
                budgetMessage.textContent = `Il reste encore du budget à utiliser (${budgetClient - totalCampagnes} €)`;
                budgetMessage.className = "budgetMessage text-warning";
            } else if(totalCampagnes > budgetClient) {
                budgetMessage.textContent = `Budget dépassé ! Total réparti = ${totalCampagnes} € (budget total = ${budgetClient} €)`;
                budgetMessage.className = "budgetMessage text-danger";
            } else {
                budgetMessage.textContent = "Budget bien réparti !";
                budgetMessage.className = "budgetMessage text-success";
            }
        }

        boosterInputs.forEach(input => input.addEventListener('input', calculateBudget));
        calculateBudget(); // Calcul initial
    });
});


</script>
