<nav class="navbar navbar-expand sticky-top navbar-light bg-white border-bottom pl-4" style="height: 72px;">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

	<button class="btn btn-light py-0 px-1 position-absolute" id="toggleSidebar" style="left: -16px;">
		<img class="img" src="<?= base_url('assets/images/icons/figma/Menu/CaretDoubleHorizontal.png') ?>">
	</button>

	<form action="" class="form-inline mr-auto">
    <input class="form-control" type="text" id="search_client" placeholder="Search" aria-label="Search">

</form>


	<ul class="navbar-nav align-items-center">
		<li class="nav-item">
			<a class="nav-link" href="#">
				<img src="<?= base_url('assets/images/icons/figma/icon-question.svg') ?>" alt="">
				Ticket
			</a>
		</li>
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle d-flex align-items-center" href="javascript:void(0);" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php $current_user = $this->ion_auth->user()->row(); ?>
				<img src="<?= base_url('assets/images/' . $current_user->photo_users) ?>" class="rounded-circle mr-2" width="32" height="32" alt="User Image">
				<span class="d-none d-md-inline mr-2"><?php echo $current_user->first_name ?> <?php echo $current_user->last_name ?></span>
				<i class="fa fa-chevron-down"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="<?php echo base_url("admin/user/edit/" . $current_user->id); ?>">Profile</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item text-danger" href="<?php echo base_url("admin/user/logout"); ?>">Logout</a>
			</div>
		</li>
	</ul>
</nav>
<script>
$(document).ready(function () {
    $("#search_client").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= site_url('Client/search') ?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nom_client,
                            value: item.nom_client,
                            idclients: item.idclients
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            window.location.href = "<?= site_url('client/detail_client/') ?>" + ui.item.idclients;
        }
    });
});
</script>


