<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rules extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->model('config/rule_model');        
		//$this->load->helper('config');
		//$this->headerdata["module"] = "Config";
	}
  
	public function index()
	{  	
		header("location: /Config/Vehicles");
		/*$data["custom"]   = ["title"   => "Reglas de configuración",
                             "header"  => "Reglas de configuración",
                             "page"    => "Rules",
							 "prefix"  => "rule",
							 "section" => "Vehicles",                             
                             "module"  => $this->headerdata["module"]];
        
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]);
        $data["companylist"] = $this->main_model->company_list();  //companys
        $data["statuslist"]  = $this->listvehicle_status();
		
        //Load view 
		$this->load->view('layouts/admin',$data);         */
	
	}  
	

}