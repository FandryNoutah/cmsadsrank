<!-- views/layouts/conges/liste.php -->

<?php start_section('stylesheet'); ?>
<style>
/* tes styles ici pour le tableau etc */
</style>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<h2>Liste des demandes de congé</h2>
    <button class="btn btn-primary" data-toggle="modal" data-target="#demandeModal">
        Faire une demande
    </button>
<?php end_section(); ?>
<?php //var_dump($demandes); die(); ?>
<?php start_section('content'); ?>
<div class="table-responsive">
  <table class="table table-wrapper">
    <thead class="bg-light">
      <tr>
        <th>Nom</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Motif</th>
        <th>Nbr jours</th>
        <th>Validé par</th>
        <th>Commentaire</th>
        <th>État</th>
       
        <?php if ($is_validator): ?>
         <th>Action</th>
          <th></th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php if($is_compta == 2): ?>
      <?php foreach ($demandes_valider as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d->demandeur_first_name . ' ' . $d->demandeur_last_name) ?></td>
          <td><?= htmlspecialchars($d->date_debut) ?></td>
          <td><?= htmlspecialchars($d->date_fin) ?></td>
          <td><?= htmlspecialchars($d->motif) ?></td>
          <td><?= htmlspecialchars($d->nbr_jour) ?></td>
          <?php if(!empty($d->validateur_first_name) && !empty($d->validateur_last_name)):?> 
          <td><?= htmlspecialchars($d->validateur_first_name) ?> <?= htmlspecialchars($d->validateur_last_name) ?></td>
          <?php endif; ?>
          <td><?= htmlspecialchars($d->commentaire_validation) ?></td>
          <td><?= htmlspecialchars($d->etat) ?></td>
         
          <?php if ($is_validator): ?>
            <td><?= htmlspecialchars($d->commentaire_validation ?? '-') ?></td>
            <?php if($d->etat == "valide"): ?>
                <td>
                    Validé
                </td>
            <?php endif; ?>

            <?php if($d->etat != "valide"): ?>
                <td>
                    <button type="button"
                            class="btn btn-sm btn-info"
                            data-toggle="modal"
                            data-target="#validationModal"
                            data-id="<?= $d->id ?>"
                            data-nom="<?= htmlspecialchars($d->first_name . ' ' . $d->last_name, ENT_QUOTES) ?>"
                            data-date_debut="<?= $d->date_debut ?>"
                            data-date_fin="<?= $d->date_fin ?>"
                            data-motif="<?= htmlspecialchars($d->motif, ENT_QUOTES) ?>"
                            data-etat="<?= $d->etat ?>"
                            data-commentaire="<?= htmlspecialchars($d->commentaire_validation ?? '', ENT_QUOTES) ?>">
                        Valider
                    </button>
                </td>
            <?php endif; ?>

          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
      <?php endif; ?>
       <?php if($is_compta != 2): ?>
      <?php foreach ($demandes as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d->demandeur_first_name . ' ' . $d->demandeur_last_name) ?></td>
          <td><?= htmlspecialchars($d->date_debut) ?></td>
          <td><?= htmlspecialchars($d->date_fin) ?></td>
          <td><?= htmlspecialchars($d->motif) ?></td>
           <td><?= htmlspecialchars($d->nbr_jour) ?></td>
          
          <td>
            <?php if(!empty($d->validateur_first_name) && !empty($d->validateur_last_name)):?> 
              <?= htmlspecialchars($d->validateur_first_name) ?> 
              <?= htmlspecialchars($d->validateur_last_name) ?>
                 <?php endif; ?>  
                 <?php if(empty($d->validateur_first_name) && empty($d->validateur_last_name)):?> 
              -
                 <?php endif; ?>  
            </td>
          <td><?= htmlspecialchars($d->commentaire_validation ?? '-') ?></td>        
          <td><?= htmlspecialchars($d->etat) ?></td>
          
          <?php if ($is_validator): ?>

           <?php if($d->etat == "valide"): ?>
                <td>
                    Validé
                </td>
            <?php endif; ?>

            <?php if($d->etat != "valide"): ?>
                <td>
                    <button type="button"
                            class="btn btn-sm btn-info"
                            data-toggle="modal"
                            data-target="#validationModal"
                            data-id="<?= $d->id ?>"
                            data-nom="<?= htmlspecialchars($d->demandeur_first_name . ' ' . $d->demandeur_last_name, ENT_QUOTES) ?>"
                            data-date_debut="<?= $d->date_debut ?>"
                            data-date_fin="<?= $d->date_fin ?>"
                            data-nbr_jour="<?= $d->nbr_jour ?>"
                            data-motif="<?= htmlspecialchars($d->motif, ENT_QUOTES) ?>"
                            data-etat="<?= $d->etat ?>"
                            data-commentaire="<?= htmlspecialchars($d->commentaire_validation ?? '', ENT_QUOTES) ?>">
                        Valider
                    </button>
                </td>
                
            </td>
              
            </td>
            <?php endif; ?>
              <td>
                  <div class="dropdown no-arrow">
										<a href="#" class="btn btn-light rounded-pill px-3 dropdown-toggle" data-toggle="dropdown">
											<i class="fa fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="#" 
												data-toggle="modal" data-target="#editModal"
												data-id="<?= $d->id; ?>"
												data-date_debut="<?= $d->date_debut; ?>"
												data-date_fin="<?= htmlspecialchars($d->date_fin); ?>"
												data-motif="<?= htmlspecialchars($d->motif); ?>"
												data-date_demande="<?= $d->date_demande; ?>"
												data-date_validation="<?= htmlspecialchars($d->date_validation); ?>"
												data-commentaire_validation="<?= $d->commentaire_validation; ?>"
											>Modifier</a>
										</div>
									</div>
                </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
    <div class="modal fade" id="demandeModal" tabindex="-1" role="dialog" aria-labelledby="demandeModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="post" action="<?= site_url('conges/demander') ?>">
            <div class="modal-header">
              <h5 class="modal-title" id="demandeModalLabel">Nouvelle demande de congé</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="form-group">
                <label>Date début</label>
                <input type="date" name="date_debut" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Premier jours</label>
                <select name="jours" class="form-control" required>
                  <option value="1">Toute la journée</option>
                  <option value="0.5">Demi-journée</option>
                </select>
              </div>
              <div class="form-group">
                <label>Date fin</label>
                <input type="date" name="date_fin" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Motif</label>
                <textarea name="motif" class="form-control" required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Envoyer</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- Modal de validation -->
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
          <!-- Voici où on affiche le nom du demandeur -->
          <p><strong>Demandeur :</strong> <span id="val_nom_demandeur">--</span></p>

          <p><strong>Date :</strong> <span id="val_date_debut">--</span> au <span id="val_date_fin">--</span></p>
          <p><strong>Nbr de jours :</strong> <span id="nbr_jour"></span> Jours</p>
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
            <textarea name="commentaire" class="form-control" rows="3"></textarea>
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form method="POST" action="<?= base_url('Conges/edit') ?>">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Modifier la demande</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">

          <div class="form-group">
            <label for="edit_date_debut">Date de début</label>
            <input type="date" class="form-control" id="edit_date_debut" name="date_debut">
          </div>

          <div class="form-group">
            <label for="edit_date_fin">Date de fin</label>
            <input type="date" class="form-control" id="edit_date_fin" name="date_fin">
          </div>

          <div class="form-group">
            <label for="edit_motif">Motif</label>
            <textarea class="form-control" id="edit_motif" name="motif" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="edit_commentaire_validation">Commentaire de validation</label>
            <textarea class="form-control" id="edit_commentaire_validation" name="commentaire_validation" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
$('#editModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var modal = $(this);

  modal.find('#edit_id').val(button.data('id'));
  modal.find('#edit_date_debut').val(button.data('date_debut'));
  modal.find('#edit_date_fin').val(button.data('date_fin'));
  modal.find('#edit_motif').val(button.data('motif'));
  modal.find('#edit_date_demande').val(button.data('date_demande'));
  modal.find('#edit_date_validation').val(button.data('date_validation'));
  modal.find('#edit_commentaire_validation').val(button.data('commentaire_validation'));
});
</script>

<script>
  
$(document).ready(function(){
  $('#validationModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nom = button.data('nom');
    var date_debut = button.data('date_debut');
    var date_fin = button.data('date_fin');
    var nbr_jour = button.data('nbr_jour');
    var motif = button.data('motif');
    var etat = button.data('etat');
    var commentaire = button.data('commentaire');

    var modal = $(this);
    modal.find('#validationForm').attr('action', '<?= site_url('conges/valider/') ?>' + id);
    modal.find('#val_nom_demandeur').text(nom);
    modal.find('#val_date_debut').text(date_debut);
    modal.find('#val_date_fin').text(date_fin);
    modal.find('#nbr_jour').text(nbr_jour);
    modal.find('#val_motif').text(motif);
    modal.find('select[name="etat"]').val(etat);
    modal.find('textarea[name="commentaire"]').val(commentaire);
  });
});
</script>
<?php end_section(); ?>