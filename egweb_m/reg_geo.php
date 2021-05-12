<?
  //include('conn.php');
  //include('ObtenUrl.php');
  include('../adodb/adodb.inc.php');
  //require_once('../FirePHPCore/FirePHP.class.php'); // Clase FirePhp para hace debug con Firebug 
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  //$web = $sess->get("web");
  $estses = $sess->getState();
  if (isset($_GET["Logout"])){
    $web = $sess->get("web");
	$sess->Destroy();
	if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");
  }
  if ($estses == empty_referer) {
    if($web == 1)
		header("Location: indexApa.php?$web");
	else header("Location: index.php?$web");		
  } 

  $result = $sess->get( 'expire-test' );
  if((!patErrorManager::isError($result)) && ($sess->get('Idu'))) 
  {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get('Registrado');
		$nom = $sess->get('nom');
		$prm = $sess->get("per");
		$est = $sess->get('sta');
		$sit = $sess->get('sit');
		$geocer = $sess->get('geo');
		$eve = $sess->get('eve');
		$evf = $sess->get('evf');
		$dis = $sess->get('dis');
		$pan = $sess->get('pan');
		$veh_actual = $sess->get('veh');
		if(!$reg)
			$sess->set('Registrado',1);
  }
  else{
	    $web = $sess->get("web"); 
		$sess->Destroy();
		if($web == 1 )
			header("Location: indexApa.php?$web");
		else header("Location: index.php?$web");      	      	
   }          
//se registran variables
	require("librerias/conexion.php");
	require("librerias/SistemasConfigurables/Configsis_nuevo_geo.php");
  	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	$xajax->configure('javascript URI', '../xajaxs/');
	$xajax->register(XAJAX_FUNCTION,"vehiculos");
	$xajax->register(XAJAX_FUNCTION,"vehiculos_check");
	$xajax->register(XAJAX_FUNCTION,"ver_geocercas");
	$xajax->register(XAJAX_FUNCTION,"guardar_asignacion");
	$xajax->register(XAJAX_FUNCTION,"borrar");
	$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
	$xajax->register(XAJAX_FUNCTION,"geocercas");
	$xajax->register(XAJAX_FUNCTION,"config_folio");
	$xajax->register(XAJAX_FUNCTION,"nuevo_folio");
	$xajax->register(XAJAX_FUNCTION,"nueva_regla");
	$xajax->register(XAJAX_FUNCTION,"actualiza_regla");
	$xajax->register(XAJAX_FUNCTION,"borrar_reg");
	$xajax->register(XAJAX_FUNCTION,"borrar_folio");
	$xajax->register(XAJAX_FUNCTION,"mostrar_correos");
	$xajax->register(XAJAX_FUNCTION,"agrega_correo");
	$xajax->register(XAJAX_FUNCTION,"update_correos");
	$xajax->register(XAJAX_FUNCTION,"opciones");
	
	$xajax->register(XAJAX_FUNCTION,"validar_respuesta");
	$xajax->register(XAJAX_FUNCTION,"retraso");
	$xajax->register(XAJAX_FUNCTION,"reenvio");
	$xajax->register(XAJAX_FUNCTION,"revisa_reenvio");
	$xajax->register(XAJAX_FUNCTION,"intersecta");
	$xajax->register(XAJAX_FUNCTION,"check_cmd");
	$xajax->register(XAJAX_FUNCTION,"revisa_envio");
function get_real_ip(){
	if (isset($_SERVER["HTTP_CLIENT_IP"])){
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
		return $_SERVER["HTTP_X_FORWARDED"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
		return $_SERVER["HTTP_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED"])){
		return $_SERVER["HTTP_FORWARDED"];
	}
	else{
		return $_SERVER["REMOTE_ADDR"];
	}
}
function intersecta($geo,$veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$sin_tocar=0;
	if(count($geo)>0 && count($veh)>0){//busqueda entre las del equipo y las nuevas
		for($i=0;$i<count($veh);$i++){
			$id_veh=mysql_query("select id_veh from vehiculos where num_veh=".$veh[$i]);
			$nom=mysql_fetch_array($id_veh);
			for($j=0;$j<count($geo);$j++){
				$q_geo_equipo=mysql_query("SELECT num_geo from geo_equipo where activo=1 and num_veh=".$veh[$i]);//actuales en el equipo
				while($geo_eq=mysql_fetch_array($q_geo_equipo)){
					$degtorad = 0.01745329; 
					$radtodeg = 57.29577951; 
					$u_pos=mysql_query("select latitud,longitud,radioMts,nombre from geo_time where num_geo=".$geo_eq[0]);//coordenadas de geo en  equipo
					$data=mysql_fetch_array($u_pos);
					$lat=$data[0];
					$lon=$data[1];
					$radio_equipo=$data[2];
					$geos=mysql_query("SELECT latitud,longitud,radioMts,nombre from geo_time where num_geo=".$geo[$j]);//coordenadas de "nueva"
					$row = mysql_fetch_array($geos);//sacar el radio geocerca
					$dlong = ($lon - $row[1]); 
					$radio_nueva=$row[2];
					if($geo[$j]!=$geo_eq[0]){
						$dvalue = (sin($lat * $degtorad) * sin($row[0] * $degtorad)) + (cos($lat * $degtorad) * cos($row[0] * $degtorad) * cos($dlong * $degtorad)); 
						$dd = acos($dvalue) * $radtodeg; 
						$km = ($dd * 111.302)*1000;
						$km = number_format($km,1,'.','');//distancia entre centro geo y pos actual
						$margen_error=100;
						$radio_total=$radio_equipo+$radio_nueva+$margen_error;
						if($radio_total>$km){
							$objResponse->alert("Las siguientes geocercas se intersectan o estan a menos de 100 mts entre si: ".$data[3]."(en equipo) y ".$row[3]."(nueva)");
							$objResponse->script("quita_intersec(".$geo[$j].")");
							$sin_tocar=1;
						}
					}
					else{
						$objResponse->alert("La Geocerca ".$row[3]." ya esta asignada en el vehiculo ".$nom[0]);
						$objResponse->script("quita_intersec(".$geo_eq[0].")");
						$sin_tocar=1;
					}
				}
			}
		}
		/*
			busqueda entre las nuevas para ver que entre ellas no se intersecten
		*/
		if($sin_tocar==0){
			for($i=0;$i<count($geo);$i++){
				for($j=0;$j<count($geo);$j++){
					$q1=mysql_query("SELECT latitud,longitud,radioMts,nombre from geo_time where num_geo=".$geo[$i]);
					$dat1=mysql_fetch_array($q1);
					$degtorad = 0.01745329; 
					$radtodeg = 57.29577951;
					$lat=$dat1[0];
					$lon=$dat1[1];
					$radio_equipo=$dat1[2];
					$q2=mysql_query("SELECT latitud,longitud,radioMts,nombre from geo_time where num_geo=".$geo[$j]);
					$row = mysql_fetch_array($q2);
					$dlong = ($lon - $row[1]); 
					$radio_nueva=$row[2];
					if($geo[$j]!=$geo[$i]){
						$dvalue = (sin($lat * $degtorad) * sin($row[0] * $degtorad)) + (cos($lat * $degtorad) * cos($row[0] * $degtorad) * cos($dlong * $degtorad)); 
						$dd = acos($dvalue) * $radtodeg; 
						$km = ($dd * 111.302)*1000;
						$km = number_format($km,1,'.','');//distancia entre centro geo y pos actual
						$margen_error=100;
						$radio_total=$radio_equipo+$radio_nueva+$margen_error;
						if($radio_total>$km){
							$objResponse->alert("Las siguientes geocercas se intersectan o estan a menos de 100 mts entre si: ".$dat1[3]." y ".$row[3]);
							$objResponse->script("quita_intersec(".$geo[$j].")");
							unset($geo[$j]);
							$sin_tocar=1;
						}
					}
				}
			}
		}
	}
	return $objResponse;
}
/*
    funcion para comprobar si el comando se finalizo correctamente
    y posteriormente "borrar" el registro 
*/
function check_cmd(){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$folios=mysql_query("SELECT det.folio,cmd.reg,cmd.completado,cmd.desactivamaestro
	FROM gpscondicionalerta gps 
	inner join gpscondicionalertadet det on gps.folio=det.folio
	inner join gpscond_cmdsxalrt cmd on cmd.folio=gps.folio
	where gps.id_empresa=".$sess->get('Ide')." 
	and gps.activo=1");
	if(mysql_num_rows($folios)>0){
		while($row=mysql_fetch_array($folios)){
			if($row[2]==1){//si el comando se completo
				if($row[3]==0 && $row[2]==1){//un registro de la regla
					$folio=$row[0];
					$reg=$row[1];
					mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio and reg=$reg");
					$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio and reg=$reg");
					while($row=mysql_fetch_array($borrar)){
						$num_veh=$row[0];
						$num_geo=$row[1];
						mysql_query("UPDATE geo_veh set activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
						mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$row[0]." AND num_geo=".$row[1]);
					}
					/*
						borrar "dentro"
					*/
					$dentro=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
					if(mysql_num_rows($dentro)>0){
						$folios_d=mysql_fetch_array($dentro);
						$folio_D=$folios_d[0];
						mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_D and num_veh=$num_veh and num_geo=$num_geo");
					}
					/*
						borrar registros de las salida!
					*/
					$salidas=mysql_query("SELECT folio_fuera from gpscondgeocompleja where folio_entgeo=$folio and folio_fuera>0");
					while($folios_S=mysql_fetch_array($salidas)){
						$folio_S=$folios_S[0];
						$select=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio_S
						and num_veh=$num_veh and num_geo=$num_geo");
						if(mysql_num_rows($select)>0){
							//update
							mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_S");
							mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_S and num_veh=$num_veh and num_geo=$num_geo");
						}
					}
				}
				if($row[3]==1 && $row[2]==1){//una regla
					$folio=$row[0];
					mysql_query("UPDATE gpscondicionalertadet SET activo=0 where folio=$folio");
					mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio");
					mysql_query("UPDATE gps_config set activo=0 where folio=$folio");
					/*
						enviaremos comandos al equipo para borrar la geocerca asignada
					*/
					$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio");
					while($row=mysql_fetch_array($borrar)){
						mysql_query("UPDATE geo_veh set activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
						mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$row[0]." AND num_geo=".$row[1]);
					}
					/*
						borrar "dentro"
					*/
					$dentro=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
					if(mysql_num_rows($dentro)>0){
						$folios_d=mysql_fetch_array($dentro);
						$folio_D=$folios_d[0];
						mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_D");
						mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_D");
					}
					/*
						borrar registros de las salida!
					*/
					$salidas=mysql_query("SELECT folio_fuera from gpscondgeocompleja where folio_entgeo=$folio and folio_fuera>0");
					while($folios_S=mysql_fetch_array($salidas)){
						$folio_S=$folios_S[0];
						$select=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio_S");
						if(mysql_num_rows($select)>0){
							mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_S");
							mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_S");
						}
					}
				}
			}
			else{
				$mensaje_error="";
			}
		}
	}
	return $objResponse;
}
/*
    Funcion ciclica para revisar que el comando se haya borrado
*/
function revisa_envio($id,$i){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options ); 
	$query=mysql_query("SELECT respuesta from notificaweb where id=".$id);
	//$objResponse->alert($id);
	$resp=mysql_fetch_array($query);
	$intentos=60;
	if($sess->get("intentos")<$intentos){
		if(preg_match("/NO RESPONDIO/i",$resp[0]) || preg_match("/error/i",$resp[0])){
			$objResponse->assign("borrado_cmd","innerHTML",'Se ocaciono un error al intentar guardar esta geocerca, vualva a intentarlo');
		}
		else{
			if(!preg_match("/SAVE/i",$resp[0])){
				$objResponse->script("setTimeout('xajax_revisa_envio($id,$i+1)',1000)");
			}
			else{
				mysql_query("UPDATE gpscond_cmdsxalrt set completado=1 where id_notificaweb=$id");
				$objResponse->alert("Se guardo exitosamente la nueva configuracion");
				$folios=mysql_query("SELECT folio from gpscond_cmdsxalrt where id_notificaweb=$id");
				$folio=mysql_fetch_array($folios);
				$objResponse->script("xajax_check_cmd()");
				$objResponse->script("xajax_config_folio(".$folio[0].")");
				$objResponse->assign("borrado_cmd","innerHTML",'');
			}
		}
		$sess->set("intentos",$i+1);
	}
	else{
		$objResponse->alert("Tiempo de espera agotado, vuelva a intentarlo nuevamente...");
		$objResponse->assign("borrado_cmd","innerHTML",'');
	}
	return $objResponse;
}
function borrar_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	/*
	mysql_query("UPDATE gpscondicionalertadet SET activo=0 where folio=$folio");
	mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio");
	mysql_query("UPDATE gps_config set activo=0 where folio=$folio");
	*/
	/*
		enviaremos comandos al equipo para borrar la geocerca asignada
	*/
	$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio");
	while($row=mysql_fetch_array($borrar)){
		$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$row[0]);
		$idsistemas=mysql_fetch_array($sistema);
		$idsistema=$idsistemas[0];
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
		$query=mysql_query("SELECT index_equipo FROM geo_equipo where num_veh=".$row[0]." AND num_geo=".$row[1]." and activo=1");
		$index=mysql_fetch_array($query);
		//formamos el comando a enviar al equipo
		$cmd="SETGEO:".$row[0].";%s;".$sess->get("Idu").";".$index[0].";0";
		mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$row[0].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
		$idRequest=mysql_insert_id();
		$cmd = sprintf($cmd,$idRequest);
		$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
		/*
		mysql_query("UPDATE geo_veh set activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
		mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$row[0]." AND num_geo=".$row[1]);
		*/
	}
	/*
		borrar "dentro"
	*/
	$dentro=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
	if(mysql_num_rows($dentro)>0){
		$folios_d=mysql_fetch_array($dentro);
		$folio_D=$folios_d[0];
		$select=mysql_query("SELECT num_veh,vel_max,num_geo from gpscondicionalertadet where folio=$folio_D");
		//mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_D");
		//mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_D");
		if(mysql_num_rows($select)>0){//si tengo velocidad dentro de geocerca
			//busco si estoy dentro de la geocerca seleccionada
			while($pos=mysql_fetch_array($select)){
				$degtorad = 0.01745329; 
				$radtodeg = 57.29577951; 
				//$resp = "Aprox. a ";
				//lat - lon ---> pos actual
				$u_pos=mysql_query("select (u.lat/3600/16),((u.long & 8388607)/3600/12*-1) from ultimapos u where num_veh=".$pos[0]);
				$data=mysql_fetch_array($u_pos);
				$lat=$data[0];
				$lon=$data[1];
				$geos=mysql_query("SELECT * from geo_time where num_geo=".$pos[2]);
				$row = mysql_fetch_array($geos);//sacar el radio geocerca
				$dlong = ($lon - $row[2]); 
				$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
				$dd = acos($dvalue) * $radtodeg; 
				$km = ($dd * 111.302)*1000;
				$km = number_format($km,1,'.','');//distancia entre centro geo y pos actual
				//$objResponse->alert("distancia:".$km." Radio:".$row[3]."  latU:$lat lonU:$lon  latG:".$row[1]." lonG=".$row[2]);
				if($km < $row[3]){//si la distancia es menor al radio
					/*
						enviamos comando de desactivar velocidad
					*/
					$ver=mysql_query("select tpoleo from vehiculos where num_veh=".$pos[1]);
					$t_po=mysql_fetch_array($ver);
					$t_poleo=$t_po[0];
					
					$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$pos[0]);
					$idsistemas=mysql_fetch_array($sistema);
					$idsistema=$idsistemas[0];
					$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
					//formamos el comando a enviar al equipo
					$cmd="SETALERVEL:".$pos[0].";%s;".$sess->get("Idu").";0;50";
					mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$pos[0].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
					$idRequest=mysql_insert_id();
					$ver=mysql_query("SELECT * from gpscond_cmdsxalrt where folio=$folio");
					if(mysql_num_rows($ver)>0){
						mysql_query("UPDATE gpscond_cmdsxalrt set id_notificaweb=$idRequest,desactivamaestro=1 where folio=$folio");
					}
					else{
						mysql_query("INSERT INTO gpscond_cmdsxalrt values($folio,$reg,$idRequest,0,1)");
					}
					$cmd = sprintf($cmd,$idRequest);
					$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
					$cmd2="SETREPPOS:".$pos[0].";%s;".$sess->get("Idu").";1;1;$t_poleo;0;0";
					mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$pos[0].",'$cmd2','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
					$idRequest2=mysql_insert_id();
					$cmd2 = sprintf($cmd2,$idRequest2);
					$objResponse->script($equipoGps->sendCMDtoEGServer($cmd2));
				}
			}
		}
		
	}
	$objResponse->script("xajax_revisa_envio($idRequest,0)");
	/*
		borrar registros de las salida!
	*/
	$salidas=mysql_query("SELECT folio_fuera from gpscondgeocompleja where folio_entgeo=$folio and folio_fuera>0");
	while($folios_S=mysql_fetch_array($salidas)){
		$folio_S=$folios_S[0];
		$select=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio_S");
		if(mysql_num_rows($select)>0){
			//mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_S");
			//mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_S");
		}
	}
	if(!mysql_error()){
		//$objResponse->redirect("reg_geo.php?");
	}
	else{
		//$objResponse->alert(mysql_error());
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',53,
	'Borra configuracion en geocercas online',13,".$sess->get('Ide').",'".get_real_ip()."')");
	/*
		Mandamos llamar la funcion para checar los comandos borrados
	*/
	return $objResponse;
}

function borrar_reg($folio,$reg){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	//borrar la "entrada" solo el detalle
	//mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio and reg=$reg");
	$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio and reg=$reg");
	while($row=mysql_fetch_array($borrar)){
		$num_veh=$row[0];
		$num_geo=$row[1];
		$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$row[0]);
		$idsistemas=mysql_fetch_array($sistema);
		$idsistema=$idsistemas[0];
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
		$query=mysql_query("SELECT index_equipo FROM geo_equipo where num_veh=".$row[0]." AND num_geo=".$row[1]." and activo=1");
		//$objResponse->alert(mysql_error());
		$index=mysql_fetch_array($query);
		//formamos el comando a enviar al equipo
		$cmd="SETGEO:".$row[0].";%s;".$sess->get("Idu").";".$index[0].";0";
		mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$row[0].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
		$idRequest=mysql_insert_id();
		$ver=mysql_query("SELECT * from gpscond_cmdsxalrt where folio=$folio and reg=$reg");
		if(mysql_num_rows($ver)>0){
			mysql_query("UPDATE gpscond_cmdsxalrt set id_notificaweb=$notifica where folio=$folio");
		}
		else{
			mysql_query("INSERT INTO gpscond_cmdsxalrt values($folio,$reg,$notifica,0,0)");
		}
		
		$cmd = sprintf($cmd,$idRequest);
		$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
		/*
		mysql_query("UPDATE geo_veh set activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
		mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$row[0]." AND num_geo=".$row[1]);
		*/
	}
	//$objResponse->alert($cmd);
	/*
		borrar "dentro"
	*/
	$dentro=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
	if(mysql_num_rows($dentro)>0){
		$folios_d=mysql_fetch_array($dentro);
		$folio_D=$folios_d[0];
		$select=mysql_query("SELECT num_veh,vel_max,num_geo from gpscondicionalertadet where folio=$folio_D 
		and num_veh=$num_veh and vel_max>0 and num_geo=$num_geo");
		//mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_D and num_veh=$num_veh and num_geo=$num_geo");
		if(mysql_num_rows($select)>0){//si tengo velocidad dentro de geocerca
			//busco si estoy dentro de la geocerca seleccionada
			while($pos=mysql_fetch_array($select)){
				$degtorad = 0.01745329; 
				$radtodeg = 57.29577951; 
				//$resp = "Aprox. a ";
				//lat - lon ---> pos actual
				$u_pos=mysql_query("select (u.lat/3600/16),((u.long & 8388607)/3600/12*-1) from ultimapos u where num_veh=".$num_veh);
				$data=mysql_fetch_array($u_pos);
				$lat=$data[0];
				$lon=$data[1];
				$geos=mysql_query("SELECT * from geo_time where num_geo=".$pos[2]);
				$row = mysql_fetch_array($geos);//sacar el radio geocerca
				$dlong = ($lon - $row[2]); 
				$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
				$dd = acos($dvalue) * $radtodeg; 
				$km = ($dd * 111.302)*1000;
				$km = number_format($km,1,'.','');//distancia entre centro geo y pos actual
				//$objResponse->alert("distancia:".$km." Radio:".$row[3]."  latU:$lat lonU:$lon  latG:".$row[1]." lonG=".$row[2]);
				if($km < $row[3]){//si la distancia es menor al radio
					/*
						enviamos comando de desactivar velocidad
					*/
					$ver=mysql_query("select tpoleo from vehiculos where num_veh=".$num_veh);
					$t_po=mysql_fetch_array($ver);
					$t_poleo=$t_po[0];
					
					$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$num_veh);
					$idsistemas=mysql_fetch_array($sistema);
					$idsistema=$idsistemas[0];
					$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
					//formamos el comando a enviar al equipo
					$cmd="SETALERVEL:".$num_veh.";%s;".$sess->get("Idu").";0;50";
					mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$num_veh.",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
					$idRequest=mysql_insert_id();
					$cmd = sprintf($cmd,$idRequest);
					$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
					$cmd2="SETREPPOS:".$num_veh.";%s;".$sess->get("Idu").";1;1;$t_poleo;0;0";
					mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$num_veh.",'$cmd2','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
					$idRequest2=mysql_insert_id();
					$cmd2 = sprintf($cmd2,$idRequest2);
					$objResponse->script($equipoGps->sendCMDtoEGServer($cmd2));
				}
			}
		}
		
	}
	$objResponse->script("xajax_revisa_envio($idRequest,0)");
	/*
		borrar registros de las salida!
	*/
	$salidas=mysql_query("SELECT folio_fuera from gpscondgeocompleja where folio_entgeo=$folio and folio_fuera>0");
	while($folios_S=mysql_fetch_array($salidas)){
		$folio_S=$folios_S[0];
		$select=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio_S
		and num_veh=$num_veh and num_geo=$num_geo");
		if(mysql_num_rows($select)>0){
			//update
			/*
			mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio_S");
			mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_S and num_veh=$num_veh and num_geo=$num_geo");
			*/
		}
	}
	
	$objResponse->script("xajax_config_folio($folio)");
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',56,
	'Borra vehiculo de regla en geocercas online',13,".$sess->get('Ide').",'".get_real_ip()."')");
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	//$objResponse->alert($idRequest);
	$result = $equipoGps->getStatusResponseGEO($idRequest);
	//$objResponse->alert($result);
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfigGEO($veh));
		$objResponse->script("setTimeout('check_online()',4000)");
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConectedGEO($veh)");
		$objResponse->script("setTimeout('check_online()',3000)");
	}else $objResponse->script("setUpTimerOnlineGEO($veh,'".$idRequest."')");
	return $objResponse;		
}
function nuevo_folio($T_dias,$T_geo,$T_veh,$inicio,$fin,$minima_e,$minima_s,$maxima_e,$maxima_s,$descrip,$correos,$dentro,$fuera,$periodo,$activo,$gestion,$duracion,$estricto,$t_rep_e,$d_rep_e,$r_rep_e,$t_rep_s,$d_rep_s,$r_rep_s,$unavez){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$retraso=array();
	/*
		insert en gpscondicionalerta
	*/
	$cam_t="-1";
	$cam_d="-1";
	$cam_r="-1";
	if($dentro==1){
		if($t_rep_e>0){
			$cam_t=$t_rep_e;
		}
		if($d_rep_e>0){
			$cam_d=$d_rep_e;
		}
		if($r_rep_e>0){
			$cam_r=$r_rep_e;
		}
		$minima=$minima_e;
		$maxima=$maxima_e;
	}
	else{
		$cam_t=$t_rep_s;
		$cam_d=$d_rep_s;
		$cam_r=$r_rep_s;
		$minima=$minima_s;
		$maxima=$maxima_s;
	}
	
	//$no_repetir=0;//								&&&&&& TAL VEZ SE CAMBIE ESTA VARIABLE
	if($unavez==0){
		$no_repetir=0;
	}
	else{
		$no_repetir=2147483647;
	}
	$mail='';
	if($correos!=''){
		$mail=$correos;
	}
	//insertamos la accion de "entrar en geocerca"
	$insert="INSERT INTO gpscondicionalerta VALUES(0,'$descrip',$estricto,".$sess->get('Ide').",'".
	date("Y-m-d H:i:s")."','$mail',0,0,$no_repetir,$activo,-1,$cam_t,$cam_d,$cam_r,$maxima)";
	mysql_query($insert);
	//$objResponse->alert(mysql_error());
	$folio=mysql_insert_id();
	
	switch($periodo){
		case 'sem':
			$dias='S:';
				for($x=0;$x<count($T_dias);$x++){
					$dias.=$T_dias[$x];
					if($x<(count($T_dias)-1)){
						$dias.=",";
					}
				}
			break;
		case 'mes':
			$dias='M:';
			list($fechai,$horai)=explode(" ",$inicio);
			list($ai,$mi,$di)=explode("-",$fechai);
			list($fechaf,$horaf)=explode(" ",$fin);
			list($af,$mf,$df)=explode("-",$fechaf);
			for($i=$di;$i<=$df;$i++){
				$dias.=(int)$i;
				if($i<$df){
					$dias.=',';
				}
			}
			break;
		case 'siempre':
			$dias="T";
			break;
	}
	if($inicio!=''){
		$inicio=date("Y-m-d ").$inicio;
	}
	if($fin!=''){
		$fin=date("Y-m-d ").$fin;
	}
	if($inicio==''){
		$inicio=date("Y-m-d ").'00:00:00';
	}
	if($fin==''){
		$fin=date("Y-m-d ").'00:00:00';
	}
	/*
		INSERTAMOS EN LA TABLA gps_config
	*/
	$geocercas='';
	for($j=0;$j<count($T_geo);$j++){
		if($geocercas!=''){
			$geocercas.=";";
		}
		$geocercas.=$T_geo[$j];
	}
	$insert="INSERT INTO gps_config VALUES
	($folio,$minima,$maxima,$dentro,$fuera,'$inicio','$fin','$dias','$geocercas',1,'$gestion')";
	mysql_query($insert);
	//$objResponse->alert($insert);
	/*
		insert en gpscondicionalertadet "comando"
	*/
	for($i=0;$i<count($T_veh);$i++){
		for($j=0;$j<count($T_geo);$j++){
			$insert="INSERT INTO gpscondicionalertadet 
				VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,-1,-1,".$T_geo[$j].",1,0,'$inicio','$fin',$duracion,0,1,
				$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
			mysql_query($insert);
			//$objResponse->alert(mysql_error());
		}
	}
	$folio_M=$folio;
	mysql_query("INSERT INTO gpscondgeocompleja values($folio_M,0,0)");//inserto en la "nueva"
	
	/* 		insertamos la accion de "dentro de geocerca" 	*/
	if($maxima>0 ){
		$insert="INSERT INTO gpscondicionalerta VALUES(0,'$descrip',$estricto,".$sess->get('Ide').",'".
		date("Y-m-d H:i:s")."','$mail',0,0,$no_repetir,$activo,-1,$cam_t,$cam_d,$cam_r,$maxima)";
		mysql_query($insert);
		$folio=mysql_insert_id();
		$folio_D=$folio;
		mysql_query("INSERT INTO gpscondgeocompleja values($folio_M,$folio_D,0)");//inserto en la "nueva"
		//$objResponse->alert($insert);
		for($i=0;$i<count($T_veh);$i++){
			for($j=0;$j<count($T_geo);$j++){
				$insert="INSERT INTO gpscondicionalertadet 
					VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",1,0,'$inicio','$fin',$duracion,0,1,
					$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
				mysql_query($insert);
				//$objResponse->alert($insert);
			}
		}
	}
	
	
	/* PARTE ESPECIAL PARA GEO_REGLAS SALIDA*/
	
	for($i=0;$i<count($T_veh);$i++){
		for($j=0;$j<count($T_geo);$j++){
			$ver=mysql_query("select tpoleo from vehiculos where num_veh=".$T_veh[$i]);
			$t_po=mysql_fetch_array($ver);
			$t_poleo=$t_po[0];
			$cmd_vel="-1";
			if($maxima>0 && $cam_t<0 && $cam_d<0 && $cam_r<0){
				$cmd_vel=0;
				$t_poleo="-1";
			}
			$no_repetir=0;
			$insert="INSERT INTO gpscondicionalerta VALUES(0,'$descrip',$estricto,".$sess->get('Ide').",'".
			date("Y-m-d H:i:s")."','$mail',0,0,$no_repetir,$activo,-1,$t_poleo,-1,-1,$cmd_vel)";
			mysql_query($insert);
			$consecutivo=mysql_insert_id();
			$folio_S=$consecutivo;
			mysql_query("INSERT INTO gpscondgeocompleja values($folio_M,0,$folio_S)");//inserto en la "nueva"
			$insert="INSERT INTO gpscondicionalertadet 
				VALUES(".$consecutivo.",0,".$sess->get("Ide").",".$T_veh[$i].",0,-1,-1,".$T_geo[$j].",0,1,'$inicio','$fin',$duracion,0,1,
				$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
			mysql_query($insert);
			//$objResponse->alert(mysql_error());
		}
	}
	
	if($gestion=='equipo'){
		/*
			enviamos comandos al equipo
			revisamos si el vehiculo cuenta con dicha geocerca
		*/
		$original=$T_geo;
		$retraso=array();
		for($i=0;$i<count($T_veh);$i++){
			/*
				ordenar array
			*/
			$dentro=array();//ya en el equipo y ordenadas
			$query=mysql_query("SELECT index_equipo,num_geo FROM geo_equipo where num_veh=".$T_veh[$i]." and activo=1 ORDER BY index_equipo");
			if(mysql_num_rows($query)>0){
				while($r_d=mysql_fetch_array($query)){
					//if(in_array($r_d[1],$T_geo)){//si en el array tengo existentes, las meto(las geocercas) en orden
						array_push($dentro,$r_d[1]);
					//}
				}
				for($z=0;$z<count($T_geo);$z++){
					if(!in_array($T_geo[$z],$dentro)){//agrego las nuevas
						array_push($dentro,$T_geo[$z]);
					}
				}
				$T_geo=$dentro;//"array ordenado"
				mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$T_veh[$i]);
			}
			else{
				$T_geo=$original;
			}
			//$objResponse->alert($T_geo);
			/*
				comando RESET
			*/
			$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$T_veh[$i]);
			$idsistemas=mysql_fetch_array($sistema);
			$idsistema=$idsistemas[0];
			$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
			$cmd_reset="SETGEOCRESET:".$T_veh[$i].";%s;".$sess->get("Idu");
			mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd_reset','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
			$idRequest=mysql_insert_id();
			$cmd = sprintf($cmd_reset,$idRequest);
			$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));//comando para resetear en caso de "muchas geocercas"
			
			/*
				ordeno si existen en el array
			*/
			$nuevas=join(',',$T_geo);
			$query=mysql_query("SELECT index_equipo,num_geo FROM geo_equipo where num_veh=".$T_veh[$i]."
								and num_geo in($nuevas)
								ORDER BY index_equipo");
			$ordenadas=array();
			while($r_d=mysql_fetch_array($query)){
				array_push($ordenadas,$r_d[1]);
			}
			for($z=0;$z<count($T_geo);$z++){
				if(!in_array($T_geo[$z],$ordenadas)){//agrego las nuevas
					array_push($ordenadas,$T_geo[$z]);
				}
			}
			$T_geo=$ordenadas;
			mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$T_veh[$i]);
			$index=0;
			for($j=0;$j<count($T_geo);$j++){
				$equipo_i=mysql_query("SELECT * FROM geo_equipo where num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." and activo=1");
				if(mysql_num_rows($equipo_i)==0){
					/*
						procedemos a insertar
						seleccionamos el index del equipo
					*/
					//$query=mysql_query("SELECT index_equipo FROM geo_equipo where num_veh=".$T_veh[$i]." and activo=1 ORDER BY index_equipo");
					$index=$j+1;
					while($z_index=mysql_fetch_array($query)){
						if($z==$z_index[0]){
							$z++;
							//$objResponse->alert($z);
						}
						else{
							break;
							//$objResponse->alert("break");
						}
					}
					
					if($z==mysql_num_rows($query)){
						//$index=$z+1;
						//$objResponse->alert("index +1");
					}
					else{
						//$index=$z;
						//$objResponse->alert("index=Z".$z);
					}
					if(mysql_num_rows($query)>0){
						//$index=mysql_num_rows($query);
					}
					/*
						verificamos la "capacidad" maxima del equipo
					*/
					$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$T_veh[$i]);
					$idsistemas=mysql_fetch_array($sistema);
					$idsistema=$idsistemas[0];
					$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
					$maximos=mysql_query("select tipo_equipo from sistemas where id_sistema=".$idsistema);
					$maximosx=mysql_fetch_array($maximos);
					//$objResponse->alert(mysql_error());
					//constantes?!"
					$U1C=50;
					$U1G=50;
					$U1L=50;
					$U1=200;
					$X1=2;
					$X1P=2;
					switch($maximosx[0]){
						case 'U1':
							$maximo=$U1;
							break;
						case 'UCG':
							$maximo=$U1C;
							break;
						case 'UC':
							$maximo=$U1C;
							break;
						case 'UGO':
							$maximo=$U1G;
							break;
						case 'U1L':
							$maximo=$U1L;
							break;
						case 'X1':
							$maximo=$X1;
							break;
						case 'X1P':
							$maximo=$X1P;
							break;
					}
					
					$conteo=mysql_query("SELECT count(*) FROM geo_equipo where num_veh=".$T_veh[$i]." and activo=1");
					$contar=mysql_fetch_array($conteo);
					/*
						si el max id es menor o igual, enviaremos la geocerca al equipo
						
						tambien cuento con el index que es donde se inserta el registro
						
					*/
					
					if(($contar[0]<=$maximo) && ($index<=$maximo)){
						
						/*
							revisamos si existe registro 
						*/
						/*
								// comprobacion para agregar una a una
						$query=mysql_query("select index_equipo from geo_equipo where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]." and activo=0");
						if(mysql_num_rows($query)>0){
							$folios=mysql_fetch_array($query);
							$index=$folios[0];
							mysql_query("UPDATE geo_equipo set activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						}
						else{
							$query="INSERT INTO geo_equipo VALUES(0,".$T_veh[$i].",$index,".$T_geo[$j].",1);";
							mysql_query($query);
						}
						*/
						
						//$index=$j+1;
						$query="INSERT INTO geo_equipo VALUES(0,".$T_veh[$i].",$index,".$T_geo[$j].",1);";
						mysql_query($query);
						
						//$objResponse->alert($query);
						/*
							una vez insertado el registro "individual" procedemos a mandar el registro al equipo
						*/
						
						//enviamos el comando para que se inserte el comando
						//$objResponse->script($equipoGps->inserta_geo_equipo($T_veh[$i],$T_geo[$j],$sess->get("Idu")));
						//numero de geocerca en el equipo
						
						//formamos el comando a enviar al equipo
						$cmd="SETGEO:".$T_veh[$i].";%s;".$sess->get("Idu").";".$index.";";
						/*
							verificamos el tipo de geocerca
						*/
						$tipos=mysql_query("SELECT tipo FROM geo_time where num_geo=".$T_geo[$j]);
						$tipo=mysql_fetch_array($tipos);
						if($tipo[0]==0){// tipo circular
							//obtenemos las coordenadas de la geocerca
							$cord=mysql_query("SELECT latitud,longitud,radioMts FROM geo_time where num_geo=".$T_geo[$j]);
							$coord=mysql_fetch_array($cord);
							// tipo geocerca ;tiempo en segundos; metros
							$tipo_geo=1;
							$cmd.="$tipo_geo;1;1;".$coord[2].";".number_format($coord[0],6,'.','').",".number_format($coord[1],6,'.','');
						}
						else{//poligonales
							$query=mysql_query("SELECT latitud,longitud from geo_puntos where id_geo=".$T_geo[$j]." ORDER BY orden ASC");
							//numero de vertices
							$puntos=mysql_num_rows($query);
							$tipo_geo=2;
							$cmd.="$tipo_geo;1;1;".$puntos.";";
							$x=0;
							while($row=mysql_fetch_array($query)){
								$cmd.=$row[0].','.$row[1];
								if($x<$puntos){
									$cmd.=',';
								}
								$x++;
							}
						}
						mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
						$idRequest=mysql_insert_id();
						//$cmd="GETENLINEA:".$T_veh[$i].";".$idRequest.";".$sess->get("Idu");
						$cmd = sprintf($cmd,$idRequest);
						//$objResponse->alert("Comando: ".$cmd);
						array_push($retraso,$cmd);
						/*
							si hay retraso, comentar la siguiente linea
						*/
						$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
						$leer_reg=mysql_query("SELECT reg from gpscondicionalertadet where folio=$folio_M and num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						$registros=mysql_fetch_array($leer_reg);
						$registro=$registros[0];
						$q_pendientes=mysql_query("select * from gpscond_cmdsxalrt where folio=$folio_M and reg=$registro");
						if(mysql_num_rows($q_pendientes)>0){
							mysql_query("UPDATE gpscond_cmdsxalrt set completado=0,id_notificaweb=$idRequest where folio=$folio_M and reg=$registro)");
						}
						else{
							mysql_query("insert into gpscond_cmdsxalrt (folio,reg,id_notificaweb) values($folio_M,$registro,$idRequest)");
						}
						$equipo_g=mysql_query("SELECT * FROM geo_veh where num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]);
						if(mysql_num_rows($equipo_g)==0){
							mysql_query("INSERT INTO geo_veh VALUES(".$T_veh[$i].",".$T_geo[$j].",0,$dentro,$fuera,'".date("Y-m-d H:i:s")."'
							,".$sess->get("Idu").",0,$activo,1)");
						}
						else{
							mysql_query("UPDATE geo_veh SET activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						}
					}
					else{// SI YA ALCANZO SU LIMITE 
						$objResponse->alert("Su vehiculo solo cuenta con $maximo registros esta geocerca se ejecutara desde el servidor");
					}
				}
				/*else{
					$objResponse->alert("ya existe");
				}*/
			}
			$cmd_save="SETGEOCGUARDA:".$T_veh[$i].";%s;".$sess->get("Idu");
			mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd_save','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
			$idRequest=mysql_insert_id();
			$cmd = sprintf($cmd_save,$idRequest);
			$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
			
		}
	}
	/*
		insertamos en auditabilidad
	*/
	$total=count($retraso);
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',65,
	'Crea configuracion en reglas de geocercas',13,".$sess->get('Ide').",'".get_real_ip()."')");
	$objResponse->assign('geo_progreso',"innerHTML","Guardando... <img src='img2/loader.gif' width='25px'>");
	$objResponse-> alert("Enviando informacion... Espere un momento");
	$sess->set("intentos",0);
	//$objResponse->script("xajax_retraso(".json_encode($retraso).",0,$total)");
	$objResponse->script("xajax_validar_respuesta($idRequest,$folio_M,".json_encode($T_veh).",".json_encode($T_geo).")");
	$objResponse->script("$('#procesando').val(1)");
	return $objResponse;
}
function nueva_regla($T_dias,$T_geo,$T_veh,$inicio,$fin,$minima,$maxima,$descrip,$correos,$dentro,$fuera,$periodo,$activo,$folio,$gestion,$duracion,$estricto){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	/*
		insert en gpscondicionalertadet
	*/
	$query=mysql_query("SELECT * FROM gps_config WHERE folio=$folio");
	$dat=mysql_fetch_array($query);
	$minima=$dat[1];
	$maxima=$dat[2];
	$dentro=$dat[3];
	$fuera=$dat[4];
	$inicio=$dat[5];
	$fin=$dat[6];
	$dias=$dat[7];
	$T_geo=explode(";",$dat[8]);
	$dentro=0;
	$F_D=mysql_query("SELECT folio_dentro FROM gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
	if(mysql_num_rows($F_D)>0){
		$dentro=1;
	}
	$folio_M=$folio;
	$folios=mysql_fetch_array($F_D);
	$folio_D=$folios[0];
	for($i=0;$i<count($T_veh);$i++){
		for($j=0;$j<count($T_geo);$j++){
			//maestro "entra"
			$query="SELECT * FROM gpscondicionalertadet 
			where folio=$folio and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j];
			$rev=mysql_query($query);
			if(mysql_num_rows($rev)==0){
				$insert="INSERT INTO gpscondicionalertadet 
				VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,-1,-1,".$T_geo[$j].",1,0,'$inicio','$fin',$duracion,0,1,
				$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
				mysql_query($insert);
			}
			else{
				$update="UPDATE gpscondicionalertadet set activo=1 
				WHERE folio=$folio and num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]." and enlosdias='$dias'
				and entrageo=1 and salegeo=0 and vel_min=-1 and vel_max=-1 and cualquierpos=-1";
				mysql_query($update);
			}
			if($dentro==1){//insertare "dentro"	
				$ver=mysql_query("SELECT * FROM gpscondicionalertadet 
				where folio=$folio_D and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]);
				if(mysql_num_rows($ver)==0){
					$insert="INSERT INTO gpscondicionalertadet 
						VALUES($folio_D,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",1,0,'$inicio','$fin',$duracion,0,1,
						$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
					mysql_query($insert);
				}
				else{
					mysql_query("UPDATE 
					gpscondicionalertadet set activo=1 where 
					folio=$folio_D and num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
				}
			}
			//maestro "fuera"
			$ver=mysql_query("select tpoleo from vehiculos where num_veh=".$T_veh[$i]);
			$t_po=mysql_fetch_array($ver);
			$t_poleo=$t_po[0];
			$cmd_vel="-1";
			if($maxima>0 && $cam_t<0 && $cam_d<0 && $cam_r<0){
				$cmd_vel=0;
				$t_poleo="-1";
			}
			$no_repetir=0;
			$ver=mysql_query("SELECT d.folio from gpscondicionalertadet d
			inner join gpscondgeocompleja o on d.folio=o.folio_fuera
			where d.num_veh=".$T_veh[$i]." and d.num_geo=".$T_geo[$j]."
			and o.folio_entgeo=$folio_M");
			if(mysql_num_rows($ver)==0){
				$insert="INSERT INTO gpscondicionalerta VALUES(0,'$descrip',$estricto,".$sess->get('Ide').",'".
				date("Y-m-d H:i:s")."','$correos',0,0,$no_repetir,$activo,-1,$t_poleo,-1,-1,$cmd_vel)";
				mysql_query($insert);
				$consecutivo=mysql_insert_id();
				$folio_S=$consecutivo;
				mysql_query("INSERT INTO gpscondgeocompleja values($folio_M,0,$folio_S)");//inserto en la "nueva"
				$insert="INSERT INTO gpscondicionalertadet 
					VALUES(".$consecutivo.",0,".$sess->get("Ide").",".$T_veh[$i].",0,-1,-1,".$T_geo[$j].",0,1,'$inicio','$fin',$duracion,0,1,
					$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0);";
				mysql_query($insert);
			}
			else{
				$fol=mysql_fetch_array($ver);
				mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=".$fol[0]);
				mysql_query("UPDATE gpscondicionalerta set activo=1 where folio=".$fol[0]);
			}
		}
	}
	if($gestion=='equipo'){
		/*
			enviamos comandos al equipo
			revisamos si el vehiculo cuenta con dicha geocerca
		*/
		$original=$T_geo;
		$retraso=array();
		for($i=0;$i<count($T_veh);$i++){
			/*
				ordenar array
			*/
			$dentro=array();//ya en el equipo y ordenadas
			$query=mysql_query("SELECT index_equipo,num_geo FROM geo_equipo where num_veh=".$T_veh[$i]." and activo=1 ORDER BY index_equipo");
			if(mysql_num_rows($query)>0){
				while($r_d=mysql_fetch_array($query)){
					//if(in_array($r_d[1],$T_geo)){//si en el array tengo existentes, las meto(las geocercas) en orden
						array_push($dentro,$r_d[1]);
					//}
				}
				for($z=0;$z<count($T_geo);$z++){
					if(!in_array($T_geo[$z],$dentro)){//agrego las nuevas
						array_push($dentro,$T_geo[$z]);
					}
				}
				$T_geo=$dentro;//"array ordenado"
				mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$T_veh[$i]);
			}
			else{
				$T_geo=$original;
			}
			//$objResponse->alert($T_geo);
			/*
				comando RESET
			*/
			$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$T_veh[$i]);
			$idsistemas=mysql_fetch_array($sistema);
			$idsistema=$idsistemas[0];
			$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
			$cmd_reset="SETGEOCRESET:".$T_veh[$i].";%s;".$sess->get("Idu");
			mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd_reset','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
			$idRequest=mysql_insert_id();
			$cmd = sprintf($cmd_reset,$idRequest);
			$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));//comando para resetear en caso de "muchas geocercas"
			
			/*
				ordeno si existen en el array
			*/
			$nuevas=join(',',$T_geo);
			$query=mysql_query("SELECT index_equipo,num_geo FROM geo_equipo where num_veh=".$T_veh[$i]."
								and num_geo in($nuevas)
								ORDER BY index_equipo");
			$ordenadas=array();
			while($r_d=mysql_fetch_array($query)){
				array_push($ordenadas,$r_d[1]);
			}
			for($z=0;$z<count($T_geo);$z++){
				if(!in_array($T_geo[$z],$ordenadas)){//agrego las nuevas
					array_push($ordenadas,$T_geo[$z]);
				}
			}
			$T_geo=$ordenadas;
			mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$T_veh[$i]);
			$index=0;
			for($j=0;$j<count($T_geo);$j++){
				$equipo_i=mysql_query("SELECT * FROM geo_equipo where num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." and activo=1");
				if(mysql_num_rows($equipo_i)==0){
					/*
						procedemos a insertar
						seleccionamos el index del equipo
					*/
					$query=mysql_query("SELECT distinct(index_equipo) FROM geo_equipo where num_veh=".$T_veh[$i]." ORDER BY index_equipo");
					$index=$index+1;
					/*if(mysql_num_rows($query)>0){
						$index=mysql_num_rows($query);
					}*/
					
					/*$z=1;
					while($z_index=mysql_fetch_array($query)){
						if($z==$z_index[0]){
							$z++;
						}
						else{
							break;
						}
					}
					
					if($z==mysql_num_rows($query)){
						$index=$z+1;
					}
					else{
						$index=$z;
					}*/
					/*
						verificamos la "capacidad" maxima del equipo
					*/
					
					$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$T_veh[$i]);
					$idsistemas=mysql_fetch_array($sistema);
					$idsistema=$idsistemas[0];
					$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
					$maximos=mysql_query("select tipo_equipo from sistemas where id_sistema=".$idsistema);
					$maximosx=mysql_fetch_array($maximos);
					//constantes?!"
					$U1C=50;
					$U1G=50;
					$U1L=50;
					$U1=200;
					$X1=2;
					$X1P=2;
					switch($maximosx[0]){
						case 'U1':
							$maximo=$U1;
							break;
						case 'UCG':
							$maximo=$U1C;
							break;
						case 'UC':
							$maximo=$U1C;
							break;
						case 'UGO':
							$maximo=$U1G;
							break;
						case 'U1L':
							$maximo=$U1L;
							break;
						case 'X1':
							$maximo=$X1;
							break;
						case 'X1P':
							$maximo=$X1P;
							break;
					}
					
					$conteo=mysql_query("SELECT count(*) FROM geo_equipo where num_veh=".$T_veh[$i]." and activo=1");
					$contar=mysql_fetch_array($conteo);
					/*
						si el max id es menor o igual, enviaremos la geocerca al equipo
						
						tambien cuento con el index que es donde se inserta el registro
						
					*/
					
					if(($contar[0]<=$maximo) && (($j+1)<=$maximo)){
						/*
							revisamos si existe registro 
						*/
						/*$query=mysql_query("select index_equipo from geo_equipo where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						if(mysql_num_rows($query)>0){
							$folios=mysql_fetch_array($query);
							$index=$folios[0];
							mysql_query("UPDATE geo_equipo set activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
							//$objResponse->alert(mysql_error());
						}
						else{*/
							//$objResponse->alert($index);
							$query="INSERT INTO geo_equipo VALUES(0,".$T_veh[$i].",".$index.",".$T_geo[$j].",1);";
							mysql_query($query);
						//}
						//$objResponse->alert($query);
						/*
							una vez insertado el registro "individual" procedemos a mandar el registro al equipo
						*/
						
						//enviamos el comando para que se inserte el comando
						//$objResponse->script($equipoGps->inserta_geo_equipo($T_veh[$i],$T_geo[$j],$sess->get("Idu")));
						//numero de geocerca en el equipo
						
						//formamos el comando a enviar al equipo
						$cmd="SETGEO:".$T_veh[$i].";%s;".$sess->get("Idu").";".$index.";";
						/*
							verificamos el tipo de geocerca
						*/
						$tipos=mysql_query("SELECT tipo FROM geo_time where num_geo=".$T_geo[$j]);
						$tipo=mysql_fetch_array($tipos);
						if($tipo[0]==0){// tipo circular
							//obtenemos las coordenadas de la geocerca
							$cord=mysql_query("SELECT latitud,longitud,radioMts FROM geo_time where num_geo=".$T_geo[$j]);
							$coord=mysql_fetch_array($cord);
							// tipo geocerca ;tiempo en segundos; metros
							$tipo_geo=1;
							$cmd.="$tipo_geo;1;1;".$coord[2].";".number_format($coord[0],6,'.','').",".number_format($coord[1],6,'.','');
						}
						else{
							$query=mysql_query("SELECT latitud,longitud from geo_puntos where id_geo=".$T_geo[$j]." ORDER BY orden ASC");
							//numero de vertices
							$puntos=mysql_num_rows($query);
							$tipo_geo=2;
							$cmd.="$tipo_geo;1;1;".$puntos.";";
							$x=0;
							while($row=mysql_fetch_array($query)){
								$cmd.=$row[0].','.$row[1];
								if($x<$puntos){
									$cmd.=',';
								}
								$x++;
							}
						}
						mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
						$idRequest=mysql_insert_id();
						//$cmd="GETENLINEA:".$T_veh[$i].";".$idRequest.";".$sess->get("Idu");
						$cmd = sprintf($cmd,$idRequest);
						//$objResponse->alert("Comando: ".$cmd);
						array_push($retraso,$cmd);
						/*
							guardar geocerca
						*/
						$leer_reg=mysql_query("SELECT reg from gpscondicionalertadet where folio=$folio_M and num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						$registros=mysql_fetch_array($leer_reg);
						$registro=$registros[0];
						$q_pendientes=mysql_query("select * from gpscond_cmdsxalrt where folio=$folio_M and reg=$registro");
						if(mysql_num_rows($q_pendientes)>0){
							mysql_query("UPDATE gpscond_cmdsxalrt set completado=0,id_notificaweb=$idRequest where folio=$folio_M and reg=$registro");
						}
						else{
							mysql_query("insert into gpscond_cmdsxalrt (folio,reg,id_notificaweb) values($folio_M,$registro,$idRequest)");
						}
						
						/* 
							si hay retraso comentar la siguiente linea
						*/
						$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
						
						$equipo_g=mysql_query("SELECT * FROM geo_veh where num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]);
						if(mysql_num_rows($equipo_g)==0){
							mysql_query("INSERT INTO geo_veh VALUES(".$T_veh[$i].",".$T_geo[$j].",0,$dentro,$fuera,'
							".date("Y-m-d H:i:s")."',".$sess->get("Idu").",0,$activo,1)");
						}
						else{
							mysql_query("UPDATE geo_veh set activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
						}
					}
					else{// SI YA ALCANZO SU LIMITE 
						$objResponse->alert("Su vehiculo solo cuenta con $maximo registros esta geocerca se ejecutara desde el servidor");
					}
				}
			}
			/*
							guardar geocerca
			*/
			$cmd_save="SETGEOCGUARDA:".$T_veh[$i].";%s;".$sess->get("Idu");
			mysql_query("insert into notificaweb(id,num_veh,cmd,solicito,id_usuario,origen,respuesta) values(0,".$T_veh[$i].",'$cmd_save','".date("Y-m-d G:i:s")."',".$sess->get("Idu").",'EGW','')");		
			$idRequest=mysql_insert_id();
			$cmd = sprintf($cmd_save,$idRequest);
			$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
		}
	}
	$total=count($retraso);
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',55,
	'Asigna vehiculo a regla en geocercas online',13,".$sess->get('Ide').",'".get_real_ip()."')");
	$objResponse-> alert("Enviando informacion... Espere un momento");
	$objResponse->assign('geo_progreso',"innerHTML","Guardando... <img src='img2/loader.gif' width='25px'>");
	$sess->set("intentos",0);
	//$objResponse->script("xajax_retraso(".json_encode($retraso).",0,$total)");
	$objResponse->script("xajax_validar_respuesta($idRequest,$folio_M,".json_encode($T_veh).",".json_encode($T_geo).")");
	$objResponse->script("$('#procesando').val(1)");
	return $objResponse;
}
function validar_respuesta($idRequest,$folio_M,$T_veh,$T_geo){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options ); 
	$n_geo=count($T_geo)*120;
	$intentos=$n_geo;
	$actual=$sess->get("intentos");

	//$objResponse->alert("actual: ".$actual." intentos: ".$intentos);
	//$objResponse->alert($idRequest);
	$query=mysql_query("SELECT respuesta,cmd from notificaweb where id=".$idRequest);
	$resp=mysql_fetch_array($query);
	if(preg_match("/NO RESPONDIO/i",$resp[0])){
		$objResponse->alert("Se produjo un error al comunicarse con el equipo... agregue los vehiculos a la regla");
		/*
			desactivo los vehiculos de la regla
		*/
		//salida->M
		//fol->det
		//dentro->det
		//borro de la "ENTRADA"
		$geo=array();
		for($i=0;$i<count($T_veh);$i++){
			mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio_M and num_veh=".$T_veh[$i]);
		}
		$dentro_f=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio_M and folio_dentro>0");
		if(mysql_num_rows($dentro_f)>0){
			$fol_d=mysql_fetch_array($dentro_f);
			for($i=0;$i<count($T_veh);$i++){
				mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$fol_d[0] and num_veh=".$T_veh[$i]);
			}
		}
		//salidas
		$salida_f=mysql_query("SELECT folio_fuera from gpscondgeocompleja where folio_entgeo=$folio_M and folio_fuera>0");
		while($f_s=mysql_fetch_array($salida_f)){
			for($i=0;$i<count($T_veh);$i++){
				$ver=mysql_query("SELECT folio from gpscondicionalertadet where folio=$f_s[0] and num_veh=".$T_veh[$i]." and salegeo=1");
				if(mysql_num_rows($ver)>0){
					mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$f_s[0] and num_veh=".$T_veh[$i]." and salegeo=1");
					mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$f_s[0]");
				}
			}
		}
		/*
			desasigno las geocercas
		*/
		for($i=0;$i<count($T_veh);$i++){
			for($j=0;$j<count($T_geo);$j++){
				mysql_query("UPDATE geo_equipo set activo=0 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
				mysql_query("UPDATE geo_veh set activo=0 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
			}
		}
		$objResponse-> redirect("reg_geo.php");
	}
	if(preg_match("/SAVE/i",$resp[0])){
		$objResponse->alert("Se guardo su configuracion correctamente");
		$objResponse-> redirect("reg_geo.php");
	}
	else{
		if(preg_match("/SETGEOCGUARDA/i",$resp[1])){
			if(preg_match("/OK:GF/i",$resp[0])){
				$objResponse->alert("Se guardo su configuracion correctamente");
				$objResponse-> redirect("reg_geo.php");
			}
			else{
				$objResponse->script("setTimeout('xajax_validar_respuesta($idRequest,$folio_M,".json_encode($T_veh).",".json_encode($T_geo).")',1000)");
				$total=count($T_geo);
				$objResponse->assign('geo_progreso',"innerHTML","Guardando... <img src='img2/loader.gif' width='25px'>");
			}
		}
		else{
			$sess->set("intentos",$actual+1);
			if($sess->get("intentos")>$intentos){
				$objResponse->alert("Se produjo un error, vuelva a intentar");
				$objResponse->assign('geo_progreso',"innerHTML","");
				$objResponse->redirect("reg_geo.php");
			}
			else{
				$objResponse->script("setTimeout('xajax_validar_respuesta($idRequest,$folio_M,".json_encode($T_veh).",".json_encode($T_geo).")',1000)");
				$objResponse->assign('geo_progreso',"innerHTML","Guardando... <img src='img2/loader.gif' width='25px'>");
			}
		}
	}
	return $objResponse;
}

function retraso($retraso,$i,$total){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	if($i<$total){
		$data=explode(";",$retraso[$i]);
		list($setgeo,$num_veh)=explode(":",$data[0]);
		$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$num_veh);
		//$objResponse->alert($retraso[$i]);
		$idsistemas=mysql_fetch_array($sistema);
		$idsistema=$idsistemas[0];
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
		$objResponse->script($equipoGps->sendCMDtoEGServer($retraso[$i]));
		//$objResponse->alert("Total: ".$total." array_pos: ".$i);
		$siguiente=$i+1;
		$objResponse->script("progreso($total,$siguiente);");
		if($siguiente<$total){
			$objResponse->script("setTimeout('xajax_retraso(".json_encode($retraso).",$siguiente,$total)',120000)");	//2 minutos -> 120000
			//$objResponse->script("nC('checkbox#idVeh [value=\"$num_veh\"]').attr('disabled', 'disabled');");//bloqueo el vehiculo
		}
	}
	else{
		$objResponse->alert("Proceso Terminado");
		$objResponse->assign('geo_progreso',"innerHTML","Proceso Terminado");
		//$objResponse->script("nC('checkbox#idVeh [value=\"$num_veh\"]').removeAttr('disabled');");//desbloqueo el vehiculo
	}
	return $objResponse;
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query="select v.id_veh,v.num_veh,v.id_sistema,v.VEH_X1
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on (v.estatus = ev.estatus)
			inner join sistemas as S ON v.id_sistema=S.id_sistema
			where vu.id_usuario = $idu 
			AND exists(
				SELECT * FROM equipos_configurables AS EC
				INNER JOIN secciones_configurables AS SC on EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo=EC.id_tipo_equipo
				AND EC.activo=1
				AND SC.seccion='georeglas' 
			)
			AND ev.publicapos=1
			AND vu.activo=1
			order by v.id_veh asc";
	//$objResponse->alert($query);		
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th style='font-size:14px;width:150px;'>Vehículos</th>
				<th><input type='checkbox' id='all_veh' onclick='check_All_veh()'></th>
			</tr>";
			$i=0;
	$int="";
	if(mysql_num_rows($rows)==1){
		$int=1;
	}
	while($row=mysql_fetch_array($rows)){
	if(preg_match("/axps/i",$row[3])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($row[2]);
	}

	//$equipoGps->setNumVeh($row[1]);
	//$equipoGps->createJsonFromDB();
	//$objResponse->alert($row[2]);
	//$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	//$objResponse->alert($row[1]);
	//$objResponse->script($equipoGps->callTimerInitGEO($idu,$row[1]));
		$cont.="<tr>
					<td colspan='2'><input type='checkbox' class='Classveh' onclick='contar$int()' id='idVeh' name='Veh".$i."' value='".$row[1]."'>"
					.$row[0]."<div id='online".$row[1]."' style='width:10px;display:inline;float:right;'></div>
					</td>
				</tr>
		";
		$i++;
	}
	$cont.= "</table>";	
		
	$objResponse->assign("vehiculos_config_geo","innerHTML",$cont);
return $objResponse;
}
function ver_geocercas($id_geo,$veh,$tipo){	
	unset($todos_vehiculos);
	$todos_vehiculos=$veh;
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$sess->set('f_ini',$ini);
	$sess->set('f_fin','');
	$sess->set('max','');
	$sess->set('min','');
	$sess->set('activo','');
	$sess->set('sem','');
	$sess->set('mes','');
	$sess->set('dentro','');
	$sess->set('fuera','');
	$sess->set('desc','');
	$sess->set('mail','');
	$sess->set('dias','');
	$sess->set('folio','');
	$sess->set('V_guardados','');
	//$objResponse->alert($veh." veh");
	for($i=0;$i<count($id_geo);$i++){
		if(count($id_geo)==1){
			//$id=explode(",",$id_geo);
			//$id_geo_gen=$id[0];
			$id_geo_gen=$id_geo;
			$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.nombre
			from geo_time g 
			where g.num_geo=$id_geo_gen and g.activo=1";
			//$objResponse->alert($cad_geo);
		}
		else{
			$id_geo_gen=$id_geo[$i];
			$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.nombre
			from geo_time g 
			where g.num_geo=$id_geo_gen and g.activo=1";
			//$objResponse->alert($cad_geo);
		}	
		$res_geo = mysql_query($cad_geo);
		if(mysql_error()){
			$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.nombre
			from geo_time g 
			where g.num_geo=$id_geo[$i] and g.activo=1";
			$res_geo = mysql_query($cad_geo);
		}
		//$objResponse->alert($cad_geo);
		$num_geo = mysql_num_rows($res_geo);
		if($num_geo == 1){
			$row = mysql_fetch_row($res_geo);
			$radio = $row[2];
			$objResponse->call("mostrar_circular",$row[0],$row[1],$row[2],$row[3]);
			//$objResponse->alert("circular");
		}
		if($num_geo > 1 ){
			$i=0;
			 $arregloLatitud=array(); $arregloLongitud=array();
			$nombre="";
			while($row = mysql_fetch_row($res_geo)){
				array_push($arregloLatitud,$row[4]);
				array_push($arregloLongitud,$row[5]);
				if($i==$num_geo-1) $nombre=$row[7];
				$i++;
			}
			$objResponse->call("mostrar_poligonal",$arregloLatitud,$arregloLongitud,$nombre);
		}
	}
			if(!empty($veh)){
				$ids = join(',',$veh);
				//$busq="";
				$busq="AND (GPS_DET.num_veh IN (".$ids.") OR GPS_DET.num_veh NOT IN (".$ids."))";
				//$busq="AND (GPS_DET.num_veh NOT IN (".$ids."))";
			}
			else{
				$busq="";
			}
	for($i=0;$i<count($id_geo);$i++){
		if(count($id_geo)==1){
			$id=explode(",",$id_geo);
			$id_geo_gen=$id[0];
		}
		else{
			$id_geo_gen=$id_geo[$i];
		}
		$query_chec="SELECT GPS_DET.num_veh,GPS_DET.enlosdias,GPS_DET.horaini,GPS_DET.horafin,GPS_DET.vel_max,GPS_DET.vel_min,GPS.activo,
			GPS_DET.entrageo,GPS_DET.salegeo,GPS.descripcion,GPS.enviaremail,GPS.folio
			FROM gpscondicionalertadet AS GPS_DET
			INNER JOIN gpscondicionalerta AS GPS ON GPS_DET.folio=GPS.folio
			WHERE GPS.id_empresa=$ide 
			AND GPS_DET.num_geo=".$id_geo_gen."
			AND (GPS_DET.horaini <= NOW() OR GPS_DET.horaini = '0000-00-00 00:00:00' 
				AND GPS_DET.horafin >= NOW() OR GPS_DET.horafin = '0000-00-00 00:00:00' )
			$busq";
		$rows=mysql_query($query_chec);
		if(mysql_num_rows($rows)>0){
			while($row=mysql_fetch_array($rows)){
				/*if(in_array($row[0],$todos_vehiculos)){	
				}
				else{
					$todos_vehiculos[]=$row[0];
					$V_guardados[]=$row[0];
					$sess->set('V_guardados',$V_guardados);
				}*/
				$D_M_S=$row[1];
				/* procesamos la informacion del campo "enlosdias"	*/
				if($D_M_S=='T'){
					$semana=1;
					$mes=1;
					$dias="1,2,3,4,5,6,7";
				}
				else{
					list($M_S,$dias)=explode(':',$row[1]);
					if($M_S=='S'){
						$semana=1;
						$mes=0;
					}
					else{
						$semana=0;
						$mes=1;
					}
				}
				$ini=$row[2];
				$fin=$row[3];
				$max=$row[4];
				$min=$row[5];
				$activo=$row[6];
				$dentro=$row[7];
				$fuera=$row[8];
				$desc=$row[9];
				$mail=$row[10];
				if($row[11]!=''){
					if(in_array($row[11],$folio)){
					}
					else{
						$folio[]=$row[11];
					}
				}
				$folioX=$row[11];
				$sess->set('f_ini',$ini);
				$sess->set('f_fin',$fin);
				$sess->set('max',$max);
				$sess->set('min',$min);
				$sess->set('activo',$activo);
				$sess->set('sem',$semana);
				$sess->set('mes',$mes);
				$sess->set('dentro',$dentro);
				$sess->set('fuera',$fuera);
				$sess->set('desc',$desc);
				$sess->set('mail',$mail);
				$sess->set('dias',$dias);
				$sess->set('folio',$folio);
				//$objResponse->alert($activo);
			}
		}
	}
	$q_folios=mysql_query("select DISTINCT(m.folio) from gpscondgeocompleja c
							inner join gpscondicionalerta m on c.folio_entgeo=m.folio
							where id_empresa=".$sess->get('Ide')." 
							order by m.folio");
	$x_fol=array();
	while($q_c=mysql_fetch_array($q_folios)){
		array_push($x_fol,$q_c[0]);
	}
	$id_fols = join(',',$x_fol);
	$cond="";
	$query=mysql_query("SELECT gps.folio,gps.descripcion 
	FROM gpscondicionalerta gps 
	inner join gps_config config on gps.folio=config.folio
	where gps.id_empresa=".$sess->get('Ide')." 
	and gps.activo=1 
	and config.num_geo>0
	and config.gestion='equipo'
	/*group by gps.descripcion*/
	and gps.folio in($id_fols)
	order by gps.descripcion");
	if(mysql_num_rows($query)>0){
		$cond.="
			<div id='geo_datos' >
				<table id='newspaper-a1' style='width:180px;'>
					<tr>
						<th colspan='3'>Mis configuraciones</th>
					</tr>
		";
		while($row=mysql_fetch_array($query)){
			if($folioX==$row[0]){
				$checked='';
			}
			else{
				$checked='';
			}
			$cond.="
				<tr>
					<td width='10px'><input type='radio' name='config' onclick='xajax_config_folio(".$row[0].");setTimeout(\"check_online2(".$row[0].")\",1000);' ".$checked."></td>
					<td>".$row[1]."</td>
					<td id='borrar_f_".$row[0]."'><img src='img/ico_delete.png' title='Borrar configuracion' onclick='xajax_borrar_folio(".$row[0].")'></td>
				</tr>
			";
		}
		$cond.="	
			</table>
		</div>";
	}
	else{
		$cond.="
			<div id='geo_datos'>
				<table id='newspaper-a1' style='width:200px;'>
					<tr>
						<th colspan='2'>Mis configuraciones</th>
					</tr>
					<tr>
						<td colspan='2'>Aun no tiene ninguna configuraci&oacute;n</td>
					</tr>
				</table>
			</div>
			";
	}
	$cond.="
		<div id='semana_hora'>
			<table id='newspaper-a1'>
				<tr>
					<th>
						Horarios
					</th>
				</tr>
				<tr>
					<td>
						Hora de Inicio:<br>
						<input type='text' id='inicio' style='position: relative; z-index: 100;' readonly='readonly' size='13'/>
					</td>
				</tr>
				<tr>
					<td>
						Hora de Fin:<br>
						<input type='text' id='fin' style='position: relative; z-index: 100;' readonly='readonly' size='13'/>
					</td>
				</tr>
				<tr>
					<td>
						Tiempo (minutos):<br>
						<input type='text' size='13' id='tiempo_regla'>
					</td>
				</tr>
			</table>
		</div>
	";
	for($i=0;$i<count($veh);$i++){
		if(in_array($veh[$i],$todos_vehiculos)){
		}
		else{
			$todos_vehiculos[]=$veh[$i];
		}
	}
	//$objResponse->alert($query_chec);							//************************alert query
	if(count($todos_vehiculos)>1){
		$plural="s";
	}
	else{
		$plural='';
	}
	$cond.="<div id='agr_veh'>
	<table id='newspaper-a1' width='160px'>
		<tr>
			<th>Veh&iacute;culo$plural</th>
		</tr>";
	$sess->set('todos_vehiculos',$todos_vehiculos);
	$T_V=$sess->get('todos_vehiculos');
	$T_G=$sess->get('V_guardados');
	for($w=0;$w<count($T_V);$w++){
		$query2="SELECT V.id_veh FROM vehiculos AS V
			WHERE V.num_veh=".$T_V[$w];
		$rows=mysql_query($query2);
		$row=mysql_fetch_array($rows);
		$id_folio = join(',',$sess->get('folio'));
		$query_ver="SELECT GPS_DET.num_veh,GPS_DET.num_geo
			FROM gpscondicionalertadet AS GPS_DET
			WHERE GPS_DET.num_veh=".$T_V[$w]."
			AND GPS_DET.folio IN ($id_folio)";
		//$objResponse->alert($query_ver);	
		$qver=mysql_query($query_ver);
		if(mysql_num_rows($qver)>0){
			$xd=mysql_fetch_array($qver);
			/*
			$guardado="<img title='Regla Asignada' src='img2/delete.png' width='15px' style='float:right;cursor:pointer;' 
			onclick='borrar(".json_encode($folio).",".$T_V[$w].",".$xd[1].")'>";
			*/
			$guardado="";
		}
		else{
			$guardado='';
		}
		$cond.="
			<tr>
				<td>".$row[0]." $guardado </td>
			</tr>
		";
	}
	//$objResponse->assign("contenido_geo","innerHTML",$query_chec);
	$cond.="</table></div>";
	$cond.="<div id='geo_boton_server' align='left'>
				<input type='button' value='Crear nueva configuraci&oacute;n' class='guardar1' onclick='nuevo_geo();' >
			</div>";
	$cond.="
	<div id='geo_descripcion'>
		<table id='newspaper-a1' width='305px'>
			<tr>
				<th colspan='2'  align='center'>Dias de la semana</th>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='checkbox' id='dias' name='dias2' value='2' checked>Lu&nbsp;				 
					<input type='checkbox' id='dias' name='dias3' value='3' checked>Ma&nbsp;				 
					<input type='checkbox' id='dias' name='dias4' value='4' checked>Mi&nbsp;				 
					<input type='checkbox' id='dias' name='dias5' value='5' checked>Ju&nbsp;			
					<input type='checkbox' id='dias' name='dias6' value='6' checked>Vi&nbsp;				
					<input type='checkbox' id='dias' name='dias7' value='7' checked>Sa&nbsp;				 
					<input type='checkbox' id='dias' name='dias1' value='1' checked>Do
				</td>
			</tr>
				<input type='hidden' id='equipo' name='gestion'>
				<input type='hidden' id='sem' name='periodo'>
			<tr>
				<td colspan='2'>
					Descripci&oacute;n:<input type='text' id='descripcion' size='36'>
				</td>
			</tr>
			<tr>
				<td colspan='1' id='checar_correos'>
					<input type='radio' id='enviar_correos' onclick='xajax_mostrar_correos(0)' />Correos
				</td>
				<td>
					<input type='checkbox' id='una_vez' />Avisa una vez
				</td>
			</tr>
			<tr>
				<td colspan='2' align='left' id='mostrar_correos'></td>
			</tr>
		</table>
	</div>";
	$objResponse->script("setTimeout('calendario(\"inicio\")',100)");
	$objResponse->script("setTimeout('calendario(\"fin\")',500)");
	$objResponse->assign("contenido_geo_asignadas","innerHTML",$cond);
	$objResponse->assign("reglas","innerHTML",'');
	$objResponse->script("xajax_opciones()");
	$objResponse->script("setTimeout(function(){entrasale()},1500)");
return $objResponse;
}
function config_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query_chec="SELECT activo,descripcion,
			enviaremail,folio,cambiareptiempo,norepetirhasta
			cambiarepdistancia,cambiareprumbo
			FROM gpscondicionalerta 
			WHERE id_empresa=".$sess->get('Ide')."
			AND folio=$folio 
			and activo=1";
	$datos=mysql_query($query_chec);
	//$objResponse->alert(mysql_error());
	$dat=mysql_fetch_array($datos);
	$q_dura=mysql_query("select duracion from gpscondicionalertadet where folio=$folio limit 1");
	$duraciones=mysql_fetch_array($q_dura);
	$duracion=$duraciones[0];
	/*
		mostraremos la "configuracion" de los parametros de la tabla gps_config
	*/
	/*
		buscamos en el folio de "dentro" para los correos
	*/
	/*
	$query_d=mysql_query("SELECT folio_dentro from gpscondgeocompleja where folio_entgeo=$folio and folio_dentro>0");
	$q_d=mysql_fetch_array($query_d);
	$l_mail=mysql_query("select enviaremail from gpscondicionalerta where folio=".$q_d[0]);
	$l_m=mysql_fetch_array($l_mail);
	$correo=str_replace(";",'\n',$l_m[0]);
	*/
	$correo=str_replace(";",'\n',$dat[2]);
	$query=mysql_query("SELECT * FROM gps_config where folio=$folio");
	$dat2=mysql_fetch_array($query);
	list($fi,$ini)=explode(" ",$dat2[5]);
	list($ff,$fin)=explode(" ",$dat2[6]);
	list($x,$dias)=explode(":",$dat2[7]);
	$d2=str_replace(",","",$dias);
	$unavez=0;
	if($dat[5]=='2147483647'){
		$unavez=1;
	}
	$objResponse->script("mostrar_actuales_config('".$dat[0]."','".$dat[1]."','".$correo."',".$dat[3].",".$dat2[1].",".$dat2[2].",
	".$dat2[3].",".$dat2[4].",'".$ini."','".$fin."','".$d2."',".$dat[4].",".$dat[5].",".$dat[6].",".$duracion.",".$unavez.")");
	$geo_cerca=explode(";",$dat2[8]);
	$objResponse->script("mostrar_geo_sel(".json_encode($geo_cerca).")");
	$query_g=mysql_query("SELECT * FROM gpscondicionalertadet where folio=$folio and activo=1 order by reg asc");
	$reglas="
		<table id='newspaper-a1' width='845px;'>
			<tr>
				<th>Veh&iacute;culos</th>
				<th>MsjxClave</th>
				<th>Geo</th>
				<th>Vel</th>
				<th>Periodo</th>
				<th>Horario</th>
				<th></th>
			</tr>
		";
	while($row=mysql_fetch_array($query_g)){
		$vehiculo='';
		$msjxclave='';
		$geo='';
		$min='';
		$periodo='';
		$horario='';
		$num_veh=$row[3];
		$query=mysql_query("SELECT id_veh from vehiculos where num_veh=".$row[3]);
		$vehiculos=mysql_fetch_array($query);
		$vehiculo=$vehiculos[0];
		if($row[4]!=''){
			$query=mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje=".$row[4]." and id_empresa=".$sess->get('Ide'));
			if(mysql_num_rows($query)==0){
				$query=mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje=".$row[4]." and id_empresa=15");
				$mensaje=mysql_fetch_array($query);
				$msjxclave=$mensaje[0];
			}
			else{
				$mensaje=mysql_fetch_array($query);
				$msjxclave=$mensaje[0];
			}
		}
		else{
			$msjxclave='-';
		}
		if($row[7]!=0){
			$query=mysql_query("SELECT nombre FROM geo_time where id_empresa=".$sess->get('Ide')." and activo=1 AND num_geo=".$row[7]);
			$nombre=mysql_fetch_array($query);
			$geo=$nombre[0];
		}
		if($row[5]=="-1" || $row[6]=="-1"){
			if($row[5]=="-1" && $row[6]=="-1"){
				$min="N/A";
			}
			if($row[5]=="-1" && $row[6]!="-1"){
				$min="Max de ".$row[6];
			}
			if($row[5]!="-1" && $row[6]=="-1"){
				$min="Min de ".$row[5];
			}
		}
		if($row[5]==0 && $row[6]==5){
			$min="Detenido";
		}
		if($row[5]>0 && $row[6]>0){
			$min=$row[5]." - ".$row[6];
		}
		if(preg_match('/T/i',$row[16])){
			$periodo='Siempre';
		}
		if(preg_match('/S/i',$row[16])){
			list($a,$dias)=explode(":",$row[16]);
			$dia=explode(",",$dias);
			$title='';
			for($i=0;$i<count($dia);$i++){
				switch($dia[$i]){
					case '1':$title.="Domingo";break;
					case '2':$title.="Lunes";break;
					case '3':$title.="Martes";break;
					case '4':$title.="Miercoles";break;
					case '5':$title.="Jueves";break;
					case '6':$title.="Viernes";break;
					case '7':$title.="Sabado";break;
				}
				if($i<count($dia)-1){
					$title.=",";
				}
			}
			$periodo="<span title='En los dias: ".$title."'>Semanal</span>";
		}
		if(preg_match('/M/i',$row[16])){
			list($a,$dias)=explode(":",$row[16]);
			$dia=explode(",",$dias);
			$title='';
			for($i=0;$i<count($dia);$i++){
				$title.=$dia[$i];
				if($i<count($dia)-1){
					$title.=",";
				}
			}
			$periodo="<span title='En los dias: ".$title."'>Por Mes</span>";
		}
		if($row[10]=='0000-00-00 00:00:00' && $row[11]=='0000-00-00 00:00:00'){
			$horario="N/A";
		}
		else{
			list($fechai,$horai)=explode(" ",$row[10]);
			list($fechaf,$horaf)=explode(" ",$row[11]);
			if($horai=='00:00:00' && $horaf='00:00:00'){
				$horario='Siempre';
			}
			else{
				$horario=$horai." - ".$horaf;
			}
		}
		/*
			buscamos pendientes
		*/
		$pendientes=mysql_query("select completado from gpscond_cmdsxalrt where folio=".$row[0]." and reg=".$row[1]);
		$terminado=mysql_fetch_array($pendientes);
		$accion="<img src='img/ico_delete.png' onclick='xajax_borrar_reg(".$row[0].",".$row[1].")' >";
		if($terminado[0]==0){
			$accion="Incompleto...<img src='img2/movs.png' width='20px' title='Clic para Reenviar el comando' onclick='xajax_reenvio(".$row[0].",".$row[1].")' >";
		}
		$reglas.="
			<tr>
				<td>".$vehiculo."</td>
				<td>".$msjxclave."</td>
				<td>".$geo."</td>
				<td>".$min."</td>
				<td>".$periodo."</td>
				<td>".$horario."</td>
				<td id='borrar_$num_veh' name='borrar_$num_veh'>$accion</td>
			</tr>
		";
	}
	mostrar_correos($folio);
	$objResponse->assign("reglas","innerHTML",$reglas);
	return $objResponse;
}
function reenvio($folio,$reg){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options ); 
	$query=mysql_query("
	SELECT n.cmd,n.id from notificaweb n
	inner join gpscond_cmdsxalrt c on n.id=c.id_notificaweb
	where c.folio=$folio
	and c.reg=$reg");
	$comandos=mysql_fetch_array($query);
	mysql_query("UPDATE notificaweb set respuesta='' where id=".$comandos[1]);
	$data=explode(";",$comandos[0]);
	list($setgeo,$num_veh)=explode(":",$data[0]);
	$sistema=mysql_query("SELECT id_sistema FROM vehiculos where num_veh=".$num_veh);
	$idsistemas=mysql_fetch_array($sistema);
	$idsistema=$idsistemas[0];
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	$cmd = sprintf($comandos[0],$comandos[1]);
	$sess->set("intentos",0);
	$objResponse->script($equipoGps->sendCMDtoEGServer($cmd));
	$objResponse->script("xajax_revisa_reenvio($comandos[1],0)");
	$objResponse->assign("geo_progreso","innerHTML",'Reenviando... <img src="img2/loader.gif" width="25px">');
	return $objResponse;
}
function revisa_reenvio($id,$i){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options ); 
	$query=mysql_query("SELECT respuesta from notificaweb where id=".$id);
	$resp=mysql_fetch_array($query);
	$intentos=60;
	if($sess->get("intentos")<$intentos){
		if(preg_match("/NO RESPONDIO/i",$resp[0]) || preg_match("/error/i",$resp[0])){
			$objResponse->assign("geo_progreso","innerHTML",'Se ocaciono un error al intentar guardar esta geocerca, vualva a intentarlo');
		}
		else{
			if(!preg_match("/SAVE/i",$resp[0])){
				$objResponse->script("setTimeout('xajax_revisa_reenvio($id,$i+1)',1000)");
			}
			else{
				$objResponse->alert("Se guardo exitosamente la geocerca pendiente");
				$folios=mysql_query("SELECT folio from gpscond_cmdsxalrt where id_notificaweb=$id");
				$folio=mysql_fetch_array($folios);
				$objResponse->script("xajax_config_folio(".$folio[0].")");
				$objResponse->assign("geo_progreso","innerHTML",'');
			}
		}
		$sess->set("intentos",$i+1);
	}
	else{
		$objResponse->alert("Tiempo de espera agotado, vuelva a intentarlo nuevamente...");
		$objResponse->assign("geo_progreso","innerHTML",'');
	}
	return $objResponse;
}
function geocercas(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query="SELECT g.num_geo,g.nombre,g.tipo,g.latitud,g.longitud,t.descripcion
			FROM geo_time g
			INNER JOIN tipo_geocerca t on g.tipo=t.tipo
			WHERE g.id_empresa = ".$sess->get("Ide")."
			and g.tipo=0
			and g.activo=1
			ORDER BY g.nombre";
	
	$rows=mysql_query($query);
	if(mysql_num_rows($rows)>0){
		$cont="<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;'>
				<tr>
					<th>Geocercas</th>
					<th><input type='checkbox' onclick='check_All_geo()' id='all_geo'></th>
				</tr>";
		if(mysql_num_rows($rows)==1){
			while($row=mysql_fetch_array($rows)){
				$cont.="<tr>
						<td colspan='2'>
							<input type='checkbox' class='Classgeo' name='ejec' id='ejec' onclick='contar1(\"$row[0]\",\"$row[2]\")' value='".$row[0]."'>";
				if($row[2]==1){
					$cad_punto = "select latitud, longitud from geo_puntos where id_geo = ".$row[0];
					$punt = mysql_query($cad_punto);
					$rowPunt = mysql_fetch_array($punt);
				}
				else{
					$cad_punto = "select latitud, longitud from geo_time where num_geo = ".$row[0];
					$punt = mysql_query($cad_punto);
					$rowPunt = mysql_fetch_array($punt);
				}
				$cont.="<span style='cursor:pointer;' title='click para ver la hubicacion de la geocerca ". $row[5]."' onclick=\"veh_seleccion('".$rowPunt[0]."','".$rowPunt[1]."')\">".$row[1]."</span>
							</td>
						</tr>";
			}
		}
		else{
			while($row=mysql_fetch_array($rows)){
				$cont.="<tr>
						<td colspan='2'>
							<input type='checkbox' class='Classgeo' name='ejec' id='ejec' onclick='contar(\"$row[2]\")' value='".$row[0]."'>";
				if($row[2]==1){
					$cad_punto = "select latitud, longitud from geo_puntos where id_geo = ".$row[0];
					$punt = mysql_query($cad_punto);
					$rowPunt = mysql_fetch_array($punt);
				}
				else{
					$cad_punto = "select latitud, longitud from geo_time where num_geo = ".$row[0];
					$punt = mysql_query($cad_punto);
					$rowPunt = mysql_fetch_array($punt);
				}
				$cont.="<span style='cursor:pointer;' title='click para ver la hubicacion de la geocerca ". $row[5]."' onclick=\"veh_seleccion('".$rowPunt[0]."','".$rowPunt[1]."')\">".$row[1]."</span>
							</td>
						</tr>";
			}
		}
		$cont.="</table>";
		$objResponse->assign("geocercas_config","innerHTML",$cont);
	}
	else{
		$objResponse->alert("Aun no tiene ninguna geocerca circular creada, es necesario tener por lo menos una para esta seccion");
		$objResponse->script("cerrar_ventana()");
		$objResponse->assign("geocercas_config","innerHTML",'');
	}
	
	return $objResponse;
}
function mostrar_correos($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos="
	<table id='newspaper-a1'>
		<tr>
			<th colspan='2'>Correos</th>
			<th>Nombre</th>
		</tr>";
	$query=mysql_query("SELECT * FROM correos_empresa where id_empresa=".$sess->get("Ide")." and activo=1 order by nombre");
	while($row=mysql_fetch_array($query)){
		if($folio!=0){
		$comp=mysql_query("SELECT enviaremail,folio from gpscondicionalerta where id_empresa=".$sess->get("Ide")." and activo=1 AND folio=$folio");
		$actuales=mysql_fetch_array($comp);
		if(strstr($actuales[0],$row[3])){
			$checked='checked';
		}
		else{
			$checked='';
		}
		$correos.="
			<tr>
				<td><input type='checkbox' name='id_correo' id='id_correo' onclick='agrega_correo(".$row[1].");
				update_correos(".$actuales[1].",".$row[1].");' 
				value='".$row[1]."' $checked></td>
				<td>".$row[3]."</td>
				<td>".$row[2]."</td>
			</tr>
		";
		}
		else{
			$correos.="
			<tr>
				<td><input type='checkbox' name='id_correo' id='id_correo' onclick='agrega_correo(".$row[1].")' value='".$row[1]."'></td>
				<td>".$row[3]."</td>
				<td>".$row[2]."</td>
			</tr>
		";
		}
	}
	$correos.="</table>";
	$objResponse->assign("mostrar_correos_dialog","innerHTML",$correos);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function update_correos($folio,$T_correo){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos='';
	for($i=0;$i<count($T_correo);$i++){
		$query=mysql_query("SELECT correo from correos_empresa where id_correo=".$T_correo[$i]." AND id_empresa=".$sess->get("Ide"));
		$add=mysql_fetch_array($query);
		if($correos!=''){
			$correos.=";";
		}
		$correos.=$add[0];
	}
	mysql_query("UPDATE gpscondicionalerta SET enviaremail='$correos' where folio=$folio");
	return $objResponse;
}
function agrega_correo($T_correo){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$correos='';
	$mostrar='';
	for($i=0;$i<count($T_correo);$i++){
		$query=mysql_query("SELECT correo from correos_empresa where id_correo=".$T_correo[$i]." and activo=1 AND id_empresa=".$sess->get("Ide"));
		$add=mysql_fetch_array($query);
		if($correos!=''){
			$correos.=";";
		}
		if($mostrar!=''){
			$mostrar.="<br />";
		}
		$correos.=$add[0];
		$mostrar.=$add[0];
	}
	$mostrar.="<input type='hidden' id='correos' value='$correos'>";
	$objResponse->assign("mostrar_correos","innerHTML",$mostrar);
	return $objResponse;
}
function opciones(){
	$objResponse = new xajaxResponse();
	$mostrar_i="
	<div id='contenido_reglas_i'>
		<table id='newspaper-a1'>
			<tr>
				<th colspan='2'><input type='radio' name='entra_sale' onclick='entrasale()' id='entrar' checked>Al entrar</th>
			</tr>
			<tr>
				<td>Velocidad m&aacute;xima</td>
				<td><input type='text' id='max_e' value='-1' size='3' onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode==109;'></td>
			</tr>
			<tr>
				<td>Velocidad m&iacute;nima</td>
				<td><input type='text' id='min_e' value='-1' size='3' onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode==109;'></td>
			</tr>
			<tr>
				<th colspan='2'>Cambiar tipo de reporte </th>
			</tr>
			<tr>
				<td>Modo</td>
				<td>
					<select id='pdsr_mode_e' onchange='pdsr_e()'>
						<option value='1'>Tiempo</option>
						<option value='2'>Distancia</option>
						<option value='8'>Rumbo</option>
						<option value='9'>Tiempo o rumbo</option>
						<option value='10'>Distancia o rumbo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tiempo</td>
				<td><input type='text' id='t_rep_e' onkeypress='return event.charCode==0 || event.charCode >= 48 && event.charCode <= 57;' placeholder='(minutos)'></td>
			</tr>
			<tr>
				<td>Distancia</td>
				<td><input type='text' id='d_rep_e' onkeypress='return event.charCode==0 || event.charCode >= 48 && event.charCode <= 57;' placeholder='(metros)'></td>
			</tr>
			<tr>
				<td>Rumbo</td>
				<td><input type='text' id='r_rep_e' onkeypress='return event.charCode==0 || event.charCode >= 48 && event.charCode <= 57;'
				placeholder='°(grados)'></td>
			</tr>
		</table>
	</div>
	";
	$mostrar_d="
	<div id='contenido_reglas_d' style='display:none;'>
		<table id='newspaper-a1'>
			<tr>
				<th colspan='2'><input type='radio' name='entra_sale' onclick='entrasale()' id='salir'>Al salir</th>
			</tr>
			<tr>
				<td>Velocidad m&aacute;xima</td>
				<td><input type='text' id='max_s' value='-1' size='3'></td>
			</tr>
			<tr>
				<td>Velocidad m&iacute;nima</td>
				<td><input type='text' id='min_s' value='-1' size='3'></td>
			</tr>
			<tr>
				<th colspan='2'>Cambiar reporte (solo equipos U1)</th>
			</tr>
			<tr>
				<td>Modo</td>
				<td>
					<select id='pdsr_mode_s' onchange='pdsr_s()'>
						<option value='9'>Tiempo - rumbo</option>
						<option value='10'>Distancia - rumbo</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tiempo</td>
				<td><input type='text' id='t_rep_s'>(minutos)</td>
			</tr>
			<tr>
				<td>Distancia</td>
				<td><input type='text' id='d_rep_s'></td>
			</tr>
			<tr>
				<td>Rumbo</td>
				<td><input type='text' id='r_rep_s'></td>
			</tr>
		</table>
	</div>
	";
	$mostrar=$mostrar_i.$mostrar_d;
	$objResponse->assign("contenido_reglas","innerHTML",$mostrar);
	return $objResponse;
}
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Reglas en geocercas</title>
	<!--<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />-->
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
	<script src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<style type="text/css">
	 #ui-datepicker-div{ font-size: 70%; }
	  /* css for timepicker */
	 .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
	 .ui-timepicker-div dl{ text-align: left; }
	 .ui-timepicker-div dl dt{ height: 25px; }
	 .ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
	 .ui-timepicker-div td { font-size: 70%; } 
	</style>	
	<script type="text/javascript" >
	function calendario(id){
		jQuery("#"+id).timepicker({
			closeText: 'Cerrar',
			currentText: 'Hoy',
			timeFormat: 'hh:mm'
		});
	}
	</script>
	<script type="text/javascript" >
	$(document).ready(function () {
		//Zero the idle timer on mouse movement.
		$(this).mousemove(function (e) {
			opener.idleTime = 0;
		});
		$(this).keypress(function (e) {
			opener.idleTime = 0;
		});
	});
	function cerrar_ventana(){
		window.close();
	}
	function check_All_veh() {
		var j = jQuery.noConflict();
		if(j("#all_veh").is(':checked')){
			j(".Classveh").prop('checked', true);
			contar();
		}
		else{
			j(".Classveh").removeAttr('checked');
			contar();
		}
	}
	function check_All_geo() {
		var j = jQuery.noConflict();
		if(j("#all_geo").is(':checked')){
			j(".Classgeo").prop('checked', true);
			contar();
		}
		else{
			j(".Classgeo").removeAttr('checked');
			contar();
		}
	}
	</script>
	<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>-->
	<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbr1ZoDby1GW6nP7RAgokJLqWP_95d6SE" ></script>
	<script src="js/reg_geo.js"></script>
	<script>
		window.onbeforeunload = confirmaSalida; 
	
		function confirmaSalida()   {    
			   if ($("#procesando").val()==1) {
					  return "Estas seguro de abandonar la pagina? Aun hay un proceso pendiente";  
			   }
		}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();load();xajax_geocercas(0);xajax_ver_geocercas(0,0,0);" style="overflow-x:hidden;overflow-y:scroll;width:1100px;height:770px;background:url(img2/main-bkg-00.png) transparent repeat;" >
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" style="overflow:hidden;width:1100px;">
<div id="fondo2" style="overflow:hidden;width:1100px;">
<div id="fondo3" style="overflow:hidden;width:1100px;">
<center>
<div id="cuerpo2" width="225" height="156">
	<div id="cuerpoSuphead" style="width:1100px;">
	<div id="logo" style='position:absolute;z-index:10;top:0px;left:10px;'><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
<form id="form1"  name="form1" action="#" method="post">
<div id="cuerpo_head" style='top:80px;width:1100px;height:820px;' >
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config'></div>
	<div id='mostrar_correos_dialog' style='display:none;' align="center"></div>
	<div id='reglas' style='position:absolute;top:560px;left:210px;width:850px;overflow-y:auto;overflow-x:hidden;height:180px;'></div>
	<div id='contenido_geo_reglas' style='height:350px;z-index:100;'></div><!-- EL MAPA SE CARGA AQUI-->
	<div id='contenido_reglas'></div>
	<div id='contenido_geo_asignadas'></div>
	<div id='geo_progreso' style="position:absolute;left:210px;top:300px;width:330px;height:50px;"></div>
	<input type='hidden' id='procesando' value='0'>
</div>
<div id='borrado_cmd' style='position:absolute;top:100px;left:220px;width:250px;height:50px;'></div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>
</html>