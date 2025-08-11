<?php start_section('stylesheet'); ?>
<style>
  .section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .toggle{
    --w:38px;
    --h:20px;
    position:relative;
  }

  .switch{
    width:var(--w);
    height:var(--h);
    border-radius:999px;
    background:#E6E6E6;
    display:inline-block;
    position:relative;
    transition:background .18s ease;
  }

  .knob{
    --size:14px;
    width:var(--size);
    height:var(--size);
    border-radius:50%;
    background:black;
    position:absolute;
    top:50%;
    transform:translate(4px,-50%);
    transition:transform .18s ease, background .18s ease;
  }

  input[type="checkbox"]{
    position:absolute;
    opacity:0;
    pointer-events:none;
  }

  input[type="checkbox"]:checked + .switch{
    background:#111;
  }

  input[type="checkbox"]:checked + .switch .knob{
    transform:translate(calc(var(--w) - 18px), -50%);
    background:#fff;
  }

  label.toggle{
    cursor:pointer;
    display:inline-flex;
    align-items:center;
  }

  .toggle-label{
    font-size: 14px;
    font-weight: 500;
    margin-left: 8px;
  }
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="container-fluid p-0 h-100">
  <div class="row no-gutters h-100">
    <?php $this->load->view('layouts/client/detail/sidebar'); ?>
    <div class="col w-100">
      <div class="container-fluid">
        <br>
		<?php foreach ($donnees as $d): ?>
					<div class="row row-cols-2">
						<div class="col">
							<div class="card h-100">
								<div class="nav-link py-3 active"  style="text-align: right; margin-top: 10px; margin-right: 20px;">	
								installed
								</div>
								<div class="card-body text-center">
									<h3 class="mb-4">Google Tag Manager</h3>
									<p class="text-muted mx-5 mb-5" style="font-size: 18px;">
										Google Tag Manager installé 
										Action : Demander l’accès administrateur au conteneur GTM (gtm@adsrank.fr) et vérifier la configuration.</p>
									<span class="badge alert-success rounded-pill px-4 py-3" style="font-size: 14px; font-weight: 500;">
										<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
										<?php echo $d['tracking_gtm']; ?>
									</span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card h-100">
								<div class="nav-link py-3 active"  style="text-align: right; margin-top: 10px; margin-right: 20px;">	
								installed
								</div>
								<div class="card-body text-center">
									<h3 class="mb-4">Wordpress</h3>
									<p class="text-muted mx-5 mb-5" style="font-size: 18px;">
										WordPress est installé avec cette URL.
										Action : Vérifier la présence de GTM puis suivre la procédure correspondante.
									</p>
									<div class="row justify-content-center">
										<div class="col-auto">
											<img src="<?php echo $d['cms_logo']; ?>" width="43">
										</div>
									</div>
								</div>
							</div>
						</div>

						
					</div>
				<?php endforeach; ?>
        <br><br>
        <label>
          <h4 class="mb-0 ml-3">Création de Tâches</h4>
        </label>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center border-bottom py-2">
            <div>
              <div >Procédure d'installation et Invitation</div>
              <div style="color:#8b8b8b;font-size:13px;">En sélectionnant cette option, la tâche correspondante sera automatiquement ajoutée à votre Team Task</div>
            </div>
            <label class="toggle" aria-label="Activer procédure">
              <input type="checkbox" />
              <span class="switch">
                <span class="knob"></span>
              </span>
            </label>
          </div>
        </div>

        </br>
		  <label>
          <h4 class="mb-0 ml-3">Office Manager </h4>
        </label>
        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center border-bottom py-2">
            <div>
              Invitation reçu du client
              <div style="color:#8b8b8b;font-size:13px;">Receive push notifications on mentions and comments via your mobile app</div>
            </div>
            <label class="toggle">
              <input type="checkbox" />
              <span class="switch">
                <span class="knob"></span>
              </span>
            </label>
          </div>
          <div class="d-flex justify-content-between align-items-center border-bottom py-2">
            <div>
              Google Tag manager
              <div style="color:#8b8b8b;font-size:13px;">Receive push notifications on mentions and comments immediately on your desktop app</div>
            </div>
            <label class="toggle">
              <input type="checkbox" />
              <span class="switch">
                <span class="knob"></span>
              </span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', e => {
      console.log('Toggle changed:', e.target.checked);
    });
  });
  document.getElementById('toggle_procedure').addEventListener('change', function(e) {
    var checked = e.target.checked;
    fetch('<?php echo site_url('Client/activer_processus_tache'); ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'etat=' + (checked ? 1 : 0)
    })
    .then(response => response.text())
    .then(data => {
      console.log('Réponse serveur:', data);
    })
    .catch(err => {
      console.error('Erreur:', err);
    });
  });
</script>
<?php end_section(); ?>
