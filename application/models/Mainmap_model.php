<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Mainmap_model extends CI_Model {
    
    // get login database
    public function vehicle_list()
	{
        $this->dbweb->select("ID_VEH, NUM_VEH, estatus, id_sistema, id_empresa");
		$this->dbweb->from("vehiculos");	
		$this->dbweb->limit(30);
        $query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
		}	    
    } 
    
     
 
	
}