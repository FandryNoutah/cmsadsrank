<?php
class Task_model extends CI_Model {

public function __construct() {
    parent::__construct();
}

    // Méthode pour récupérer une tâche par son ID

    public function get_task_by_id($idtask) {
        // Construire la requête SQL
        $sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
                FROM tasks 
                LEFT JOIN users ON users.id = tasks.assigned_to 
                LEFT JOIN clients ON clients.idclients = tasks.idclients 
                LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
                LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
                WHERE tasks.idtask = ?";
    
        // Exécuter la requête avec le paramètre $idtask
        $query = $this->db->query($sql, array($idtask));
    
        // Retourner le résultat sous forme d'un seul objet
        return $query->row(); // Utiliser row() pour récupérer une seule ligne
    }

    // public function get_task_by_id($idtask) {
    //     // Sélectionner les colonnes de tasks, users et clients
    //     $this->db->select('tasks.*, users.*, clients.*, am_clients.*, assigned_clients.*');
        
    //     // De la table 'tasks'
    //     $this->db->from('tasks');
        
    //     // Jointure sur la table 'users' pour récupérer l'utilisateur assigné
    //     $this->db->join('users', 'users.id = tasks.assigned_to', 'left');
        
    //     // Jointure sur la table 'clients' pour récupérer le client principal (idclients de tasks)
    //     $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
        
    //     // Jointure sur la table 'clients' pour récupérer les données du client AM (Account Manager)
    //     $this->db->join('clients AS am_clients', 'am_clients.idclients = tasks.AM', 'left');
        
    //     // Jointure sur la table 'clients' pour récupérer le client assigné à la tâche (client de l'utilisateur assigné)
    //     $this->db->join('clients AS assigned_clients', 'assigned_clients.idclients = tasks.assigned_to', 'left');
        
    //     // Ajouter une condition pour filtrer par l'ID de la tâche
    //     $this->db->where('tasks.idtask', $idtask);
        
    //     // Exécuter la requête
    //     $query = $this->db->get();
        
    //     // Retourner le résultat sous forme d'un seul objet
    //     return $query->row(); // Utiliser row() pour récupérer une seule ligne
    // }
    public function update_task($idtask, $task_data) {
        // Préparer les données à mettre à jour
        $data = array(
            'date_demande' => $task_data['date_demande'],
            'date_due' => $task_data['date_due'],
            'AM' => $task_data['AM'],
            'assigned_to' => $task_data['assigned_to'],
            'description' => $task_data['task_description'],
            'Statuts_technique' => $task_data['task_status'],
            'title' => $task_data['title'],
            'note_technique' => $task_data['note_technique']
        );
        
        // Mettre à jour la tâche dans la base de données
        $this->db->where('idtask', $idtask);
        $this->db->update('tasks', $data);
    }
    
    
    
        
    


// Fonction pour récupérer toutes les tâches
public function get_all_tasks() {
    $this->db->select('tasks.*, users.*'); // Sélectionner les colonnes de tasks et clients
    $this->db->from('tasks');
    $this->db->join('users', 'users.id = tasks.assigned_to', 'left'); // Jointure sur assigned_to et idclients
    $query = $this->db->get();
    return $query->result();
}
public function get_all_users() {
    $this->db->select('*'); // Sélectionner les colonnes de tasks et clients
    $this->db->from('users');
    $query = $this->db->get();
    return $query->result();
}
public function get_task_team() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    $this->db->where('tasks.type_tache', 1); // Ajouter la condition WHERE type_tache = 1
    
    $query = $this->db->get();
    return $query->result();
}
public function get_task_temporaire() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    $this->db->where('tasks.type_tache', 2);
    
    $query = $this->db->get();
    return $query->result();
}
public function get_task_gtm() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    $this->db->where('tasks.type_tache', 3); // Ajouter la condition WHERE type_tache = 1
    
    $query = $this->db->get();
    return $query->result();
}
public function get_teamtask_nocomplete() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    // Ajouter les conditions WHERE
    $this->db->where('tasks.type_tache', 1); // type_tache = 3
    $this->db->where('tasks.statuts_technique !=', 2); // statuts_technique != 2
    
    $query = $this->db->get();
    return $query->result();
}



public function get_temporaire_nocomplete() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    // Ajouter les conditions WHERE
    $this->db->where('tasks.type_tache', 2); // type_tache = 3
    $this->db->where('tasks.statuts_technique !=', 2); // statuts_technique != 2
    
    $query = $this->db->get();
    return $query->result();
}
public function get_gtm_nocomplete() {
    // Sélectionner les colonnes de tasks, users (AM et assigned_to), et clients
    $this->db->select('tasks.*, 
                       am_users.first_name AS am_first_name, 
                       am_users.last_name AS am_last_name, 
                       assigned_users.first_name AS assigned_first_name, 
                       assigned_users.last_name AS assigned_last_name, 
                       clients.*');
                       
    $this->db->from('tasks');
    
    // Jointure pour récupérer les informations de l'AM
    $this->db->join('users AS am_users', 'am_users.id = tasks.AM', 'left');
    
    // Jointure pour récupérer les informations du TM (assigned_to)
    $this->db->join('users AS assigned_users', 'assigned_users.id = tasks.assigned_to', 'left');
    
    // Jointure pour récupérer les informations du client
    $this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');
    
    // Ajouter les conditions WHERE
    $this->db->where('tasks.type_tache', 3); // type_tache = 3
    $this->db->where('tasks.statuts_technique !=', 2); // statuts_technique != 2
    
    $query = $this->db->get();
    return $query->result();
}



public function get_all_tasks_by_idclients($id) {
    $this->db->select('tasks.*, users.*'); // Sélectionner les colonnes de tasks et users
    $this->db->from('tasks');
    $this->db->join('users', 'users.id = tasks.assigned_to', 'left'); // Jointure sur assigned_to et users.id
    $this->db->where('tasks.idclients', $id); // Ajouter la condition WHERE
    $query = $this->db->get();
    return $query->result();
}



// Fonction pour récupérer les tâches effectuées
public function get_completed_tasks() {
    $this->db->where('status', 'effectuée');
    $query = $this->db->get('tasks');
    return $query->result();
}

// Fonction pour ajouter une nouvelle tâche
public function add_task($data) {
    $this->db->insert('tasks', $data);
    return $this->db->insert_id();  // Retourner l'ID de l'insertion
}


// Fonction pour mettre à jour le statut d'une tâche
public function updates_task($taskId, $title, $description, $assignedTo, $status) {
    $data = array(
        'title' => $title,
        'description' => $description,
        'assigned_to' => $assignedTo,
        'status' => $status
    );

    $this->db->where('idtask', $taskId);
    $this->db->update('tasks', $data);
}


// Fonction pour supprimer une tâche
public function delete_task($task_id) {
    $this->db->where('idtask', $task_id);
    $this->db->delete('tasks');  // Supposons que ta table s'appelle 'tasks'
}

}
