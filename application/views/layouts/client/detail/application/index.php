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
// 1) Priorité aux flash messages (set in controller)
$flash_type = null;
$flash_msg  = null;

if ($this->session->flashdata('success')) {
    $flash_type = 'success';
    $flash_msg  = $this->session->flashdata('success');
} elseif ($this->session->flashdata('warning')) {
    $flash_type = 'warning';
    $flash_msg  = $this->session->flashdata('warning');
} elseif ($this->session->flashdata('error')) {
    $flash_type = 'danger';
    $flash_msg  = $this->session->flashdata('error');
} elseif ($this->session->flashdata('info')) {
    $flash_type = 'info';
    $flash_msg  = $this->session->flashdata('info');
}

// 2) Fallback: ?maj=ok&type=... (ancienne méthode)
if (empty($flash_msg) && !empty($_GET['maj']) && $_GET['maj'] == "ok") {
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    switch ($type) {
        case 'gtm':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour Google Tag Manager effectuée";
            break;
        case 'cms':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour CMS effectuée";
            break;
        case 'cmp':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour CMP effectuée";
            break;
        case 'datalayer':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour DataLayer effectuée";
            break;
        case 'googleads':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour Google Ads effectuée";
            break;
        case 'google_analytics':
            $flash_type = 'success';
            $flash_msg  = "Mise à jour Google Analytics effectuée";
            break;
        default:
            $flash_type = 'success';
            $flash_msg  = "Mise à jour effectuée";
            break;
    }
}

if (!empty($flash_msg)):
    // sanitize output
    $safe_msg = htmlspecialchars($flash_msg, ENT_QUOTES, 'UTF-8');
?>
<div class="alert alert-<?= $flash_type ?> alert-dismissible fade show text-center mt-3" id="majConfirm" role="alert" aria-live="polite">
    <?= $safe_msg ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer" style="position:absolute;right:10px;top:8px;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<script>
(function($){
    $(function(){
        // auto-hide après 3s
        setTimeout(function(){
            $('#majConfirm').fadeOut(400, function(){ $(this).remove(); });
        }, 3000);

        // si l'utilisateur clique sur la croix, on supprime tout de suite
        $(document).on('click', '#majConfirm .close', function(){
            $('#majConfirm').remove();
        });
    });
})(jQuery);
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

    


        <!-- ===================================================== -->
          <!--                         Google Ads                     -->
          <!-- ===================================================== -->
          <div class="col" style="margin-top:20px;">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_googleads/'.$d['idclients'].'?maj=ok&type=googleads') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4">Google Ads </h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?= (!empty($d['googleads']) && $d['googleads'] != "Aucun Google Ads détecté")
                      ? "Google Ads installé."
                      : "Aucun Google Ads — vous pouvez activer ou installer un Google Ads."; ?>
                </p>

                <?php if (!empty($d['googleads']) && $d['googleads'] != "Aucun Google Ads détecté"): ?>
                  <span class="badge alert-success rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> <?= $d['googleads']; ?>
                  </span>
                <?php else: ?>
                  <span class="badge alert-danger rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> Google Ads non installé
                  </span>
                <?php endif; ?>
              </div>

            </div>
          </div>



          <!-- ===================================================== -->
          <!--                     Google Analytics                   -->
          <!-- ===================================================== -->
          <div class="col" style="margin-top:20px;">
            <div class="card h-100">

              <div class="nav-link py-3 text-right" style="margin-right:20px;">
                <a href="<?= base_url('Client/mis_a_jour_google_analytics/'.$d['idclients'].'?maj=ok&type=google_analytics') ?>">Mettre à jour</a>

              </div>

              <div class="card-body text-center">
                <h3 class="mb-4">Google Analytics</h3>

                <p class="text-muted mx-5 mb-5" style="font-size:18px;">
                  <?= (!empty($d['google_analytics']) && $d['google_analytics'] != "Non détecté")
                      ? "Google Analytics détecté."
                      : "Aucun Google Analytics — vous pouvez en implémenter un."; ?>
                </p>

                <?php if (!empty($d['google_analytics']) && $d['google_analytics'] != "Non détecté"): ?>
                  <span class="badge alert-success rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> <?= $d['google_analytics']; ?>
                  </span>
                <?php else: ?>
                  <span class="badge alert-danger rounded-pill px-4 py-3">
                    <i class="fa fa-circle mr-1"></i> Google Analytics non disponible
                  </span>
                <?php endif; ?>

              </div>

            </div>
          </div>

        </div>
        

<?php endforeach; ?>

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
