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


    public function delete_geo($data,$id){
        $this->dbweb->where('num_geo',$id);
        return $this->dbweb->update('geo_time',$data);
    }

    public function geo_info($id){
        $this->dbweb->select("g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre");
		$this->dbweb->from("geo_time g","left outer");
		$this->dbweb->join("geo_puntos p","g.num_geo = p.id_geo","left outer");        
		$this->dbweb->where("g.num_geo",$id); 
        $this->dbweb->where("g.activo",1); 
        $this->dbweb->order_by("p.orden","asc"); 
 		$query = $this->dbweb->get();
        if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}

    }

    public function geo_infopo($id){
        $this->dbweb->select("latitud, longitud");
		$this->dbweb->from("geo_puntos");		
		$this->dbweb->where("id_geo",$id); 
        $this->dbweb->where("activo",1); 
        $this->dbweb->order_by("orden","asc"); 
        $this->dbweb->limit(1); 
 		$query = $this->dbweb->get();
        if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}

    }


}