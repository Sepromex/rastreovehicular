<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/contact_model');		
		$this->load->helper('acount');
		$this->headerdata["module"] = "Acount";
	}

	public function index()
	{   	  
		$data["custom"]   = ["title"   => "Contactos",
                             "page"    => "ContactList",
                             "section" => "Contact",
							 "prefix"  => "contact",
                             "module"  => $this->headerdata["module"]];
        //Files to be included in head, body and footer
		$data["include"]    = includefiles($data["custom"]["page"]);  
        //$data["locations"]  = $this->main_model->get_locations();  
        $data["userlist"]   = $this->main_model->contactuser_list();
        $data["companys"]   = $this->main_model->company_list(); 
		//Load view
		$this->load->view('layouts/admin',$data);
	}
	 
	public function List(){
		//Json contact list
		$contact_list = $this->contact_model->contact_list();  
		if(isset($contact_list) && count($contact_list)>0){
				foreach($contact_list  AS $row){
					$icon =  contact_toption($row->id_contacto); 
					$data  = ["<div class='text-center'>".$row->id_contacto."</div>",
							  $row->nombre,
							  "<div class='text-center'>".$row->horario."</div>",
							  $row->email,
                              "<div class='text-center'>".$row->telefono."</div>",
							  "<div class='text-center'>".$row->puesto."</div>",
							  "<div class='text-center'>".generalstatus($row->estatus)."</div>",
							  $icon]; 
					$jsonData['data'][] = $data;
				}   
		} 
        echo json_encode($jsonData);
	}

    public function new(){ 		
			$var   = array("(", ")", "-", " ");
			$phone = str_replace($var, "", $_POST["contact_phone"]);
			$contact    = ["nombre"      => $_POST["contact_name"],
                           "puesto"      => $_POST["contact_job"],
                           "email"       => $_POST["contact_email"],
                           "telefono"    => $phone, 
                           "horario"     => $_POST["contact_available"],                            
                           "id_empresa"  => $_POST["contact_companyid"],                            
                           "id_usuario"  => $_POST["contact_userid"], 
                           "fecha_reg"   => date('Y-m-d'),                    
                           "estatus"     => "1"];

			$contact_id = $this->contact_model->add_contact($contact);
			if($contact_id): echo "true"; else: echo "No se inserto el contacto"; endif;			
	}

    public function view_contactconfig(){
		$contact = $this->contact_model->contact_byid($_POST["id"]);         
		header("Content-type: application/json");         	
		echo json_encode($contact);
	}  
    
    public function update(){ 
		$var   = array("(", ")", "-", " ");
		$phone = str_replace($var, "", $_POST["conf_contactphone"]);		
		$contact  = ["nombre"      => $_POST["conf_contactname"],
					 "id_usuario"  => $_POST["conf_contactuserid"],
					 "horario"     => $_POST["conf_contactailable"],
					 "email"       => $_POST["conf_contactemail"],
					 "telefono"    => $phone,
                     "puesto"      => $_POST["conf_contactjob"], 
                     "id_empresa"  => $_POST["conf_contactcompanyid"]];
		
					 //print_array($contact);
		$contact  = $this->contact_model->update_contact($contact,$_POST["conf_contactid"]);    
		if($contact): echo "true"; else: echo "No se edito el contacto"; endif;
	}

    public function delete(){
		$contact = $this->contact_model->delete_contact($_POST["id"]);    
		if($contact): echo "true"; else: echo "No se elimino el contacto"; endif;
	}
	
}
