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
	if(preg_match('/seprosat/',curPageURL())){
		$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
	}
	else{
		$xajax->configure('javascript URI', '../xajaxs/');
	}
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
function borrar_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	mysql_query("UPDATE gpscondicionalertadet SET activo=0 where folio=$folio");
	mysql_query("UPDATE gpscondicionalerta set activo=0 where folio=$folio");
	mysql_query("UPDATE gps_config set activo=0 where folio=$folio");
	$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio");
	while($row=mysql_fetch_array($borrar)){
		mysql_query("update geo_veh SET activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
	}
	if(!mysql_error()){
		$objResponse->redirect("alertas_geo_server.php?g=r");
	}
	else{
		//$objResponse->alert(mysql_error());
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',40,
	'Borra configuracion en geocercas server',13,".$sess->get('Ide').",'".get_real_ip()."')");
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
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConectedGEO($veh)");
	}else $objResponse->script("setUpTimerOnlineGEO($veh,'".$idRequest."')");
	return $objResponse;		
}
function nuevo_folio($T_dias,$T_geo,$T_veh,$inicio,$fin,$minima,$maxima,$descrip,$correos,$dentro,$fuera,$periodo,$activo,$gestion,$duracion,$estricto){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	/*
		insert en gpscondicionalerta
	*/
	//$objResponse->alert($T_geo);
	$no_repetir=5;
	//$mail=str_replace("\n",';',$correos);
	$mail=$correos;
	$gas=0;
	$insert="INSERT INTO gpscondicionalerta VALUES(0,'$descrip',$estricto,".$sess->get('Ide').",'".
	date("Y-m-d H:i:s")."','$mail',0,0,$no_repetir,$activo,-1,0,0,0,-1)";
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
	$insert_C="INSERT INTO gps_config VALUES($folio,$minima,$maxima,$dentro,$fuera,'$inicio','$fin','$dias','$geocercas',1,'$gestion')";
	mysql_query($insert_C);
	/*
		insert en gpscondicionalertadet
	*/
	for($i=0;$i<count($T_veh);$i++){
		for($j=0;$j<count($T_geo);$j++){
			$insert_entrar="INSERT INTO gpscondicionalertadet 
				VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",$dentro,0,'$inicio','$fin',$duracion,0,1,
				$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0,$gas);";
			mysql_query($insert_entrar);
			$insert_salir="INSERT INTO gpscondicionalertadet 
				VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",0,$fuera,'$inicio','$fin',$duracion,0,1,
				$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0,$gas);";
			mysql_query($insert_salir);
			//$objResponse->alert(mysql_error());
			/*
				insert into geo_veh
			*/
			mysql_query("INSERT INTO geo_veh values(".$T_veh[$i].",".$T_geo[$j].",0,1,1,'".date("Y-m-d H:i:s")."',".$sess->get('Idu').",
			0,1,1)");
			/*
			insert into geo_veh
			*/
			$ver=mysql_query("SELECT * from geo_veh where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
			if(mysql_num_rows($ver)==0){
				mysql_query("INSERT INTO geo_veh values(".$T_veh[$i].",".$T_geo[$j].",0,1,1,'".date("Y-m-d H:i:s")."',
							".$sess->get('Idu').",0,1,1)");
			}
			else{
				mysql_query("UPDATE geo_veh SET activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
			}
		}
		
	}
	
	if(mysql_error()){
		$objResponse->alert(mysql_error());
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',41,
	'Crea configuracion en geocercas server',13,".$sess->get('Ide').",'".get_real_ip()."')");
	$objResponse-> redirect("alertas_geo_server.php?g=f");
	return $objResponse;
}
function nueva_regla($T_dias,$T_geo,$T_veh,$inicio,$fin,$minima,$maxima,$descrip,$correos,$dentro,$fuera,$periodo,$activo,$folio,$gestion,$duracion,$estricto){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	/*
		No se modificara nada en gpscondicionalerta
	*/
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
	$gas=0;
	$T_geo=explode(";",$dat[8]);
	for($i=0;$i<count($T_veh);$i++){
		for($j=0;$j<count($T_geo);$j++){
			$query="SELECT * FROM gpscondicionalertadet 
			where folio=$folio and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." 
			AND entrageo=$dentro and salegeo=0 and horaini='".$inicio."' and horafin='".$fin."' and duracion=$duracion
			and enlosdias='".$dias."'";
			$rev=mysql_query($query);
			//$objResponse->alert($query);
			if(mysql_num_rows($rev)==0){
				$insert_dentro="INSERT INTO gpscondicionalertadet 
					VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",$dentro,0,'$inicio','$fin',$duracion,0,1,
					$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0,$gas);";
				mysql_query($insert_dentro);
				//$objResponse->alert($insert);
			}
			else{
				mysql_query("UPDATE gpscondicionalertadet set activo=1 
				where folio=$folio and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." 
				AND entrageo=$dentro and salegeo=0 and horaini='".$inicio."' and horafin='".$fin."' and duracion=$duracion
				and enlosdias='".$dias."' ");
			}
			$query="SELECT * FROM gpscondicionalertadet 
			where folio=$folio and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." 
			AND entrageo=0 and salegeo=$fuera and horaini='".$inicio."' and horafin='".$fin."' and duracion=$duracion
			and enlosdias='".$dias."'";
			$rev=mysql_query($query);
			//$objResponse->alert($query);
			if(mysql_num_rows($rev)==0){
				$insert_dentro="INSERT INTO gpscondicionalertadet 
					VALUES($folio,0,".$sess->get("Ide").",".$T_veh[$i].",0,$minima,$maxima,".$T_geo[$j].",0,$fuera,'$inicio','$fin',$duracion,0,1,
					$activo,'$dias','".date("Y-m-d H:i:s")."','-1',0,0,$gas);";
				mysql_query($insert_dentro);
				//$objResponse->alert($insert);
			}
			else{
				mysql_query("UPDATE gpscondicionalertadet set activo=1 
				where folio=$folio and num_veh=".$T_veh[$i]." AND num_geo=".$T_geo[$j]." 
				AND entrageo=0 and salegeo=$fuera and horaini='".$inicio."' and horafin='".$fin."' and duracion=$duracion
				and enlosdias='".$dias."' ");
			}
			/*
			insert into geo_veh
			*/
			$ver=mysql_query("select * from geo_veh where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
			if(mysql_num_rows($ver)==0){
				mysql_query("INSERT INTO geo_veh values(".$T_veh[$i].",".$T_geo[$j].",0,1,1,'".date("Y-m-d H:i:s")."',
							".$sess->get('Idu').",0,1,1)");
			}
			else{
				mysql_query("UPDATE geo_veh SET activo=1 where num_veh=".$T_veh[$i]." and num_geo=".$T_geo[$j]);
			}
		}
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',42,
	'Asigna vehiculo a regla en geocercas server',13,".$sess->get('Ide').",'".get_real_ip()."')");
	$objResponse-> redirect("alertas_geo_server.php?g=r");
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
			AND ev.publicapos=1
			AND exists(
				SELECT * FROM equipos_configurables AS EC
				INNER JOIN secciones_configurables AS SC on EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo=EC.id_tipo_equipo
				AND EC.activo=1
				AND SC.seccion='geocercas' 
			)
			AND vu.activo=1
			order by v.id_veh asc";
			/*  QUITE ESTA CONDICION PORQUE RICH LO PIDIO JEJEJE
			AND exists(
				SELECT * FROM equipos_configurables AS EC
				INNER JOIN secciones_configurables AS SC on EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo=EC.id_tipo_equipo
				AND EC.activo=1
				AND SC.seccion='geocercas' 
			)
			*/
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th style='font-size:14px;width:150px;'>Vehiculo</th>
				<th><input type='checkbox' id='all_veh' onclick='check_All_veh()'></th>
			</tr>";
			$i=0;
	$int="";
	while($row=mysql_fetch_array($rows)){
		if(mysql_num_rows($rows)){
			$int=1;
		}
		$cont.="<tr>
					<td colspan='2'><input type='checkbox' class='Classveh' onclick='contar$int()' id='idVeh' name='Veh".$i."' value='".$row[1]."'>"
					.$row[0]."
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
	//$objResponse->alert($veh." ver_geo");
	for($i=0;$i<count($id_geo);$i++){
		if(count($id_geo)==1){
			/*$id=explode(",",$id_geo);
			$id_geo_gen=$id[0];
			if(is_array($id_geo_gen)){
				$id_geo_gen=$id_geo[0];
			}*/
			$id_geo_gen=$id_geo[0];
			//$objResponse->alert($id_geo);
			$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre";
			$cad_geo .= " from geo_time g left outer join geo_puntos p on (g.num_geo = p.id_geo)";
			$cad_geo .= " where num_geo =". $id_geo[0]." and g.activo=1 /*and p.activo=1 order by p.orden ASC*/";
		}
		else{
			$id_geo_gen=$id_geo[$i];
			$cad_geo = "select g.latitud,g.longitud,g.radioMts,g.tipo,p.latitud,p.longitud,p.orden,g.nombre";
			$cad_geo .= " from geo_time g left outer join geo_puntos p on (g.num_geo = p.id_geo)";
			$cad_geo .= " where num_geo =". $id_geo_gen." and g.activo=1 /*and p.activo=1 order by p.orden ASC*/";
		}
		//$objResponse->alert($cad_geo);
		$res_geo = mysql_query($cad_geo);
		//$objResponse->alert(mysql_error());
		$num_geo = mysql_num_rows($res_geo);
		if($num_geo == 1){
			$row = mysql_fetch_row($res_geo);
			$radio = $row[2];
			$objResponse->call("mostrar_circular",$row[0],$row[1],$row[2],$row[7]);
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
	
	$cond="";
	$query=mysql_query("SELECT gps.folio,gps.descripcion 
	FROM gpscondicionalerta gps 
	inner join gps_config config on gps.folio=config.folio
	where gps.id_empresa=".$sess->get('Ide')." 
	and gps.activo=1 
	and config.num_geo>0
	and config.gestion='server'
	/*group by gps.descripcion*/
	order by gps.descripcion");
	if(mysql_num_rows($query)>0){
		$cond.="
			<div id='geo_datos' >
				<table id='newspaper-a1' style='width:200px;'>
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
					<td width='10px'><input type='radio' name='config' onclick='xajax_config_folio(".$row[0].")' ".$checked."></td>
					<td>".$row[1]."</td>
					<td><img src='img/ico_delete.png' title='Borrar configuracion' onclick='xajax_borrar_folio(".$row[0].")'></td>
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
						<input type='text' id='inicio' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
					</td>
				</tr>
				<tr>
					<td>
						Hora de Fin:<br>
						<input type='text' id='fin' style='position: relative; z-index: 10;' readonly='readonly' size='15'/>
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
				<input type='hidden' id='server' name='gestion'>
				<input type='hidden' id='sem' name='periodo'>
			<tr>
				<td colspan='2'>
					Descripci&oacute;n:<input type='text' id='descripcion' size='40'>
				</td>
			</tr>
			<tr>
				<td colspan='2' id='checar_correos'>
					<input type='radio' id='enviar_correos' onclick='xajax_mostrar_correos(0)' />Correos
				</td>
			</tr>
			<tr>
				<td colspan='2' align='left' id='mostrar_correos'></td>
			</tr>
		</table>
	</div>";
	//$objResponse->alert();
	$objResponse->script("setTimeout('calendario(\"inicio\")',100)");
	$objResponse->script("setTimeout('calendario(\"fin\")',500)");
	/*$objResponse->script("mostrar_actuales(".json_encode($sess->get("todos_vehiculos")).",'".$sess->get("dias")."','".
	$sess->get("f_ini")."','".$sess->get("f_fin")."','".$sess->get("max")."','".$sess->get("min")."',".
	$sess->get("activo").",".$sess->get("dentro").",".$sess->get("fuera").",".$sess->get("sem").",".
	$sess->get("mes").",'".$sess->get("desc")."','".$sess->get("mail")."',".json_encode($sess->get("folio")).")");*/
	$objResponse->assign("contenido_geo_asignadas","innerHTML",$cond);
	//$objResponse->assign("geo_boton","innerHTML",$query_chec);
	$objResponse->assign("reglas","innerHTML",'');
return $objResponse;
}
function config_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query_chec="SELECT GPS.activo,GPS.descripcion,GPS.enviaremail,GPS.folio
			FROM gpscondicionalerta GPS
			WHERE GPS.id_empresa=".$sess->get('Ide')."
			AND GPS.folio=$folio 
			and GPS.activo=1";
	$datos=mysql_query($query_chec);
	$dat=mysql_fetch_array($datos);
	$correo=str_replace(";",'\n',$dat[2]);
	/*
		mostraremos la "configuracion" de los parametros de la tabla gps_config
	*/
	$query=mysql_query("SELECT * FROM gps_config where folio=$folio");
	$dat2=mysql_fetch_array($query);
	list($fi,$ini)=explode(" ",$dat2[5]);
	list($ff,$fin)=explode(" ",$dat2[6]);
	list($x,$dias)=explode(":",$dat2[7]);
	$d2=str_replace(",","",$dias);
	$objResponse->script("mostrar_actuales_config('".$dat[0]."','".$dat[1]."','".$correo."',".$dat[3].",".$dat2[1].",".$dat2[2].",
	".$dat2[3].",".$dat2[4].",'".$ini."','".$fin."','".$d2."',".json_encode($dias).")");
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
		$query=mysql_query("SELECT id_veh from vehiculos where num_veh=".$row[3]);
		$vehiculos=mysql_fetch_array($query);
		$vehiculo=$vehiculos[0];
		$geo='';
		$min='';
		$periodo='';
		$horario='';
		if($row[4]!=''){
			$query=mysql_query("SELECT mensaje FROM c_mensajes where id_mensaje=".$row[4]." and id_empresa=".$sess->get('Ide'));
			if(mysql_num_rows()==0){
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
			$query=mysql_query("SELECT nombre FROM geo_time where id_empresa=".$sess->get('Ide')." AND num_geo=".$row[7]." and activo=1");
			$nombre=mysql_fetch_array($query);
			$geo=$nombre[0];
			if($row[8]==1){
				$geo.=" (Entra)";
			}
			if($row[9]==1){
				$geo.=" (Sale)";
			}
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
		$reglas.="
			<tr>
				<td>".$vehiculo."</td>
				<td>".$msjxclave."</td>
				<td>".$geo."</td>
				<td>".$min."</td>
				<td>".$periodo."</td>
				<td>".$horario."</td>
				<td><img src='img/ico_delete.png' onclick='xajax_borrar_reg(".$row[0].",".$row[1].")'></td>
			</tr>
		";
	}
	$objResponse->assign("reglas","innerHTML",$reglas);
	
	//$objResponse->alert(json_encode($dias));
	return $objResponse;
}
function geocercas(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query="SELECT g.num_geo,g.nombre,g.tipo,g.latitud,g.longitud,t.descripcion
			FROM geo_time g
			INNER JOIN tipo_geocerca t on g.tipo=t.tipo
			WHERE g.id_empresa = ".$sess->get("Ide")." 
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
		$objResponse->alert("Aun no tiene ninguna geocerca creada, es necesario tener por lo menos una para esta secci&oacute;n");
		$objResponse->script("cerrar_ventana()");
		$objResponse->assign("geocercas_config","innerHTML",'');
	}
	
	return $objResponse;
}
function borrar_reg($folio,$reg){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio and reg=$reg");
	$borrar=mysql_query("select num_veh,num_geo from gpscondicionalertadet where folio=$folio and reg=$reg");
	while($row=mysql_fetch_array($borrar)){
		mysql_query("update geo_veh set activo=0 WHERE num_veh=".$row[0]." AND num_geo=".$row[1]);
	}
	//$objResponse->alert($cmd);
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',43,
	'Borra vehiculo de regla en geocercas server',13,".$sess->get('Ide').",'".get_real_ip()."')");
	$objResponse->script("xajax_config_folio($folio)");
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
		$query=mysql_query("SELECT correo from correos_empresa where id_correo=".$T_correo[$i]." AND id_empresa=".$sess->get("Ide"));
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
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Asignaci&oacute;n de geocercas offline</title>
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
	<script src="js/geo_admin_server.js"></script>
</head>
<body id="fondo1" onload="xajax_vehiculos();load();xajax_geocercas(0);xajax_ver_geocercas(0,0,0);" style="overflow-x:hidden;overflow-y:scroll;width:1100px;background:url(img2/main-bkg-00.png) transparent repeat;">
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
<form id="form1"  name="form1" action="g_config.php" method="post">
<div id="cuerpo_head"style='top:80px;width:1100px;height:820px;' >
	<div id='vehiculos_config_geo'></div>
	<div id='geocercas_config'></div>
	<div id='mostrar_correos_dialog' style='display:none;'></div>
	<div id='contenido_geo' style='height:350px;'></div><!-- EL MAPA SE CARGA AQUI-->
	<div id='reglas' style='position:absolute;top:560px;left:210px;width:850px;overflow-y:auto;overflow-x:hidden;height:180px;'></div>
	<div id='contenido_geo_asignadas'>
	</div>
</div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>
</html>