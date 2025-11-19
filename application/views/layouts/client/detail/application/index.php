<?php start_section('stylesheet'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
  .section-title{font-size:16px;font-weight:600;margin-bottom:8px;}
  .toggle{--w:38px;--h:20px;position:relative;}
  .switch{width:var(--w);height:var(--h);border-radius:999px;background:#E6E6E6;display:inline-block;position:relative;transition:background .18s ease;}
  .knob{--size:14px;width:var(--size);height:var(--size);border-radius:50%;background:black;position:absolute;top:50%;transform:translate(4px,-50%);transition:transform .18s ease, background .18s ease;}
  input[type="checkbox"]{position:absolute;opacity:0;pointer-events:none;}
  input[type="checkbox"]:checked + .switch{background:#111;}
  input[type="checkbox"]:checked + .switch .knob{transform:translate(calc(var(--w) - 18px), -50%);background:white;}
  label.toggle{cursor:pointer;display:inline-flex;align-items:center;}
  .toggle-label{font-size:14px;font-weight:500;margin-left:8px;}
</style>
<?php end_section(); ?>


<?php start_section('content'); ?>

<!-- ===================================================== -->
<!--               MESSAGE MISE À JOUR                     -->
<!-- ===================================================== -->
<?php 
if (!empty($_GET['maj']) && $_GET['maj'] == "ok"): 

$type = isset($_GET['type']) ? $_GET['type'] : '';

switch ($type) {
    case 'gtm':
        $message = "Mise à jour Google Tag Manager effectuée";
        break;

    case 'cms':
        $message = "Mise à jour CMS effectuée";
        break;

    case 'cmp':
        $message = "Mise à jour CMP effectuée";
        break;

    case 'datalayer':
        $message = "Mise à jour DataLayer effectuée";
        break;

    default:
        $message = "Mise à jour effectuée";
        break;
}
?>

<div class="alert alert-success text-center mt-3" id="majConfirm">
    <?= $message ?>
</div>

<script>
setTimeout(() => { $('#majConfirm').fadeOut(); }, 3000);
</script>

<?php endif; ?>



<?php foreach ($donnees as $d): ?>

<?php
$cms_full = $d['cms'];
$cms_name = (stripos($cms_full, 'Inconnu') !== false || stripos($cms_full, 'non détectable') !== false)
            ? "Non détectable"
            : explode(' ', $cms_full)[0];
?>

<div class="container-fluid p-0 h-100">
  <div class="row no-gutters h-100">

    <?php $this->load->view('layouts/client/detail/sidebar'); ?>

    <div class="col w-100">
      <div class="container-fluid">
        <br>

        <div class="row row-cols-2">

          <!-- ===================================================== -->
          <!--                  GOOGLE TAG MANAGER CARD             -->
          <!-- ===================================================== -->
          <div class="col">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_gtm/'.$d['idclients'].'?maj=ok&type=gtm') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4">Google Tag Manager</h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?php if (!empty($d['tracking_gtm'])): ?>
                    Google Tag Manager installé — Action : demander l’accès administrateur et vérifier la configuration.
                  <?php else: ?>
                    Google Tag Manager NON installé — Vous pouvez activer la procédure GTM.
                  <?php endif; ?>
                </p>

                <?php if (!empty($d['tracking_gtm'])): ?>
                  <span class="badge alert-success rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> <?= $d['tracking_gtm']; ?>
                  </span>
                <?php else: ?>
                  <span class="badge alert-danger rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> GTM non installé
                  </span>
                <?php endif; ?>

              </div>
            </div>
          </div>


          <!-- ===================================================== -->
          <!--                          CMS CARD                     -->
          <!-- ===================================================== -->
          <div class="col">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_cms/'.$d['idclients'].'?maj=ok&type=cms') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4"><?= $cms_name; ?></h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?= ($cms_name != "Non détectable")
                      ? $cms_name . " est installé avec cette URL."
                      : "CMS indétectable."; ?>
                </p>

                <?php if ($cms_name != "Non détectable"): ?>
                <img src="<?= $d['cms_logo']; ?>" width="43">
                <?php endif; ?>

              </div>
            </div>
          </div>


          <!-- ===================================================== -->
          <!--                          CMP CARD                     -->
          <!-- ===================================================== -->
          <div class="col" style="margin-top:20px;">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_cmp/'.$d['idclients'].'?maj=ok&type=cmp') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4">CMP</h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?= (!empty($d['cmp']) && $d['cmp'] != "Aucun CMP détecté")
                      ? "CMP installé — vérifier conformité RGPD."
                      : "Aucun CMP — vous pouvez activer ou installer un CMP."; ?>
                </p>

                <?php if (!empty($d['cmp']) && $d['cmp'] != "Aucun CMP détecté"): ?>
                  <span class="badge alert-success rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> <?= $d['cmp']; ?>
                  </span>
                <?php else: ?>
                  <span class="badge alert-danger rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> CMP non installé
                  </span>
                <?php endif; ?>
              </div>

            </div>
          </div>



          <!-- ===================================================== -->
          <!--                     DATALAYER CARD                    -->
          <!-- ===================================================== -->
          <div class="col" style="margin-top:20px;">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_datalayer/'.$d['idclients'].'?maj=ok&type=datalayer') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4">DataLayer</h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?= (!empty($d['datalayer']) && $d['datalayer'] != "Non détecté")
                      ? "DataLayer détecté — vérifier sa structure et conformité."
                      : "Aucun DataLayer — vous pouvez en implémenter un."; ?>
                </p>

                <?php if (!empty($d['datalayer']) && $d['datalayer'] != "Non détecté"): ?>
                  <span class="badge alert-success rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> <?= $d['datalayer']; ?>
                  </span>
                <?php else: ?>
                  <span class="badge alert-danger rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> DataLayer non disponible
                  </span>
                <?php endif; ?>

              </div>

            </div>
          </div>

        </div>
        

<?php endforeach; ?>


<!-- ===================================================== -->
<!--             CRÉATION DE TÂCHES                        -->
<!-- ===================================================== -->
<br><br>
<h4 class="ml-3">Création de Tâches</h4>

<div class="mb-3">
  <div class="d-flex justify-content-between align-items-center border-bottom py-2">

    <div>
      <div>Procédure d'installation et Invitation</div>
      <div style="color:#8b8b8b;font-size:13px;">Ajout automatique dans Team Task</div>
    </div>

    <label class="toggle">
      <input type="checkbox" class="activer-procedure"
             data-idclient="<?= $d['idclients']; ?>"
             data-am="<?= $d['initiative']; ?>"
             data-assigned="<?= $d['account_manager']; ?>"
             <?= !empty($procedure_gtm) ? "checked disabled" : "" ?>>
      <span class="switch"><span class="knob"></span></span>
    </label>

  </div>
</div>


<!-- ===================================================== -->
<!--                  OFFICE MANAGER                       -->
<!-- ===================================================== -->
<h4 class="ml-3 mt-4">Office Manager</h4>

<div class="mb-3">

  <!-- Invitation -->
  <div class="d-flex justify-content-between align-items-center border-bottom py-2">
    <div>
      Invitation reçue du client
      <div style="color:#8b8b8b;font-size:13px;">Suivi notifications mobile</div>
    </div>

    <label class="toggle">
      <input type="checkbox" <?= !empty($procedure_gtm) ? "checked" : "" ?>>
      <span class="switch"><span class="knob"></span></span>
    </label>
  </div>

  <!-- GTM -->
  <div class="d-flex justify-content-between align-items-center border-bottom py-2">
    <div>
      Google Tag Manager
      <div style="color:#8b8b8b;font-size:13px;">Notifications desktop</div>
    </div>
    <label class="toggle">
      <input type="checkbox">
      <span class="switch"><span class="knob"></span></span>
    </label>
  </div>

</div>

</div>
</div>
</div>
</div>


<!-- ===================================================== -->
<!--                     SCRIPT AJAX                       -->
<!-- ===================================================== -->
<script>
$(document).ready(function () {

    $('.activer-procedure').change(function () {

        if (!this.checked) return;

        $.ajax({
            url: "<?= base_url('Client/activer_processus_tache'); ?>",
            method: "POST",
            data: {
                idclients: $(this).data('idclient'),
                am: $(this).data('am'),
                assigned_to: $(this).data('assigned'),
                date: new Date().toISOString().split('T')[0]
            },
            success: function () { alert("Processus activé avec succès !"); },
            error: function () { alert("Erreur lors de l'activation du processus."); }
        });
    });

});
</script>

<?php end_section(); ?>
