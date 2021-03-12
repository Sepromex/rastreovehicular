<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Vehicle_model extends CI_Model {
    
    // Vehicle list
    public function vehicle_list()
	{
        $this->db->select("*");
		$this->db->from("vehiculos");
        //$this->db->where("estatus","1"); undefined status
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 


    public function add_vechicle($data){
        $this->db->insert('vehiculos',$data);
		return $this->db->insert_id();   
    } 

    // Get user by ID
    public function vehicle_byid($id)
	{
        $this->db->select("*");
		$this->db->from("vehiculos");
        $this->db->where("id_vehiculo",$id);
        $query = $this->db->get();
         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    } 
 

    public function update_vehicle($data,$id){
        $this->db->where('id_vehiculo',$id);
        return $this->db->update('vehiculos',$data);
    } 
	
    public function delete_vechicle($id){
        $this->db->where('id_vehiculo',$id);
        return $this->db->delete('vehiculos');
    }

}