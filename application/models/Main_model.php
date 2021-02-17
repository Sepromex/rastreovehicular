<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Main_model extends CI_Model {
    
    // Contact user list
    public function contactuser_list()
	{
        $this->db->select("id_usuario, email, concat(nombre, ' ', apellido) as nombre");
		$this->db->from("usuarios");
        $this->db->where("estatus","1");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 

    // Contact list
    public function contact_list($id = 0, $type="company")
	{
        $field = "id_empresa";
        if($type == "office"){ $field = "id_sucursal"; }        
        $this->db->select("*");
		$this->db->from("contactos");
        $this->db->where("estatus","1");         
        if($id > 0){
            $this->db->where($field,$id); 
        }       
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 

    public function office_list($company = 0)
	{
        $this->db->select("*"); 
		$this->db->from("sucursales"); 
        if($company > 0){
            $this->db->where("id_empresa",$company); 
        }        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }   
  
    // Company list
    public function company_list()
	{
        $this->db->select("id_empresa, razon_social");
		$this->db->from("empresas");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 

 

    public function get_locations()
	{
        $this->dbmaster->select("*");
		$this->dbmaster->from("estados");        
        $this->dbmaster->order_by("nombre","asc");
        $query = $this->dbmaster->get();         
		
        if($query->num_rows()>0){        
			return $query->result();
		}	     
    } 

    public function get_city()
	{
        $this->dbmaster->select("*");
		$this->dbmaster->from("municipios");        
        $this->dbmaster->order_by("nombre","asc");
        $query = $this->dbmaster->get();		
        if($query->num_rows()>0){        
			return $query->result();
		}	     
    } 



}