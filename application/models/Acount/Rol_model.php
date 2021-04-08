<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Rol_model extends CI_Model {
    
    // Rol list
    public function rol_list()
	{
        $this->db->select("*");
		$this->db->from("usuario_roles");  
        $this->db->where("estatus",1);      
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    } 

    public function add_rol($data){        
        $this->db->insert('usuario_roles',$data);
		return $this->db->insert_id();   
    }

    // Get user by ID
    public function rol_byid($id)
	{
        $this->db->select("*");
		$this->db->from("usuario_roles");
        $this->db->where("id_rol",$id);
        $query = $this->db->get();
         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    } 

    //acessos de rol de usuario
    public function rol_access($rolid){
        $this->db->select("*");
		$this->db->from("usuario_rolacceso");
        $this->db->where("id_rol",$rolid);
        $this->db->where("activo",1);
        $this->db->order_by("id_modulo, id_submodulo","asc");
        $query = $this->db->get();
 
		if($query->num_rows()>0){ 
			return $query->result();
		}else{
			return false; 
		}
    }

    public function get_modules()
	{
        $this->db->select("*");
		$this->db->from("modulos_rv");
        $this->db->where("estatus","1");
        $this->db->order_by("grado, mprincipal","asc");
        $query = $this->db->get();
         
		if($query->num_rows()>0){            
            $modules = [];
			foreach($query->result() as $module){
                if($module->grado == "1"):
                    $modules[$module->id_modulo]["name"] = $module->modulo;
                elseif($module->grado == "2"): 
                    $modules[$module->mprincipal]["modules"][$module->id_modulo] = $module->modulo;
                endif;
            }
            return $modules;
		}else{			
			return false; 			
        }
    }  

    public function update_rol($data,$id){
        $this->db->where('id_rol',$id);
        return $this->db->update('usuario_roles',$data);
    }
	

    public function set_access($checkrol,$rolid){ 
        $delete = ["activo" => 0];
        $this->db->where('id_rol',$rolid);
        $this->db->update('usuario_rolacceso',$delete);

        foreach($checkrol as $module_id => $submodule){
            foreach($submodule as $submodule_id => $access){
                $data    = ["id_rol"       => $rolid,
                            "id_modulo"    => $module_id,
                            "id_submodulo" => $submodule_id,
                            "insertar"     => (isset($access["insert"]))?$access["insert"]:0,
                            "editar"       => (isset($access["edit"]))?$access["edit"]:0,
                            "eliminar"     => (isset($access["delete"]))?$access["delete"]:0,
                            "leer"         => (isset($access["read"]))?$access["read"]:0,
                            "activo"       => "1"];
                
                $this->db->select("id_acceso");
                $this->db->from("usuario_rolacceso");
                $this->db->where("id_rol",$rolid);
                $this->db->where("id_modulo",$module_id);
                $this->db->where("id_submodulo",$submodule_id);
                $query = $this->db->get();
                // If exist configuration
                if($query->num_rows()>0){                    
                    $rolaccess = $query->row_array();
                    $update    = ["activo" => 1]; 
                    $this->db->where('id_acceso',$rolaccess["id_acceso"]);
                    $this->db->update('usuario_rolacceso',$data);
                }else{			                    
                    $this->db->insert('usuario_rolacceso',$data);
                    $access_id = $this->db->insert_id();
                }

            }
        }
                 
        return "true";
    }
    
    public function delete_rol($id){
        $delete = ["estatus" => 0];
        $this->db->where('id_rol',$id);
        return $this->db->update('usuario_roles',$delete);
    }
}
 