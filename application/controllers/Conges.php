<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Conges extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Conge_model');
		$this->load->model('Event_model');
		$this->load->library('ion_auth');
		$this->current_user = $this->ion_auth->user()->row();
	}

	public function index()
	{
		$is_validator = ($this->current_user->tech == 3);

		$this->data['demandes'] = $this->Conge_model->get_all_demandes($this->current_user->id, $is_validator);
		$this->data['is_validator'] = $is_validator;

		$is_compta = ($this->current_user->tech == 2);

		$this->data['demandes_valider'] = $this->Conge_model->get_all_demandes_valider($this->current_user->id, $is_compta);
		$this->data['is_compta'] = intval($this->current_user->tech);

		if ($is_compta == 2) {
			
			$agendaFitlers = $this->input->get("agendaFilters");

			$events = $this->Event_model->get_all_event();
			$this->data['events'] = $events;
			
			$this->content = "layouts/conges/compta/index";
			$this->layout();
		} else {
			$this->content = "layouts/conges/index";
			$this->layout();
		}
	}

	public function demander()
	{
		if ($this->input->post()) {
			$date_debut = $this->input->post('date_debut');
			$date_fin = $this->input->post('date_fin');
			$jours_de_demande = (float) $this->input->post('jours');
			if (!$date_debut || !$date_fin) {
				echo json_encode(['error' => 'Dates manquantes']);
				return;
			}

			$start = new DateTime($date_debut);
			$end = new DateTime($date_fin);
			$annees = range((int)$start->format('Y'), (int)$end->format('Y'));
			$jours_feries = [];
			foreach ($annees as $annee) {
				$jours_feries = array_merge($jours_feries, $this->get_french_holidays($annee));
			}
			$jours_feries = array_unique($jours_feries);
			$count = 0;
			$interval = new DateInterval('P1D');
			$period = new DatePeriod($start, $interval, $end->modify('+1 day'));

			foreach ($period as $date) {
				$jour = $date->format('w');
				$date_str = $date->format('Y-m-d');
				if ($jour != 0 && $jour != 6 && !in_array($date_str, $jours_feries)) {
					$count++;
				}
			}
			$nbr_jours = 0;
			if ($jours_de_demande == 1) {
				$nbr_jours = $count;
			} elseif ($jours_de_demande == 0.5) {
				if ($count == 1) {
					$nbr_jours = 0.5;
				} elseif ($count > 1) {
					$nbr_jours = $count - 1 + 0.5;
				} else {
					$nbr_jours = 0;
				}
			}
			$data = [
				'user_id' => $this->current_user->id,
				'date_debut' => $date_debut,
				'date_fin' => $date_fin,
				'motif' => $this->input->post('motif'),
				'etat' => 'en_attente',
				'nbr_jour' => $nbr_jours
			];
			$this->Conge_model->add_demande($data);
			redirect('conges');
		} else {
			redirect('conges');
		}
	}

	public function valider($id)
	{
		$this->load->model('Conge_model');
		$this->load->model('Event_model');

		$etat = $this->input->post('etat');
		$commentaire = $this->input->post('commentaire');
		$conge = $this->Conge_model->get_conge_by_id($id);

		// Vérifier que la demande existe
		if (!$conge) {
			// Optionnel : afficher un message d'erreur ou logger
			redirect('conges');
			return;
		}

		// Traitement selon l'état choisi
		if ($etat === 'valide') {
			// Mettre à jour l'état dans la base
			$this->Conge_model->update_etat($id, $commentaire, 'valide');

			// Calcul des jours ouvrés
			$dtDebut = new DateTime($conge->date_debut);
			$dtFin = new DateTime($conge->date_fin);
			$dtFinInclus = clone $dtFin;
			$dtFinInclus->modify('+1 day');

			// Jours fériés pour les années concernées
			$annees = range((int)$dtDebut->format('Y'), (int)$dtFin->format('Y'));
			$jours_feries = [];
			foreach ($annees as $annee) {
				$jours_feries = array_merge($jours_feries, $this->get_french_holidays($annee));
			}

			// Calcul des jours ouvrés
			$jours_ouvres = 0;
			$periode = new DatePeriod($dtDebut, new DateInterval('P1D'), $dtFinInclus);
			foreach ($periode as $date) {
				$jour = $date->format('N'); // 6 = samedi, 7 = dimanche
				$dateStr = $date->format('Y-m-d');
				if ($jour < 6 && !in_array($dateStr, $jours_feries)) {
					$jours_ouvres++;
				}
			}
			$nbr_jour = $conge->nbr_jour;
			// Création de l'événement
			$title = 'Congé de ' . $conge->prenom . ' ' . $conge->nom;
			$description = 'Congé validé du ' . $conge->date_debut . ' au ' . $conge->date_fin
				. ' (' . $nbr_jour . ' jour ouvré' . ')';

			$start_date = date("Y-m-d 01:i:s", strtotime($conge->date_debut));
			$end_date   = date("Y-m-d 01:i:s", strtotime($conge->date_fin));
			$color = $conge->couleur;
			$data_event = [
				"title"       => $title,
				"description" => $description,
				"start_date"  => $start_date,
				"end_date"    => $end_date,
				"color"       => $color,
				"created_by"  => $this->current_user->id,
				"nbr_jour"  => $nbr_jour
			];

			$attendee_ids = [
				(int)$conge->user_id,
				(int)$this->current_user->id,
				19 // ID d'un administrateur ou RH ?
			];

			$this->Event_model->insert_event($data_event, $attendee_ids);
		} elseif ($etat === 'en_attente') {
			$this->Conge_model->update_etat($id, $commentaire, 'en_attente');
		} elseif ($etat === 'refuse') {
			$this->Conge_model->update_etat($id, $commentaire, 'refuse');
		}

		// Redirection à la liste des congés
		redirect('conges');
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
