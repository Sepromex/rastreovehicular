<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Company_model extends CI_Model {
    
    // Company list
    public function company_list()
	{
        $this->db->select("e.id_empresa,
                           e.nombre as razon_social,
                           e.rfc,
                           e.rep as representante, 
                           e.tel_ppal as telefono, 
                           e.estatus as estatus_id,
                           e.id_giro,
                           es.descripcion as estatus,
                           gi.descripcion as giro"); 
		$this->db->from("empresas e","left"); 
        $this->db->join("estemp es","e.estatus = es.estatus"); 
        $this->db->join("empresas_giros gi","e.id_giro = gi.id_giro"); 
        
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
        $this->db->select("e.id_empresa,
                            e.nombre as razon_social,
                            e.rfc,
                            e.rep as representante, 
                            e.tel_ppal as telefono, 
                            e.estatus as estatus_id,
                            e.email,
                            e.direccion,
                            e.colonia,
                            e.ciudad,
                            e.id_giro,
                            es.descripcion as estatus,
                            gi.descripcion as giro"); 
        $this->db->from("empresas e","left"); 
        $this->db->join("estemp es","e.estatus = es.estatus","left"); 
        $this->db->join("empresas_giros gi","e.id_giro = gi.id_giro","left");         
        // Condition
        $this->db->where("e.id_empresa",$id);
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

    public function company_category()
	{
        $this->db->select("*"); 
		$this->db->from("empresas_giros");         
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }  


}