<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Company_model extends CI_Model {
    
    // Company list
    public function company_list()
	{
        $this->db->select("id_empresa,razon_social,rfc,representante,telefono,estatus"); 
		$this->db->from("empresas");        
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
        }	            
    }    

    public function add_company($data){        
        $this->db->insert('empresas',$data);
		return $this->db->insert_id();   
    }

    // Get company by ID
    public function company_byid($id)
	{
        $this->db->select("*");
		$this->db->from("empresas");
        $this->db->where("id_empresa",$id);
        $query = $this->db->get();         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}	    
    }
    
    public function update_company($data,$id){
        $this->db->where('id_empresa',$id);
        return $this->db->update('empresas',$data);
    }  
     
    // Acessos de rol de usuario
    public function rol_access($rolid){
        $this->db->select("*");
		$this->db->from("usuario_rolacceso");
        $this->db->where("id_rol",$rolid);
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
		$this->db->from("modulos");
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

    public function set_access($checkrol,$rolid){ 
        $this->db->where('id_rol',$rolid);
        $this->db->delete('usuario_rolacceso');
        foreach($checkrol as $module_id => $submodule){
            foreach($submodule as $submodule_id => $access){
                $data = ["id_rol"       => $rolid,
                         "id_modulo"    => $module_id,
                         "id_submodulo" => $submodule_id,
                         "insertar"     => (isset($access["insert"]))?$access["insert"]:0,
                         "editar"       => (isset($access["edit"]))?$access["edit"]:0,
                         "eliminar"     => (isset($access["delete"]))?$access["delete"]:0,
                         "leer"         => (isset($access["read"]))?$access["read"]:0];
                $this->db->insert('usuario_rolacceso',$data);
                $access_id = $this->db->insert_id();
            }
        }        
        return $access_id;
    }
    
    public function delete_user($id){
        $this->db->where('id_usuario',$id);
        return $this->db->delete('usuarios');
    }
}