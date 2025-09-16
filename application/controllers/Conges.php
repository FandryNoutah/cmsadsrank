<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conges extends MY_Controller {

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

    // Vue principale pour la liste
    $this->content = "layouts/conges/liste";
    $this->layout();
}


    public function demander()
    {
        if ($this->input->post()) {
            $data = [
                'user_id' => $this->current_user->id,
                'date_debut' => $this->input->post('date_debut'),
                'date_fin' => $this->input->post('date_fin'),
                'motif' => $this->input->post('motif'),
                'etat' => 'en_attente'
            ];
            $this->Conge_model->add_demande($data);
            redirect('conges');
        } else {
            // si tu veux, rediriger ou afficher une vue de formulaire
            redirect('conges');
        }
    }

 public function valider($id)
{
    $this->load->model('Conge_model');
    $this->load->model('Event_model');

    $conge = $this->Conge_model->get_conge_by_id($id);

    if ($conge) {
        $this->Conge_model->update_etat($id, 'valide');

        $dtDebut = new DateTime($conge->date_debut);
        $dtFin = new DateTime($conge->date_fin);

        // Cloner pour ne pas modifier l'objet original
        $dtFinInclus = clone $dtFin;
        $dtFinInclus->modify('+1 day');

        // Obtenir les jours fériés pour les années concernées
        $annees = range((int)$dtDebut->format('Y'), (int)$dtFin->format('Y'));
        $jours_feries = [];
        foreach ($annees as $annee) {
            $jours_feries = array_merge($jours_feries, $this->get_french_holidays($annee));
        }

        $jours_ouvres = 0;

        $periode = new DatePeriod($dtDebut, new DateInterval('P1D'), $dtFinInclus);
        foreach ($periode as $date) {
            $jour = $date->format('N'); // 6 = samedi, 7 = dimanche
            $dateStr = $date->format('Y-m-d');

            if ($jour < 6 && !in_array($dateStr, $jours_feries)) {
                $jours_ouvres++;
            }
        }

        $title = 'Congé de ' . $conge->prenom . ' ' . $conge->nom;
        $description = 'Congé validé du ' . $conge->date_debut . ' au ' . $conge->date_fin 
                     . ' (' . $jours_ouvres . ' jour' . ($jours_ouvres > 1 ? 's' : '') . ' ouvré' . ($jours_ouvres > 1 ? 's' : '') . ')';

        $start_date = date("Y-m-d 01:i:s", strtotime($conge->date_debut));
        $end_date   = date("Y-m-d 01:i:s", strtotime($conge->date_fin));
        $color = '#FF5733';

        $data_event = [
            "title"       => $title,
            "description" => $description,
            "start_date"  => $start_date,
            "end_date"    => $end_date,
            "color"       => $color,
            "created_by"  => $this->current_user->id
        ];

        $attendee_ids = [
            (int)$conge->user_id,
            (int)$this->current_user->id,
            19
        ];

        $this->Event_model->insert_event($data_event, $attendee_ids);

        redirect('conges');
    } else {
        show_404();
    }
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
