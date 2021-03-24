<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert extends CI_Controller {

	public function __construct(){
		parent::__construct();		
		//$this->load->helper('config');
		//$this->headerdata["module"] = "Config";
	}
  
	public function index()
	{  	
		header("location: /Config/Vehicles"); 
	}  	
    
}

?>