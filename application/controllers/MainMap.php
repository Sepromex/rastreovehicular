<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainMap extends CI_Controller {	 

	public function __construct(){
		parent::__construct();
		$this->load->model('Mainmap_model');		
		$this->load->helper('map');
		$this->headerdata["module"] = "Maps";		
	}

	public function index()
	{
		$data["custom"]   = ["title"   => "Rastreo Vehicular",
				"page"    => "MainMap",
				"prefix"  => "map",
				"section" => "Map",
				"module"  => $this->headerdata["module"]];

		//Files in head, body y footer 
		$data["include"]   = includefiles($data["custom"]["page"]);		
		$data["site_type"] = $this->Mainmap_model->load_sitestype(15);
		$data["vehicles"]  = $this->Mainmap_model->mainvehiclelist();
		$data["geoc"]      = $this->Mainmap_model->load_geo(15,1029);
		$data["sites"]     = $this->Mainmap_model->load_sites(15);		
		
		//Load view
		$this->load->view('layouts/admin',$data);
		//$this->output->enable_profiler(TRUE);
    }
 
	public function test(){
		$data  = array();
		$this->load->view('map',$data);
	} 

	public function load_geo(){
		//$data = ["user_id" => 1029, "company_id" => 15];
		$geoc = $this->Mainmap_model->load_geo(15,1029);		
		$li = '';
		foreach($geoc as $geo){
			$icon = ($geo->tipo==0)?'circle':'polig';
			$li.='<li class="py-1 px-2 mail-item inbox sent g-'.$icon.' ">
						<div class="d-flex align-self-center align-middle">
							<label class="chkbox">
								<input type="checkbox">
								<span class="checkmark small"></span>
							</label>
							<div class="mail-content d-md-flex w-100">                                                    
								<span class="car-name">'.$geo->nombre.'</span>                                                     
								<div class="d-flex mt-3 mt-md-0 ml-auto"> 
									<!-- <div class="h6 primary mdi mdi-power-plug"></div>	 -->
									<img src="/dist/images/map/geo/'.$icon.'.png" width="20px" height="18px">
								</div>
							</div>
						</div>
				 </li>'; 
		}
		echo $li;
	}
	
	public function show_sites(){
		$sites = $this->Mainmap_model->show_sites($_POST["id"]);
		header("Content-type: application/json");
		echo json_encode($sites);
	}

	public function load_sites(){
		$company_id = 15;
		$sites = $this->Mainmap_model->load_sites($company_id);		
		$li = '';
		foreach($sites as $site){
			$icon_class = ($site->id_tipo>0)?$site->id_tipo:0;			
			$iconimg    = ($site->imagen!="")?substr($site->imagen,14):"defaul_marker.png";

			$li.='<li class="py-1 px-2 mail-item inbox sitetype-'.$icon_class.'"> 
						<div class="d-flex align-self-center align-middle">
							<label class="chkbox">
								<input type="checkbox">
								<span class="checkmark small"></span>
							</label>
							<div class="mail-content d-md-flex w-100">								
								<span class="car-name" onclick="show_site('.$site->id_sitio.')"> '.$site->nombre.'</span>                                                     
								<div class="d-flex mt-3 mt-md-0 ml-auto"> 
									<img src="/dist/images/map/site_type/'.$iconimg.'" width="25px" height="22px" class="toltip" data-placement="top" title="'.$site->descripcion.'">
									<a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="icon-options-vertical"></i>
									</a>									
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right">										
										<a class="dropdown-item single-delete" href="#" onclick="edit_vehiclelist('.$site->id_sitio.')"><i class="icon-trash"></i> Editar </a>
										<a class="dropdown-item single-delete" href="#"><i class="icon-trash"></i> Eliminar </a>
									</div>
								</div>
							</div> 
						</div>
					</li>'; 

					//onclick="edit_vehiclelist('.$vehid.')"
		}
		echo $li;
	}

	public function mostrar_vehiculos_act(){

//		unset($_SESSION["messages"]); unset($_SESSION["speeds"]);
		if(!isset($_SESSION["messages"])):$this->Mainmap_model->load_messages();endif;
		if(!isset($_SESSION["speeds"])):$this->Mainmap_model->load_speeds(1029);endif;

		$id_user = "1029"; 
		//vehicles list 
		$jsondata = [];
		$vehicles = $this->Mainmap_model->main_vehiclelist();		
		if(is_array($vehicles)){			
			foreach($vehicles as $index => $veh){ 	
			  //echo " ///////////////////////// </br></br>";				
 		  	  //$vehpublicpos    = $veh->publicapos;
				$vehdescription  = $veh->descripcion;
				$vehspeed        = $veh->velocidad;
				$vehsystemid     = $veh->id_sistema;				
				$vehid           = $veh->NUM_VEH; 
				$vehentry1       = $veh->ent1_st;
				$vehentry2       = $veh->ent2_st;
				$vehentry3       = $veh->ent3_st;            
				$vehentry4       = $veh->ent4_st;
				$vehignition     = $veh->ignition_st;
				$vehcompanyid    = $veh->id_empresa;
				$vehentries      = $veh->entradas;
				$vehdevicetype   = $veh->tipo_equipo;
				 
				$vehmotor        = "";	
				$vehmotortoltip  = "";
				$vehspeedname    = "";			
				$accessory       = "";
				$accessoryname   = "";
				$messageid       = 0;
				$prueba = ""; $classmotor = "";
				/*  Check system type: 23-Portman Movistar,26-Portman Telcel,61-UMini Telcel */
				if($vehsystemid==23 || $vehsystemid==26){
					//Get terminal and port									
					if($vehentry1==1 && $vehentry2==0){
						$vehmotor       = "mdi mdi-power-plug text-success";
						$vehmotortoltip = "Terminal conectada Y puerta cerrada";	
						$classmotor = "term-on";					
					
					}
					if($vehentry1==0 && $vehentry2==1){
						$vehmotor       = "mdi mdi-power-plug-off text-primary term-off";
						$vehmotortoltip = "Terminal desconectada y puerta abierta";
						$classmotor = "term-off";
					
					}
					if($vehentry1==1 && $vehentry2==1){
						$vehmotor       = "mdi mdi-power-plug text-orange term-onoff";
						$vehmotortoltip = "Terminal conectada Y puerta abierta";
						$classmotor = "term-onoff";
					
					}
					if($vehentry1==0 && $vehentry2==0){
						$vehmotor       = "mdi mdi-power-plug-off text-orange term-offon";
						$vehmotortoltip = "Terminal desconectada y puerta cerrada";
						$classmotor = "term-offon";
					}					
				}else{
					// Entries On
					if($vehentry1==1 || $vehentry2==1 || $vehentry3==1 || $vehentry4==1){
						//save entries
						$active = array();
						if($vehentry1==1){ array_push($active,1); }
						if($vehentry2==1){ array_push($active,2); }
						if($vehentry3==1){ array_push($active,3); }
						if($vehentry4==1){ array_push($active,4); }						
						
						// Get  entries config by vehicle  
						$entryby_veh = $this->Mainmap_model->entries_config($vehid);
						if(is_array($entryby_veh) && count($entryby_veh)>0){
							$data_accesory  = ["active"    => $active,
											   "datarow"   => $entryby_veh[0],											   
											   "companyid" => $vehcompanyid];  
							$result         = $this->Mainmap_model->accesory_title($data_accesory);												
						}else{							 					
							$entryby_company = $this->Mainmap_model->entries_configbycompany($vehcompanyid);
							if(is_array($entryby_company) && count($entryby_company)>0){
								$data_accesory  = ["active"    => $active,
											       "datarow"   => $entryby_company[0],
											       "companyid" => $vehcompanyid]; 
								$result         = $this->Mainmap_model->accesory_title($data_accesory); 
							}else{
								$deviceconfig = $this->Mainmap_model->entryconfigby_devicetype($vehdevicetype,1);
								if(isset($deviceconfig[0])){
									$data_accesory  = ["active"    => $active,
											           "datarow"   => $deviceconfig[0],
											           "companyid" => $vehcompanyid]; 
									$result         = $this->Mainmap_model->accesory_title($data_accesory); 
								} 
							} 					
						}

						if(isset($result)){  $prueba .= " [accesory-188".$result["accessory"]." ] ";
							$accessory      = $result["accessory"];
							$accessoryname  = $result["accessoryname"];
							$messageid      = $result["messaje_id"];
						}

						if($accessory==1){  
							if($accessoryname==""){ 
								//echo "entro sin sentido </br></br>";
								$accessoryname      = isset($_SESSION["messages"][15][$messageid])?$_SESSION["messages"][15][$messageid]:"";
							}
						}
						$prueba .= " ** ".$accessoryname." ** ";	
						if(preg_match('/encendido/i',$accessoryname)): $vehmotor = "mdi mdi-engine text-success"; $classmotor = "engine-on"; 
						else: $vehmotor = "mdi mdi-engine-off text-info"; $classmotor = "engine-off"; endif; 
						 
					} 

					/* ******************************** */
					$accessory = "";
					if($vehmotor == ""){
						$sistemas_invalidos = array(10,14,16,17,18,20,22,25,27,28,30,31,32,33,34,35,43);
						if(!in_array($vehsystemid,$sistemas_invalidos)){	
							if(isset($vehignition) && $vehignition==1){ //encendido
								$vehmotor       = "mdi mdi-engine text-success engine-on";
								$vehmotortoltip = "Motor encendido";
								$classmotor = "engine-on";
								
							}else{ //apagado
								$vehmotor       = "mdi mdi-engine-off text-info engine-off";
								$vehmotortoltip = "Motor apagado";
								$classmotor = "engine-off";
								
							}
						}else{ //incluimos a los spider y x8
							if($vehspeed>8){
								$vehmotor       = "mdi mdi-engine text-success engine-on";
								$vehmotortoltip = "Motor encendido";
								$classmotor = "engine-on";
								
							}else{//apagado
								$vehmotor       = "mdi mdi-engine-off text-info engine-off";
								$vehmotortoltip = "Motor apagado";
								$classmotor = "engine-off";
								
							}
						}
					} 
					/* ********************************* */
				}				

				/* *********** END PRIMER ELSE ************ */ 
				$speedtoltip = "";
				if($vehspeed<=8){
					$vehspeedname="blue";
					$speedtoltip = "Detenido";
				}

				if(isset($_SESSION["speeds"][$vehid])){
					$speeds = $_SESSION["speeds"][$vehid];
					if($vehspeed<=$speeds["vel1"] && $vehspeed >= 9){
						$vehspeedname='green';
						$speedtoltip = "Mínima";
					}
					if($vehspeed<=$speeds["vel2"] && $vehspeed > $speeds["vel2"]){
						$vehspeedname='yellow';
						$speedtoltip = "Normal";
					}
					if($vehspeed<=$speeds["vel3"] && $vehspeed > $speeds["vel3"]){
						$vehspeedname='orange';
						$speedtoltip = "Regular";
					}
					if($vehspeed>=$speeds["vel4"]){
						$vehspeedname='red';
						$speedtoltip = "Máxima";
					}
				}else{ 
					if($vehspeed>8){
						if($vehspeed<46){
							$vehspeedname="green";
							$speedtoltip = "Mínima";
						} 
						if($vehspeed>=46){
							$vehspeedname="yellow";
							$speedtoltip = "Normal";
						}
						if($vehspeed>=71){
							$vehspeedname="orange";
							$speedtoltip = "Regular";
						}
						if($vehspeed>=101){
							$vehspeedname="red";
							$speedtoltip = "Máxima";
						}
					} 
				}	

				if($vehspeed == ""){
					$vehspeedname = "blue";
					$speedtoltip = "Detenido";
				}
				// -- '.$prueba.' 
				$jsondata[] = ["speed"         => $vehspeedname,
							   "class_motor"   => $classmotor,
							   "icon_motor"    => $vehmotor,
							   "toltip_motor"  => $vehmotortoltip,
							   "speed_tooltip" => $speedtoltip,
							   "idveh"         => $vehid,
							   "company"       => $vehcompanyid];


							/*echo '<li class="py-1 px-2 mail-item inbox sent starred cursor-pointer speed-'.$vehspeedname.' '.$classmotor.'">
									<div class="d-flex align-self-center align-middle">
										<label class="chkbox" >
											<input type="checkbox" onclick="vehicle_realtime(this)" id="checkveh_'.$vehid.'">
											<span class="checkmark small"></span>
										</label>
										<div class="mail-content d-md-flex w-100">                                                    
											<span class="car-name" onclick="vehicle_detail('.$vehid.')">'.$veh->ID_VEH.'</span>

											<div class="d-flex mt-3 mt-md-0 ml-auto">

												<div class="h6 mr-1 '.$vehmotor.' toltip" data-placement="top" title="'.$vehmotortoltip.'"></div>									
												<div class="speed-icon mr-1">
													<img class="toltip" style="width:100%;" src="/dist/images/config/vehicles/speed_'.$vehspeedname.'.png" data-placement="top" title="'.$speedtoltip.'" alt="'.$vehspeedname.'" onclick="vehicle_ubication('.$vehid.','.$vehcompanyid.')">
												</div> 

												<a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="icon-options-vertical"></i>
												</a>

												<div class="dropdown-menu p-0 m-0 dropdown-menu-right"> 
														<a class="dropdown-item mailread" href="#" onclick="edit_vehiclelist('.$vehid.')"><i class="mdi mdi-playlist-edit"></i> Editar </a>
												</div> 

											</div>
										</div>
									</div>
								</li>'; */
			}
		} 

		header("Content-type: application/json");        	
		echo json_encode($jsondata);

		//$this->output->enable_profiler(TRUE);   <div class="h6 primary mdi mdi-satellite-uplink text-danger"></div>  
		/*else{echo "else_end";}*/
		//print_array($vehicles); 
	}


public function vehicle_detail(){
	$data["vehicle"] = $this->main_model->vehicle_byid($_POST["id"]);
	$this->load->view("map/vehicle_detail",$data);
}

public function get_ubication(){
		$options="";
		/* insertar auditabilidad */
		$veh     = $_POST["id"];
		$company = $_POST["company"];
		
		// cambiar valor del vehiculo actual en el DOM

		$msg = $this->Mainmap_model->company_messages($company);
		if($msg): $company = $msg["id_empresa"]; else: $company = 15; endif;

		/* ************ */
		if($veh!=0){
			$max_pos = 0;
			$idlast_positions   = $this->Mainmap_model->id_pos_date($veh);			
			if(isset($idlast_positions["id"]) && $idlast_positions["id"]>0){
				$max_pos = $idlast_positions["id"];
			}	

			$resveh = $this->Mainmap_model->vehicle_position($max_pos,$veh,$company);  
			if($resveh){
				$resveh = $this->Mainmap_model->vehicle_position(0,$veh,$company);
			}		
			
			//print_array($resveh);
			
			$rowveh = $resveh;
			$vehname = $rowveh["id_veh"];
			$lat = $rowveh["lat"];
			$lon = $rowveh["lon"];
			$vel = $rowveh["velocidad"];
			$fecha = $rowveh["fecha"];
			$tipov = $rowveh["tipoveh"];
			$t_msj = $rowveh["t_mensaje"];
			$empresa = $rowveh["id_empresa"];
			$clv = $rowveh["entradas"];
			$odo = $rowveh["odometro"];
			$bat = $rowveh["entradas_a"];
			$idtipo = $rowveh["id_tipo"];
			$idsis = $rowveh["id_sistema"];
			$obsoleto = $rowveh["obsoleto"];

			$zona=$this->Mainmap_model->get_gtm($veh);
			if($zona == "0"){
				$dif="+0";				
			}else{
				$dif=(5)+($zona["gmt"]);
				$fecha=date("Y-m-d H:i:s",strtotime($fecha." $dif hours"));
			} 

			$men      = $obsoleto;
			$cab_bat  = ""; 
			$cabe     = "";
			$cuer_bat = "";
			$cabe     = "";
			$cuerpo   = "";

			if($idsis == 23 || $idsis == 26){
				if($bat<= 100 && $bat > 90){
					$bateria = "<img src='/dist/images/map/carga1.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<=90  && $bat >75 ){
					$bateria = "<img src='/dist/images/map/carga2.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 75 && $bat > 60){
					$bateria = "<img src='/dist/images/map/carga3.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 60 && $bat > 48){
					$bateria = "<img src='/dist/images/map/carga4.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 48 && $bat > 30){
					$bateria = "<img src='/dist/images/map/carga5.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 30 && $bat > 15){
					$bateria = "<img src='/dist/images/map/carga6.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat	<= 15 && $bat >= 1){
					$bateria = "<img src='/dist/images/map/carga7.png' width='10' height='20' title='$bat %'/>";
				}
				if($bat == 0){
					$bateria = "<img src='/dist/images/map/carga8.png' width='10' height='20' title='$bat %'/>";
				}
				$cab_bat  = "<th>Bateria</th>";
				$cuer_bat = "<td>$bateria</td>";
			}
			if( $idsis == 20 || $idsis == 34  ){ //$veh == 67948  || $veh == 66887
				$cabe = "<th>ODO</th>";
				$cuerpo = "<td>$odo</td>";
			}	
			if($t_msj == 2 || $t_msj == 1 || $t_msj == 13)
				$men = $rowveh["mensaje"];		
			if($men != ''){
				$img='<img src="/dist/images/map/msg.png" border = "0" title="'.$men.'" width = "25" height="16" onclick = "alert(\''.$men.'\')" >';
			}
			else
				$img = "&nbsp;";
				

			// ERROR EN ESTE IF
			if((($lat != "") || ($lon != "")) && (($lat != 0) || ($lon != 0))){
				$cruce = ""; //otro_server($lat,$lon);
				$calle = "";

				if($cruce==''){//si no trae cruce entra al web service
				}
				else 
				if( $obsoleto != 1 ){ $calle = $cruce; } //si trae cruce no entra al web service y recibe al valor de la consulta		
				else $calle = "Posición obsoleta: $cruce";
//<img onclick='ocultar_veh();' src='img2/cerrar.png' width='20px'>
				$datos = "
				<div id='mostrar_veh' style='margin:0px; width: 100%;'>
					<div style='float:right;'></div>
					<table border='0' id='box-table-a' class='table' style=' margin:0px;'>
						<tr class='fuente_siete' style='margin:0px; width: 100%; background-color:#f3f3f3;'>
							<th align='center'>Veh&iacute;culo</th>
							<th  align='center'>Fecha / Hora</th>
							<th align='center'>Km/H</th>
							$cab_bat 
							$cabe
							<th align='center'>Latitud,Longitud</th>
							<th align='center'>Ubicaci&oacute;n</th>
							<th align='center'>MSJ</th>
							<th>Satelites</th>
						</tr>
						<tr class='fuente_ocho'>";

				$fec1     = date_format(date_create($fecha),'Y-m-d h:i:s'); // cambio de strtotime() a date_format()para php 7				
				$fec1     = intval($fec1);
				
				$mes=date('n',$fec1);
	
	//			echo $fecha." -- /// -- ".$mes;

				switch($mes){
					case 1: $mess='Ene'; break;
					case 2: $mess='Feb'; break;
					case 3: $mess='Mar'; break;
					case 4: $mess='Abr'; break;
					case 5: $mess='May'; break;
					case 6: $mess='Jun'; break;
					case 7: $mess='Jul'; break;
					case 8: $mess='Ago'; break;
					case 9: $mess='Sep'; break;
					case 10: $mess='Oct'; break;
					case 11: $mess='Nov'; break;
					case 12: $mess='Dic'; break;
				}
				
				
				//$calle .= " ".sitio_cercano($idemp,$lat,$lon);
				$datos .= "
							<td>".$vehname."</td>
							<td>".date('d',$fec1).'-'.$mess.'-'.date('Y h:i:s A', $fec1)."</td>
							<td>".$vel."</td>
							$cuer_bat 
							$cuerpo
							<td>".number_format($lat,7,'.','').",".number_format($lon,7,'.','')."</td>
							<td>".$calle."</td>
							<td>".$img."</td>
							<td align='center'>".$rowveh["satelites"]."</td>
						</tr>
					</table>
				</div>";

				//echo "--".$max_pos."--";
				$data["table"]   = $datos; //mostrar tabla
				$data["last"]    = ["lat" => $lat, "lon" => $lon, "tipov" => $tipov]; //Ultima posicion "MapaCord"
				$data["route"]   = $this->Mainmap_model->get_positiones($veh);	//$objResponse->call("crea_recorrido",
				$data["veh"]     = $veh;

				//$objResponse->script("mostrarLinea2(0);");				
				//$objResponse->script("muestra_cuerpo()");
				
			}else{ //Sucede cuando no hay datos de ese vehiculo en la tabla ultimapos				
				$data["error"] = "No hay posición válida del vehículo seleccionado en este momento, vuelva a intentar en unos momentos o envíe un poleo";
			}

		}else { //si selecciona el valor "0" le decimos al usuario que seleccione un vehiculo de la lista
			$data["error"] = "Seleccione un vehiculo de la lista."; 
		}

		header("Content-type: application/json");        	
		echo json_encode($data);

		/************* */



	}
























	




}