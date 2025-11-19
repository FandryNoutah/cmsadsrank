<div class="modal fade" id="modifier_Brief" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-file-alt"></i> Brief campagne
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?php foreach ($campagne as $c): ?>
          <div class="brief-item mb-4" data-idcampagne="<?= $c['idcampagne'] ?>">
            <h5 class="d-flex justify-content-between align-items-center">
              <span>Nom campagne : <?= $c['nom_campagne'] ?></span>
              <!-- Bouton Edit : sans contour -->
              <button type="button" 
                      class="btn btn-link btn-edit-brief p-0" 
                      style="text-decoration: none;"
                      data-id="<?= $c['idcampagne'] ?>">
                <i class="fas fa-edit fa-lg" style="color: black;"></i>
              </button>
            </h5>
            
            <p class="brief-text"><?= nl2br($c['information_campagne']) ?></p>

            <form class="edit-brief-form d-none" data-id="<?= $c['idcampagne'] ?>">
                <textarea rows="10" class="form-control mb-3" name="information_campagne"><?= $c['information_campagne'] ?></textarea>

                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-light btn-block btn-cancel">Annuler</button>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-dark btn-block" id="submitBtn_<?= $c['idcampagne'] ?>">
                            <span class="btnText">Confirmer</span>
                            <span class="btnLoader spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>


            <hr>
          </div>
        <?php endforeach; ?>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>

    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

  // Clic sur le bouton éditer
  $('.btn-edit-brief').on('click', function () {
    const id = $(this).data('id');
    const container = $('[data-idcampagne="' + id + '"]');
    container.find('.brief-text').addClass('d-none');
    container.find('.edit-brief-form').removeClass('d-none');
  });

  // Annuler l'édition
  $('.btn-cancel').on('click', function () {
    const form = $(this).closest('.edit-brief-form');
    form.addClass('d-none');
    form.siblings('.brief-text').removeClass('d-none');
  });

  // Enregistrement AJAX
  $('.edit-brief-form').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const id = form.data('id');
    const newText = form.find('textarea[name="information_campagne"]').val();
    const btn = form.find('.btn-dark');
    const loader = btn.find('.btnLoader');
    const text = btn.find('.btnText');

    // Active le loader
    loader.removeClass('d-none');
    text.addClass('d-none');
    btn.prop('disabled', true);

    $.ajax({
      url: '<?= site_url("Client/update_brief") ?>',
      method: 'POST',
      data: {
        idcampagne: id,
        information_campagne: newText
      },
      success: function (response) {
        // Mise à jour visuelle
        form.siblings('.brief-text').html(newText.replace(/\n/g, "<br>"));
        form.addClass('d-none');
        form.siblings('.brief-text').removeClass('d-none');

        // Feedback visuel
        form.closest('.brief-item').css('background-color', '#e8ffe8');
        setTimeout(() => {
          form.closest('.brief-item').css('background-color', '');
        }, 800);
      },
      error: function () {
        alert('Erreur lors de la mise à jour du brief.');
      },
      complete: function() {
        // Réinitialise le bouton
        loader.addClass('d-none');
        text.removeClass('d-none');
        btn.prop('disabled', false);
      }
    });
  });
});
</script>
