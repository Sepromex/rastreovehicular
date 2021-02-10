<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Login_model extends CI_Model {
    
    // get login database
    public function check_login($user, $password)
	{
        $this->dbmaster->select("id_usuario, usuario, estatus, concat(nombre, ' ', apellido) as nombre, password");
		$this->dbmaster->from("usuarios");
        $this->dbmaster->where("usuario",$user);		
        $this->dbmaster->where("password",$password);				
        $query = $this->dbmaster->get();        
         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    } 
    
    public function send_email($email){
        $this->dbmaster->select("email");
		$this->dbmaster->from("usuarios");
        $this->dbmaster->where("email",$email);        
        $query = $this->dbmaster->get(); 
         
        //verificar si existe email en la DB
		if($query->num_rows()>0){            
            //Generar código
            //Enviar correo
            return true;
            
		}else{			
			return false; 			
		}
    }
 
	
}