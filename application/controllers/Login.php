<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/*public function __construct(){
		parent::__construct();					
	}*/

	public function index()
	{ 
		$this->load->view('login/login');
    }
    
    public function start()
	{
        session_start();
        //print_r($_POST);
        // Test
        $_SESSION["user"]["usuario"] = $_POST["usuario"];
        $_SESSION["user"]["nombre"]  = "Michelle Mendoza";
        $_SESSION["user"]["id"]      = "1";
        
        header('Location: http://rastreovehicular/MainMap');
		//phpinfo(); 
    }
    
    public function cerrar_session(){
        session_destroy();
        header('Location: http://rastreovehicular/Login');

    }
}
