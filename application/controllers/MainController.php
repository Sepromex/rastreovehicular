<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {	 

	public function __construct(){
		parent::__construct();
		$this->load->model('Mainmap_model');
		$this->headerdata["module"] = "Maps";		
	}

	public function default_table()
	{ 	
        $jsonData['data'] = [];
        echo json_encode($jsonData);				 
    }
    
     
}