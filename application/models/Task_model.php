<?php
class Task_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	// Méthode pour récupérer une tâche par son ID
	public function get_All_task_non_complete()
	{
		
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		// Condition de filtre
		$this->db->where('Statuts_technique !=', 2);

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}
	
	public function count_All_task_non_complete($current_user = null) {
		
		$this->db->select('COUNT(*) as total');
		$this->db->from('tasks');

		if ($current_user) {
			$this->db->where('assigned_to', $current_user);
		}

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		// Condition de filtre
		$this->db->where('Statuts_technique !=', 2);

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner le nombre total
		$result = $query->row();
		return $result->total;
	}
	
	public function get_team_task_non_complete()
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		// Condition de filtre
		$this->db->where('Statuts_technique !=', 2);
		$this->db->where('type_tache', 1);

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}
	public function get_temporaire_task_non_complete()
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		// Condition de filtre
		$this->db->where('Statuts_technique !=', 2);
		$this->db->where('type_tache', 2);

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}
	public function get_gtm_task_non_complete()
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		// Condition de filtre
		$this->db->where('Statuts_technique !=', 2);
		$this->db->where('type_tache', 3);

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}
	public function get_all_tâche($status = null)
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		if ($status !== null) {
			$this->db->where('Statuts_technique', $status); // Exact match
			// OR use $this->db->where('Statuts_technique !=', $status) if you want "not equal"
		}

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}

	public function get_task_temporaire($status = null)
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		$this->db->where('type_tache', 2);

		if ($status !== null) {
			$this->db->where('Statuts_technique', $status); // Exact match
			// OR use $this->db->where('Statuts_technique !=', $status) if you want "not equal"
		}

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}

	public function get_task_gtm($status = null)
	{
		$this->db->select('tasks.*, u1.first_name as assigned_to_name, u1.photo_users as assigned_to_photo, u2.first_name as AM_name, u2.photo_users as AM_photo, clients.*');
		$this->db->from('tasks');

		// Jointure avec la table users pour "assigned_to" (utilisateur assigné à la tâche)
		$this->db->join('users u1', 'u1.id = tasks.assigned_to', 'left');

		// Jointure avec la table clients
		$this->db->join('clients', 'clients.idclients = tasks.idclients', 'left');

		// Jointure avec la table users pour "AM" (utilisateur AM)
		$this->db->join('users u2', 'u2.id = tasks.AM', 'left');

		$this->db->where('type_tache', 3);

		if ($status !== null) {
			$this->db->where('Statuts_technique', $status); // Exact match
			// OR use $this->db->where('Statuts_technique !=', $status) if you want "not equal"
		}

		// Exécution de la requête
		$query = $this->db->get();

		// Retourner les résultats
		return $query->result();
	}

	public function get_task_by_id($idtask)
	{
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
	public function get_task_by_id_client($idclients)
{
    // Construire la requête SQL
    $sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
            FROM tasks 
            LEFT JOIN users ON users.id = tasks.assigned_to 
            LEFT JOIN clients ON clients.idclients = tasks.idclients 
            LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
            LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
            WHERE tasks.idclients = ?";

    // Exécuter la requête avec le paramètre $idclients
    $query = $this->db->query($sql, array($idclients));

    // Retourner le résultat sous forme de tableau d'objets
    return $query->result(); 

}
public function get_procedure_gtm($idclients)
{
    // Construire la requête SQL
    $sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
            FROM tasks 
            LEFT JOIN users ON users.id = tasks.assigned_to 
            LEFT JOIN clients ON clients.idclients = tasks.idclients 
            LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
            LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
            WHERE tasks.idclients = ? AND tasks.procedure_gtm = 1";

    // Exécuter la requête avec le paramètre $idclients
    $query = $this->db->query($sql, array($idclients));

    // Retourner le résultat sous forme de tableau d'objets
    return $query->result(); 
}
public function get_all_procedure_gtm()
{
    // Construire la requête SQL
    $sql = "SELECT tasks.*, users.*, clients.*, am_clients.*, assigned_clients.* 
            FROM tasks 
            LEFT JOIN users ON users.id = tasks.assigned_to 
            LEFT JOIN clients ON clients.idclients = tasks.idclients 
            LEFT JOIN clients AS am_clients ON am_clients.idclients = tasks.AM 
            LEFT JOIN clients AS assigned_clients ON assigned_clients.idclients = tasks.assigned_to 
            WHERE tasks.procedure_gtm = 1";

    // Exécuter la requête avec le paramètre $idclients
    $query = $this->db->query($sql);

    // Retourner le résultat sous forme de tableau d'objets
    return $query->result(); 
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
	public function update_task($taskId, $task_data)
	{
		/* $data = array(
			'date_demande' => $date_demande,
			'date_due' => $date_due,
			'AM' => $am,
			'assigned_to' => $assignedTo,
			'description' => $description,
			'Statuts_technique' => $status,
			'title' => $title
		); */

		// Mettre à jour la tâche dans la base de données
		$this->db->where('idtask', $taskId);
		$this->db->update('tasks', $task_data);
	}

	// Fonction pour récupérer toutes les tâches
	public function get_all_tasks()
	{
		$this->db->select('tasks.*, users.*'); // Sélectionner les colonnes de tasks et clients
		$this->db->from('tasks');
		$this->db->join('users', 'users.id = tasks.assigned_to', 'left'); // Jointure sur assigned_to et idclients
		$query = $this->db->get();
		return $query->result();
	}
	public function get_all_users()
	{
		$this->db->select('*'); // Sélectionner les colonnes de tasks et clients
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}





	public function get_all_tasks_by_idclients($id)
	{
		$this->db->select('tasks.*, users1.first_name as users1_first_name, users1.last_name as users1_last_name, users2.first_name as users2_first_name, users2.last_name as users2_last_name');
		$this->db->from('tasks');

		// Jointure pour l'utilisateur assigné
		$this->db->join('users as users1', 'users1.id = tasks.assigned_to', 'left');

		// Jointure pour la personne qui a créé la tâche
		$this->db->join('users as users2', 'users2.id = tasks.am', 'left');

		$this->db->where('tasks.idclients', $id); // Condition pour le client
		$query = $this->db->get();
		return $query->result();
	}





	// Fonction pour récupérer les tâches effectuées
	public function get_completed_tasks()
	{
		$this->db->where('status', 'effectuée');
		$query = $this->db->get('tasks');
		return $query->result();
	}

	// Fonction pour ajouter une nouvelle tâche
	public function add_task($data)
	{
		// Récupérer le dernier idtask inséré
		$this->db->select_max('idtask');  // Sélectionner l'idtask maximum
		$query = $this->db->get('tasks');
		$last_id = $query->row()->idtask;

		// Calculer la nouvelle référence (format ADS00001, ADS00002, etc.)
		$new_reference = 'ADS' . str_pad($last_id + 1, 5, '0', STR_PAD_LEFT);

		// Ajouter la nouvelle référence au tableau de données
		$data['reference'] = $new_reference;

		// Insérer la nouvelle tâche dans la base de données
		$this->db->insert('tasks', $data);

		// Retourner l'ID de la tâche insérée
		return $this->db->insert_id();
	}



	// Fonction pour mettre à jour le statut d'une tâche
	public function updates_task($taskId, $title, $description, $assignedTo, $status)
	{
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
	public function delete_task($task_id)
	{
		$this->db->where('idtask', $task_id);
		$this->db->delete('tasks');  // Supposons que ta table s'appelle 'tasks'
	}
}
