<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainMap extends CI_Controller {	 

	public function __construct(){
		parent::__construct();
		$this->load->model('Mainmap_model');		
	}

	public function index()
	{ 	
		$custom = array("title" => "Rastreo Vehicular",
				        "page"  => "MainMap"); 

		//Archivos que se incluiran en head, body y footer 
		$data["include"]      = includefiles($custom["page"]);
		$data["custom"]       = $custom;
		$data["vehicle_list"] = $this->Mainmap_model->vehicle_list(); 

		//Cargar vista
		$this->load->view('layouts/admin',$data);
				 
    }
    
     
}