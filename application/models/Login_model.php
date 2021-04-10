<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Login_model extends CI_Model {
    
    // get login database
    public function check_login($user, $password)
	{
        $this->db->select("ID_USUARIO as id_usuario, 
                           username as usuario, 
                           ESTATUS as estatus, 
                           NOMBRE as nombre, 
                           PASSWORD as password, 
                           ID_EMPRESA as id_empresa,usuario_tipo, id_rol, activo, f_inicio, f_termino");
		$this->db->from("usuarios");
        $this->db->where("USERNAME",$user);		
        $this->db->where("PASSWORD",$password);
        $this->db->where("activo",1);
        $this->db->where("ESTATUS >",1);        
        $query = $this->db->get();                 
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
            
        //check email in db
		if($query->num_rows()>0){ 
            //load code
            //send email
            return true;
            
		}else{			
			return false; 			
		}
    }


    public function get_modules(){
        $this->db->select("*");
		$this->db->from("modulos_rv");  
        //$this->db->where("mprincipal","5");  
        $this->db->order_by("mprincipal, grado, msecundario", "asc");   
        $query = $this->db->get(); 
            
        //check email in db
		if($query->num_rows()>0){ 
            return $query->result();
            
		}else{			
			return false; 			
		}
    } 
 
	
}