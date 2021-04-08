<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('config/vehicle_model');        
		$this->load->helper('config');
		$this->headerdata["module"] = "Config";
	}
  
	public function index()
	{  	
		$data["custom"]   = ["title"   => "Catálogo de Vehiculos",
                             "header"  => "Vehiculos",
                             "page"    => "Vehicles",
							 "prefix"  => "veh",
					 		 "section" => "Vehicles",                             
                             "module"  => $this->headerdata["module"]];
        
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]);
        $data["companylist"] = $this->main_model->company_list();  //companys
        $data["statuslist"]  = $this->listvehicle_status();
		
        //Load view 
		$this->load->view('layouts/admin',$data);         
	} 
	 
	public function List(){
		//Json vehicle list
		$vehicle_list = $this->vehicle_model->vehicle_list();

		if(isset($vehicle_list) && count($vehicle_list)>0){			  
				foreach($vehicle_list  AS $row){
					$icon = vehicle_toption($row->id_vehiculo);
                    //($row->id_grupo != '')?$row->id_grupo:'',
					$data  = ["<div class='text-center'>".$row->id_vehiculo."</div>",
							  $row->vehiculo,                              
                              ($row->placas   != '')?$row->placas:'',
                              ($row->modelo   != '')?$row->modelo:'',
							  ($row->detalle  != '')?$row->detalle:'',  
							  "<div class='text-center'>".$this->vehicle_status($row->estatus)."</div>",
							  $icon];
					$jsonData['data'][] = $data;   //generalstatus()
				}           
		}
        echo json_encode($jsonData);
	}

    // Vehicle status DB sepromex
    private function vehicle_status($id){
        $status_list = $_SESSION["catalog"]["vehicle_status"];
        return (isset($status_list[$id]))?$status_list[$id]:"Indefinido";
    }

    // List vehicle status DB sepromex
    public function listvehicle_status(){
        $status_list = $_SESSION["catalog"]["vehicle_status"];
        return $status_list;
    }
    
    // Insert new vehicle
	public function new(){  
        //print_array($_POST);
		$vehicle    = ["vehiculo"  => $_POST["newv_name"],
					   "placas"    => $_POST["newv_plate"],
					   "modelo"    => $_POST["newv_plate"],
					   "detalle"   => $_POST["newv_detail"],
                       "id_sepro"  => $_POST["newv_idsepro"],
                       "estatus"   => $_POST["newv_status"],
                       "fecha_reg" => date('Y-m-d')];
		$vehicle_id = $this->vehicle_model->add_vechicle($vehicle);
		if($vehicle_id): echo "true"; else: echo "No se inserto el Vehiculo"; endif;
	}
	 
	public function vehicle_edit(){
		$data["vehicle"]     = $this->main_model->vehicle_byid($_POST["id"]); 
		
		$this->load->view("config/vehicle/vehicle_edit",$data);
	}

	public function view_vehicleconfig(){
		$data["vehicle"]    = $this->main_model->vehicle_byid($_POST["id"]);
        $data["companylist"] = $this->main_model->company_list();  //companys
        $data["statuslist"]  = $this->listvehicle_status();
		
        $this->load->view("config/vehicle/vehicle_configform",$data);	
	}

	public function vehicle_update(){
		$vehicle  = ["modelo"     => $_POST["vehedit_model"],
                     "placas"     => $_POST["vehedit_plate"],                    
                     "detalle"    => $_POST["vehedit_detail"]];
					 //print_array($vehicle);
		$vehicle  = $this->vehicle_model->update_vehicle($vehicle,$_POST["vehedit_vehid"]);		
		if($vehicle): echo "true"; else: echo "No se edito el vehiculo"; endif;
	}
 
	public function update(){
		$vehicle  = ["vehiculo"   => $_POST["conf_vehname"],
                     "modelo"     => $_POST["conf_vehmodel"],
                     "placas"     => $_POST["conf_vehplate"],
                     "id_empresa" => $_POST["conf_vehcompany"],
                     "estatus"    => $_POST["conf_vehstatus"],
                     "id_sepro"   => $_POST["conf_vehidsepro"],
                     "detalle"    => $_POST["conf_vehdetail"],
                     "id_grupo"   => $_POST["conf_vehgroup"]];
		$vehicle  = $this->vehicle_model->update_vehicle($vehicle,$_POST["conf_vehid"]);		
		if($vehicle): echo "true"; else: echo "No se edito el vehiculo"; endif;
	}
 
	public function delete(){
		$vehicle = $this->vehicle_model->delete_vechicle($_POST["id"]);
		if($vehicle): echo "true"; else: echo "No se elimino el vehiculo"; endif;
	}
 
}
