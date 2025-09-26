<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Utilisateur_model");
		$this->load->model("Event_model");
		$this->load->helper('url');
		$this->load->library(['ion_auth']);
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{
		$this->content = "layouts/calendar/index.php";
		$this->layout();
	}

	public function fetch_events()
	{
		if (!$this->current_user) {
			show_error('Unauthorized', 401);
			return;
		}

		$start = $this->input->get("start");
		$end   = $this->input->get("end");
		$user_id = $this->input->get("user_id");
		$agendaFitlers = $this->input->get("agendaFilters");

		if (!empty($user_id)) {
			$user_id = intval($user_id);
			$user_filter = $this->Utilisateur_model->get_user_by_id($user_id);
			$user_color = $user_filter->couleur ?: "#3788d8";
		}

		$events = $this->Event_model->get_events($start, $end, $user_id, $agendaFitlers);

		$result = [];
		foreach ($events as $e) {

			$attendees = [];
			if (!empty($e->attendees)) {
				foreach ($e->attendees as $a) {
					$attendees[] = trim(($a->first_name ?: '') . ' ' . ($a->last_name ?: $a->username));
				}
			}

			$title = $e->title;
			if (!empty($attendees) && !substr($title, 0, strlen("Congé")) === "Congé") {
				$title .= ' de ' . implode(', ', $attendees);
			}

			$result[] = [
				"id"    => $e->id,
				"title" => $title,
				"description" => $e->description,
				"start" => date("c", strtotime($e->start_date)),
				"end"   => date("c", strtotime($e->end_date)),
				"color" => $user_color ?? $e->color,
				"attendees" => $attendees
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function fetch_users()
	{
		if (!$this->current_user) {
			show_error('Unauthorized', 401);
			return;
		}
		$users = $this->Event_model->get_users();
		header('Content-Type: application/json');
		echo json_encode($users);
	}

	public function add_event()
	{
		if (!$this->current_user) {
			show_error('Unauthorized', 401);
			return;
		}

		$custom_title = trim($this->input->post("custom_title"));
		$default_title = trim($this->input->post("title"));
		$title = $custom_title !== '' ? $custom_title : $default_title;

		if (empty($title)) {
			echo json_encode(['error' => 'Titre requis']);
			return;
		}

		$description = $this->input->post("description");

		$start_input = $this->input->post("start_date");
		$end_input = $this->input->post("end_date");

		$start_timestamp = strtotime($start_input);
		$end_timestamp = strtotime($end_input);

		if (!$start_timestamp || !$end_timestamp) {
			echo json_encode(['error' => 'Dates invalides']);
			return;
		}

		$start_date = date("Y-m-d H:i:s", $start_timestamp);
		$end_date = date("Y-m-d H:i:s", $end_timestamp);

		$jours_de_demande = (float) $this->input->post("jours");

		$start = new DateTime($start_date);
		$end = new DateTime($end_date);
		$annees = range((int)$start->format('Y'), (int)$end->format('Y'));

		$jours_feries = [];
		foreach ($annees as $annee) {
			$jours_feries = array_merge($jours_feries, $this->get_french_holidays($annee));
		}
		$jours_feries = array_unique($jours_feries);

		$count = 0;
		$interval = new DateInterval('P1D');
		$period = new DatePeriod($start, $interval, (clone $end)->modify('+1 day'));

		foreach ($period as $date) {
			$jour = $date->format('w');
			$date_str = $date->format('Y-m-d');
			if ($jour != 0 && $jour != 6 && !in_array($date_str, $jours_feries)) {
				$count++;
			}
		}

		$nbr_jours = 0;
		if ($jours_de_demande === 1.0) {
			$nbr_jours = $count;
		} elseif ($jours_de_demande === 0.5) {
			if ($count == 1) {
				$nbr_jours = 0.5;
			} elseif ($count > 1) {
				$nbr_jours = $count - 1 + 0.5;
			}
		}
		$attendees = $this->input->post("attendees");
		$attendee_ids = [];
		if (!empty($attendees)) {
			$attendee_ids = is_array($attendees) ? array_map('intval', $attendees) : array_map('intval', explode(',', $attendees));
		}

		$data = [
			"title"       => $title,
			"description" => $description,
			"start_date"  => $start_date,
			"end_date"    => $end_date,
			"color"       => $this->current_user->couleur,
			"created_by"  => $this->current_user->id,
			"nbr_jour"    => $nbr_jours
		];
		$event_id = $this->Event_model->insert_event($data, $attendee_ids);

		if ($event_id) {
			header('Content-Type: application/json');
			echo json_encode(["status" => true, "event_id" => $event_id]);
		} else {
			echo json_encode(["status" => false, "error" => "Échec de l'ajout de l'événement"]);
		}
	}


	public function event_detail($id)
	{
		$event = $this->Event_model->get_event($id);
		header('Content-Type: application/json');
		echo json_encode($event);
	}

	public function update_event()
	{
		$id = $this->input->post("id");
		$data = [
			"title"       => $this->input->post("title"),
			"description" => $this->input->post("description"),
			"start_date"  => date("Y-m-d H:i:s", strtotime($this->input->post("start_date"))),
			"end_date"    => date("Y-m-d H:i:s", strtotime($this->input->post("end_date"))),
			"color"       => $this->current_user->couleur,
		];

		$attendees = $this->input->post("attendees");
		$attendee_ids = !empty($attendees) ? (is_array($attendees) ? array_map('intval', $attendees) : array_map('intval', explode(',', $attendees))) : [];

		$this->Event_model->update_event($id, $data, $attendee_ids);
		echo json_encode(["status" => true]);
	}

	public function delete_event()
	{
		$id = $this->input->post("id");
		$this->Event_model->delete_event($id);
		echo json_encode(["status" => true]);
	}
	private function get_french_holidays($year)
	{
		$easter = easter_date($year);

		return [
			"$year-01-01", // Jour de l'an
			"$year-05-01", // Fête du travail
			"$year-05-08", // Victoire 1945
			"$year-07-14", // Fête nationale
			"$year-08-15", // Assomption
			"$year-11-01", // Toussaint
			"$year-11-11", // Armistice
			"$year-12-25", // Noël

			// Jours mobiles
			date('Y-m-d', strtotime('+1 day', $easter)),   // Lundi de Pâques
			date('Y-m-d', strtotime('+39 days', $easter)), // Ascension
			date('Y-m-d', strtotime('+50 days', $easter)), // Lundi de Pentecôte
		];
	}
}
