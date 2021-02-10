<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companys extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/rol_model');
		$this->load->helper('user');
		$this->headerdata["module"] = "Acount";
	}

	public function index()
	{  	
		$data["custom"]   = ["title"  => "Roles de Usuarios",
                             "page"   => "Company",
                             "module" => $this->headerdata["module"]];

        //Files to be included in head, body and footer
		$data["include"]  = includefiles($data["custom"]["page"]);
		$data["modules"]  = $this->rol_model->get_modules();  

		//Load view
		$this->load->view('layouts/admin',$data);	
		 
	}
	
	public function List(){
		//Json rol list
		$rol_list = $this->rol_model->rol_list();  

		if(isset($rol_list) && count($rol_list)>0){
			  
				foreach($rol_list  AS $row){
					$icon = rol_toption($row->id_rol);                    
					$data  = ["<div class='text-center'>".$row->id_rol."</div>",
							  $row->rol,
							  ($row->descripcion!='')?$row->descripcion:'',  
							  "<div class='text-center'>".user_status($row->estatus)."</div>",
							  $icon]; 
					$jsonData['data'][] = $data;
				}   
		} 
        echo json_encode($jsonData);
	} 
}
