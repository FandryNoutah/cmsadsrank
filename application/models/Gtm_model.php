<?php
class Gtm_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	public function change_statut_optimisation($id, $Débogage, $date_due)
{
	$this->load->database();
    $data = array(
        'Débogage' => $Débogage
    );

    $this->db->where('idclients', $id);
    $this->db->where('mois', $date_due);
    $this->db->update('optimisation_gtm', $data);

    $this->db->close();
}

		public function update_budger_onboarding($idclient, $budget)
	{
		$sql = "UPDATE onboarding SET budget = $budget WHERE idclients = $idclient";
		$this->db->query($sql);
		$this->db->close();
	}
	public function get_optimisation(){
        $this->db->select('o.*, c.nom_client, c.favicon');
        $this->db->from('optimisation_gtm o');
        $this->db->join('clients c','c.idclients=o.idclients','left');
        $this->db->order_by('mois','DESC');
        return $this->db->get()->result_array();
    }

    public function get_optimisation_by_id($id){
        return $this->db->get_where('optimisation_gtm',['id_optimisation_gtm'=>$id])->row_array();
    }

    public function exists_optimisation($idclients,$mois){
        $this->db->where('idclients',$idclients);
        $this->db->where('DATE_FORMAT(mois,"%Y-%m")',$mois);
        $count = $this->db->count_all_results('optimisation_gtm');
        return $count>0;
    }

    public function add_optimisation($idclients,$mois,$debug){
        $this->db->insert('optimisation_gtm',[
            'idclients'=>$idclients,
            'mois'=>$mois.'-01',
            'Débogage'=>$debug,
            'statut'=>'En_attente',
            'date_demande'=>date('Y-m-d')
        ]);
    }

    public function update_optimisation($id,$debug){
        $this->db->where('id_optimisation_gtm',$id);
        $this->db->update('optimisation_gtm',[

            'Débogage'=>$debug
        ]);
    }

    // Optionnel : ajout automatique début de mois
    public function add_optimisation_automatic($clients){
        $currentMonth = date('Y-m-01');
        foreach($clients as $c){
            if(!$this->exists_optimisation($c['idclients'],date('Y-m',$currentMonth))){
                $this->add_optimisation($c['idclients'],$currentMonth,'à vérifier');
            }
        }
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




}
