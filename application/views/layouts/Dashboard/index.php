<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border: border;
		border-bottom: 1px solid #dee2e6 !important;
		padding: 14px !important;
	}

	.table-wrapper tbody tr td:first-child,
	.table-wrapper thead tr th:first-child {
		border-left: 1px solid #dee2e6;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.table-wrapper tbody tr td:last-child,
	.table-wrapper thead tr th:last-child {
		border-right: 1px solid #dee2e6;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	.table-synced th:nth-child(2),
	.table-synced td:nth-child(2) {
		width: 15%;
	}

	.table-synced th:nth-child(3),
	.table-synced td:nth-child(3) {
		width: 15%;
	}

	.table-synced th:nth-child(4),
	.table-synced td:nth-child(4) {
		width: 15%;
	}

	.table-synced th:nth-child(5),
	.table-synced td:nth-child(5) {
		width: 10%;
	}

	.table-synced th:nth-child(6),
	.table-synced td:nth-child(6) {
		width: 5%;
	}

	/* For modal attachment design */
	.file-drop-area {
		border: 2px dashed #ccc;
		border-radius: 8px;
		padding: 30px;
		text-align: center;
		cursor: pointer;
		transition: border-color 0.3s;
	}

	.file-drop-area.dragover {
		border-color: #0d6efd;
		/* bootstrap primary */
		background: #f8f9fa;
	}

	.file-drop-icon {
		font-size: 40px;
		color: #6c757d;
		margin-bottom: 10px;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
Dashboard
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<style>
:root{
--bg: #ffffff;
--text: #101112;
--muted: #7a7f85;
--accent: #0a0a0a; 
--track: #dadcdf; 
--p: 64; 
}
*{box-sizing:border-box}



.ring{
--size: 140px;
width:var(--size); height:var(--size);
display:grid; place-items:center;
border-radius:50%;
background:
conic-gradient(var(--accent) calc(var(--p)*1%), var(--track) 0);
position:relative;
}
.ring::after{
content:"";
position:absolute; inset:10px; border-radius:50%; background:var(--bg);
box-shadow: inset 0 0 0 1px rgba(0,0,0,.04);
}
.percent{
position:relative; font-weight:700; font-size:28px;
}


.stack{flex:1 1 auto; min-width:0}
.label{font-size:22px; font-weight:600; letter-spacing:.2px; color:#73787f}
.big{font-size:56px; font-weight:800; line-height:1.1; margin:.15em 0}
.sub{font-size:22px; color:#8a9096}


.chev{flex:0 0 auto; width:56px; height:56px; border-radius:999px; border:1.5px solid #111;
display:grid; place-items:center; background:#fff; cursor:pointer; transition:.2s ease;
}
.chev:hover{ transform:translateX(2px); box-shadow:0 6px 16px rgba(0,0,0,.12)}
.chev svg{ width:26px; height:26px }
.percent {
  position: relative;
  font-weight: 700;
  font-size: 28px;
  z-index: 1; /* 👈 Ajoute ceci */
}


</style>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">
	<div class="row row-cols-4 mb-5" style="margin-top: 30px;">
    
		<div class="col">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="ring" id="ringPlanifie">
                        <div class="percent" id="percentPlanifie">0%</div>
                    </div>
                    <a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Progression tâche</a>
                    <i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"  href="<?= base_url('Task') ?>"></i>
                </div>
                <h3 class="m-0"><span id="donePlanifie"><?= $nbr_task_planifier ?></span>/<span id="totalPlanifie"><?= $nbr_task ?></span> Tâches</h3>
            </div>
        </div>
    </div>
	
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="ring" id="ringAttribue">
                        <div class="percent" id="percentAttribue">0%</div>
                    </div>
                    <a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Progression tâche attribuée</a>
                    <i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
                </div>
                <h3 class="m-0"><span id="doneAttribue"><?= $nbr_task_attribuer_plannifier ?></span>/<span id="totalAttribue"><?= $nbr_task_attribuer ?></span> Tâches</h3>
            </div>
        </div>
    </div>

	<div class="col">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="ring" id="ringAttribue">
                        <div class="percent" id="percentAttribue">0%</div>
                    </div>
                    <a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Progression tâche attribuée</a>
                    <i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
                </div>
                <h3 class="m-0"><span id="doneAttribue"><?= $nbr_task_attribuer_plannifier ?></span>/<span id="totalAttribue"><?= $nbr_task_attribuer ?></span> Tâches</h3>
            </div>
        </div>
    </div>

	<div class="col">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="ring" id="ringAttribue">
                        <div class="percent" id="percentAttribue">0%</div>
                    </div>
                    <a href="#" class="text-decoration-none text-muted ml-3 stretched-link">Progression tâche attribuée</a>
                    <i class="fa fa-chevron-right ml-auto" style="font-size: 12px;"></i>
                </div>
                <h3 class="m-0"><span id="doneAttribue"><?= $nbr_task_attribuer_plannifier ?></span>/<span id="totalAttribue"><?= $nbr_task_attribuer ?></span> Tâches</h3>
            </div>
        </div>
    </div>
</div>
<h3>Client</h3>
Nombre de client : <?php echo $nbr_client; ?></br>
Nombre de client Actif : <?php echo $nbr_client_actif; ?> Budget : <?php echo $total_budget_actif; ?> €</br>
Nombre de client En pause : <?php echo $nbr_client_pause;  ?> Budget : <?php echo $total_budget_en_pause; ?> €</br>
Nombre de client Résilié : <?php echo $nbr_client_resilie; ?>  Budget : <?php echo $total_budget_resilie; ?> €</br>
<h3>Note</h3>
<?php foreach($notes as $n ): ?>
	<?= htmlspecialchars($n->title); ?>
	

<?php endforeach; ?></br>
<h3>Discussion tâche</h3></br>
Nombre de discussion tâche : <?php echo $nbr_discussion_task; ?></br>	
<h3>Discussion Note</h3></br>
Nombre de discussion Note : <?php echo $nbr_discussion_note; ?></br>	
<h3>Discussion GTM</h3></br>
Nombre de discussion GTM : <?php echo $nbr_discussion_gtm; ?></br>	

<script>
    const completedPlanifie = <?= $nbr_task_planifier ?>;
const totalPlanifie = <?= $nbr_task ?>;
const pPlanifie = totalPlanifie > 0 ? Math.round((completedPlanifie / totalPlanifie) * 100) : 0;
document.getElementById('percentPlanifie').textContent = pPlanifie + '%';
document.getElementById('ringPlanifie').style.background =
    `conic-gradient(var(--accent) ${pPlanifie}%, var(--track) ${pPlanifie}% 100%)`;

const completedAttribue = <?= $nbr_task_attribuer_plannifier ?>;
const totalAttribue = <?= $nbr_task_attribuer ?>;
const pAttribue = totalAttribue > 0 ? Math.round((completedAttribue / totalAttribue) * 100) : 0;
document.getElementById('percentAttribue').textContent = pAttribue + '%';
document.getElementById('ringAttribue').style.background =
    `conic-gradient(var(--accent) ${pAttribue}%, var(--track) ${pAttribue}% 100%)`;

</script>

<?php end_section(); ?>
