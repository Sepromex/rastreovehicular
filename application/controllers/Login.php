<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
        parent::__construct();         
        $this->load->model('login_model');
	}

	public function index()
	{    
        $custom = array("title" => "Login",
                        "form"  => "login/login");     
        $data["custom"] = $custom; 
        $this->load->view('login/main_login',$data);
    }
    
    //Iniciar session
    public function start()
	{
        //Recibir variables por POST
        $usuario  = $_POST["user"];
        $password = $_POST["password"];

        //Buscar usuario en la DB
        $user = $this->login_model->check_login($usuario, $password);

        //Si el usuario existe, guardarlo en sessión y redireccionar
        if($user){            
            $this->init($user);
            echo "true";             
        }else{
            echo "false";
        }
    }
    
    //Guardar el usuario en session
    private function init($user){
        $login = array("id"      => $user["id_usuario"],
                       "usuario" => $user["usuario"],
                       "nombre"  => $user["nombre"],
                       "estatus" => $user["estatus"]);
        $_SESSION["user"]  = $login;
    }
    //Cerrar session
    public function cerrar_session(){
        session_destroy();
        header('Location:http://rastreovehicular/Login');
    }

    //Cargar vista de recuperar contraseña
    public function PasswordRecovery(){        
        $custom = array("title" => "Recuperar Contraseña",
                        "form"  => "login/recovery");
        $data["custom"] = $custom; 
        $this->load->view('login/main_login',$data); 
    }

    //Enviar correo de recupercion
    public function SendRecovery(){
        //Recibir variables por POST
        $email  = $_POST["email"];

        //Buscar usuario en la DB y enviar email
        $send = $this->login_model->send_email($email);
 
        //Si se envío el correo regresa true
         if($send){             
             echo "true";             
         }else{
             echo "false";
         }
    }

}
