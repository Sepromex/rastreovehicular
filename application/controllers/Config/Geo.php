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
        endif;
		$data["geot_form"]   = $_POST["type"];
        $data["geot_user"]   = 1029;
		$this->load->view("config/geo/geoside",$data);
	} 


	public function geo_update(){
		$geo     = ["nombre" => $_POST["geoside_name"]];
		$idgeo   = $this->geo_model->update_geo($geo,$_POST["geoside_id"]);
		if($idgeo): echo "true"; else: echo "No se editó la Geocerca"; endif;		
	}	

	public function insert_site(){
		/*$geo     = ["nombre"          => $_POST["nombre"],
                    "id_usuario"      => "1029",
                    "id_empresa"      => "15",
                    "color"           => "cBlue",
                    "latitud"         => $_POST["latitud"],
                    "longitud"        => $_POST["longitud"],
                    "radioMts"        => $_POST["radio"],
                    "tipo"            => $_POST["tipo"],
                    "FECHA_CREACION"  => date('Y-m-d')];
		$idgeo   = $this->geo_model->insert_geo($geo);*/
        $idgeo = 4601;
		if($idgeo>0): echo $idgeo; else: echo "false"; endif;	 
	}

	public function delete_mainsite(){		
		$site = ["activo" => 0];
		$idsite = $this->site_model->delete_site($site,$_POST["id"]);
		if($idsite>0): echo "true"; else: echo "false"; endif;
	}
 
} 