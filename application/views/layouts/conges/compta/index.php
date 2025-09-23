<?php start_section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url('assets/vendors/fullcalendar/css/main.min.css') ?>" />

<style>
	* {
		box-sizing: border-box;
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
	}

	#calendar,
	#mini_calendar {
		font-size: 14px;
		/* base text size */
		color: #202124;
		/* Google’s default text color */
	}

	/* Headers (LUN, MAR, MER …) */
	#calendar .fc-col-header-cell,
	#mini_calendar .fc-col-header-cell {
		font-weight: 500;
		/* medium, like Google */
		font-size: 12px;
		text-transform: uppercase;
	}

	/* Day numbers (1, 2, 3 …) */
	#calendar .fc-daygrid-day-top,
	#mini_calendar .fc-daygrid-day-top {
		font-weight: 400;
		font-size: 13px;
	}

	/* Event titles */
	#calendar .fc-event,
	#mini_calendar .fc-event {
		font-weight: 500;
		font-size: 12px;
	}

	/* Apply rounded corners only once at the outermost level */
	#calendar .fc-scrollgrid {
		border-radius: 28px;
		overflow: hidden;
		/* safe here */
	}

	/* Allow events to stretch across multiple days */
	#calendar .fc-daygrid,
	#calendar .fc-timegrid,
	#calendar .fc-daygrid-day,
	#calendar .fc-daygrid-day-frame,
	#calendar .fc-timegrid-slot {
		overflow: visible !important;
	}

	.fc-col-header-cell {
		border-bottom: none !important;
		text-transform: uppercase;
		padding-top: 10px;
	}

	#calendar .fc-view {
		background-color: white;
	}

	.fc-toolbar-title {
		font-weight: 600;
		font-size: 18px;
	}

	.fc .fc-next-button,
	.fc .fc-prev-button {
		background: transparent;
		border: none;
		font-weight: 500;
		border-radius: 50rem !important;
	}

	.fc-daygrid-day {
		border: 1px solid #f0f0f0;
	}

	.fc-day-today {
		background: #e8f0fe !important;
	}

	.fc-event {
		font-size: 13px;
		padding-left: 4px;
		cursor: pointer;
		border: none !important;
	}

	.fc-tooltip {
		position: absolute;
		z-index: 10000;
		background: #fff;
		border: 1px solid #ddd;
		padding: 8px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
		font-size: 13px;
	}

	.fc-icon {
		width: 1em;
		height: 1em;
		-webkit-user-select: none;
		user-select: none;
		font-family: fcicons !important;
		font-style: normal;
		font-variant: normal;
		line-height: 1;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		color: grey;
	}

	.fc .fc-today-button,
	.fc .fc-today-button:disabled {
		color: black;
		background-color: white;
		border: 1px solid black;
		border-radius: 25px;
		padding-left: 25px;
		padding-right: 25px;
	}

	#mini_calendar .fc {
		height: 374px !important;
	}

	/* 1. Remove outer container borders and shadows */
	#mini_calendar,
	#mini_calendar .fc,
	#mini_calendar .fc-scrollgrid,
	#mini_calendar .fc-scrollgrid-section,
	#mini_calendar .fc-col-header,
	#mini_calendar .fc-col-header-cell {
		border: none !important;
		box-shadow: none !important;
	}

	/* 2. Remove toolbar/header borders and background */
	#mini_calendar .fc-toolbar,
	#mini_calendar .fc-toolbar-chunk {
		border: none !important;
		box-shadow: none !important;
		background: transparent !important;
	}

	/* 3. Remove day cell borders */
	#mini_calendar .fc-daygrid-day,
	#mini_calendar .fc-daygrid-body td,
	#mini_calendar .fc-timegrid-slot {
		border: none !important;
	}

	/* 4. Remove event block borders if any */
	#mini_calendar .fc-event {
		border: none !important;
		box-shadow: none !important;
	}

	/* 5. Remove horizontal lines in week/day views */
	#mini_calendar .fc-timegrid-slot {
		border-top: none !important;
	}

	/* Center weekday headers */
	#calendar .fc-col-header-cell,
	#mini_calendar .fc-col-header-cell {
		text-align: center !important;
	}

	/* Center day numbers inside grid cells */
	#calendar .fc-daygrid-day-top,
	#mini_calendar .fc-daygrid-day-top {
		justify-content: center !important;
	}

	#mini_calendar .fc-event {
		display: none !important;
	}

	#mini_calendar .fc-daygrid-day-top {
		justify-content: center !important;
		align-items: center !important;
	}

	#mini_calendar .fc-daygrid-day-events {
		display: none;
	}
</style>
<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="d-flex">
	<div id="calendar_sidebar">
		<button id="createEventBtn" class="btn btn-white border rounded py-3 px-4 shadow-sm">
			<i class="fa fa-plus"></i>
			Créer
		</button>

		<div id="mini_calendar" class="my-3"></div>

		<h3>Mes agendas</h3>

		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Télétravail" name="agendaFilter" value="Télétravail" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Télétravail">Télétravail</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Perso" name="agendaFilter" value="Perso" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Perso">Perso</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Soutenance" name="agendaFilter" value="Soutenance" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Soutenance">Soutenance</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Formation" name="agendaFilter" value="Formation" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Formation">Formation</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Maladie" name="agendaFilter" value="Maladie" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Maladie">Maladie</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Congé" name="agendaFilter" value="Congé" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Congé">Congé</label>
		</div>
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="agenda_Contact" name="agendaFilter" value="Contact" aria-selected="true" checked>
			<label class="custom-control-label m-0" for="agenda_Contact">Contact</label>
		</div>

		<h3>Filtres</h3>
		<div class="form-group">
			<label for="userFilter">Filtrer par utilisateur :</label>
			<select id="userFilter" class="custom-select" style="width:100%; padding:6px;">
				<option value="">-- Tous les utilisateurs --</option>
			</select>
		</div>
	</div>

	<div class="main">
		<table class="table table-wrapper">
			<thead class="bg-light">
				<tr>
					<th>Nom</th>
					<th>Date début</th>
					<th>Date fin</th>
					<th>Motif</th>
					<th>Nbr jours</th>
					<th>État</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($events as $event): ?>
					<tr>
						<td></td>
						<td><?= htmlspecialchars($event->start_date) ?></td>
						<td><?= htmlspecialchars($event->end_date) ?></td>
						<td><?= htmlspecialchars($event->title) ?></td>
						<td><?= htmlspecialchars($event->nbr_jour) ?></td>
						<td></td>
					</tr>
				<?php endforeach; ?>
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

		var miniCalEl = document.createElement('div');
		miniCalEl.id = 'miniCalInner';
		document.getElementById('mini_calendar').appendChild(miniCalEl);

		var miniCal = new FullCalendar.Calendar(miniCalEl, {
			initialView: 'dayGridMonth',
			headerToolbar: false,
			contentHeight: 10,
			locale: 'fr',
			dayHeaderFormat: {
				weekday: 'narrow'
			},
			dateClick: function(info) {
				if (window.calendar) window.calendar.gotoDate(info.date);
			}
		});

		miniCal.render();
	});
</script>
<?php end_section(); ?>
