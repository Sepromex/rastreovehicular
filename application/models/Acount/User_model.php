<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class User_model extends CI_Model {
    
    // User list
    public function user_list()
	{
        $this->db->select("id_usuario, usuario, email, concat(nombre, ' ', apellido) as nombre, estatus");
		$this->db->from("usuarios");
        $this->db->where("estatus","1");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 

    // Get user by ID
    public function user_byid($id)
	{
        $this->db->select("*");
		$this->db->from("usuarios");
        $this->db->where("id_usuario",$id);
        $query = $this->db->get();
         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    } 

    public function add_user($data){        
        $this->db->insert('usuarios',$data);
		return $this->db->insert_id();   
    }

    public function update_user($data,$id){
        $this->db->where('id_usuario',$id);
        return $this->db->update('usuarios',$data);
    } 
	
    
    public function delete_user($id){
        $this->db->where('id_usuario',$id);
        return $this->db->delete('usuarios');
    }

    public function delete_vechicle($id){
        $this->db->where('id',$id);
        return $this->db->delete('usuarios_vehiculos');
    }

    public function validate_user($value,$field){
        $this->db->select($field);
		$this->db->from("usuarios");
        $this->db->where($field,$value);        
        $query = $this->db->get();
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }
    }

}