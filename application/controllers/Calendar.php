<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

   public function __construct() {
    parent::__construct();
    $this->load->model("Event_model");
    $this->load->helper('url');
    $this->load->library(['ion_auth']); // charge Ion Auth
    $this->current_user = $this->ion_auth->user()->row();
}

    public function index() {
        // charge la vue principale
        $this->load->view("Layouts/calendar_view/index.php");
    }

    // Retourne les events pour fullcalendar
    public function fetch_events() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }

    $start = $this->input->get("start");
    $end   = $this->input->get("end");
    $events = $this->Event_model->get_events($start, $end);

    $data = [];
    foreach($events as $event) {
        $att_names = [];
        foreach($event->attendees as $a) {
            $name = trim(($a->first_name ?: '') . ' ' . ($a->last_name ?: ''));
            $att_names[] = $name ? $name : ($a->username ?: $a->email);
        }

        $data[] = [
            "id"    => $event->id,
            "title" => $event->title,
            "start" => $event->start_date,
            "end"   => $event->end_date,
            "color" => $event->color,
            "description" => $event->description,
            "created_by"  => $event->created_by,
            "attendees"   => $att_names
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($data);
}


    // Endpoint pour récupérer les utilisateurs (pour le select multiple)
    public function fetch_users() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }
    $users = $this->Event_model->get_users($this->current_user->id);
    header('Content-Type: application/json');
    echo json_encode($users);
}




    // Ajout d'un event (POST)
    public function add_event() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }

    $title = $this->input->post("title");
    $description = $this->input->post("description");
    $start_date = $this->input->post("start_date");
    $end_date = $this->input->post("end_date");
    $color = $this->input->post("color");
    $attendees = $this->input->post("attendees");

    $data = [
        "title"       => $title,
        "description" => $description,
        "start_date"  => $start_date,
        "end_date"    => $end_date,
        "color"       => $color,
        "created_by"  => $this->current_user->id
    ];

    $attendee_ids = [];
    if (!empty($attendees)) {
        $attendee_ids = is_array($attendees) ? array_map('intval', $attendees) : array_map('intval', explode(',', $attendees));
    }

    $event_id = $this->Event_model->insert_event($data, $attendee_ids);

    header('Content-Type: application/json');
    echo json_encode(["status" => true, "event_id" => $event_id]);
}



    // Détail d'un event (id)
    public function event_detail($id) {
        $event = $this->Event_model->get_event($id);
        header('Content-Type: application/json');
        echo json_encode($event);
    }
}
