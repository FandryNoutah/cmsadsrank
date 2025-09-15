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
        // Mettre à jour l'état du congé
        $this->Conge_model->update_etat($id, 'valide');  

        // Dates de début et fin en DateTime
        $dtDebut = new DateTime($conge->date_debut);
        $dtFin = new DateTime($conge->date_fin);
        $interval = $dtDebut->diff($dtFin);
        // Pour inclure le jour de fin inclusif, tu peux ajouter +1 si nécessaire

        // Nombre de jours
        $nombre_de_jours = $interval->days + 1; // si tu veux inclure le dernier jour, sinon juste $interval->days

        // Préparer le titre et la description
        $title = 'Congé de ' . $conge->first_name . ' ' . $conge->last_name;
        $description = 'Congé validé du ' . $conge->date_debut . ' au ' . $conge->date_fin 
                       . ' (' . $nombre_de_jours . ' jour' . ($nombre_de_jours > 1 ? 's' : '') . ')';

        $start_date = date("Y-m-d H:i:s", strtotime($conge->date_debut));
        $end_date   = date("Y-m-d H:i:s", strtotime($conge->date_fin));
        $color = '#FF5733';

        $data_event = [
            "title"       => $title,
            "description" => $description,
            "start_date"  => $start_date,
            "end_date"    => $end_date,
            "color"       => $color,
            "created_by"  => $this->current_user->id
        ];

        $attendee_ids = [];
        $attendee_ids[] = (int) $conge->user_id;          // demandeur
        $attendee_ids[] = (int) $this->current_user->id;    // validateur
        $attendee_ids[] = 19;                              // personne taguée “19”

        $event_id = $this->Event_model->insert_event($data_event, $attendee_ids);

        redirect('conges');
    } else {
        show_404();
    }
}



}
