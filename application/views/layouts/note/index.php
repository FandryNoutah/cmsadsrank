<?php start_section('stylesheet'); ?>
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
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
Note
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<li class="nav-item">
		<a class="nav-link py-3 active" type="button" id="list_tab" data-toggle="tab" data-target="#list" type="button" role="tab" aria-controls="list" aria-selected="true">
			<img src="<?= base_url('assets/images/icons/figma/icon-list.svg') ?>" alt="">
			List
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link py-3" type="button" id="kanban_tab" data-toggle="tab" data-target="#kanban" type="button" role="tab" aria-controls="kanban" aria-selected="false">
			<img src="<?= base_url('assets/images/icons/figma/icon-kanban.svg') ?>" alt="">
			Kanban
		</a>
	</li>
</ul>

<div class="row mx-lg-2">
	<div class="col-auto px-1">
		<button class="btn btn-outline-dark">
			<img src="<?= base_url('assets/images/icons/figma/icon-funnelsimple.svg') ?>" alt="">
			Sort By
		</button>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-outline-dark">
			<img src="<?= base_url('assets/images/icons/figma/icon-funnel.svg') ?>" alt="">
			Filter
		</button>
	</div>
	<div class="col-auto px-1">
		<button class="btn btn-dark" data-toggle="modal" data-target="#taskModal">
			<img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
			Add Note
		</button>
	</div>
</div>
<?php end_section(); ?>

<?php start_section('content'); ?>
	<div class="tab-pane fade" id="kanban" role="tabpanel" aria-labelledby="kanban_tab">
    <div class="card mt-3">
								<div class="card-body">
									<div class="d-flex">
										<div class="mr-2">
											<span class="badge alert-success">Internal</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-warning">Marketing</span>
										</div>
										<div class="mr-2">
											<span class="badge alert-danger">Urgent</span>
										</div>
										<a href="#" class="col-auto ml-auto text-decoration-none text-muted">
											<i class="fa fa-ellipsis-h"></i>
										</a>
									</div>
									<h6 class="my-3" style="font-size: 14px;">Monthly product Descussion</h6>
									<div class="row mb-3" style="font-size: 14px;">
										<span class="col-auto mr-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/calendar.svg') ?>" alt="">
											Due Date 24 Jan 2023
										</span>
										<span class="col-auto text-muted">
											<img src="<?= base_url('assets/images/icons/figma/checklist.svg') ?>" alt="">
											10/124
										</span>
									</div>
									<div class="row no-gutters" style="font-size: 14px;">
										<div class="col-auto mr-auto">
											<div class="d-flex align-items-center avatar-group">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 1">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 2">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 3">
												<img src="<?= base_url('assets/images/figma/user_frame.png') ?>" width="24" class="rounded-circle avatar" alt="Avatar 4">
											</div>
										</div>
										<span class="col-auto mr-3 text-muted">
											<img src="<?= base_url('assets/images/icons/figma/attachment-8.svg') ?>" alt="">
											5
										</span>
										<span class="javascript:void(0);ol-auto text-muted" data-toggle="modal" data-target="#discussionModal" data-id="id_task">
											<img src="<?= base_url('assets/images/icons/figma/chat-9.svg') ?>" alt="">
											19
										</span>
									</div>
								</div>
							</div>
    
  </div>

</body>
</html>
<?php end_section(); ?>