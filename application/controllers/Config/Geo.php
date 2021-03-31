<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geo extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->helper('config');
		$this->load->model('config/geo_model'); 
		$this->headerdata["module"] = "MainMap";
	}

	public function geo_sideform(){
        if($_POST["type"] == 1):
		    $data["geoside"]      = $this->geo_model->geo_byid($_POST["id"]);		
		else:			
			$data["geoside"] = ["num_geo"   => 0,
								"latitud"   => $_POST["lat"],
								"longitud"  => $_POST["lon"],
								"radioMts"  => $_POST["radio"],
								"nombre"    => "",
							    "empresa"   => "",
								"username"  => ""];
		endif;
		$data["geot_form"]    = $_POST["type"];
		$this->load->view("config/geo/geoside",$data);
	} 


	public function geo_update(){
		$geo     = ["nombre" => $_POST["geoside_name"]];
		$idgeo   = $this->geo_model->update_geo($geo,$_POST["geoside_id"]);
		if($idgeo): echo "true"; else: echo "No se editó la Geocerca"; endif;		
	}	

	public function insert_site(){
		$geo     = ["nombre"          => $_POST["geoside_name"],
                    "id_usuario"      => "1029",
                    "id_empresa"      => "15",
                    "color"           => "cBlue",
                    "latitud"         => $_POST["maingeo_latitud"],
                    "longitud"        => $_POST["maingeo_longitud"],
                    "radioMts"        => $_POST["maingeo_radio"],
                    "tipo"            => $_POST["maingeo_tipo"],
                    "FECHA_CREACION"  => date('Y-m-d')];
		$idgeo   = $this->geo_model->insert_geo($geo);
        //$idgeo = 4601;
		if($idgeo>0): echo $idgeo; else: echo "false"; endif;	 
	}

	public function delete_maingeo(){		
		$geo = ["activo" => 0];
		$idgeo = $this->geo_model->delete_geo($geo,$_POST["id"]);
		if($idgeo>0): echo "true"; else: echo "false"; endif;
	}

	public function info_geo(){		
		$data  = $this->geo_model->geo_info($_POST["id"]);
		header("Content-type: application/json");        	
		echo json_encode($data);
	}

	public function info_geo_po(){
		$data  = $this->geo_model->geo_infopo($_POST["id"]);
		header("Content-type: application/json");        	
		echo json_encode($data);
	}

 
} 