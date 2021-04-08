<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Contact_model extends CI_Model {
    // Contact list
    public function contact_list($company = 0)
	{
        $this->dbweb->select("*");
		$this->dbweb->from("contactos_web");
        $this->dbweb->where("estatus",1);
        $query = $this->dbweb->get();  
        if($company != 0) { $this->dbweb->where("id_empresa",$company);}     
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }   
     

    public function add_contact($data){        
        $this->db->insert('contactos_web',$data);
		return $this->db->insert_id();   
    } 

    // Get contact by ID
    public function contact_byid($id)
	{
        $this->db->select("*");
		$this->db->from("contactos_web");
        $this->db->where("id_contacto",$id);
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    }  
    
    public function update_contact($data,$id){
        $this->db->where('id_contacto',$id);
        return $this->db->update('contactos_web',$data);
    } 
    
    public function delete_contact($id){
        $data = ["estatus" => 0];
        $this->db->where('id_contacto',$id);
        return $this->db->update('contactos_web',$data);
    }

}