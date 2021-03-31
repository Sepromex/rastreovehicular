<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Mainmap_model extends CI_Model {

	

	public function get_positiones($idveh){		 
		$this->dbweb->select("v.tipoveh, (p.lat/3600/16) as lat,((p.long & 8388607)/3600/12*-1) as lon");
		$this->dbweb->from("posiciones p","left");
		$this->dbweb->join("vehiculos v","p.num_veh = v.num_veh","left");
		$this->dbweb->where("p.num_veh",$idveh);	
		$this->dbweb->order_by("p.ID_POS","desc");
		$this->dbweb->limit(10);
		$query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
		} 
	}

	public function site_type($company_id){
		$this->dbweb->select("id_tipo,imagen,descripcion");
		$this->dbweb->from("tipo_sitios");		 
		$this->dbweb->where("id_empresa",$company_id);
		$this->dbweb->or_where("id_empresa",15);
		$this->dbweb->order_by("descripcion","ASC");		
		$query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
		}
	}
	
	public function load_sitestype($company_id){
		$this->dbweb->select("distinct(s.id_tipo), t.imagen, t.descripcion");
		$this->dbweb->from("sitios s");
		$this->dbweb->join("tipo_sitios t","s.id_tipo = t.id_tipo");
		$this->dbweb->where("s.nombre !=","");
		$this->dbweb->where("s.id_empresa",$company_id);
		$this->dbweb->or_where("s.id_empresa",15);
		$this->dbweb->order_by("t.descripcion","ASC");	
		$query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
		}
	}

	public function load_sites($company_id){
		$this->dbweb->select("s.id_sitio,s.nombre,s.latitud,s.longitud,s.id_tipo, t.imagen, t.descripcion");
		$this->dbweb->from(" sitios s","left outer");
		$this->dbweb->join("tipo_sitios t","s.id_tipo = t.id_tipo","left");
		$this->dbweb->where("s.id_empresa",$company_id);
		$this->dbweb->where("s.activo",1);		
		$this->dbweb->order_by("s.nombre","ASC");		
		$query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{			
			return false; 			
		}
	}

	
	function show_sites($id){	 
		$this->dbweb->select("s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.imagen,t.descripcion");
		$this->dbweb->from("sitios s","left outer");
		$this->dbweb->join("tipo_sitios t", "s.id_tipo = t.id_tipo");
		$this->dbweb->where("s.id_sitio",$id);	
        $query = $this->dbweb->get(); 
		if($query->num_rows()>0){ 
			return $query->row_array();
		}else{			
			return false; 
		}

		/*
		id='".$rowSit[0]."' 
		value='".$rowSit[0]."'
		ver_sitio($rowSit[0])
					veh_seleccion(".$rowSit[2].",".$rowSit[3].")
						strtolower(addslashes($rowSit[1]))."
		*/

	}

	public function load_geo($company_id,$user_id){
		$this->dbweb->select("G.num_geo,G.nombre,G.tipo,G.latitud,G.longitud,g.radioMts,g.tipo, G.id_usuario, G.id_empresa, T.descripcion");
		$this->dbweb->from("geo_time AS G");
		$this->dbweb->join("tipo_geocerca AS T","G.tipo=T.tipo");
		$this->dbweb->where("G.id_empresa",$company_id);
		$this->dbweb->where("G.activo",1);
		// $this->dbweb->where("G.id_usuario",$user_id);
		$this->dbweb->where("G.nombre !=","");
		$this->dbweb->order_by("G.nombre","ASC");
		$query = $this->dbweb->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

    public function company_messages($company){
		$this->dbweb->select("id_empresa");
		$this->dbweb->from("c_mensajes");
		$this->dbweb->where("id_empresa",$company);	
        $query = $this->dbweb->get(); 
		if($query->num_rows()>0){ 
			return $query->row_array();
		}else{
			return false; 
		}
	}
	
 
	public function vehicle_position($id_pos = 0,$idveh = 0, $company = 0){
		$this->dbweb->select("distinct(v.id_veh),(u.lat/3600/16) as lat,((u.long & 8388607)/3600/12*-1) as lon,u.mensaje,u.velocidad,u.fecha,
		v.tipoveh,u.t_mensaje,v.id_empresa,u.entradas,u.odometro,u.entradas_a,u.id_tipo,v.id_sistema,
		pm.descripcion,cm.mensaje,p.obsoleto,p.satelites,p.hdop");
		$this->dbweb->from("vehiculos v","left outer");
		$this->dbweb->join("ultimapos u", "v.num_veh = u.num_veh","left outer");
		$this->dbweb->join("posiciones p", "v.num_veh = p.num_veh and p.fecha = u.fecha","left outer"); 
		$this->dbweb->join("postmens pm", "pm.t_mensaje = u.t_mensaje","left outer");
		$this->dbweb->join("c_mensajes cm", "cm.id_mensaje = u.entradas and cm.id_empresa = $company","left outer");		
		$this->dbweb->join("estveh s", "v.estatus = s.estatus");
		$this->dbweb->where("v.num_veh",$idveh);
		$this->dbweb->where("s.publicapos","1");
		if($id_pos != 0){ $this->dbweb->where("p.id_pos>",$id_pos); }
		$query = $this->dbweb->get(); 
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}

	public function get_gtm($veh){
		$this->dbweb->select("gmt");
		$this->dbweb->from("veh_gmt");
		$this->dbweb->where("num_veh",$veh);
        $query = $this->dbweb->get();
		if($query->num_rows()>0){ 
			return $query->row_array();
		}else{
			$data = ["num_veh" => $veh, "gmt" => "-5"];
			$this->db->insert('veh_gmt',$data);			
			return "0"; 
		}
	}

	public function id_pos_date($veh){
		$yesterday = strtotime(date("Y-m-d")."-1 day");
		$this->dbweb->select("id");
		$this->dbweb->from("id_pos");
		$this->dbweb->where("fechahora>",date("Y-m-d H:i:s",$yesterday));	
		$this->dbweb->order_by("id");
		$this->dbweb->limit(1); 
        $query = $this->dbweb->get();
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}
	} 


	public function accesory_title($data){
		//Search message by code 2 - 9  
		$active     = $data["active"];
		$datarow    = $data["datarow"];
		$companyid  = $data["companyid"];
		$accessoryname = "";
		
		
		for($a=0;$a<count($active);$a++){
			$start   = $active[$a]*2;
			$end     = $start+2; 

			for($i=$start;$i<$end;$i++){
				$menssage_id   = configentrieby_vehicle($datarow,$i); 
				$message       = isset($_SESSION["messages"][$companyid][$menssage_id])?$_SESSION["messages"][$companyid][$menssage_id]:"";
				
				if($message == ""){ 
					$message   = isset($_SESSION["messages"][15][$menssage_id])?$_SESSION["messages"][15][$menssage_id]:"";
				} 
				
				if($i==($end-1) && ($menssage_id!=252 && $menssage_id!=0)){
					$accessoryname.=$message;
				}else{
					if($menssage_id!=0 && $i==$start){
						$accessoryname.=$message;
					}
				} 
				if($i==$start && $menssage_id!=252 && $menssage_id!=0){
					$accessoryname.="/";
				}
			}
			$accessoryname.=" "; 
		}
		return ["accessory" => 1, "accessoryname" => $accessoryname, "messaje_id" => $menssage_id];
	}

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
       
	public function mainvehiclelist($id_user = "1029"){
		$this->dbweb->select(" v.ID_VEH, v.NUM_VEH, v.id_empresa ");
		$this->dbweb->from("veh_usr vu","left");
		$this->dbweb->join("vehiculos v", "vu.NUM_VEH = v.NUM_VEH","left");
		$this->dbweb->join("estveh ev", "v.estatus = ev.estatus","left"); 
		$this->dbweb->where("vu.ID_USUARIO",$id_user);
		$this->dbweb->where("vu.activo","1");
		$this->dbweb->where("ev.publicapos","1");	
		$this->dbweb->group_by("v.num_veh");
		$this->dbweb->order_by("v.ID_VEH","asc"); 
        $query = $this->dbweb->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function main_vehiclelist($id_user = "1029"){
		$this->dbweb->select(" v.ID_VEH, v.NUM_VEH,v.estatus,ev.publicapos,ev.descripcion,p.velocidad,v.id_sistema,
		p.ent1_st,p.ent2_st,p.ent3_st,p.ent4_st,p.ignition_st,v.id_empresa,p.entradas, sis.tipo_equipo");
		$this->dbweb->from("veh_usr vu","left");
		$this->dbweb->join("vehiculos v", "vu.NUM_VEH = v.NUM_VEH","left");
		$this->dbweb->join("estveh ev", "v.estatus = ev.estatus","left"); 
		$this->dbweb->join("ultimapos p", "vu.num_veh=p.num_veh AND v.num_veh=p.num_veh","left");  
		$this->dbweb->join("sistemas sis", "sis.id_sistema = v.id_sistema","left");		
		$this->dbweb->where("vu.ID_USUARIO",$id_user);
		$this->dbweb->where("ev.publicapos","1");
		$this->dbweb->where("vu.activo","1");		
		$this->dbweb->group_by("v.num_veh");
		$this->dbweb->order_by("v.ID_VEH","asc"); 
        $query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->result();
		}else{
			return false; 			
		} 
	}

	// Before:: check_conection
	public function last_post($num_veh){
		$this->dbweb->select("ent1_st, ent2_st, ignition_st");
		$this->dbweb->from("ultimapos");
		$this->dbweb->where("num_veh",$num_veh);	
        $query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			return $query->row_array();
		}else{			
			return false; 			
		}
	} 
 

	public function entries_config($vehid){		
		$this->dbweb->select("id_cfg, num_veh, E1_Act, E1_Des, E2_Act, E2_Des, E3_Act, E3_Des, E4_Act, E4_Des");
		$this->dbweb->from("cfg_entxveh");
		$this->dbweb->where("num_veh",$vehid);
		$this->dbweb->where("estatus","1");
        $query = $this->dbweb->get();
		if($query->num_rows()>0){          
			return $query->result();
		}else{
			return false;
		}
	}


	public function entries_configbycompany($companyid){		
		$this->dbweb->select("*");
		$this->dbweb->from("cfg_ent");
		$this->dbweb->where("id_empresa",$companyid);
		$this->dbweb->where("estatus","1");
        $query = $this->dbweb->get();
		if($query->num_rows()>0){          
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_systemtype($systemid){		
		$this->dbweb->select("tipo_equipo");
		$this->dbweb->from("sistemas");
		$this->dbweb->where("id_sistema",$systemid);
        $query = $this->dbweb->get();
		if($query->num_rows()>0){          
			return $query->row_array();
		}else{
			return false;
		}
	}
 

	public function entryconfigby_devicetype($type){
		$this->dbweb->select("*");
		$this->dbweb->from("cfg_entxtequipo");
		$this->dbweb->where("tipo_equipo",$type);
         $query = $this->dbweb->get();
		if($query->num_rows()>0){          
			return $query->result();
		}else{
			return false;
		}
	}	
 
	
	public function get_message($data){
		$this->dbweb->select("mensaje");
		$this->dbweb->from("c_mensajes");
		$this->dbweb->where("id_empresa",$data["company_id"]);
		$this->dbweb->where("id_mensaje",$data["message_id"]);
        $query = $this->dbweb->get();
		if($query->num_rows()>0){          
			return $query->row_array();
		}else{
			return false;
		}
	}	


	public function load_messages(){
		$this->dbweb->select("id_empresa, mensaje, id_mensaje");
		$this->dbweb->from("c_mensajes"); 
        $query = $this->dbweb->get();
		$messages = [];
		if($query->num_rows()>0){          
			foreach($query->result() as $message){
				$messages[$message->id_empresa][$message->id_mensaje] = $message->mensaje;
			}
			$_SESSION["messages"] = $messages;
		}else{
			return false;
		}
	}	

	public function load_speeds($data){
		$this->dbweb->select("*");
		$this->dbweb->from("config_vel");
		$this->dbweb->where("id_usuario",$data["user_id"]);			
        $query = $this->dbweb->get();         
		if($query->num_rows()>0){            
			foreach($query->result() as $speed){
				$speeds[$speed->num_veh]   = ["vel1" => $speed->vel1, 
											  "vel2" => $speed->vel2, 
											  "vel3" => $speed->vel3, 
											  "vel4" => $speed->vel4];
			}
			$_SESSION["speeds"] = $speeds;
		}else{			
			return false; 		
		}
	}

}