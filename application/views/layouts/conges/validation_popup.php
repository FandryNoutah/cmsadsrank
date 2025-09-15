<?php
// Assure-toi que $demande est défini quand tu ouvres la modale
?>
<div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-labelledby="validationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="validationForm" method="post" action="">
        <div class="modal-header">
          <h5 class="modal-title" id="validationModalLabel">Validation de la demande</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Date :</strong> <span id="val_date_debut">--</span> au <span id="val_date_fin">--</span></p>
          <p><strong>Motif :</strong> <span id="val_motif">--</span></p>
          <div class="form-group">
            <label>Statut :</label>
            <select name="etat" class="form-control" required>
              <option value="en_attente">En attente</option>
              <option value="valide">Validé</option>
              <option value="refuse">Refusé</option>
            </select>
          </div>
          <div class="form-group">
            <label>Commentaire :</label>
            <textarea name="commentaire" class="form-control" rows="3"><?= isset($demande->commentaire_validation) ? htmlspecialchars($demande->commentaire_validation) : '' ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Mettre à jour</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
