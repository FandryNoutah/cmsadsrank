<?php start_section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url('assets/vendors/fullcalendar/css/main.min.css') ?>" />

<style>
	body {
		overflow: hidden;
		font-family: 'Roboto', sans-serif;
	}

	#calendar_sidebar {
		width: 260px;
		padding: 12px;
		overflow: auto;
		height: calc(100vh - 101px);
	}

	#calendar_sidebar h3 {
		margin: 16px 0 8px;
		color: #5f6368;
		font-size: 13px;
	}

	#calendar_sidebar label {
		display: block;
		margin-bottom: 6px;
		font-size: 14px;
	}

	.main {
		flex: 1;
		padding: 12px;
		height: calc(100vh - 101px);
		overflow: auto;
		background: #fff;
	}
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="d-flex bg-light">
	<div id="calendar_sidebar">
		<button id="createEventBtn" class="btn btn-white border rounded py-3 px-4 shadow-sm w-100">
			<i class="fa fa-plus"></i>
			Créer
		</button>
		<div id="miniCalendar" class="my-3"></div>
		<h3>Mes agendas</h3>
		<?php
		$agendas = ["Télétravail", "Perso", "Soutenance", "Formation", "Maladie", "Congé", "Contact"];
		foreach ($agendas as $a): ?>
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input"
					id="agenda_<?= $a ?>" name="agendaFilter" value="<?= $a ?>" checked>
				<label class="custom-control-label m-0" for="agenda_<?= $a ?>"><?= $a ?></label>
			</div>
		<?php endforeach; ?>
		<h3>Filtres</h3>
		<div class="form-group">
			<label for="userFilter">Filtrer par utilisateur :</label>
			<select id="userFilter" class="custom-select custom-select-sm w-100">
				<option value="">-- Tous les utilisateurs --</option>
			</select>
		</div>
	</div>

	<div class="main">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<div>
				<button id="todayBtn" class="btn btn-outline-dark rounded-pill px-4 btn-sm">Aujourd'hui</button>
				<button id="prevBtn" class="btn btn-white">
					<i class="fa fa-chevron-left"></i>
				</button>
				<button id="nextBtn" class="btn btn-white">
					<i class="fa fa-chevron-right"></i>
				</button>
			</div>
			<h3 id="monthTitle" class="m-0"></h3>
			<div>
				<select id="viewSelect" class="custom-select custom-select-sm">
					<option value="month">Mois</option>
				</select>
			</div>
		</div>

		<table class="table table-bordered table-hover rounded">
			<thead class="thead-light">
				<tr>
					<th>Titre</th>
					<th>Début</th>
					<th>Fin</th>
					<th>Agenda</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody id="eventTableBody">
				<tr>
					<td colspan="5" class="text-center text-muted">Chargement...</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script src="<?= base_url('assets/vendors/fullcalendar/js/main.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/fullcalendar/js/locale.fr.js') ?>"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var URL_FETCH_EVENTS = '<?= site_url("calendar/fetch_events"); ?>';
		var URL_FETCH_USERS = '<?= site_url("calendar/fetch_users"); ?>';
		var URL_EVENT_DETAIL = '<?= site_url("calendar/event_detail"); ?>';
		var URL_DELETE_EVENT = '<?= site_url("calendar/delete_event"); ?>';

		var currentDate = new Date();

		var miniCal = new FullCalendar.Calendar(document.getElementById('miniCalendar'), {
			initialView: 'dayGridMonth',
			headerToolbar: false,
			editable: false,
			dayMaxEvents: false,
		});
		miniCal.render();

		function updateMonthTitle() {
			var options = {
				month: 'long',
				year: 'numeric'
			};
			document.getElementById('monthTitle').innerText = currentDate.toLocaleDateString('fr-FR', options);
		}

		function loadUsers() {
			$.get(URL_FETCH_USERS, function(users) {
				var $filter = $('#userFilter').empty();
				$filter.append('<option value="">-- Tous les utilisateurs --</option>');
				users.forEach(function(u) {
					var name = (u.first_name || '') + ' ' + (u.last_name || '');
					if (!name.trim()) name = u.username || u.email || ('user-' + u.id);
					$filter.append($('<option>').val(u.id).text(name));
				});
			}, 'json');
		}

		function loadEvents() {
			var userId = $('#userFilter').val() || '';
			var agendaFilters = $('input[name="agendaFilter"]:checked').map(function() {
				return this.value;
			}).get();

			$('#eventTableBody').html('<tr><td colspan="5" class="text-center text-muted">Chargement...</td></tr>');

			$.ajax({
				url: URL_FETCH_EVENTS,
				data: {
					user_id: userId,
					agendaFilters: agendaFilters,
					start: new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).toISOString(),
					end: new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).toISOString()
				},
				dataType: 'json'
			}).done(function(response) {
				var events = response;
				if (response.data) {
					events = response.data;
				}

				if (!events.length) {
					$('#eventTableBody').html('<tr><td colspan="5" class="text-center text-muted">Aucun événement trouvé</td></tr>');
					return;
				}

				var rows = events.map(function(ev) {
					return `
					<tr>
						<td>${ev.title || '-'}</td>
						<td>${ev.start || '-'}</td>
						<td>${ev.end || '-'}</td>
						<td>${ev.agenda || '-'}</td>
						<td>
							<button class="btn btn-sm btn-outline-primary" onclick="openEditModal(${ev.id})">
								<i class="fa fa-edit"></i>
							</button>
							<button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(${ev.id})">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>`;
				});
				$('#eventTableBody').html(rows.join(''));
			}).fail(function() {
				$('#eventTableBody').html('<tr><td colspan="5" class="text-center text-danger">Erreur de chargement</td></tr>');
			});
		}

		$('#todayBtn').on('click', function() {
			currentDate = new Date();
			updateMonthTitle();
			loadEvents();
		});
		$('#prevBtn').on('click', function() {
			currentDate.setMonth(currentDate.getMonth() - 1);
			updateMonthTitle();
			loadEvents();
		});
		$('#nextBtn').on('click', function() {
			currentDate.setMonth(currentDate.getMonth() + 1);
			updateMonthTitle();
			loadEvents();
		});

		$('#userFilter, input[name="agendaFilter"]').on('change', loadEvents);

		updateMonthTitle();
		loadUsers();
		loadEvents();
	});
</script>
<?php end_section(); ?>
