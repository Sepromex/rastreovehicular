<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Main_model extends CI_Model {
    
    // Contact user list
    public function contactuser_list()
	{
        $this->db->select("id_usuario, email, concat(nombre, ' ', apellido) as nombre");
		$this->db->from("usuarios");
        //$this->db->where("estatus","1");        
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

    // Sepromex users
    public function users_sepromex(){
        $this->dbweb->select("id_usuario, username as nombre");
		$this->dbweb->from("usuarios");
        $this->dbweb->where("username !=","");
        $this->dbmaster->order_by("nombre","asc");     
        $query = $this->dbweb->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }

     
    // Vehicle list
    public function vehicle_list($empresa = 0,$id = 0){
        $this->db->select("id_vehiculo,vehiculo,placas,modelo");
		$this->db->from("vehiculos");
        if($empresa > 0){ 
            $this->db->where("id_empresa",$empresa);
        }
        if($id > 0){ 
            $this->db->where("id_vehiculo",$id);
        }
        $this->db->order_by("vehiculo","asc");
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }

    public function assigned_vehicles($id_usuario){
        $this->db->select("uv.id, uv.id_usuario, v.id_vehiculo, v.vehiculo, v.placas, v.modelo");
		$this->db->from("usuarios_vehiculos uv");
        $this->db->join("vehiculos v", "uv.id_vehiculo = v.id_vehiculo");        
        $this->db->order_by("v.id_vehiculo","asc");
        $query = $this->db->get();
        if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }

    public function assign_vehicles($data){
        $this->db->select("id");
		$this->db->from("usuarios_vehiculos");
        $this->db->where("id_vehiculo",$data["id_vehiculo"]);
        $query = $this->db->get();
        if($query->num_rows()>0){		
            return "2";
		}else{
            $this->db->insert('usuarios_vehiculos',$data);
		    if($this->db->insert_id()){ 
                return "true";
            }else{
                return "false";
            }           
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

    public function vehicle_status(){
        $this->dbweb->select("estatus, descripcion");
		$this->dbweb->from("estveh");                
        $query = $this->dbweb->get();
		if($query->num_rows()>0){
            $status = [];
			foreach($query->result() as $status_){
                $st = explode("-",$status_->descripcion);
                $status[$status_->estatus] = trim($st[1]);
            }
            return $status; 
		}else{
			return false;
        }
    }


}