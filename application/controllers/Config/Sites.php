<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->helper('config');
		$this->load->model('config/site_model');
		$this->load->model('acount/contact_model');	
		$this->load->model('Mainmap_model');
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

	public function new_site(){		
		$data["site_type"]    = $this->Mainmap_model->site_type(15);
		$data["sitet_form"]   = "1";
		$data["lat"]          = $_POST["lat"];
		$data["lon"]          = $_POST["lon"];
		$this->load->view("config/sites/site_edit",$data);
	}  
	
	public function site_edit(){
		$data["site"]         = $this->site_model->site_byid($_POST["id"]);
		$data["site_type"]    = $this->Mainmap_model->site_type(15);
		$data["sitet_form"]   = "0";
		$data["lat"]          = $data["site"]["latitud"];
		$data["lon"]          = $data["site"]["longitud"];
//		$data["contact_list"] = $this->contact_model->contact_list(15);

		$this->load->view("config/sites/site_edit",$data);
	} 

 
	public function site_update(){
		$site     = ["nombre"   => $_POST["edit_sitename"],
                     "id_tipo"  => $_POST["edit_sitetype"],
                     "contacto" => $_POST["edit_sitecontact"],
					 "tel1"     => $_POST["edit_sitephone"],
					 "tel2"     => $_POST["edit_sitephone2"]];
					 
		$site    = $this->site_model->update_site($site,$_POST["edit_siteid"]);
		if($site): echo "true"; else: echo "No se editó el sitio de Interés"; endif;		
	}	

	public function insert_site(){
		$site     = ["nombre"     => $_POST["edit_sitename"],
					 "latitud"    => $_POST["lat"],
					 "longitud"   => $_POST["lon"],
                     "id_tipo"    => $_POST["edit_sitetype"],
                     "contacto"   => $_POST["edit_sitecontact"],
					 "tel1"       => $_POST["edit_sitephone"],
					 "tel2"       => $_POST["edit_sitephone2"],
					 "activo"     => "1",
					 "id_empresa" => 15];
					 
		$idsite  = $this->site_model->insert_site($site);
 		//$idsite = 12007;					
		$data["idsite"]   = $idsite;	

		if($idsite>0): echo $idsite; else: echo "false"; endif;	 
	}

	public function delete_mainsite(){		
		$site = ["activo" => 0];
		$idsite = $this->site_model->delete_site($site,$_POST["id"]);
		if($idsite>0): echo "true"; else: echo "false"; endif;
	}
 
} 