<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Main_model extends CI_Model {
    
    public function vehicle_byid($vehid){	 
		$this->dbweb->select("v.num_veh, v.id_veh, v.ID_SISTEMA, v.ID_EMPRESA, v.ID_FLOTILLA,
			v.TIPOVEH, v.ESTATUS, v.economico, v.placas, v.modelo, v.detalle, v.MARCA, v.COLOR, v.FOTO,
			ev.DESCRIPCION as estatus_desc, sis.DESCRIPCION as sistemadesc, emp.NOMBRE as empresanom, tp.descripcion as tipoequipo");
		$this->dbweb->from("vehiculos v", "left");	
		$this->dbweb->join("estveh ev","v.estatus = ev.estatus","left");	
		$this->dbweb->join("sistemas sis","sis.id_sistema = v.id_sistema","left");	
		$this->dbweb->join("empresas emp","v.ID_EMPRESA = emp.ID_EMPRESA","left");
		$this->dbweb->join("tipo_equipo tp","v.TIPOVEH = tp.id","left");	
		$this->dbweb->where("v.num_veh",$vehid);
		$query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}
	}

    
    // Contact user list
    public function contactuser_list()
	{
        $this->db->select("id_usuario, email, nombre, username");
		$this->db->from("usuarios");
        $this->db->where("activo","1"); 
        $this->db->where("activo","1");        
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
        //$field = "id_empresa";
        //if($type == "office"){ $field = "id_sucursal"; }
        
        $this->db->select("*");
		$this->db->from("contactos_web");
        $this->db->where("estatus","1"); 
        if($id > 0){
            $this->db->where("id_empresa",$id);
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
        $this->db->select("e.nombre as razon_social,
                           e.rep as representante,
                           e.rfc,
                           e.contacto as id_contacto,
                           e.tel_ppal as telefono,
                           e.email,
                           e.direccion,
                           e.colonia,
                           e.ciudad,
                           e.id_estado,
                           est.descripcion as estado");
		$this->db->from("empresas e","left"); 
        $this->db->join("estados est", "e.id_estado = est.id_estado","left");         
        $this->db->where("id_parent",$company); 
          

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
        $this->db->select("id_empresa, NOMBRE as razon_social");
		$this->db->from("empresas");
        $query = $this->db->get();
		if($query->num_rows()>0){         
			return $query->result();
		}else{
			return false;
        }	            
    }

   

     
    // Vehicle list
    public function vehicle_list($id = 0,$id_a = 0){        
        $this->db->select("distinct(v.NUM_VEH) as id_vehiculo,
                           v.ID_VEH as vehiculo,
                           v.PLACAS as placas,
                           v.MODELO as modelo, 
                           vu.ID as id_vuser");
		$this->db->from("veh_usr as vu");
        $this->db->join("vehiculos as v","vu.NUM_VEH = v.NUM_VEH ");        
        $this->db->where("vu.ID_USUARIO", $id); 
        $this->db->where("vu.activo",1); 
        if($id_a > 0){
            $this->db->where("vu.ID",$id_a); 
        }
        $this->db->order_by("v.ID_VEH","asc");
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }   

    public function assigned_vehicles($id_usuario){
        $this->db->select("distinct(v.NUM_VEH) as id_vehiculo,
                           v.ID_VEH as vehiculo,
                           v.PLACAS as placas,
                           v.MODELO as modelo,
                           vu.ID as id_vuser");
		$this->db->from("veh_usr as vu");
        $this->db->join("vehiculos as v","vu.NUM_VEH = v.NUM_VEH ");        
        $this->db->where("vu.ID_USUARIO", $id_usuario); 
        $this->db->where("vu.activo",1); 
        $this->db->order_by("v.ID_VEH","asc");
        $query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
        }
    }

    public function assign_vehicles($data,$id){
        $this->db->select("NUM_VEH");
		$this->db->from("veh_usr");
        $this->db->where("NUM_VEH",$id);
        $this->db->where("ID_USUARIO",$data["conf_userid"]);

        $query = $this->db->get();
        if($query->num_rows()>0){		
            return "true";
		}else{
            $insert = ["ID_EMPRESA" => $data["conf_usercompany"], 
                       "ID_USUARIO" => $data["conf_userid"], 
                       "NUM_VEH"    => $id, 
                       "FECHA_I"    => $data["conf_userfinit"], 
                       "FECHA_T"    => $data["conf_userend"], 
                       "ACTIVO"     => "1"];
                       //print_array($data);            
            $this->db->insert('veh_usr',$insert);
            $id_vu = $this->db->insert_id();
		    if($id_vu){ 
                return $id_vu;
            }else{
                return "false";
            }
            //return "true";
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