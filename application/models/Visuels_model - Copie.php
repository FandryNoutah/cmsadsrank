<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Extension_model extends CI_Model {

   public function updateExclusions($idclients, $exclusions) {
    
        $this->db->where('idclients', $idclients)->delete('exclusions');

        // Puis on insère les nouvelles
        foreach ($exclusions as $ex) {
            if (trim($ex) === '') continue;
            $this->db->insert('exclusions', [
                'idclients' => $idclients,
                'exclusion' => trim($ex)
            ]);
        }
        return true;
    }
	
}
