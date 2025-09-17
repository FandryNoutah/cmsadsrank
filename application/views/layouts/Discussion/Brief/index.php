<?php start_section('page_title'); ?>
Discussion
<?php end_section(); ?>

<?php start_section('content'); ?>


<div class="row no-gutters h-100">

	<?php $this->load->view('layouts/discussion/sidebar'); ?>

	<div class="col" style="height: calc(100vh - 130px); overflow-y:auto;">
		<div class="container-fluid">
			<h5 class="mb-4">📥 Message Team Task <small>(<?= count($tasks); ?> messages)</small></h5>

			<?php foreach ($tasks as $task): ?>
				<?php if ($taREMOVED>count_messages > 0): ?>
					<div class="card mb-3">
						<div class="card-body">
							<div class="d-flex justify-content-between mb-2">
								<span class="font-weight-bold"><?= nl2br(htmlspecialchars($taREMOVED>username)); ?></span>
								<span class="text-muted small"><?= nl2br(htmlspecialchars($taREMOVED>date_due)); ?></span>
							</div>

							<div class="font-weight-bold mb-1"><?= htmlspecialchars($taREMOVED>title); ?></div>
							<div class="text-muted small mb-2"><?= nl2br(htmlspecialchars($taREMOVED>description)); ?></div>

							<button class="btn btn-light btn-sm mt-1">👍 4</button>
							<button class="btn btn-light btn-sm mt-1" data-toggle="modal" data-target="#discussionModal" data-id="<?= $taREMOVED>idtask; ?>">
								💬
								<?= $taREMOVED>count_messages; ?>
							</button>

						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

		</div>
	</div>
</div>

<?php $this->load->view('layouts/discussion/modal'); ?>

<?php end_section(); ?>
