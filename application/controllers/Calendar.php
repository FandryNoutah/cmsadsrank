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
        $this->load->view("layouts/calendar_view/index.php");
    }

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
