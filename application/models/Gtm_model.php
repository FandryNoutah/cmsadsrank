<?php
class Gtm_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function get_all_gtm() {
			$this->db->select('gtm.*, clients.*,users.*,donnee.tracking_gtm');
			$this->db->from('gtm');
			$this->db->join('clients', 'gtm.idclients = clients.idclients');
			$this->db->join('users', 'gtm.tm = users.id');
			$this->db->join('donnee', 'gtm.idclients = donnee.idclients');
			$result = $this->db->get();
			return $result->result_array();
			}
			public function get_all_optimisation_gtm() {
			$this->db->select('optimisation_gtm.*, clients.*,donnee.tracking_gtm');
			$this->db->from('optimisation_gtm');
			$this->db->join('clients', 'optimisation_gtm.idclients = clients.idclients');
			$this->db->join('donnee', 'optimisation_gtm.idclients = donnee.idclients');
			$result = $this->db->get();
			return $result->result_array();
			}

	public function add_gtm_process($data_gtm) {
    return $this->db->insert('gtm', $data_gtm);
	}
	public function get_by_id($id)
	{
		return $this->db->get_where('gtm', ['id_gtm' => $id])->row_array();
	}
	public function update($id, $data)
	{
		return $this->db->where('id_gtm', $id)
						->update('gtm', $data);
	}
<<<<<<< HEAD
	public function update_implementation($id, $data)
	{
		$this->load->database();
		return $this->db->where('idclients', $id)
						->update('gtm', $data);
	}
	public function update_invitation($id, $data)
	{
		return $this->db->where('idclients', $id)
						->update('gtm', $data);
	}
	public function insert_optimisation($data_optimisation) {
        return $this->db->insert('optimisation_gtm', $data_optimisation); 
    }
	public function update_row($id, $data) {
		unset($data['idplan_de_taggage']);
		$this->db->where('idplan_de_taggage', $id);
		return $this->db->update('plan_de_taggage', $data);
	}

	public function insert_row($data) {
		return $this->db->insert('plan_de_taggage', $data);
	}
	public function delete_row($id) {
	$this->db->where('idplan_de_taggage', $id);
	return $this->db->delete('plan_de_taggage');
}


=======
	public function insert_optimisation($data_optimisation) {
        return $this->db->insert('optimisation_gtm', $data_optimisation); 
    }
>>>>>>> d1feff0b43b53a9f63f0888aba0a47f632ead216


}
