<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Office_model extends CI_Model {
    
    // Company list
    public function office_list()
	{
        $this->db->select("id_sucursal,razon_social,rfc,representante,telefono,estatus,id_empresa"); 
		$this->db->from("sucursales");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }    
 
    public function add_office($data){        
        $this->db->insert('sucursales',$data);
		return $this->db->insert_id();   
    }

    // Get office by ID
    public function office_byid($id)
	{
        $this->db->select("*");
		$this->db->from("sucursales");
        $this->db->where("id_sucursal",$id);
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    }
    
    
    public function update_office($data,$id){
        $this->db->where('id_sucursal',$id);
        return $this->db->update('sucursales',$data);
    }  
    
    public function delete_office($id){
        $this->db->where('id_sucursal',$id);
        return $this->db->delete('sucursales');
    }
}