<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
    public function update_event($id, $data, $attendee_ids = []) {
    $this->db->where("id", $id)->update("events", $data);

    $this->db->where("event_id", $id)->delete("event_users");
    if (!empty($attendee_ids)) {
        foreach($attendee_ids as $uid) {
            $this->db->insert("event_users", [
                "event_id" => $id,
                "user_id"  => $uid
            ]);
        }
    }
    return true;
}

public function delete_event($id) {
    $this->db->where("id", $id)->delete("events");
    $this->db->where("event_id", $id)->delete("event_users");
    return true;
}

public function get_users($exclude_id = null, $limit = 1000) {
    $this->db->select("id, username, email, first_name, last_name");
    if ($exclude_id) {
        $this->db->where("id !=", $exclude_id);
    }
    $this->db->limit($limit);
    return $this->db->get("users")->result();
}

   public function get_events($start, $end, $user_id = null) {
    $start_dt = date('Y-m-d H:i:s', strtotime($start));
    $end_dt   = date('Y-m-d H:i:s', strtotime($end));

    $this->db->select('events.*');
    $this->db->from('events');

    // chevauchement
    $this->db->where('start_date <', $end_dt);
    $this->db->where('end_date >', $start_dt);

    if (!empty($user_id)) {
        // jointure pour les events partagés
        $this->db->join('event_users eu', 'events.id = eu.event_id', 'left');
        $this->db->group_start();
        $this->db->where('events.created_by', $user_id);
        $this->db->or_where('eu.user_id', $user_id);
        $this->db->group_end();
    }

    $this->db->group_by('events.id');

    $query = $this->db->get();
    $events = $query->result();

    foreach($events as $e) {
        $e->attendees = $this->get_event_attendees($e->id);
    }

    return $events;
}
public function get_user_by_id($id) {
    $query = $this->db->get_where('users', ['id' => $id]);
    return $query->row();
}




    public function get_event($id) {
        $event = $this->db->get_where("events", ["id" => $id])->row();
        if ($event) {
            $event->attendees = $this->get_event_attendees($id);
        }
        return $event;
    }

    public function insert_event($data, $attendee_ids = []) {
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
