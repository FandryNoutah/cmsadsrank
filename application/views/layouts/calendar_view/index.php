<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>Calendrier - Google-like (fonctionnel)</title>

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: "Google Sans", Arial, sans-serif;
      color: #202124;
      display: flex;
      min-height: 100vh;
      background: #fff;
    }
    .sidebar {
      width: 260px;
      border-right: 1px solid #e6e6e6;
      padding: 16px;
      background: #fff;
      overflow: auto;
    }
    #createEventBtn {
      background: #1a73e8;
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 24px;
      width: 100%;
      cursor: pointer;
      font-weight: 500;
      margin-bottom: 12px;
    }
    .sidebar h3 {
      margin: 16px 0 8px;
      color: #5f6368;
      font-size: 13px;
    }
    .sidebar label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
    }
    .main {
      flex: 1;
      padding: 12px;
    }
    .fc {
      background: #fff;
    }
    .fc .fc-toolbar {
      padding: 8px 12px;
      border-bottom: 1px solid #eee;
      background: #f8f9fa;
      border-radius: 6px;
    }
    .fc-toolbar-title {
      font-weight: 600;
      font-size: 18px;
    }
    .fc .fc-button {
      background: transparent;
      border: none;
      color: #1a73e8;
      font-weight: 500;
    }
    .fc .fc-button:hover {
      background: #e8f0fe;
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
    .modal {
      display: none;
      position: fixed;
      top: 10%;
      left: 50%;
      transform: translateX(-50%);
      background: #fff;
      border: 1px solid #ccc;
      padding: 16px;
      width: 420px;
      z-index: 20000;
    }
    .modal h3 {
      margin: 0 0 10px;
    }
    .modal input[type="text"],
    .modal input[type="datetime-local"],
    .modal textarea,
    .modal select,
    .modal input[type="color"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 10px;
    }
    .small {
      font-size: 12px;
      color: #666;
    }
    #viewSelect {}

    #custom-controls .fc-button {
      background: transparent;
      border: none;
      color: #1a73e8;
      font-weight: 500;
      cursor: pointer;
      border-radius: 4px;
      padding: 6px 10px;
    }
    #custom-controls .fc-button:hover {
      background: #e8f0fe;
    }
    .fc-icon {
      width: 1em;
      height: 1em;
      -webkit-user-select: none;
      user-select: none;
      font-family: fcicons !important;
      speak: none;
      font-style: normal;
      font-variant: normal;
      line-height: 1;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      color: grey;
    }
    .fc .fc-button-primary:disabled {
      color: black;
      background-color: white;
      border: 1px solid black;
      border-radius: 25px;
      padding-left: 25px;
      padding-right: 25px;
    }
    .fc-direction-ltr .fc-toolbar > * > :not(:first-child) {
      color: black;
      background-color: white;
      border: 1px solid black;
      border-radius: 25px;
      padding-left: 25px;
      padding-right: 25px;
    }
  </style>
</head>
<body>


  <div class="sidebar">
    <button id="createEventBtn">+ Créer</button>

    <div id="mini-calendar" style="margin-bottom:12px;"></div>

    <h3>Mes agendas</h3>
    <label><input type="checkbox" checked> Télétravail</label>
    <label><input type="checkbox" checked> Perso</label>
    <label><input type="checkbox" checked> Soutenance</label>
	   <label><input type="checkbox" checked> Formation</label>
    <label><input type="checkbox" checked> Maladie</label>
	   <label><input type="checkbox" checked> Congé</label>
    <label><input type="checkbox" checked> Contact</label>

    <h3>Filtres</h3>
    <label for="userFilter">Filtrer par utilisateur :</label>
    <select id="userFilter" style="width:100%; padding:6px;">
      <option value="">-- Tous les utilisateurs --</option>
    </select>
  </div>

   <div style="margin-bottom: 12px;">
  <select id="viewSelect" style="padding: 6px; font-size: 14px;  border: 1px solid #ddd;
  border-radius: 4px;
  background: #fff;
  color: #202124;">
    <option value="dayGridMonth">Mois</option>
    <option value="timeGridWeek">Semaine</option>
    <option value="timeGridDay">Jour</option>
  </select>
</div>

  <div class="main">
    <div id="calendar"></div>
  </div>

  <div id="eventModal" class="modal" aria-hidden="true">
    <h3>Ajouter un événement</h3>
    <form id="eventForm">
      <label for="title-select">Titre</label>
      <select id="title-select" name="title" onchange="toggleCustomTitle(this)">
        <option value="Télétravail">Télétravail</option>
        <option value="Perso">Perso</option>
        <option value="Soutenance">Soutenance</option>
        <option value="Formation">Formation</option>
        <option value="Maladie">Maladie</option>
        <option value="Congé">Congé</option>
        <option value="Contact">Contact</option>
        <option value="Autre">Autre...</option>
      </select>

      <div id="custom-title-container" style="display:none; margin-top:8px;">
        <label for="custom-title">Titre personnalisé</label>
        <input type="text" id="custom-title" name="custom_title">
      </div>

      <label>Description</label>
      <textarea name="description" rows="3"></textarea>

      <label>Début</label>
      <input type="datetime-local" name="start_date" required>

      <label>Fin</label>
      <input type="datetime-local" name="end_date" required>

      <label>Couleur</label>
      <input type="color" name="color" value="#3788d8">

      <label>Participants</label>
      <select id="attendeesSelect" name="attendees[]" multiple style="min-height:80px;"></select>
      <div class="small">Ctrl/Cmd + Click pour sélectionner plusieurs</div>

      <div style="margin-top:10px;">
        <button type="submit">Enregistrer</button>
        <button type="button" id="cancelBtn">Annuler</button>
      </div>
    </form>
  </div>

  <div id="editEventModal" class="modal" aria-hidden="true">
    <h3>Modifier un événement</h3>
    <form id="editEventForm">
      <input type="hidden" name="id">

      <label>Titre</label>
      <input type="text" name="title">

      <label>Description</label>
      <textarea name="description" rows="3"></textarea>

      <label>Début</label>
      <input type="datetime-local" name="start_date">

      <label>Fin</label>
      <input type="datetime-local" name="end_date">

      <label>Couleur</label>
      <input type="color" name="color" value="#3788d8">

      <label>Participants</label>
      <select id="editAttendeesSelect" name="attendees[]" multiple style="min-height:80px;"></select>

      <div style="margin-top:10px;">
        <button type="submit">Mettre à jour</button>
        <button type="button" id="cancelEditBtn">Annuler</button>
        <button type="button" id="deleteBtn" style="color:red;">Supprimer</button>
      </div>
    </form>
  </div>

<script>

function pad(n){ return String(n).padStart(2,'0'); }

function toLocalInputString(d){
  if (!(d instanceof Date)) d = new Date(d);
  return d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate()) + 'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
}

function parseDateForInput(value){
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
    var y = Number(mysqlMatch[1]), m = Number(mysqlMatch[2]) - 1, day = Number(mysqlMatch[3]);
    var hh = Number(mysqlMatch[4]), mm = Number(mysqlMatch[5]), ss = Number(mysqlMatch[6] || 0);
    return toLocalInputString(new Date(y, m, day, hh, mm, ss));
  }

  var iso = s.replace(' ', 'T');
  var dt2 = new Date(iso);
  if (!isNaN(dt2)) return toLocalInputString(dt2);

  return '';
}

function toggleCustomTitle(select){
  var el = document.getElementById('custom-title-container');
  el.style.display = (select.value === 'Autre') ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function(){

  var URL_FETCH_EVENTS   = '<?php echo site_url("calendar/fetch_events"); ?>';
  var URL_FETCH_USERS    = '<?php echo site_url("calendar/fetch_users"); ?>';
  var URL_ADD_EVENT      = '<?php echo site_url("calendar/add_event"); ?>';
  var URL_UPDATE_EVENT   = '<?php echo site_url("calendar/update_event"); ?>';
  var URL_DELETE_EVENT   = '<?php echo site_url("calendar/delete_event"); ?>';
  var URL_EVENT_DETAIL   = '<?php echo site_url("calendar/event_detail"); ?>';

  var frenchHolidays = ["2025-08-15","2025-07-14","2025-12-25"];

  var miniCalEl = document.createElement('div');
  miniCalEl.id = 'miniCalInner';
  document.getElementById('mini-calendar').appendChild(miniCalEl);

  var miniCal = new FullCalendar.Calendar(miniCalEl, {
    initialView: 'dayGridMonth',
    headerToolbar: false,
    height: 180,
    locale: 'fr',
    dateClick: function(info){
      if (window.calendar) window.calendar.gotoDate(info.date);
    }
  });
  miniCal.render();

  function loadUsers(){
    return $.get(URL_FETCH_USERS, function(users){
      var $filter = $('#userFilter').empty();
      $filter.append('<option value="">-- Tous les utilisateurs --</option>');
      users.forEach(function(u){
        var name = ((u.first_name?u.first_name:'') + (u.last_name? ' '+u.last_name:'')).trim();
        if (!name) name = u.username || u.email || ('user-'+u.id);
        $filter.append($('<option>').val(u.id).text(name));
      });

      var $a = $('#attendeesSelect').empty();
      var $ea = $('#editAttendeesSelect').empty();
      users.forEach(function(u){
        var name = ((u.first_name?u.first_name:'') + (u.last_name? ' '+u.last_name:'')).trim();
        if (!name) name = u.username || u.email || ('user-'+u.id);
        $a.append($('<option>').val(u.id).text(name));
        $ea.append($('<option>').val(u.id).text(name));
      });
    }, 'json').fail(function(err){
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
  left: 'prev,next today',
  center: 'title',
  right: '' 
},
    selectable: true,
    displayEventTime: false,

    events: function(fetchInfo, successCallback, failureCallback){
      var userId = $('#userFilter').val() || '';
      $.ajax({
        url: URL_FETCH_EVENTS,
        data: { start: fetchInfo.startStr, end: fetchInfo.endStr, user_id: userId },
        dataType: 'json'
      }).done(function(data){
        successCallback(data);
      }).fail(function(err){
        console.error('Erreur fetch_events', err);
        failureCallback(err);
      });
    },

    dayCellDidMount: function(info){
      var dateStr = info.date.toISOString().split('T')[0];
      var day = info.date.getDay();
      if (frenchHolidays.indexOf(dateStr) !== -1) {
        info.el.style.backgroundColor = '#e6f4ea';
      } else if (day === 0 || day === 6) {
        info.el.style.backgroundColor = '#fafafa';
      }
    },

    eventMouseEnter: function(info){
      var tooltip = document.createElement('div');
      tooltip.className = 'fc-tooltip';
      var attendees_html = '';
      if (info.event.extendedProps.attendees && info.event.extendedProps.attendees.length) {
        attendees_html = '<br><strong>Participants :</strong> ' + info.event.extendedProps.attendees.join(', ');
      }
      tooltip.innerHTML = "<strong>" + info.event.title + "</strong><br>" + (info.event.extendedProps.description || '') + attendees_html;
      document.body.appendChild(tooltip);

      function moveHandler(e){
        tooltip.style.left = (e.pageX + 12) + 'px';
        tooltip.style.top = (e.pageY + 12) + 'px';
      }
      info.el.addEventListener('mousemove', moveHandler);

      info.el.addEventListener('mouseleave', function leave(){
        tooltip.remove();
        info.el.removeEventListener('mousemove', moveHandler);
        info.el.removeEventListener('mouseleave', leave);
      });
    },

    dateClick: function(info){
      $('#eventForm')[0].reset();
      $('#custom-title-container').style && ($('#custom-title-container').style.display = 'none');

      var base = new Date(info.date.getFullYear(), info.date.getMonth(), info.date.getDate(), 9, 0);
      var baseEnd = new Date(info.date.getFullYear(), info.date.getMonth(), info.date.getDate(), 10, 0);

      $('#eventForm').find('input[name=start_date]').val(toLocalInputString(base));
      $('#eventForm').find('input[name=end_date]').val(toLocalInputString(baseEnd));
      $('#eventModal').show();
    },

    eventClick: function(info){
      var id = info.event.id;
      if (id) {
        $.get(URL_EVENT_DETAIL + '/' + id, function(res){
          fillEditModalFromObject(res);
          $('#editEventModal').show();
        }, 'json').fail(function(){
          fillEditModalFromEvent(info.event);
          $('#editEventModal').show();
        });
      } else {
        fillEditModalFromEvent(info.event);
        $('#editEventModal').show();
      }
    },

    eventDidMount: function(info){
      info.el.addEventListener('contextmenu', function(e){
        e.preventDefault();
        document.querySelectorAll('.fc-contextmenu').forEach(function(m){ m.remove(); });
        var menu = document.createElement('div');
        menu.className = 'fc-contextmenu';
        menu.style.position='absolute';
        menu.style.top = e.pageY + 'px';
        menu.style.left = e.pageX + 'px';
        menu.style.background = '#fff';
        menu.style.border = '1px solid #ccc';
        menu.style.padding = '6px';
        menu.style.zIndex = 99999;
        menu.innerHTML = '<div data-action="edit" style="padding:6px;cursor:pointer;">✏️ Modifier</div><div data-action="delete" style="padding:6px;cursor:pointer;color:red;">🗑️ Supprimer</div>';
        document.body.appendChild(menu);

        menu.addEventListener('click', function(ev){
          var a = ev.target.getAttribute('data-action');
          if (a === 'edit') {
            fillEditModalFromEvent(info.event); $('#editEventModal').show();
          } else if (a === 'delete') {
            var id = info.event.id;
            if (id) deleteEventAjax(id);
            else info.event.remove();
          }
          menu.remove();
        });

        setTimeout(function(){
          document.addEventListener('click', function handler(){
            if (menu) menu.remove();
            document.removeEventListener('click', handler);
          });
        }, 0);
      });
    }
  });

  calendar.render();
$('#viewSelect').on('change', function() {
  var selectedView = $(this).val();
  calendar.changeView(selectedView);
});

  calendar.on('datesSet', function(){ miniCal.gotoDate(calendar.getDate()); });

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
    attendeesRaw.forEach(function(a){
      if (!a) return;
      if (typeof a === 'object') attendees.push(a.id || a.value || (a.username || a.name) || JSON.stringify(a));
      else attendees.push(String(a));
    });

    const $sel = $('#editAttendeesSelect');
    $sel.find('option').prop('selected', false);
    attendees.forEach(function(a){
      var optByVal = $sel.find('option[value="'+a+'"]');
      if (optByVal.length) optByVal.prop('selected', true);
      else $sel.find('option').filter(function(){ return $(this).text() === a; }).prop('selected', true);
    });
  }

  function fillEditModalFromObject(obj){
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
    attendeesRaw.forEach(function(a){
      if (!a) return;
      if (typeof a === 'object') attendees.push(a.id || a.value || (a.username || a.name) || JSON.stringify(a));
      else attendees.push(String(a));
    });

    var $sel = $('#editAttendeesSelect');
    $sel.find('option').prop('selected', false);
    attendees.forEach(function(a){
      var optByVal = $sel.find('option[value="'+a+'"]');
      if (optByVal.length) optByVal.prop('selected', true);
      else $sel.find('option').filter(function(){ return $(this).text() === a; }).prop('selected', true);
    });
  }

  $('#createEventBtn').on('click', function(){
    $('#eventForm')[0].reset();
    $('#custom-title-container').hide();
    var now = new Date();
    $('#eventForm').find('input[name=start_date]').val(toLocalInputString(new Date(now.getFullYear(), now.getMonth(), now.getDate(), 9, 0)));
    $('#eventForm').find('input[name=end_date]').val(toLocalInputString(new Date(now.getFullYear(), now.getMonth(), now.getDate(), 10, 0)));
    $('#eventModal').show();
  });
  $('#cancelBtn').on('click', function(){ $('#eventModal').hide(); });
  $('#cancelEditBtn').on('click', function(){ $('#editEventModal').hide(); });

  $('#userFilter').on('change', function(){ calendar.refetchEvents(); });

  $('#eventForm').on('submit', function(e){
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
    }).done(function(res){
      $('#eventModal').hide();
      $f[0].reset();
      calendar.refetchEvents();
      loadUsers();
    }).fail(function(xhr){
      console.error('Erreur add_event', xhr.responseText || xhr.statusText);

      calendar.addEvent({
        id: 'tmp-'+Date.now(),
        title: payload.title,
        start: payload.start_date,
        end: payload.end_date,
        backgroundColor: payload.color,
        extendedProps: { description: payload.description, attendees: payload.attendees }
      });
      $('#eventModal').hide();
      $f[0].reset();
      alert('Ajout local (le serveur a renvoyé une erreur). Voir console pour détails.');
    });
  });

  $('#editEventForm').on('submit', function(e){
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
    }).done(function(){
      $('#editEventModal').hide();
      calendar.refetchEvents();
    }).fail(function(xhr){
      console.error('Erreur update_event', xhr.responseText || xhr.statusText);
      var ev = calendar.getEventById(payload.id);
      if (ev){
        ev.setProp('title', payload.title);
        ev.setExtendedProp('description', payload.description);
        try { if (payload.start_date) ev.setStart(payload.start_date); if (payload.end_date) ev.setEnd(payload.end_date); } catch(e){}
        if (payload.color) ev.setProp('backgroundColor', payload.color);
      }
      $('#editEventModal').hide();
      alert('Mise à jour locale (le serveur a renvoyé une erreur). Voir console.');
    });
  });

  $('#deleteBtn').on('click', function(){
    var id = $('#editEventForm').find('input[name=id]').val();
    if (!id) return alert('Aucun id spécifié');
    if (!confirm('Supprimer cet événement ?')) return;
    deleteEventAjax(id);
  });

  function deleteEventAjax(id){
    $.post(URL_DELETE_EVENT, { id: id })
      .done(function(res){ $('#editEventModal').hide(); calendar.refetchEvents(); })
      .fail(function(xhr){ console.error('Erreur delete_event', xhr.responseText || xhr.statusText); alert('Erreur suppression'); });
  }

  window.openEditModal = function(evOrId){
    if (typeof evOrId === 'string' || typeof evOrId === 'number') {
      $.get(URL_EVENT_DETAIL + '/' + evOrId, function(res){ fillEditModalFromObject(res); $('#editEventModal').show(); }, 'json').fail(function(){ alert('Impossible de récupérer les détails.'); });
    } else {
      fillEditModalFromEvent(evOrId);
      $('#editEventModal').show();
    }
  };
  window.deleteEvent = deleteEventAjax;

}); 
</script>

</body>
</html>
