<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Geo_model extends CI_Model { 
      
    public function geo_byid($geo_id){
		$this->dbweb->select("g.num_geo, g.latitud, g.longitud, g.radioMts, g.nombre , e.nombre as empresa, u.username");
		$this->dbweb->from("geo_time g","left");
		$this->dbweb->join("empresas e","g.id_empresa = e.ID_EMPRESA","left");
        $this->dbweb->join("usuarios u","g.id_usuario = u.ID_USUARIO","left");
		$this->dbweb->where("g.num_geo",$geo_id); 
 		$query = $this->dbweb->get();         

        if($query->num_rows()>0){          
			return $query->row_array();
		}else{
			return false; 			
		}

    }

    public function update_geo($data,$id){
        $this->dbweb->where('num_geo',$id);
        return $this->dbweb->update('geo_time',$data);
    } 
	

    public function insert_geo($data){        
        $this->dbweb->insert('geo_time',$data);
        return $this->dbweb->insert_id(); 
    } 


    public function delete_site($data,$id){
        $this->dbweb->where('id_sitio',$id);
        return $this->dbweb->update('sitios',$data);
    }


}