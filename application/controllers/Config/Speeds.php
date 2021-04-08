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
					$icon = speed_toption($row->id_usuario);                    
					$data  = ["<div class='text-center'>".$row->id_usuario."</div>",
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
		$speed["speed"]   = $this->speeds_model->speed_byid($_POST["id"]);
		$speed["veh_id"]  = $_POST["id"];
		$this->load->view("config/speed/add_speed",$speed);	
        //header("Content-type: application/json");
        //echo json_encode($speed);
	}

 
	public function update(){ 		
		
		$vehicle  = $this->speeds_model->update_speed($_POST);		
		echo "true_";//if($vehicle): echo "true"; else: echo "No se edito el vehiculo"; endif; 		
	}
 
	public function delete(){ 
		$speed = $this->speeds_model->delete_speed($_POST["id"]);    
		if($speed): echo "true"; else: echo "Error! Intente de nuevo."; endif;	
	}
 
}
