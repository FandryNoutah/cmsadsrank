<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
public function get_users($exclude_id = null, $limit = 1000) {
    $this->db->select("id, username, email, first_name, last_name");
    if ($exclude_id) {
        $this->db->where("id !=", $exclude_id);
    }
    $this->db->limit($limit);
    return $this->db->get("users")->result();
}

    public function get_events($start, $end) {
        // récupère les événements dans l'intervalle et ajoute participants
        $this->db->where("start_date >=", $start);
        $this->db->where("end_date <=", $end);
        $events = $this->db->get("events")->result();

        foreach($events as $e) {
            $e->attendees = $this->get_event_attendees($e->id);
        }
        return $events;
    }

    public function get_event($id) {
        $event = $this->db->get_where("events", ["id" => $id])->row();
        if ($event) {
            $event->attendees = $this->get_event_attendees($id);
        }
        return $event;
    }

    public function insert_event($data, $attendee_ids = []) {
        // $data must contain created_by
        $this->db->insert("events", $data);
        $event_id = $this->db->insert_id();

        if (!empty($attendee_ids)) {
            foreach($attendee_ids as $uid) {
                $this->db->insert("event_users", [
                    "event_id" => $event_id,
                    "user_id"  => intval($uid)
                ]);
            }
        }
        return $event_id;
    }

    public function get_event_attendees($event_id) {
        $this->db->select("u.id, u.username, u.email, u.first_name, u.last_name");
        $this->db->from("event_users eu");
        $this->db->join("users u", "u.id = eu.user_id", "inner");
        $this->db->where("eu.event_id", $event_id);
        return $this->db->get()->result();
    }

}
