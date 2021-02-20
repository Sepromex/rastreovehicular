<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companys extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/company_model');
		$this->load->model('main_model');
		$this->load->helper('acount');
		$this->headerdata["module"] = "Acount";
	}
 
	public function index()
	{  	
		$data["custom"]   = ["title"   => "Empresas",
                             "page"    => "CompanyList",
							 "prefix"  => "company",
							 "section" => "Company",
                             "module"  => $this->headerdata["module"]];
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]); 		
		$data["contactlist"] = $this->main_model->contact_list();
		$data["officelist"]  = $this->main_model->office_list();		
		$data["states"]      = $this->main_model->get_locations(); 
		$data["cities"]      = $this->main_model->get_city();	

		//Load view
		$this->load->view('layouts/admin',$data);	 
	}
	
	public function List(){
		//Json company list
		$company_list = $this->company_model->company_list();  
		if(isset($company_list) && count($company_list)>0){
				foreach($company_list  AS $row){
					$icon = company_toption($row->id_empresa);
					$data  = ["<div class='text-center'>".$row->id_empresa."</div>",
							  $row->razon_social,
							  "<div class='text-center'>".$row->rfc."</div>",
							  "<div class='text-left'>".$row->representante."</div>",
							  "<div class='text-center'>".$row->telefono."</div>",
							  "<div class='text-center'>".generalstatus($row->estatus)."</div>",
							  $icon]; 
					$jsonData['data'][] = $data;
				}   
		}
        echo json_encode($jsonData);
	} 

	public function new(){				
		$company    = ["razon_social"  => $_POST["company_name"],
					   "giro"          => $_POST["company_type"],
					   "rfc"           => $_POST["company_rfc"],
					   "representante" => $_POST["company_agent"], 	
					   "id_contacto"   => $_POST["company_contactid"], 						   
					   "email"         => $_POST["company_email"], 
					   "telefono"      => $_POST["company_phone"],
					   "direccion"     => $_POST["company_address"],
					   "colonia"       => $_POST["company_sub"],
					   "ciudad"        => $_POST["company_city"],
					   "estado"        => $_POST["company_state"],
					   "fecha_reg"     => date('Y-m-d'),                    
					   "estatus"       => "1"];

		$company_id  = $this->company_model->add_company($company);    
		if($company_id): echo "trues"; else: echo "No se inserto la Empresa"; endif;
		// // "id_direccion"  => "",  print_array($_POST);
	}

	public function view_companyconfig(){
		//Get list of contacts and offices where company = $_POST["id"]
		$data["company_contactlist"] = $this->main_model->contact_list($_POST["id"]);
		$data["company_officelist"]  = $this->main_model->office_list($_POST["id"]);		
		//Get a list of states and cities, used to select the office address
		$data["states"]              = $this->main_model->get_locations(); 
		$data["cities"]              = $this->main_model->get_city(); 
		//Get company info
		$data["company"]       	     = $this->company_model->company_byid($_POST["id"]);

		//Load view and send DATA
		$this->load->view("acount/company/company_configform",$data); 			
	} 

	public function update(){	 
		$company    = ["razon_social"  => $_POST["conf_companyname"],
					   "giro"          => $_POST["conf_companytype"],
					   "rfc"           => $_POST["conf_companyrfc"],
					   "representante" => $_POST["conf_companyagent"], 	
					   "id_contacto"   => $_POST["conf_companycontactid"],
					   "email"         => $_POST["conf_companyemail"], 
					   "telefono"      => $_POST["conf_companyphone"],                    
					   "estatus"       => $_POST["conf_companystatus"],
					   "direccion"     => $_POST["conf_companyaddress"],
					   "colonia"       => $_POST["conf_companysub"],
					   "ciudad"        => (isset($_POST["conf_companycity"]))?$_POST["conf_companycity"]:"",
					   "estado"        => (isset($_POST["conf_companystate"]))?$_POST["conf_companystate"]:""];
		$company    = $this->company_model->update_company($company,$_POST["conf_companyid"]);    
		if($company): echo "true"; else: echo "No se edito la empresa"; endif;
	}

	public function delete(){
		$contact = $this->contact_model->delete_contact($_POST["id"]);    
		if($contact): echo "true"; else: echo "No se elimino el contacto"; endif;
	} 

	public function MyCompany($id){
		$data["custom"]   = ["title"   => "Mi Empresa",
                             "page"    => "MyCompany",
							 "prefix"  => "company",
							 "section" => "Company",
                             "module"  => $this->headerdata["module"]];							 
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]); 	
		// Info company
		$data["company"]     = $this->company_model->company_byid($id);
		// Info selects
		$data["contactlist"] = $this->main_model->contact_list();
		$data["officelist"]  = $this->main_model->office_list();		
		$data["states"]      = $this->main_model->get_locations(); 
		$data["cities"]      = $this->main_model->get_city();

		$data["company_contactlist"] = $this->main_model->contact_list($id);
		$data["company_officelist"]  = $this->main_model->office_list($id);
		
		//Load view
		$this->load->view('layouts/admin',$data);
	}
} 