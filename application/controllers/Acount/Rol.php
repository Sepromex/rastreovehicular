<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/rol_model');
		$this->load->helper('acount');
		$this->headerdata["module"] = "Acount";
	}

	public function index() 
	{  	
		$data["custom"]   = ["title"   => "Roles de Usuarios",
                             "page"    => "Rol",
							 "prefix"  => "rol",
							 "section" => "Users",
                             "module"  => $this->headerdata["module"]];
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
							  "<div class='text-center'>".generalstatus($row->estatus)."</div>",
							  $icon]; 
					$jsonData['data'][] = $data; 
				}   
		} 
        echo json_encode($jsonData);
	}


	public function new(){  
			$rol    = ["rol"         => $_POST["rol_name"],
					   "descripcion" => $_POST["rol_description"],
					   "fecha_reg"   => date('Y-m-d'),
					   "estatus"     => "1"];
			$rol_id = $this->rol_model->add_rol($rol);
			if($rol_id): echo "true"; else: echo "No se inserto el rol"; endif;		 
	}
	 
	public function view_rolconfig(){
		$data["rol"]    = $this->rol_model->rol_byid($_POST["id"]);
		$data["access"]	= $this->rol_model->rol_access($_POST["id"]);
		header("Content-type: application/json");        	
		echo json_encode($data);
	}

 
	public function update(){ 
		$rol  = ["rol"        => $_POST["conf_rolname"],
				"descripcion" => $_POST["conf_roldescription"], 
				"estatus"     => $_POST["conf_rolstatus"]];				
		$rol  = $this->rol_model->update_rol($rol,$_POST["conf_rolid"]);    
		if(isset($_POST["rolcheck"])){
			$access = $this->rol_model->set_access($_POST["rolcheck"],$_POST["conf_rolid"]);
		}
		else{ $access = true; }		 
		if($rol && $access): echo "true"; else: echo "No se edito el rol de usuario"; endif;
	}
 
	public function delete(){
		$user = $this->rol_model->delete_rol($_POST["id"]);    
		if($user): echo "true"; else: echo "No se elimino el usuario"; endif;	
	}
 
}
