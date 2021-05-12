<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
        parent::__construct();         
        $this->load->model('login_model');
        $this->load->model('acount/rol_model');     
	}

    //Load login 
	public function index()
	{ 
        $custom = array("title" => "Login",
                        "form"  => "login/login");     
        $data["custom"] = $custom; 
        $this->load->view('login/main_login',$data);
    }
    
    //Start session
    public function start()
	{
        //Get data 
        $usuario  = $_POST["user"];
        $password = $_POST["password"];
 
        //Search user 
        $user = $this->login_model->check_login($usuario, $password);
  
        //If user exist, save and return true
        if($user){
            $fec  = strtotime(date("Y-m-d H:i:00",time()));
            $feci = strtotime($user["f_inicio"]);
            $fecf = strtotime($user["f_termino"]);

            if($fec > $feci && $fec < $fecf){               
                $this->load_system_data($user);
                $this->init($user);                
                //echo "true"; 
                echo "true"; 
            }else{
                echo "Error: Usuario caducado.";
            }                              
        }else{
            echo "Error: Usuario o contraseña incorrecto.";
        }
    }

    private function load_system_data($user){       
        $data["vehicle_status"] = $this->main_model->vehicle_status();
        //$data["module"]         = $this->login_model->get_modules();

        $_SESSION["catalog"]    = $data;
        
    }
    
    //Save user in session 
    private function init($user){
        $login = array("id"      => $user["id_usuario"],
                       "usuario" => $user["usuario"],
                       "nombre"  => $user["nombre"],
                       "company" => $user["id_empresa"],
                       "id_rol" => $user["id_rol"],
                       "estatus" => $user["estatus"]);
                
        $_SESSION["user"]  = $login;        
    }


    //Save user in session 
    public function init_test(){
        $user = $this->login_model->check_login("monitoreo2", "GPS2020");
        $this->load_system_data($user);        

        $login = array("id"      => $user["id_usuario"],
                       "usuario" => $user["usuario"],
                       "nombre"  => $user["nombre"],
                       "company" => $user["id_empresa"],
                       "rol_id"  => $user["id_rol"],
                       "estatus" => $user["estatus"]);        
 
        $data["rol"] = $this->rol_model->rol_access($user["id_rol"]);
        
        $modules_ = $this->login_model->get_modules();
        $modules  = array();
        $menu = array();

        if(is_array($modules)){
            foreach($modules_ as $mod){
                $modules[$mod->id_modulo] = $mod;
            }

            foreach($modules as $mod){                
                $index = $mod->modulo;
                if($mod->mprincipal != 0){                    
                     $index = $modules[$mod->mprincipal]->modulo;                    
                }

                if($mod->mprincipal != 0)
                {                      
                    if($mod->msecundario != 0){                        
                        $menu[$index][$mod->mprincipal][$mod->msecundario]["node"][$mod->id_modulo][]  =  $mod;
                    }else{
                        $menu[$index][$mod->mprincipal][$mod->id_modulo] =  $mod;
                    }                    
                }

                
                
            }
            
            
        }
        print_array($menu);
        
        $_SESSION["user"]  = $login;        
        
    }


    //Close session
    public function cerrar_session(){
        session_destroy();
        header('Location:/rv/Login');
    }
 
    //Load recovery view
    public function PasswordRecovery(){
        $custom = array("title" => "Recuperar Contraseña",
                        "form"  => "login/recovery");
        $data["custom"] = $custom; 
        $this->load->view('login/main_login',$data); 
    } 

    //Send email recovery
    public function SendRecovery(){
        //Get data        
        $email  = $_POST["email"];

        //Search user in DB and send email
        $send = $this->login_model->send_email($email);
 
        //If email send, return true
         if($send){             
             echo "true";             
         }else{
             echo "false";
         }
    }
    

}
