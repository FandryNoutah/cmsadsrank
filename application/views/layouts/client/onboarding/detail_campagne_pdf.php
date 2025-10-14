<h2 style="text-align: center;">Liste des campagnes</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Type</th>
            <th>Campagnes</th>
            <th>Budget</th>
            <th>Demande</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($campagnes)): ?>
            <?php foreach ($campagnes as $campagne): ?>
                <tr>
                    <td><?= $campagne['type_campagne']; ?></td>
                    <td><?= $campagne['nom_campagne']; ?></td>
                    <td><?= $campagne['repartition_budget'] ?: 0; ?> Euro</td>
                    <td>GTM</td>
                    <td><?= $campagne['actif'] == 1 ? 'En cours' : 'Terminée'; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" align="center">Aucune campagne trouvée.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
