<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function mostrar_vehiculos_act(){//se carga cada 30 segundos
	require("librerias/conexion.php");
	mysql_query("UPDATE alertas_leido SET atendido=1 WHERE lat>3000000");
	$objResponse = new xajaxResponse();
	/*
	$us=mysql_query("SELECT USER()");
	$ub=mysql_fetch_array($us);
	$objResponse->alert($ub[0]);
	*/
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $_SESSION["Idu"];
	$cons_veh = "SELECT v.ID_VEH, v.NUM_VEH,v.estatus,ev.publicapos,
				ev.descripcion,p.velocidad,v.id_sistema,
				p.ent1_st,p.ent2_st,p.ent3_st,p.ent4_st,v.id_empresa,p.entradas
				FROM veh_usr AS vu
				Inner join vehiculos AS v ON vu.NUM_VEH = v.NUM_VEH
				inner join estveh ev on (v.estatus = ev.estatus)
				left JOIN ultimapos AS p ON vu.num_veh=p.num_veh
				AND v.num_veh=p.num_veh
				WHERE vu.ID_USUARIO = $idu 
				and ev.publicapos=1
				and vu.activo=1
				group by v.num_veh 
				ORDER BY v.ID_VEH ASC";
	$resp_veh  = mysql_query($cons_veh); 
	$cont= "<table id='newspaper-a1' width='195px' style='padding:0px;margin:0px;'>
			<tr>
				<th style='font-size:14px;width:150px;'>Vehiculo</th>
				<th style='font-size:14px;' colspan='2'>Status</th>
			</tr>";
	$w_accesorio="";
	if(mysql_num_rows($resp_veh)>0){
		while($rows_veh = mysql_fetch_array($resp_veh)){
			//comprovaremos las velocidades configurables
			$img_motor="";
			if($rows_veh[6]==23 || $rows_veh[6]==26 || $rows_veh[6]==61){ //portman (23,26)  uminis (61)
				/*
					PORTMAN
					//entrada 1=Desconectado/conectado 
					//entrada 2=Puerta abierta
				*/
				$terminales=mysql_query("SELECT ent1_st from ultimapos where num_veh=".$rows_veh[1]);
				$img_motor="";
				$terminal=mysql_fetch_array($terminales);
				$puertas=mysql_query("SELECT ent2_st from ultimapos where num_veh=".$rows_veh[1]);
				$puerta=mysql_fetch_array($puertas);
				if($terminal[0]==1 && $puerta[0]==0){
					$img_motor="<img src='img_alertas/conectado.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta cerrada' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==0 && $puerta[0]==1){
					$img_motor="<img src='img_alertas/desconectado.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta abierta' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==1 && $puerta[0]==1){
					$img_motor="<img src='img_alertas/conectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal conectada Y puerta abierta' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
				if($terminal[0]==0 && $puerta[0]==0){
					$img_motor="<img src='img_alertas/desconectado_abierta.png' style='cursor:pointer;' width='15px' title='Terminal desconectada y puerta cerrada' 
					onclick='ubicacion(".$rows_veh[1].");'>";
				}
			}else{
				/*
					buscar en accesorios del vehiculo
					cfg_entxveh and activo=1 //por equipo
					cfg_ent and estatus=1//por empresa
					cfg_entxtequipo //por tipo de equipo
				*/
				$w_accesorio="";
				$title_accesorio="";
				if($rows_veh[7]==1 || $rows_veh[8]==1 || $rows_veh[9]==1 || $rows_veh[10]==1){//entrada activada
					$activada=array();
					if($rows_veh[7]==1){
						array_push($activada,1);
					}
					if($rows_veh[8]==1){
						array_push($activada,2);
					}
					if($rows_veh[9]==1){
						array_push($activada,3);
					}
					if($rows_veh[10]==1){
						array_push($activada,4);
					}
					$ac_eq=mysql_query("SELECT * from cfg_entxveh where num_veh=".$rows_veh[1]." and estatus=1");
					//$objResponse->alert("SELECT * from cfg_entxveh where num_veh=".$rows_veh[1]." and estatus=1");
					
					if(mysql_num_rows($ac_eq)>0){//personalizados
						//buscamos los mensajes por clave 2 a 9
						$w_accesorio=1;
						$b_acc=mysql_fetch_array($ac_eq);
						for($a=0;$a<count($activada);$a++){
							$ini=$activada[$a]*2;
							$fin=$ini+2;
							for($i=$ini;$i<$fin;$i++){
								$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
								id_mensaje=".$b_acc[$i]);
								if(mysql_num_rows($d_men)>0){
									$desc=mysql_fetch_array($d_men);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
								}else{
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
									id_mensaje=".$b_acc[$i]);
									$desc=mysql_fetch_array($d_men);
									//$objResponse->alert($desc[0]);
									if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
										$title_accesorio.=$desc[0];
										$id_msj=$b_acc[$i];
									}else{
										if($b_acc[$i]!=0 && $i==$ini){
											$title_accesorio.=$desc[0];
										}
									}
									if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
										$title_accesorio.="/";
									}
									//$objResponse->alert($title_accesorio);
								}
							}
							$title_accesorio.=" ";
						}
					}else{
						$ac_emp=mysql_query("SELECT * from cfg_ent where id_empresa=".$rows_veh[11]." and estatus=1");
						if(mysql_num_rows($ac_emp)>0){
							//buscamos mensajes por clave2 a 9
							$w_accesorio=1;
							$b_acc=mysql_fetch_array($ac_emp);
							for($a=0;$a<count($activada);$a++){
								$ini=$activada[$a]*2;
								$fin=$ini+2;
								for($i=$ini;$i<$fin;$i++){
									$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
									id_mensaje=".$b_acc[$i]);
									if(mysql_num_rows($d_men)>0){
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}else{
										$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
										id_mensaje=".$b_acc[$i]);
										$desc=mysql_fetch_array($d_men);
										if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
											$title_accesorio.=$desc[0];
											$id_msj=$b_acc[$i];
										}else{
											if($b_acc[$i]!=0 && $i==$ini){
												$title_accesorio.=$desc[0];
											}
										}
										if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
											$title_accesorio.="/";
										}
									}
								}
								$title_accesorio.=" ";
							}
						}else{
							$tipo_e=mysql_query("select tipo_equipo from sistemas where id_sistema=".$rows_veh[6]);
							$tipos=mysql_fetch_array($tipo_e);
							$ac_std=mysql_query("SELECT * from cfg_entxtequipo where tipo_equipo='".$tipos[0]."'");
							if(mysql_num_rows($ac_std)>0){
								//buscamos mensajes por clave2 a 9
								$w_accesorio=1;
								$b_acc=mysql_fetch_array($ac_std);
								for($a=0;$a<count($activada);$a++){
									$ini=($activada[$a]*2)-1;
									$fin=$ini+2;
									for($i=$ini;$i<$fin;$i++){
										$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=".$rows_veh[11]." and 
										id_mensaje=".$b_acc[$i]);
										if(mysql_num_rows($d_men)>0){
											$desc=mysql_fetch_array($d_men);
											if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
												$title_accesorio.=$desc[0];
												$id_msj=$b_acc[$i];
											}else{
												if($b_acc[$i]!=0 && $i==$ini){
													$title_accesorio.=$desc[0];
												}
											}
											if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
												$title_accesorio.="/";
											}
										}else{
											$d_men=mysql_query("SELECT mensaje from c_mensajes where id_empresa=15 and 
											id_mensaje=".$b_acc[$i]);
											$desc=mysql_fetch_array($d_men);
											if($i==($fin-1) && ($b_acc[$i]!=252 && $b_acc[$i]!=0)){
												$title_accesorio.=$desc[0];
												$id_msj=$b_acc[$i];
											}else{
												if($b_acc[$i]!=0 && $i==$ini){
													$title_accesorio.=$desc[0];
												}
											}
											if($i==$ini && $b_acc[$i]!=252 && $b_acc[$i]!=0){
												$title_accesorio.="/";
											}
										}
									}
									$title_accesorio.=" ";
								}
							}
						}
					}
					//$objResponse->alert($title_accesorio);
					if($w_accesorio==1){
						if($title_accesorio==''){
							$info=mysql_query("select mensaje from c_mensajes where id_mensaje=".$id_msj." and id_empresa=15");
							$dat=mysql_fetch_array($info);
							$title_accesorio=$dat[0];
						}
						//$w_accesorio="<img src='img_alertas/w_accesorio.png' title='$title_accesorio' style='cursor:pointer;'  
						//onclick='alert(\"".trim($title_accesorio)."\")' height='15px'>";
					}
					//$objResponse->alert($title_accesorio);
					if(preg_match('/encendido/i',$title_accesorio)){
						$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
					}
					else{
						$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
					}
				}
				$w_accesorio="";
				if($img_motor==''){
					$sistemas_invalidos=array(10,14,16,17,18,20,22,25,27,28,30,31,32,33,34,35,43);
					if(!in_array($rows_veh[6],$sistemas_invalidos)){
						$motores=mysql_query("SELECT ignition_st from ultimapos where num_veh=".$rows_veh[1]);
						$img_motor="";
						$motor=mysql_fetch_array($motores);
						if($motor[0]==1){//encendido
							$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
						}else{//apagado
							$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
						}
					}else{//incluimos a los spider y x8
						
						if($rows_veh[5]>8){
							$img_motor="<img src='img_alertas/encendido.png' style='cursor:pointer;' width='15px' title='Motor encendido' onclick='ubicacion(".$rows_veh[1].");'>";
						}else{//apagado
							$img_motor="<img src='img_alertas/apagado.png' style='cursor:pointer;' width='15px' title='Motor apagado' onclick='ubicacion(".$rows_veh[1].");'>";
						}
					}
				}
			}
			$query2="SELECT * FROM config_vel AS C WHERE C.id_usuario = $idu AND C.num_veh = ".$rows_veh[1];
			$qvelocidad=mysql_query($query2);
			if(mysql_num_rows($qvelocidad)==0){//asignamos las velocidades "default"
				if($rows_veh[5]<=8){
					$vel="azul";
				}
				if($rows_veh[5]>8){
					if($rows_veh[5]<46){
						$vel="verde";
					}
					if($rows_veh[5]>=46){
						$vel="amarillo";
					}
					if($rows_veh[5]>=71){
						$vel="naranja";
					}
					if($rows_veh[5]>=101){
						$vel="rojo";
					}
				}
			}else{
				$vel_conf=mysql_fetch_array($qvelocidad);
				if($rows_veh[5]<=8){
					$vel="azul";
				}
				if($rows_veh[5]<=$vel_conf[2] && $rows_veh[5] >=9){
					$vel='verde';
				}
				if($rows_veh[5]<=$vel_conf[3] && $rows_veh[5]>$vel_conf[2]){
					$vel='amarillo';
				}
				if($rows_veh[5]<=$vel_conf[4] && $rows_veh[5]>$vel_conf[3]){
					$vel='naranja';
				}
				if($rows_veh[5]>=$vel_conf[5]){
					$vel='rojo';
				}
			}
			if($vel==''){
				$vel="azul";
			}
			$cont.= "<tr>
					<td style='font-size:12px;word-wrap:break-word;' >
						<a href='#' onclick='ubicacion(".$rows_veh[1].");'>".$rows_veh[0]."</a>
						
					</td>
					<td align='center' id='velocidad".$rows_veh[1]."'>
						$w_accesorio&nbsp;$img_motor&nbsp;<img src='img2/".$vel.".png' style='cursor:pointer;' width='20px' title='".$rows_veh[5]." km/h' onclick='ubicacion(".$rows_veh[1].");'>
					</td>";
			$si = strstr($sess->get("per"),"1");
			if($sess->get('sta') != 3 || !empty($si)){
				$cont.= "
					<td id='elpoleo2'>
						<img src='img2/satelite.png' title='Solicitar posición actual ".$rows_veh[0]."' width='13px' onclick='polear(".$rows_veh[1].");xajax_elpoleo2(".$rows_veh[1].");' style='cursor:pointer;'>
					</td>
				</tr>";
			}else{
				$cont.= "
					<td id='elpoleo2'>
					</td>
				</tr>";
			}				
		}
		$cont.= "</table>";
	}
	else{
		$rows_veh = mysql_fetch_array($resp_veh);
		$cont.=$rows_veh[4];
	}
	$objResponse->assign("vehiculos_act","innerHTML",$cont);
	mysql_close($conec);
	return $objResponse;
}
