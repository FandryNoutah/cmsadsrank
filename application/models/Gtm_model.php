<?php
class Gtm_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function get_all_gtm() {
			$this->db->select('gtm.*, clients.*,users.*');
			$this->db->from('gtm');
			$this->db->join('clients', 'gtm.idclients = clients.idclients');
			$this->db->join('users', 'gtm.tm = users.id');
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


}
