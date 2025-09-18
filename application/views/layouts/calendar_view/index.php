<html>

<head>
	<meta charset="utf-8">
	<title>Calendrier</title>

	<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />

	<link rel="stylesheet" href="<?= base_url('assets/vendors/fullcalendar/css/main.min.css') ?>" />

	<style>
		.fc .fc-scrollgrid {
			background-color: #fff !important;
			border-radius: 28px;
		}

		/* ===== Toolbar Styling ===== */
		.fc .fc-toolbar {
			background: #f8f9fa;
			/* light gray */
			border-radius: 12px;
			padding: 10px;
			margin-bottom: 20px;
		}

		.fc .fc-toolbar-title {
			font-size: 1.25rem;
			font-weight: 500;
		}

		.fc .fc-button {
			border-radius: 20px !important;
			background: white;
			border: 1px solid #dcdcdc;
			color: #333;
			padding: 6px 14px;
			font-weight: 500;
			box-shadow: none;
		}

		.fc .fc-button:hover {
			background: #f0f0f0;
		}

		.fc .fc-button-primary:not(:disabled).fc-button-active,
		.fc .fc-button-primary:not(:disabled):active {
			background: #e6f0ff;
			border-color: #b3d1ff;
			color: #0066cc;
		}

		/* ===== Day Header Styling (Mon, Tue...) ===== */
		.fc .fc-col-header-cell {
			background: white;
			color: #5f6368;
			/* Google gray */
			font-weight: 500;
			text-align: center;
			border-top-left-radius: 28px;
			border-top-right-radius: 28px;
		}

		/* ===== Day Cell Styling ===== */
		.fc-theme-standard td,
		.fc-theme-standard th {
			border: 1px solid #e6e6e6;
			/* softer borders */
		}

		.fc .fc-daygrid-day {
			text-align: center;
			/* center align numbers */
			vertical-align: top;
			border-radius: 10px;
		}

		.fc .fc-daygrid-day-number {
			font-weight: 500;
			color: #3c4043;
		}

		/* Highlight today */
		.fc .fc-day-today {
			background: #eaf2fe !important;
		}

		/* ===== Events Styling ===== */
		.fc .fc-event {
			border-radius: 8px !important;
			padding: 2px 6px;
			font-size: 0.85rem;
			font-weight: 500;
			border: none;
		}

		.fc .fc-event:hover {
			opacity: 0.9;
		}

		.fc .fc-daygrid-day-top {
			display: grid !important;
		}

		.fc .fc-today-button, .fc-today-button:disabled {
			color: #1f1f1f;
			border-color: #1f1f1f;
			background-color: transparent;
			border-radius: 50rem !important;
		}

		.fc-prev-button {
			color: #1f1f1f;
			background-color: transparent;
			border: 0px;
		}
	</style>
</head>

<body class="bg-light">

	<!-- <div class="form-group text-center">
		<label for="userFilter">Filtrer par utilisateur :</label>
		<select id="userFilter" class="form-control mx-auto" style="max-width: 200px;">
			<option value="">-- Tous les utilisateurs --</option>
		</select>
	</div> -->

	<div class="container">
		<div id="calendar"></div>
	</div>

	<?php $this->load->view('layouts/calendar_view/modal/event'); ?>
	<?php $this->load->view('layouts/calendar_view/modal/edit'); ?>

	<script src="<?= base_url('assets/vendors/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fontawesome/js/all.min.js') ?>"></script>

	<script src="<?= base_url('assets/vendors/fullcalendar/js/main.min.js') ?>"></script>
	<script src="<?= base_url('assets/vendors/fullcalendar/js/locale.fr.js') ?>"></script>

	<!-- <script>
		let calendar; // global

		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			calendar = new FullCalendar.Calendar(calendarEl, { // <-- sans var
				initialView: 'dayGridMonth',
				locale: 'fr',
				events: function(fetchInfo, successCallback, failureCallback) {
					var userId = $('#userFilter').val() || '';
					$.ajax({
						url: '<?php echo site_url("calendar/fetch_events"); ?>',
						data: {
							start: fetchInfo.startStr,
							end: fetchInfo.endStr,
							user_id: userId
						},
						dataType: 'json',
						success: function(data) {
							successCallback(data);
						},
						error: function(err) {
							console.error("Erreur fetch_events", err);
							failureCallback(err);
						}
					});
				}

			});

			calendar.render();

			// maintenant ça marche car calendar est global
			$('#userFilter').on('change', function() {
				calendar.refetchEvents();
			});
		});
	</script> -->

	<script>
		$(function() {

			function toggleCustomTitle(select) {
				const customContainer = document.getElementById('custom-title-container');
				if (select.value === 'Autre') {
					customContainer.style.display = 'block';
				} else {
					customContainer.style.display = 'none';
				}
			}

			const frenchHolidays = [
				"2025-01-01",
				"2025-04-21",
				"2025-05-01",
				"2025-05-08",
				"2025-05-29",
				"2025-06-09",
				"2025-07-14",
				"2025-08-15",
				"2025-11-01",
				"2025-11-11",
				"2025-12-25",
				"2026-01-01",
				"2026-04-06",
				"2026-05-01",
				"2026-05-08",
				"2026-05-14",
				"2026-05-25",
				"2026-07-14",
				"2026-08-15",
				"2026-11-01",
				"2026-11-11",
				"2026-12-25"
			];

			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap',
				initialView: 'dayGridMonth',
				locale: 'fr',
				timeZone: 'local',
				headerToolbar: {
					left: 'today prev,next',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				navLinks: true, // click day/week names to navigate
				selectable: true, // select to create events
				editable: true, // drag/drop and resize events
				nowIndicator: true,
				events: '<?php echo site_url("calendar/fetch_events"); ?>',
				selectable: true,
				displayEventTime: false,
				dayCellDidMount: function(info) {
					const dateStr = info.date.getFullYear() + '-' +
						String(info.date.getMonth() + 1).padStart(2, '0') + '-' +
						String(info.date.getDate()).padStart(2, '0');

					const day = info.date.getDay();
					if (frenchHolidays.includes(dateStr)) {
						info.el.style.backgroundColor = '#ffe5e5';
					} else if (day === 0 || day === 6) {
						info.el.style.backgroundColor = '#f0f0f0';
					}
				},
				eventMouseEnter: function(info) {
					var tooltip = document.createElement('div');
					tooltip.className = 'fc-tooltip';
					var attendees_html = '';
					if (info.event.extendedProps.attendees && info.event.extendedProps.attendees.length) {
						attendees_html = '<br><strong>Participants :</strong><br>' + info.event.extendedProps.attendees.join(', ');
					}
					tooltip.innerHTML = "<strong>" + info.event.title + "</strong><br>" + (info.event.extendedProps.description || '') + attendees_html;
					document.body.appendChild(tooltip);

					info.el.addEventListener('mousemove', function(e) {
						tooltip.style.left = (e.pageX + 12) + 'px';
						tooltip.style.top = (e.pageY + 12) + 'px';
					});

					info.el.addEventListener('mouseleave', function() {
						if (tooltip) tooltip.remove();
					});
				},
				dateClick: function(info) {
					$('#eventModal').modal('show');
					var d = info.date;
					var isoDate = d.getFullYear() + "-" +
						("0" + (d.getMonth() + 1)).slice(-2) + "-" +
						("0" + d.getDate()).slice(-2) + "T" +
						("0" + d.getHours()).slice(-2) + ":" +
						("0" + d.getMinutes()).slice(-2);
					$('input[name=start_date]').val(isoDate);

					var end = new Date(d.getTime() + 60 * 60 * 1000);
					var isoEnd = end.getFullYear() + "-" +
						("0" + (end.getMonth() + 1)).slice(-2) + "-" +
						("0" + end.getDate()).slice(-2) + "T" +
						("0" + end.getHours()).slice(-2) + ":" +
						("0" + end.getMinutes()).slice(-2);
					$('input[name=end_date]').val(isoEnd);
				},
				eventClick: function(info) {
					var id = info.event.id;
					$.get('<?php echo site_url("calendar/event_detail"); ?>/' + id, function(data) {
						var msg = "<strong>" + data.title + "</strong>\n\n" + (data.description || '') + "\n\nParticipants:\n";
						if (data.attendees && data.attendees.length) {
							data.attendees.forEach(function(a) {
								msg += "- " + (a.first_name ? (a.first_name + ' ' + a.last_name) : a.username) + "\n";
							});
						} else {
							msg += "Aucun participant";
						}
						alert(msg);
					}, 'json');
				},
				eventDidMount: function(info) {
					info.el.addEventListener('contextmenu', function(e) {
						e.preventDefault();

						var menu = document.createElement('div');
						menu.className = 'fc-contextmenu';
						menu.style.position = 'absolute';
						menu.style.top = e.pageY + 'px';
						menu.style.left = e.pageX + 'px';
						menu.style.background = '#fff';
						menu.style.border = '1px solid #ccc';
						menu.style.padding = '6px';
						menu.style.zIndex = 99999;

						menu.innerHTML = `
							<div class="menu-item" data-action="edit" style="cursor:pointer; padding:4px;">✏️ Modifier</div>
							<div class="menu-item" data-action="delete" style="cursor:pointer; padding:4px; color:red;">🗑️ Supprimer</div>
						`;

						document.body.appendChild(menu);

						menu.addEventListener('click', function(ev) {
							var action = ev.target.getAttribute('data-action');
							if (action === 'edit') {
								openEditModal(info.event);
							} else if (action === 'delete') {
								deleteEvent(info.event.id);
							}
							menu.remove();
						});

						document.addEventListener('click', function handler() {
							if (menu) menu.remove();
							document.removeEventListener('click', handler);
						});
					});
				},
				datesSet: function() {

					console.log($('.fc-today-button'));
					
				}
			});

			calendar.render();

			function loadUsers() {
				$.get('<?php echo site_url("calendar/fetch_users"); ?>', function(users) {
					var $sel = $('#attendeesSelect');
					$sel.empty();
					users.forEach(function(u) {
						var name = (u.first_name ? u.first_name : '') + (u.last_name ? ' ' + u.last_name : '');
						if (!name.trim()) name = u.username || u.email;
						$sel.append($('<option>').val(u.id).text(name));
					});
				}, 'json');
			}
			loadUsers();

			$('#eventForm').on('submit', function(e) {
				e.preventDefault();
				var formData = $(this).serialize();
				$.ajax({
					url: '<?php echo site_url("calendar/add_event"); ?>',
					type: 'POST',
					data: formData,
					success: function(res) {
						$('#eventModal').modal('hide');
						calendar.refetchEvents();
						$('#eventForm')[0].reset();
						loadUsers();
					},
					error: function(xhr) {
						alert('Erreur: ' + xhr.statusText);
					}
				});
			});

			$('#cancelBtn').on('click', function() {
				$('#eventModal').modal('hide');
			});

			function openEditModal(event) {
				$('#editEventModal').modal('show');
				$('input[name="id"]').val(event.id);
				$('input[name="title"]').val(event.title);
				$('textarea[name="description"]').val(event.extendedProps.description || '');

				$('input[name="start_date"]').val(event.start.toISOString().slice(0, 16));
				$('input[name="end_date"]').val(event.end ? event.end.toISOString().slice(0, 16) : event.start.toISOString().slice(0, 16));
				$('input[name="color"]').val(event.backgroundColor);

				$.get('<?php echo site_url("calendar/fetch_users"); ?>', function(users) {
					var $sel = $('#editAttendeesSelect');
					$sel.empty();
					users.forEach(function(u) {
						var name = (u.first_name ? u.first_name : '') + (u.last_name ? ' ' + u.last_name : '');
						if (!name.trim()) name = u.username || u.email;
						var opt = $('<option>').val(u.id).text(name);
						if (event.extendedProps.attendees && event.extendedProps.attendees.includes(name)) {
							opt.prop('selected', true);
						}
						$sel.append(opt);
					});
				}, 'json');
			}

			$('#editEventForm').on('submit', function(e) {
				e.preventDefault();
				var formData = $(this).serialize();
				$.ajax({
					url: '<?php echo site_url("calendar/update_event"); ?>',
					type: 'POST',
					data: formData,
					success: function(res) {
						$('#editEventModal').modal('hide');
						calendar.refetchEvents();
					},
					error: function(xhr) {
						alert('Erreur: ' + xhr.statusText);
					}
				});
			});

			$('#cancelEditBtn').on('click', function() {
				$('#editEventModal').modal('hide');
			});

			function deleteEvent(eventId) {
				if (confirm("Supprimer cet événement ?")) {
					$.post('<?php echo site_url("calendar/delete_event"); ?>', {
						id: eventId
					}, function(res) {
						calendar.refetchEvents();
					}, 'json');
				}
			}

		});
	</script>

</body>

</html>
