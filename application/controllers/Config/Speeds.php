<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Speeds extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('config/speeds_model');        
		$this->load->helper('config');
		$this->headerdata["module"] = "Config";
	}
  
	public function index()
	{  			
		$data["custom"]   = ["title"   => "Configuración de velocidades",
                             "header"  => "Velocidades",
                             "page"    => "Speeds",
							 "prefix"  => "speed",
							 "section" => "Vehicles",                             
                             "module"  => $this->headerdata["module"]];
        
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]);
        $data["companylist"] = $this->main_model->company_list();  //companys
        

        //Load view 
		$this->load->view('layouts/admin',$data);         
	} 
	// Vehicle status DB sepromex
    private function vehicle_status($id){
        $status_list = $_SESSION["catalog"]["vehicle_status"];
        return (isset($status_list[$id]))?$status_list[$id]:"Indefinido";
    }

    
	public function List(){
		//Json speed list
		$speed_list = $this->speeds_model->speed_list();
		if(isset($speed_list) && count($speed_list)>0){
				foreach($speed_list  AS $row){
					$icon = speed_toption($row->id_velocidad);                    
					$data  = ["<div class='text-center'>".$row->id_velocidad."</div>",
							  $row->nombre,
                              ($row->minima  != '')?$row->minima:'',
                              ($row->regular != '')?$row->regular:'',
							  ($row->normal  != '')?$row->normal:'',
							  ($row->maxima  != '')?$row->maxima:'',
							  $row->unidad,
							  $icon];
					$jsonData['data'][] = $data;
				}
		}
        echo json_encode($jsonData);
	}
 
    //Insert new vehicle
	public function new(){  
        //print_array($_POST);			
		$speed      = ["nombre"  => $_POST["speed_name"],
					   "minima"  => $_POST["speed_min"],
					   "normal"  => $_POST["speed_normal"],
					   "regular" => $_POST["speed_regular"],
                       "maxima"  => $_POST["speed_max"],
                       "unidad"  => $_POST["speed_unit"]];
		$speed_id = $this->speeds_model->add_speed($speed);
		if($speed_id): echo "true"; else: echo "Error! Intente de nuevo."; endif;
	}
	 
	public function view_speedconfig(){
		$speed   = $this->speeds_model->speed_byid($_POST["id"]);
        header("Content-type: application/json");
        echo json_encode($speed);
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
		$vehicle  = $this->speeds_model->update_vehicle($vehicle,$_POST["conf_vehid"]);		
		if($vehicle): echo "true"; else: echo "No se edito el vehiculo"; endif;
	}
 
	public function delete(){ 
		$speed = $this->speeds_model->delete_speed($_POST["id"]);    
		if($speed): echo "true"; else: echo "Error! Intente de nuevo."; endif;	
	}
 
}
