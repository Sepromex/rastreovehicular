<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Speeds_model extends CI_Model {

    // Vehicle list
    public function speed_list()
	{
        $this->db->select("*");
		$this->db->from("config_vel");
        $this->db->where("id_usuario",$_SESSION["user"]["id"]);
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
		$this->db->from("config_vel");
        $this->db->where("num_veh",$id);
        $this->db->where("id_usuario",$_SESSION["user"]["id"]);
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
    } 

    public function update_speed($data){
        $this->db->select("num_veh");
		$this->db->from("config_vel");
        $this->db->where("num_veh",$data["speed_id"]);
        $this->db->where("id_usuario",$_SESSION["user"]["id"]);
        $query = $this->db->get();
		if($query->num_rows()>0){			
            
            $speed = ["vel1"       => $data["speed_min"],
                      "vel2"       => $data["speed_normal"],
                      "vel3"       => $data["speed_regular"],
                      "vel4"       => $data["speed_max"]];
            $this->db->where("num_veh",$data["speed_id"]); 
            $this->db->where("id_usuario",$_SESSION["user"]["id"]);
            $update =  $this->db->update('config_vel',$speed);
            return true;            
		}else{			
            
            $speed = ["id_usuario" => $_SESSION["user"]["id"],
                      "num_veh"    => $data["speed_id"],
                      "vel1"       => $data["speed_min"],
                      "vel2"       => $data["speed_normal"],
                      "vel3"       => $data["speed_regular"],
                      "vel4"       => $data["speed_max"]];            
            $this->db->insert('config_vel',$speed);
            return $this->db->insert_id();
		}
        //print_array($speed);
      
    } 
	
    public function delete_speed($id){
        $this->db->where('id_velocidad',$id);
        return $this->db->delete('velocidades');
    }

}