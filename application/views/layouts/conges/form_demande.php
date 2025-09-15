<!-- Vue: layouts/conges/validation_popup.php -->

<h3>Validation de la demande</h3>

<p><strong>Date :</strong> <?= $demande->date_debut ?> au <?= $demande->date_fin ?></p>
<p><strong>Motif :</strong> <?= $demande->motif ?></p>

<form method="post">
    <label>Statut :</label>
    <select name="etat">
        <option value="en_attente" <?= $demande->etat == 'en_attente' ? 'selected' : '' ?>>En attente</option>
        <option value="valide" <?= $demande->etat == 'valide' ? 'selected' : '' ?>>Validé</option>
        <option value="refuse" <?= $demande->etat == 'refuse' ? 'selected' : '' ?>>Refusé</option>
    </select><br>
    <button type="submit">Mettre à jour</button>
</form>
