<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_chat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Chargement du modèle et des helpers nécessaires
        $this->load->model('Group_message_model');
        $this->load->helper(['form', 'url']);

        // Récupération de l'utilisateur connecté via Ion Auth
        $this->current_user = $this->ion_auth->user()->row();

        // Sécurité : si l'utilisateur n'est pas connecté, on redirige
        if (!$this->current_user) {
            redirect('auth/login');
        }
    }

    /**
     * Affiche la discussion de groupe
     */
    public function index()
    {
        $data['messages'] = $this->Group_message_model->get_all_messages();
        $data['current_user'] = $this->current_user;
        $this->load->view('layouts/chat/group_chat', $data);
    }

    /**
     * Envoie un message
     */
    public function send_message()
    {
        $message = $this->input->post('message', TRUE);

        if (!empty($message) && $this->current_user) {
            $this->Group_message_model->insert_message([
                'user_id' => $this->current_user->id,
                'message' => $message
            ]);
        }

        redirect('group_chat');
    }
}
