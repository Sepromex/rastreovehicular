<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class test extends CI_Controller {

	public function __construct(){
        parent::__construct();         
           
	}
 
    public function recorridox (){
        $this->db->select("F_INICIO, origen, NUM_VEH, fecha, LAT, LONG, T_MENSAJE, ENTRADAS, SALIDAS, ENTRADAS_A, VELOCIDAD, DIRECCION, OBSOLETO, ODOMETRO");
		$this->db->from("posiciones");
        $this->db->where("NUM_VEH", '10005390');
        $this->db->where("FECHA >=", '2021-04-21 13:00:00');
        $this->db->where("FECHA <=", '2021-04-22 00:00:00');
        //$this->db->where("FECHA <=", '2021-04-23 16:48:00');
        $query = $this->db->get();
		if($query->num_rows()>0){         
			
            $result = $query->result();
            foreach($result as $r){                
                $nuevafecha = strtotime ( '-48 day' , strtotime ( $r->fecha ) ) ;
                $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
                $horam      = date('H:i:s', strtotime($r->fecha) );
                //echo $r->fecha." -- ".$nuevafecha." -- ".$horam."</br>";
                $array = ["F_INICIO"   => $nuevafecha." ".$horam,
                          "origen"     => $r->origen, 
                          "NUM_VEH"    => '287376563', 
                          "fecha"      => $nuevafecha." ".$horam, 
                          "LAT"        => $r->LAT, 
                          "LONG"       => $r->LONG, 
                          "T_MENSAJE"  => '', 
                          "ENTRADAS"   => $r->ENTRADAS, 
                          "SALIDAS"    => $r->SALIDAS, 
                          "ENTRADAS_A" => $r->ENTRADAS_A, 
                          "VELOCIDAD"  => $r->VELOCIDAD, 
                          "DIRECCION"  => $r->DIRECCION, 
                          "OBSOLETO"   => $r->OBSOLETO,
                          "ODOMETRO"   => $r->ODOMETRO];
                          //$array = ["VELOCIDAD"  => $r->VELOCIDAD];
                          print_array($array);
                $this->db->insert('posiciones',$array);
                $pos = $this->db->insert_id();
                //$pos = 77;
                $ids[] = $pos;
                //break;
            }

            $_SESSION["ids_pos"]["0"] = $ids;
            print_array($_SESSION["ids_pos"]["0"]);

		}else{
			return false;
        }	
    }


    public function recorrido (){
        $this->db->select("F_INICIO, origen, NUM_VEH, fecha, LAT, LONG, T_MENSAJE, ENTRADAS, SALIDAS, ENTRADAS_A, VELOCIDAD, DIRECCION, OBSOLETO, ODOMETRO");
		$this->db->from("posiciones");
        $this->db->where("NUM_VEH", '10005390');
        $this->db->where("FECHA >=", '2021-04-22 00:22:00');
        $this->db->where("FECHA <=", '2021-04-22 15:00:00');
        //$this->db->where("FECHA <=", '2021-04-23 16:48:00');
        $query = $this->db->get();
		if($query->num_rows()>0){         
			
            $result = $query->result();
            foreach($result as $r){                
                $fecha = $r->fecha; 
                
                $nuevafecha = strtotime ( '-48 day' , strtotime ($fecha) ) ;
                $nuevafecha = date ( 'Y-m-j' , $nuevafecha ); 

                $nuevahora = strtotime ( '-21 minute' , strtotime ( $fecha ));               
                $nuevahora = date( 'H:i:s' , $nuevahora );                  
                //$_SESSION["ids_pos"]["hora"][] = $nuevafecha." ".$nuevahora;

                $array = ["F_INICIO"   => $nuevafecha." ".$nuevahora,
                          "origen"     => $r->origen, 
                          "NUM_VEH"    => '287376563', 
                          "fecha"      => $nuevafecha." ".$nuevahora,
                          "LAT"        => $r->LAT, 
                          "LONG"       => $r->LONG, 
                          "T_MENSAJE"  => '', 
                          "ENTRADAS"   => $r->ENTRADAS, 
                          "SALIDAS"    => $r->SALIDAS, 
                          "ENTRADAS_A" => $r->ENTRADAS_A, 
                          "VELOCIDAD"  => $r->VELOCIDAD, 
                          "DIRECCION"  => $r->DIRECCION, 
                          "OBSOLETO"   => $r->OBSOLETO,
                          "ODOMETRO"   => $r->ODOMETRO];
                          //$array = ["VELOCIDAD"  => $r->VELOCIDAD];
                          print_array($array);
                $this->db->insert('posiciones',$array);
                $pos = $this->db->insert_id();
                //$pos = 77;
                //$ids[] = $pos;
                //break;
            }

            //$_SESSION["ids_pos"]["0"] = $ids;
            //print_array($_SESSION["ids_pos"]["0"]);

		}else{
			return false;
        }	
    }


    public function recorrido2 (){
        $ids = array();
        $_SESSION["ids_pos"]["3"] = array();
        $this->db->select("F_INICIO, origen, NUM_VEH, fecha, LAT, LONG, T_MENSAJE, ENTRADAS, SALIDAS, ENTRADAS_A, VELOCIDAD, DIRECCION, OBSOLETO, ODOMETRO");
		$this->db->from("posiciones");
        $this->db->where("NUM_VEH", '10005390');
        $this->db->where("FECHA >=", '2021-04-23 13:25:00');
        $this->db->where("FECHA <=", '2021-04-23 16:48:05');
        $query = $this->db->get();
		if($query->num_rows()>0){ 
            $result = $query->result();
            $x = 0;
            foreach($result as $r){           
                $fecha = $r->fecha; 
                $nuevafecha = strtotime ( '-49 day' , strtotime ($fecha) ) ;
                $nuevafecha = date ( 'Y-m-j' , $nuevafecha ); 
                $nuevahora = strtotime ( '+1 hour +15 minute' , strtotime ( $fecha ));               
                $nuevahora = date( 'H:i:s' , $nuevahora );                  
                $_SESSION["ids_pos"]["3"][$x]["f"] = $nuevafecha." ".$nuevahora;                
                $_SESSION["ids_pos"]["3"][$x]["v"] = $r->VELOCIDAD;
                $x++;
            }
		}

        print_array($_SESSION["ids_pos"]["3"]);
        
    }


    public function recorrido3(){
        $this->db->select("F_INICIO, origen, NUM_VEH, fecha, LAT, LONG, T_MENSAJE, ENTRADAS, SALIDAS, ENTRADAS_A, VELOCIDAD, DIRECCION, OBSOLETO, ODOMETRO");
		$this->db->from("posiciones");
        $this->db->where("NUM_VEH", '10005390');
        $this->db->where("FECHA >=", '2021-04-23 13:25:00');
        $this->db->where("FECHA <=", '2021-04-23 16:48:05');
        $this->db->order_by("FECHA", 'DESC');
        //$this->db->where("FECHA <=", '2021-04-23 16:48:00');
        $query = $this->db->get();
		if($query->num_rows()>0){         
			
            $result = $query->result();
            $x = 0;
            foreach($result as $r){  
                $array = ["F_INICIO"   => $_SESSION["ids_pos"]["3"][$x]["f"],
                          "origen"     => $r->origen, 
                          "NUM_VEH"    => '287376563', 
                          "fecha"      => $_SESSION["ids_pos"]["3"][$x]["f"], 
                          "LAT"        => $r->LAT, 
                          "LONG"       => $r->LONG, 
                          "T_MENSAJE"  => '', 
                          "ENTRADAS"   => $r->ENTRADAS, 
                          "SALIDAS"    => $r->SALIDAS, 
                          "ENTRADAS_A" => $r->ENTRADAS_A, 
                          "VELOCIDAD"  => $r->VELOCIDAD,  
                          "DIRECCION"  => $r->DIRECCION, 
                          "OBSOLETO"   => $r->OBSOLETO,
                          "ODOMETRO"   => $r->ODOMETRO];
                         
                $this->db->insert('posiciones',$array);
                $pos = $this->db->insert_id();
                //$pos = 77;                               
                print_array($array);
                $x++;
                $_SESSION["ids_pos"]["1"] = $pos;
                //break;
            }

		}
    }
    

}
