<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainMap extends CI_Controller {	 

	public function __construct(){
		parent::__construct();
		$this->load->model('Mainmap_model');
		$this->headerdata["module"] = "Maps";		
	}

	public function index()
	{ 	
		$data["custom"]   = ["title"   => "Rastreo Vehicular",
				"page"    => "MainMap",
				"prefix"  => "map",
				"section" => "Map",
				"module"  => $this->headerdata["module"]];

		//Archivos que se incluiran en head, body y footer 
		$data["include"]      = includefiles($data["custom"]["page"]);		
		$data["vehicle_list"] = $this->Mainmap_model->vehicle_list(); 

		//Cargar vista
		$this->load->view('layouts/admin',$data);
				 
    }
    
     
}