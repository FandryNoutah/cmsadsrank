<?php start_section('stylesheet'); ?>
<link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap/css/bootstrap.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/vendors/fontawesome/css/all.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/vendors/fullcalendar/css/main.min.css') ?>" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

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
		<div id="calendar"></div>
	</div>
</div>

<?php $this->load->view('layouts/calendar/modal/event'); ?>
<?php $this->load->view('layouts/calendar/modal/edit'); ?>
<?php end_section(); ?>

<?php start_section('script'); ?>
<script src="<?= base_url('assets/vendors/fullcalendar/js/main.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/fullcalendar/js/locale.fr.js') ?>"></script>

<script>

	$(function() {
		if (!$('#sidebarMenu').hasClass("collapsed")) {
			$('#toggleSidebar').click();
		}
	});

	function pad(n) {
		return String(n).padStart(2, '0');
	}

	function toLocalInputString(d) {
		if (!(d instanceof Date)) d = new Date(d);
		return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
	}

	function parseDateForInput(value) {
		if (!value) return '';
		if (value instanceof Date) return toLocalInputString(value);

		var s = String(value).trim();

		if (/^\d+$/.test(s)) {
			var n = Number(s);
			if (s.length === 10) n = n * 1000;
			var dt = new Date(n);
			if (!isNaN(dt)) return toLocalInputString(dt);
		}

		var mysqlMatch = s.match(/^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/);
		if (mysqlMatch) {
			var y = Number(mysqlMatch[1]),
				m = Number(mysqlMatch[2]) - 1,
				day = Number(mysqlMatch[3]);
			var hh = Number(mysqlMatch[4]),
				mm = Number(mysqlMatch[5]),
				ss = Number(mysqlMatch[6] || 0);
			return toLocalInputString(new Date(y, m, day, hh, mm, ss));
		}

		var iso = s.replace(' ', 'T');
		var dt2 = new Date(iso);
		if (!isNaN(dt2)) return toLocalInputString(dt2);

		return '';
	}

	function toggleCustomTitle(select) {

		var el = document.getElementById('custom_title_container');
		el.classList.toggle('d-none', select.value !== 'Autre');
	}

	document.addEventListener('DOMContentLoaded', function() {

		var URL_FETCH_EVENTS = '<?php echo site_url("calendar/fetch_events"); ?>';
		var URL_FETCH_USERS = '<?php echo site_url("calendar/fetch_users"); ?>';
		var URL_ADD_EVENT = '<?php echo site_url("calendar/add_event"); ?>';
		var URL_UPDATE_EVENT = '<?php echo site_url("calendar/update_event"); ?>';
		var URL_DELETE_EVENT = '<?php echo site_url("calendar/delete_event"); ?>';
		var URL_EVENT_DETAIL = '<?php echo site_url("calendar/event_detail"); ?>';

		var frenchHolidays = ["2025-08-15", "2025-07-14", "2025-12-25"];

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

		function loadUsers() {

			return $.get(URL_FETCH_USERS, function(users) {

				var $filter = $('#userFilter').empty();
				$filter.append('<option value="">-- Tous les utilisateurs --</option>');

				users.forEach(function(u) {
					var name = ((u.first_name ? u.first_name : '') + (u.last_name ? ' ' + u.last_name : '')).trim();
					if (!name) name = u.username || u.email || ('user-' + u.id);
					$filter.append($('<option>').val(u.id).text(name));
				});

				var $a = $('#attendeesSelect').empty();
				var $ea = $('#editAttendeesSelect').empty();

				users.forEach(function(u) {
					var name = ((u.first_name ? u.first_name : '') + (u.last_name ? ' ' + u.last_name : '')).trim();
					if (!name) name = u.username || u.email || ('user-' + u.id);
					$a.append($('<option>').val(u.id).text(name));
					$ea.append($('<option>').val(u.id).text(name));
				});

			}, 'json').fail(function(err) {
				console.error('Erreur fetch_users', err);
			});
		}

		loadUsers();

		var calendarEl = document.getElementById('calendar');
		window.calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth',
			locale: 'fr',
			timeZone: 'local',
			headerToolbar: {
				left: 'today prev,next',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay'
			},
			selectable: true,
			displayEventTime: false,
			events: function(fetchInfo, successCallback, failureCallback) {

				var userId = $('#userFilter').val() || '';
				var agendaFilters = $('input[name="agendaFilter"]:checked').map(function() {
					return this.value;
				}).get();

				$.ajax({
					url: URL_FETCH_EVENTS,
					data: {
						start: fetchInfo.startStr,
						end: fetchInfo.endStr,
						user_id: userId,
						agendaFilters: agendaFilters
					},
					dataType: 'json'
				}).done(function(data) {
					successCallback(data);
				}).fail(function(err) {
					console.error('Erreur fetch_events', err);
					failureCallback(err);
				});
			},
			dayCellDidMount: function(info) {
				var dateStr = info.date.toLocaleDateString('fr-CA');
				var day = info.date.getDay();
				if (frenchHolidays.indexOf(dateStr) !== -1) {
					info.el.style.backgroundColor = '#e6f4ea';
				} else if (day === 0 || day === 6) {
					info.el.style.backgroundColor = '#fafafa';
				}
			},
			eventMouseEnter: function(info) {
				var tooltip = document.createElement('div');
				tooltip.className = 'fc-tooltip';
				var attendees_html = '';
				if (info.event.extendedProps.attendees && info.event.extendedProps.attendees.length) {
					attendees_html = '<br><strong>Participants :</strong> ' + info.event.extendedProps.attendees.join(', ');
				}
				tooltip.innerHTML = "<strong>" + info.event.title + "</strong><br>" + (info.event.extendedProps.description || '') + attendees_html;
				document.body.appendChild(tooltip);

				function moveHandler(e) {
					tooltip.style.left = (e.pageX + 12) + 'px';
					tooltip.style.top = (e.pageY + 12) + 'px';
				}
				info.el.addEventListener('mousemove', moveHandler);

				info.el.addEventListener('mouseleave', function leave() {
					tooltip.remove();
					info.el.removeEventListener('mousemove', moveHandler);
					info.el.removeEventListener('mouseleave', leave);
				});
			},
			dateClick: function(info) {
				$('#eventForm')[0].reset();
				$('#custom_title_container').style && ($('#custom_title_container').style.display = 'none');

				var base = new Date(info.date.getFullYear(), info.date.getMonth(), info.date.getDate(), 9, 0);
				var baseEnd = new Date(info.date.getFullYear(), info.date.getMonth(), info.date.getDate(), 10, 0);

				$('#eventForm').find('input[name=start_date]').val(toLocalInputString(base));
				$('#eventForm').find('input[name=end_date]').val(toLocalInputString(baseEnd));
				$('#eventModal').modal('show');
			},
			eventClick: function(info) {
				var id = info.event.id;
				if (id) {
					$.get(URL_EVENT_DETAIL + '/' + id, function(res) {
						fillEditModalFromObject(res);
						$('#editEventModal').modal('show');
					}, 'json').fail(function() {
						fillEditModalFromEvent(info.event);
						$('#editEventModal').modal('show');
					});
				} else {
					fillEditModalFromEvent(info.event);
					$('#editEventModal').modal('show');
				}
			},
			eventDidMount: function(info) {
				info.el.addEventListener('contextmenu', function(e) {
					e.preventDefault();
					document.querySelectorAll('.fc-contextmenu').forEach(function(m) {
						m.remove();
					});
					var menu = document.createElement('div');
					menu.className = 'fc-contextmenu';
					menu.style.position = 'absolute';
					menu.style.top = e.pageY + 'px';
					menu.style.left = e.pageX + 'px';
					menu.style.background = '#fff';
					menu.style.border = '1px solid #ccc';
					menu.style.padding = '6px';
					menu.style.zIndex = 99999;
					menu.innerHTML = '<div data-action="edit" style="padding:6px;cursor:pointer;">✏️ Modifier</div><div data-action="delete" style="padding:6px;cursor:pointer;color:red;">🗑️ Supprimer</div>';
					document.body.appendChild(menu);

					menu.addEventListener('click', function(ev) {
						var a = ev.target.getAttribute('data-action');
						if (a === 'edit') {
							fillEditModalFromEvent(info.event);
							$('#editEventModal').modal('show');
						} else if (a === 'delete') {
							var id = info.event.id;
							if (id) deleteEventAjax(id);
							else info.event.remove();
						}
						menu.remove();
					});

					setTimeout(function() {
						document.addEventListener('click', function handler() {
							if (menu) menu.remove();
							document.removeEventListener('click', handler);
						});
					}, 0);
				});
			}
		});

		calendar.render();

		calendar.on('datesSet', function() {
			miniCal.gotoDate(calendar.getDate());
		});

		function fillEditModalFromEvent(ev) {
			const form = $('#editEventForm');
			form[0].reset();

			form.find('input[name=id]').val(ev.id || '');
			form.find('input[name=title]').val(ev.title || '');
			form.find('textarea[name=description]').val(ev.extendedProps.description || '');

			form.find('input[name=start_date]').val(parseDateForInput(ev.start || ev.extendedProps.start || ev.extendedProps.start_date));
			form.find('input[name=end_date]').val(parseDateForInput(ev.end || ev.extendedProps.end || ev.extendedProps.end_date));
			form.find('input[name=color]').val(ev.backgroundColor || ev.extendedProps.color || '#3788d8');

			const attendeesRaw = ev.extendedProps.attendees || [];
			var attendees = [];
			attendeesRaw.forEach(function(a) {
				if (!a) return;
				if (typeof a === 'object') attendees.push(a.id || a.value || (a.username || a.name) || JSON.stringify(a));
				else attendees.push(String(a));
			});

			const $sel = $('#editAttendeesSelect');
			$sel.find('option').prop('selected', false);
			attendees.forEach(function(a) {
				var optByVal = $sel.find('option[value="' + a + '"]');
				if (optByVal.length) optByVal.prop('selected', true);
				else $sel.find('option').filter(function() {
					return $(this).text() === a;
				}).prop('selected', true);
			});
		}

		function fillEditModalFromObject(obj) {
			const form = $('#editEventForm');
			form[0].reset();

			form.find('input[name=id]').val(obj.id || '');
			form.find('input[name=title]').val(obj.title || '');
			form.find('textarea[name=description]').val(obj.description || '');

			form.find('input[name=start_date]').val(parseDateForInput(obj.start || obj.start_date || obj.datetime || obj.begin));
			form.find('input[name=end_date]').val(parseDateForInput(obj.end || obj.end_date || obj.finish));
			form.find('input[name=color]').val(obj.backgroundColor || obj.color || '#3788d8');

			const attendeesRaw = obj.attendees || obj.attendees_ids || [];
			var attendees = [];
			attendeesRaw.forEach(function(a) {
				if (!a) return;
				if (typeof a === 'object') attendees.push(a.id || a.value || (a.username || a.name) || JSON.stringify(a));
				else attendees.push(String(a));
			});

			var $sel = $('#editAttendeesSelect');
			$sel.find('option').prop('selected', false);
			attendees.forEach(function(a) {
				var optByVal = $sel.find('option[value="' + a + '"]');
				if (optByVal.length) optByVal.prop('selected', true);
				else $sel.find('option').filter(function() {
					return $(this).text() === a;
				}).prop('selected', true);
			});
		}

		$('#createEventBtn').on('click', function() {
			$('#eventForm')[0].reset();
			$('#custom_title_container').hide();
			var now = new Date();
			$('#eventForm').find('input[name=start_date]').val(toLocalInputString(new Date(now.getFullYear(), now.getMonth(), now.getDate(), 9, 0)));
			$('#eventForm').find('input[name=end_date]').val(toLocalInputString(new Date(now.getFullYear(), now.getMonth(), now.getDate(), 10, 0)));
			$('#eventModal').modal('show');
		});

		$('#cancelBtn').on('click', function() {
			$('#eventModal').modal('hide');
		});
		$('#cancelEditBtn').on('click', function() {
			$('#editEventModal').modal('hide');
		});

		$('#userFilter').on('change', function() {
			calendar.refetchEvents();
		});

		$('input[name="agendaFilter"]').change(function() {
			calendar.refetchEvents();
		});

		$('#eventForm').on('submit', function(e) {
			e.preventDefault();
			var $f = $(this);
			var titleVal = $f.find('#title-select').val();
			if (titleVal === 'Autre') {
				titleVal = $f.find('#custom-title').val() || 'Sans titre';
			}

			var payload = {
				title: titleVal,
				description: $f.find('textarea[name=description]').val(),
				start_date: $f.find('input[name=start_date]').val(),
				end_date: $f.find('input[name=end_date]').val(),
				color: $f.find('input[name=color]').val(),
				attendees: $('#attendeesSelect').val() || []
			};

			$.ajax({
				url: URL_ADD_EVENT,
				method: 'POST',
				data: payload,
				dataType: 'json'
			}).done(function(res) {
				$('#eventModal').modal('hide');
				$f[0].reset();
				calendar.refetchEvents();
				loadUsers();
			}).fail(function(xhr) {
				console.error('Erreur add_event', xhr.responseText || xhr.statusText);

				calendar.addEvent({
					id: 'tmp-' + Date.now(),
					title: payload.title,
					start: payload.start_date,
					end: payload.end_date,
					backgroundColor: payload.color,
					extendedProps: {
						description: payload.description,
						attendees: payload.attendees
					}
				});
				$('#eventModal').modal('hide');
				$f[0].reset();
				alert('Ajout local (le serveur a renvoyé une erreur). Voir console pour détails.');
			});
		});

		$('#editEventForm').on('submit', function(e) {
			e.preventDefault();
			const $f = $(this);
			const payload = {
				id: $f.find('input[name=id]').val(),
				title: $f.find('input[name=title]').val(),
				description: $f.find('textarea[name=description]').val(),
				start_date: $f.find('input[name=start_date]').val(),
				end_date: $f.find('input[name=end_date]').val(),
				color: $f.find('input[name=color]').val(),
				attendees: $('#editAttendeesSelect').val() || []
			};

			$.ajax({
				url: URL_UPDATE_EVENT,
				method: 'POST',
				data: payload,
				dataType: 'json'
			}).done(function() {
				$('#editEventModal').modal('hide');
				calendar.refetchEvents();
			}).fail(function(xhr) {
				console.error('Erreur update_event', xhr.responseText || xhr.statusText);
				var ev = calendar.getEventById(payload.id);
				if (ev) {
					ev.setProp('title', payload.title);
					ev.setExtendedProp('description', payload.description);
					try {
						if (payload.start_date) ev.setStart(payload.start_date);
						if (payload.end_date) ev.setEnd(payload.end_date);
					} catch (e) {}
					if (payload.color) ev.setProp('backgroundColor', payload.color);
				}
				$('#editEventModal').modal('hide');
				alert('Mise à jour locale (le serveur a renvoyé une erreur). Voir console.');
			});
		});

		$('#deleteBtn').on('click', function() {
			var id = $('#editEventForm').find('input[name=id]').val();
			if (!id) return alert('Aucun id spécifié');
			if (!confirm('Supprimer cet événement ?')) return;
			deleteEventAjax(id);
		});

		function deleteEventAjax(id) {
			$.post(URL_DELETE_EVENT, {
					id: id
				})
				.done(function(res) {
					$('#editEventModal').modal('hide');
					calendar.refetchEvents();
				})
				.fail(function(xhr) {
					console.error('Erreur delete_event', xhr.responseText || xhr.statusText);
					alert('Erreur suppression');
				});
		}

		window.openEditModal = function(evOrId) {
			if (typeof evOrId === 'string' || typeof evOrId === 'number') {
				$.get(URL_EVENT_DETAIL + '/' + evOrId, function(res) {
					fillEditModalFromObject(res);
					$('#editEventModal').modal('show');
				}, 'json').fail(function() {
					alert('Impossible de récupérer les détails.');
				});
			} else {
				fillEditModalFromEvent(evOrId);
				$('#editEventModal').modal('show');
			}
		};
		window.deleteEvent = deleteEventAjax;

	});
</script>
<?php end_section(); ?>
