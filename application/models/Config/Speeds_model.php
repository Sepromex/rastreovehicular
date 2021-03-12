<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Speeds_model extends CI_Model {

    // Vehicle list
    public function speed_list()
	{
        $this->db->select("*");
		$this->db->from("velocidades");
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }

    public function add_speed($data){
        $this->db->insert('velocidades',$data);
		return $this->db->insert_id();
    } 

    // Get speed by ID
    public function speed_byid($id)
	{
        $this->db->select("*");
		$this->db->from("velocidades");
        $this->db->where("id_velocidad",$id);
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
    }

    public function update_speed($data,$id){
        $this->db->where('id_velocidad',$id);
        return $this->db->update('velocidades',$data);
    } 
	
    public function delete_speed($id){
        $this->db->where('id_velocidad',$id);
        return $this->db->delete('velocidades');
    }

}