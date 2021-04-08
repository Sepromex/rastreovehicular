<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Vehicle_model extends CI_Model {
    
    // Vehicle list
    public function vehicle_list()
	{         
        $this->db->select("DISTINCT(v.NUM_VEH) as id_vehiculo,
                           v.ID_VEH as vehiculo,
                           v.PLACAS as placas,
                           v.MODELO as modelo, 
                           v.detalle,                           
                           v.estatus");
		$this->db->from("veh_usr as vu");
        $this->db->join("vehiculos as v","vu.NUM_VEH = v.NUM_VEH ");               
        $this->db->where("vu.ID_USUARIO", $_SESSION["user"]["id"]); 
        $this->db->where("vu.activo",1);  
        $this->db->order_by("v.NUM_VEH","asc");
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
        $this->dbweb->where('num_veh',$id);
        return $this->dbweb->update('vehiculos',$data);
    } 
	
    public function delete_vechicle($id){
        $this->db->where('id_vehiculo',$id);
        return $this->db->delete('vehiculos');
    }

}