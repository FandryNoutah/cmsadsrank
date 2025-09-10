<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Calendrier</title>

    <!-- FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
      /* tooltip basique */
      .fc-tooltip {
        position: absolute;
        z-index: 10000;
        background: #fff;
        border: 1px solid #ddd;
        padding: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        font-size: 13px;
      }
      /* modal basique */
      #eventModal { 
        display:none; 
        position:fixed; 
        top:10%; 
        left:50%; 
        transform:translateX(-50%); 
        background:white; 
        padding:20px; 
        border:1px solid #ccc; 
        z-index:20000; 
        width:420px; 
      }
    </style>
</head>
<body>
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

<?php start_section('page_heading'); ?>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div style="max-width:1100px;margin:20px auto;">
    <div id="calendar"></div>
</div>

<!-- Popup Ajouter -->
<div id="eventModal" aria-hidden="true">
    <h3>Ajouter un événement</h3>
    <form id="eventForm">
        <label>Titre</label><br>
        <input type="text" name="title" placeholder="Titre" required style="width:100%"><br><br>

        <label>Description</label><br>
        <textarea name="description" placeholder="Description" style="width:100%"></textarea><br><br>

        <label>Début</label><br>
        <input type="datetime-local" name="start_date" required style="width:100%"><br><br>

        <label>Fin</label><br>
        <input type="datetime-local" name="end_date" required style="width:100%"><br><br>

        <label>Couleur</label><br>
        <input type="color" name="color" value="#3788d8"><br><br>

        <label>Participants (tagger)</label><br>
        <select name="attendees[]" id="attendeesSelect" multiple style="width:100%; min-height:90px;">
            <!-- options remplies via AJAX -->
        </select>
        <small>Ctrl/Cmd+Click pour sélectionner plusieurs</small>
        <br><br>

        <button type="submit">Enregistrer</button>
        <button type="button" id="cancelBtn">Annuler</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // initialisation calendar
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '<?php echo site_url("calendar/fetch_events"); ?>',
        selectable: true,
        eventMouseEnter: function(info) {
            // tooltip avec description + participants
            var tooltip = document.createElement('div');
            tooltip.className = 'fc-tooltip';
            var attendees_html = '';
            if (info.event.extendedProps.attendees && info.event.extendedProps.attendees.length) {
                attendees_html = '<br><strong>Participants :</strong><br>' + info.event.extendedProps.attendees.join(', ');
            }
            tooltip.innerHTML = "<strong>"+info.event.title+"</strong><br>"+(info.event.extendedProps.description || '') + attendees_html;
            document.body.appendChild(tooltip);

            info.el.addEventListener('mousemove', function(e){
                tooltip.style.left = (e.pageX + 12) + 'px';
                tooltip.style.top = (e.pageY + 12) + 'px';
            });

            info.el.addEventListener('mouseleave', function(){
                if (tooltip) tooltip.remove();
            });
        },
        dateClick: function(info) {
            // ouvre modal
            $('#eventModal').show();
            // set default date/time local strings
            var d = info.date;
            var isoDate = d.toISOString().slice(0,16); // YYYY-MM-DDTHH:MM
            $('input[name=start_date]').val(isoDate);
            // default end same day + 1 hour
            var end = new Date(d.getTime() + 60*60*1000);
            $('input[name=end_date]').val(end.toISOString().slice(0,16));
        },
        eventClick: function(info) {
            // tu peux ouvrir un détail/édition ici
            var id = info.event.id;
            $.get('<?php echo site_url("calendar/event_detail"); ?>/' + id, function(data){
                var msg = "<strong>" + data.title + "</strong>\n\n" + (data.description || '') + "\n\nParticipants:\n";
                if (data.attendees && data.attendees.length) {
                    data.attendees.forEach(function(a){
                        msg += "- " + (a.first_name ? (a.first_name + ' ' + a.last_name) : a.username) + "\n";
                    });
                } else {
                    msg += "Aucun participant";
                }
                alert(msg);
            }, 'json');
        }
    });

    calendar.render();

    // Charger la liste des utilisateurs
    function loadUsers() {
        $.get('<?php echo site_url("calendar/fetch_users"); ?>', function(users){
            var $sel = $('#attendeesSelect');
            $sel.empty();
            users.forEach(function(u){
                var name = (u.first_name ? u.first_name : '') + (u.last_name ? ' ' + u.last_name : '');
                if (!name.trim()) name = u.username || u.email;
                $sel.append($('<option>').val(u.id).text(name));
            });
        }, 'json');
    }

    // appel immédiat au chargement
    loadUsers();

    // submit formulaire
    $('#eventForm').on('submit', function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?php echo site_url("calendar/add_event"); ?>',
            type: 'POST',
            data: formData,
            success: function(res){
                $('#eventModal').hide();
                calendar.refetchEvents();
                $('#eventForm')[0].reset();
                loadUsers(); // recharge la liste si besoin
            },
            error: function(xhr){
                alert('Erreur: ' + xhr.statusText);
            }
        });
    });

    $('#cancelBtn').on('click', function(){ 
        $('#eventModal').hide(); 
    });
});
</script>

</body>
</html>
