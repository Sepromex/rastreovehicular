<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/user_model');
		$this->load->model('acount/rol_model');
		$this->load->helper('acount');
		$this->headerdata["module"] = "Acount";
	}
 
	public function index()
	{ 
		$data["custom"]  = ["title"   => "Usuarios",
							"page"    => "Users",							
							"prefix"  => "user",
							"section" => "Users",
							"module"  => $this->headerdata["module"]];  
		//Files to be included in head, body and footer
		$data["include"]      = includefiles($data["custom"]["page"]);		
		$data["rollist"] = $this->rol_model->rol_list(); 
		
		//Load view
		$this->load->view('layouts/admin',$data);	 
	}
	
	public function List(){
		//Json user list
		$user_list = $this->user_model->user_list();  

		if(isset($user_list) && count($user_list)>0){
			  
				foreach($user_list  AS $row){
					$icon = user_toption($row->id_usuario);
					$data  = [$row->id_usuario,
							  $row->usuario,
							  $row->nombre, 
							  $row->email,                            
							  "<div class='text-center'>".user_status($row->estatus)."</div>",
							  $icon]; 
					$jsonData['data'][] = $data;
				}   
		} 
        echo json_encode($jsonData);
	}


	public function new(){
		if($_POST["password"] == $_POST["confirmpassword"]){
			$user = ["usuario"   => $_POST["user"],
					"nombre"    => $_POST["name"],
					"apellido"  => $_POST["lastname"],
					"email"     => $_POST["email"],
					"fecha_reg" => date('Y-m-d'),
					"id_rol"    => $_POST["rolid"],
					"password"  => $_POST["password"],
					"estatus"   => "1"];
			$user_id = $this->user_model->add_user($user);    
			if($user_id): echo "true"; else: echo "No se inserto el usuario"; endif;
		}else{
			echo "Las contraseñas no coinciden";
		}
	}

	 
	public function view_userconfig(){		
		/*header("Content-type: application/json");        	
		echo json_encode($user);*/

		$data["user"]    = $this->user_model->user_byid($_POST["id"]);	
		$data["rollist"] = $this->rol_model->rol_list(); 

		/*$data["company_contactlist"] = $this->main_model->contact_list($_POST["id"]);
		$data["company_officelist"]  = $this->main_model->office_list($_POST["id"]);		
		$data["company"]  = $this->company_model->company_byid($_POST["id"]);
		$data["states"]      = $this->main_model->get_locations(); 
		$data["cities"]      = $this->main_model->get_city(); */
 
		$this->load->view("acount/users/user_configform",$data); 

	}

	public function update(){
		if($_POST["conf_userpassword"] == $_POST["conf_userconfirmpassword"]){
			$user = ["usuario"   => $_POST["conf_user"],
					 "nombre"    => $_POST["conf_username"],
					 "apellido"  => $_POST["conf_userlastname"],
					 "email"     => $_POST["conf_useremail"],
					 "password"  => $_POST["conf_userpassword"],
					 "estatus"   => $_POST["conf_userstatus"]];
			$user_id = $this->user_model->update_user($user,$_POST["conf_userid"]);    
			if($user_id): echo "trues"; else: echo "No se edito el usuario"; endif;			 
		}else{
			echo "Las contraseñas no coinciden";
		}
	}

	public function delete(){
		$user = $this->user_model->delete_user($_POST["id"]);    
		if($user): echo "true"; else: echo "No se elimino el usuario"; endif;	
	}

	 
  
}
