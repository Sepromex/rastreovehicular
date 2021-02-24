<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('acount/user_model');
		$this->load->model('acount/rol_model');
		$this->load->model('main_model');
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
		$data["include"]     = includefiles($data["custom"]["page"]);		
		$data["rollist"]     = $this->rol_model->rol_list(); 
		 
		//print_array($data["include"]);
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
		$data["user"]         = $this->user_model->user_byid($_POST["id"]);	 //user info
		$data["rollist"]      = $this->rol_model->rol_list();   // User rol list
		$data["companylist"]  = $this->main_model->company_list();  //companys
		$data["usersep"]      = $this->main_model->users_sepromex();  //sepromex users
		$data["vehiclelist"]  = $this->main_model->vehicle_list($data["user"]["id_empresa"]);  //vehicle list
		 
		//Load view
		$this->load->view("acount/users/user_configform",$data);
	}
   
	public function update(){ 
		if($_POST["conf_userpassword"] == $_POST["conf_userconfirmpassword"]){
			$user = ["usuario"   	=> $_POST["conf_user"],
					 "nombre"    	=> $_POST["conf_username"],
					 "apellido"  	=> $_POST["conf_userlastname"],
					 "email"     	=> $_POST["conf_useremail"],
					 "password"  	=> $_POST["conf_userpassword"],
					 "fecha_inicio" => $_POST["conf_userfechainicio"],
					 "fecha_fin"    => $_POST["conf_userfechafin"],
					 "estatus"   	=> $_POST["conf_userstatus"],
					 "id_sepro"   	=> $_POST["conf_usersepromex"],
					 "id_rol"       => $_POST["conf_userrol"],
					 "estatus"      => $_POST["conf_userstatus"],
					 "id_empresa"   => $_POST["conf_usercompany"]];

			$user_id = $this->user_model->update_user($user,$_POST["conf_userid"]);    
			if($user_id): echo "true"; else: echo "No se edito el usuario"; endif;
			//print_array($_POST);
		}else{ 
			echo "Las contraseñas no coinciden";
		}
	}

	public function delete(){
		$user = $this->user_model->delete_user($_POST["id"]);    
		if($user): echo "true"; else: echo "No se elimino el usuario"; endif;	
	}

	public function Profile(){
		$data["custom"]  = ["title"   => "Perfil de usuario",
							"page"    => "Profile",
							"prefix"  => "user",
							"section" => "Users",
							"module"  => $this->headerdata["module"]];   
		//Files to be included in head, body and footer
		$data["include"]  = includefiles($data["custom"]["page"]);		
		$data["rollist"]  = $this->rol_model->rol_list(); 
		$data["user"]     = $this->user_model->user_byid($_SESSION["user"]["id"]);
		
		//Load view
		$this->load->view('layouts/admin',$data);	
	}

	
 
	public function validate_name(){				
		$user = $this->user_model->validate_user($_POST["name"],"usuario");
		if($user): echo "false"; else: echo "true"; endif;			
	} 

	public function validate_email(){
		$user = $this->user_model->validate_user($_POST["email"],"email");
		if($user): echo "false"; else: echo "true"; endif;			
	} 
	  
}
