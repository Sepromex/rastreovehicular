<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Office extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/office_model');
 		$this->load->helper('acount');
		$this->headerdata["module"] = "Acount";
	}
 
	public function index()
	{  	
		$data["custom"]   = ["title"   => "Sucursales",
                             "page"    => "OfficeList",
							 "prefix"  => "office",
							 "section" => "Company",
                             "module"  => $this->headerdata["module"]];
        //Files to be included in head, body and footer
		$data["include"]     = includefiles($data["custom"]["page"]); 		
		$data["contactlist"] = $this->main_model->contact_list();
        $data["companys"]    = $this->main_model->company_list(); 		
		$data["states"]      = $this->main_model->get_locations(); 
		$data["cities"]      = $this->main_model->get_city(); 
		//Load view
		$this->load->view('layouts/admin',$data);
	}
	
	public function List(){
		//Json office list 
		$office_list = $this->office_model->office_list();  
		if(isset($office_list) && count($office_list)>0){
				foreach($office_list  AS $row){
					$icon = office_toption($row->id_sucursal,$row->id_empresa);					
					$data  = ["<div class='text-center'>".$row->id_sucursal."</div>",
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
		$office     = ["razon_social"  => $_POST["office_name"],
					   "id_empresa"    => $_POST["office_companyid"],
					   "rfc"           => $_POST["office_rfc"],
					   "representante" => $_POST["office_agent"], 	
					   "id_contacto"   => $_POST["office_contactid"],
					   "email"         => $_POST["office_email"], 
					   "telefono"      => $_POST["office_phone"],
					   "direccion"     => $_POST["office_address"],
					   "colonia"       => $_POST["office_sub"],
					   "ciudad"        => $_POST["office_city"],
					   "estado"        => $_POST["office_state"],
					   "fecha_reg"     => date('Y-m-d'),
					   "estatus"       => "1"];

		$office_id  = $this->office_model->add_office($office);    
		if($office_id): echo "true"; else: echo "No se inserto la Empresa"; endif;
        //print_array($_POST);
	}

	public function view_officeconfig(){ 
		$data["office_contactlist"]  = $this->main_model->contact_list($_POST["id"],"office");
		$data["office"]              = $this->office_model->office_byid($_POST["id"]);
		$data["companys"]    = $this->main_model->company_list(); 
		$data["states"]      = $this->main_model->get_locations(); 
		$data["cities"]      = $this->main_model->get_city(); 
		
		$this->load->view("acount/office/office_configform",$data);
	} 
 
	public function update(){
		$office     = ["razon_social"  => $_POST["conf_officename"],
					   "id_empresa"    => $_POST["conf_officecompanyid"],
					   "rfc"           => $_POST["conf_officerfc"],
					   "representante" => $_POST["conf_officeagent"], 	
					   "id_contacto"   => $_POST["conf_officecontactid"],
					   "email"         => $_POST["conf_officeemail"], 
					   "telefono"      => $_POST["conf_officephone"],                    
					   "estatus"       => $_POST["conf_officestatus"],
					   "direccion"     => $_POST["conf_officeaddress"],
					   "colonia"       => $_POST["conf_officesub"],
					   "ciudad"        => (isset($_POST["conf_officecity"]))?$_POST["conf_officecity"]:"",
					   "estado"        => (isset($_POST["conf_officestate"]))?$_POST["conf_officestate"]:""];
		$office     = $this->office_model->update_office($office,$_POST["conf_officeid"]);    
		if($office): echo "true"; else: echo "No se edito la sucursal"; endif;		
	}

	public function delete(){
		$office = $this->office_model->delete_office($_POST["id"]);    
		if($office): echo "true"; else: echo "No se elimino la sucrusal"; endif;
	} 	
} 