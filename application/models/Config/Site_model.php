<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Site_model extends CI_Model { 
      
    public function site_byid($site_id){
		$this->dbweb->select("s.id_sitio,s.nombre,s.latitud,s.longitud,s.id_contacto,s.id_tipo, t.imagen, t.descripcion, s.contacto, s.tel1, s.tel2");
		$this->dbweb->from("sitios s","left outer");
		$this->dbweb->join("tipo_sitios t","s.id_tipo = t.id_tipo","left");
		$this->dbweb->where("s.id_sitio",$site_id);
		$this->dbweb->where("s.activo",1);		
 		$query = $this->dbweb->get();         

        if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}
    }

    public function update_site($data,$id){
        $this->dbweb->where('id_sitio',$id);
        return $this->dbweb->update('sitios',$data);
    } 
	

    public function insert_site($data){        
        $this->dbweb->insert('sitios',$data);
        return $this->dbweb->insert_id(); 
    } 


    public function delete_site($data,$id){
        $this->dbweb->where('id_sitio',$id);
        return $this->dbweb->update('sitios',$data);
    }


}