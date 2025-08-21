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
		<div class="d-flex justify-content-between">
						<h1 style="font-size: 48px;">Tâches en cours | <?php echo $donnees[0]['nom_client'] ?></h1>
					
					</div><br>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr class="text-muted">
									<th>Label</th>
									<th>Date de la demande</th>
									<th>Date due</th>
									<th>Description</th>
									<th>Status</th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="6">
										<a href="#" class="text-dark">
											<i class="fa fa-plus"></i>
											New Task
										</a>
									</td>
								</tr>
								<?php if ($task != NULL): ?>
									<?php foreach ($task as $t): ?>
										<tr>
											<td class="align-middle" style="font-weight: 500;"><?php echo $t->title; ?></td>
											<td class="align-middle text-muted">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												<?php echo $t->date_demande; ?>
											</td>
											<td class="align-middle text-muted">
												<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
												<?php echo $t->date_due; ?>
											</td>
											<td class="align-middle text-muted">
												<?php echo $t->description; ?>
											</td>

											<td class="align-middle">
												<span class="badge alert-warning rounded-pill px-3 py-2" style="font-size: 12px; font-weight: 500;">
													<i class="fa fa-circle mr-1" style="font-size: 10px;"></i>
													Planned
												</span>
												<a href="javascript:void(0);" class="ml-auto">
													<i class="fa fa-ellipsis-v"></i>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

							</tbody>
						</table>
        <br><br>
        
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
