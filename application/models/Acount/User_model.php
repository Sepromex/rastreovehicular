<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class User_model extends CI_Model {
    public function status_usr_list(){
        $this->db->select("*");
		$this->db->from("estusr");        
        $query = $this->db->get();
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }
    } 

    // User list
    public function user_list()
	{        
        $this->db->select("u.ID_USUARIO as id_usuario, 
                           u.username as usuario, 
                           u.EMAIL as email,
                           u.ESTATUS as estatus_id, 
                           u.NOMBRE as nombre, 
                           u.PASSWORD as password, 
                           u.ID_EMPRESA as id_empresa,u.usuario_tipo, u.activo, e.DESCRIPCION as estatus");
		$this->db->from("usuarios u","left");
        $this->db->join("estusr e", "u.ESTATUS = e.ESTATUS");
        $this->db->where("activo","1");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 
        }	            
    } 

    // Get user by ID
    public function user_byid($id)
	{  //usuario, contraseña, fecha inicio, fecha fin , rol de usuario, asignar vehiculos
        $this->db->select("u.ID_USUARIO as id_usuario, 
                           u.username as usuario, 
                           u.EMAIL as email,
                           u.ESTATUS as estatus_id, 
                           u.NOMBRE as nombre, 
                           u.PASSWORD as password, 
                           u.ID_EMPRESA as id_empresa,
                           u.usuario_tipo, 
                           u.activo, u.id_rol, u.fechaalta, u.F_INICIO as fecha_inicio, u.F_TERMINO as fecha_fin,  e.DESCRIPCION as estatus");
		$this->db->from("usuarios u","left");
        $this->db->join("estusr e", "u.ESTATUS = e.ESTATUS");
        $this->db->where("ID_USUARIO",$id);
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
        $this->db->where('ID_USUARIO',$id);
        return $this->db->update('usuarios',$data);
    } 
	
    
    
    public function delete_user($id){
        $data = ["activo" => 0];
        $this->db->where('ID_USUARIO',$id);
        return $this->db->update('usuarios',$data);
    }

    public function delete_vechicle($data,$id){
        $this->db->where('ID',$id);
        return $this->db->update('veh_usr',$data);
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