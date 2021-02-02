<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	/*public function __construct(){
		parent::__construct();					
	}*/

	public function index()
	{ 
		echo "prueba de controlador";
		$enlace =  mysqli_connect('localhost', 'root', 'Sepromex2021@_');
		if (!$enlace) {
			die('No pudo conectarse: ' . mysqli_error());
		}
		echo 'Conectado satisfactoriamente';
		mysqli_close($enlace);
    }
    
    public function otra_prueba()
	{
		echo "prueba de controlador 2";
		//phpinfo(); 
	}
}
