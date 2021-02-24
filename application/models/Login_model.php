<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Login_model extends CI_Model {
    
    // get login database
    public function check_login($user, $password)
	{
        $this->db->select("id_usuario, usuario, estatus, concat(nombre, ' ', apellido) as nombre, password, id_empresa");
		$this->db->from("usuarios");
        $this->db->where("usuario",$user);		
        $this->db->where("password",$password);				
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
 
	
}