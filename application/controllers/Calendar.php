<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

   public function __construct() {
    parent::__construct();
    $this->load->model("Event_model");
    $this->load->helper('url');
    $this->load->library(['ion_auth']);
    $this->current_user = $this->ion_auth->user()->row();
}

    public function index() {
        $this->load->view("layouts/calendar/index.php");
    }

    public function fetch_events() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }

    $start = $this->input->get("start");
    $end   = $this->input->get("end");
    $user_id = $this->input->get("user_id");

    // Si pas de user_id fourni dans le filtre => utilisateur connecté
    if (empty($user_id)) {
        $user_id = $this->current_user->id;
    } else {
        $user_id = intval($user_id);
    }

    $events = $this->Event_model->get_events($start, $end, $user_id);

    $result = [];
    foreach ($events as $e) {
        $attendees = [];
        if (!empty($e->attendees)) {
            foreach($e->attendees as $a) {
                $attendees[] = trim(($a->first_name ?: '') . ' ' . ($a->last_name ?: $a->username));
            }
        }

        $result[] = [
            "id"    => $e->id,
            "title" => $e->title,
            "description" => $e->description,
            "start" => date("c", strtotime($e->start_date)),
            "end"   => date("c", strtotime($e->end_date)),
            "color" => $e->color ?: "#3788d8",
            "attendees" => $attendees
        ];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
}




    public function fetch_users() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }
    $users = $this->Event_model->get_users($this->current_user->id);
    header('Content-Type: application/json');
    echo json_encode($users);
}




    public function add_event() {
    if (!$this->current_user) {
        show_error('Unauthorized', 401);
        return;
    }
    if($this->input->post("custom_title") == NULL):
    $title = $this->input->post("title");
    endif;
    if($this->input->post("custom_title") != NULL):
    $title = $this->input->post("custom_title");
    endif;
    $description = $this->input->post("description");
     $start_date = date("Y-m-d H:i:s", strtotime($this->input->post("start_date")));
    $end_date   = date("Y-m-d H:i:s", strtotime($this->input->post("end_date")));
    
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



    public function event_detail($id) {
        $event = $this->Event_model->get_event($id);
        header('Content-Type: application/json');
        echo json_encode($event);
    }

public function update_event() {
    $id = $this->input->post("id");
    $data = [
        "title"       => $this->input->post("title"),
        "description" => $this->input->post("description"),
        "start_date"  => date("Y-m-d H:i:s", strtotime($this->input->post("start_date"))),
        "end_date"    => date("Y-m-d H:i:s", strtotime($this->input->post("end_date"))),
        "color"       => $this->input->post("color"),
    ];

    $attendees = $this->input->post("attendees");
    $attendee_ids = !empty($attendees) ? (is_array($attendees) ? array_map('intval', $attendees) : array_map('intval', explode(',', $attendees))) : [];

    $this->Event_model->update_event($id, $data, $attendee_ids);
    echo json_encode(["status" => true]);
}

public function delete_event() {
    $id = $this->input->post("id");
    $this->Event_model->delete_event($id);
    echo json_encode(["status" => true]);
}

}
