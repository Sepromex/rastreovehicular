<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainMap extends CI_Controller {

	/*public function __construct(){
		parent::__construct();					
	}*/

	public function index()
	{ 
        session_start(); 
		$_SESSION["user"]["name"] = "michelle";

		$data["page"] = "mainmap";
		$data["include"]["head"] = array("/dist/vendors/quill/quill.snow.css");
		$data["include"]["body"] = array("map/map");
		$data["include"]["foot"] = array("/dist/vendors/quill/quill.min.js","/dist/js/mail.script.js");
		$data["perfil"]["user_name"] = $_SESSION["user"]["name"];
		
		//$_SESSION["user"]["id"]   = $id = 0;

		$this->db->select("ID_VEH, NUM_VEH, estatus, id_sistema, id_empresa");
		$this->db->from("vehiculos");
		//$this->db->where("id_empresa","248");		
		$this->db->limit(30);
		$consulta = $this->db->get();
		$data["vehiculos"]       = $consulta->result();		
		

		$this->load->view('layouts/admin',$data);		 
    }
    
     
}