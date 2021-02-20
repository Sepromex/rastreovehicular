<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Company_model extends CI_Model {
    
    // Company list
    public function company_list()
	{
        $this->db->select("id_empresa,razon_social,rfc,representante,telefono,estatus"); 
		$this->db->from("empresas");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }    
 
    public function add_company($data){        
        $this->db->insert('empresas',$data);
		return $this->db->insert_id();   
    }

    // Get company by ID
    public function company_byid($id)
	{
        // Select all fields
        $this->db->select("*");
        // Select table
		$this->db->from("empresas");
        // Condition
        $this->db->where("id_empresa",$id);
        // Get row
        $query = $this->db->get();         
		if($query->num_rows()>0){            
            // Return row to controller Company
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    }
    
    public function update_company($data,$id){
        $this->db->where('id_empresa',$id);
        return $this->db->update('empresas',$data);
    }  
    
    public function delete_company($id){
        $this->db->where('id_empresa',$id);
        return $this->db->delete('empresas');
    }




}