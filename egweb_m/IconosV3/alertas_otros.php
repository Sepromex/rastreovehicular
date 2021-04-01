<?
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 // include('conn.php');
 // include('ObtenUrl.php');
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
	require("librerias/SistemasConfigurables/Configsis_nuevo.php");
  	require('../xajaxs/xajax_core/xajax.inc.php');
	$xajax = new xajax(); 
	if(preg_match('/seprosat/',curPageURL())){
		$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
	}
	else{
		$xajax->configure('javascript URI', '../xajaxs/');
	}
	$xajax->register(XAJAX_FUNCTION,"vehiculos");
	$xajax->register(XAJAX_FUNCTION,"mostrar_config");
	$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
	$xajax->register(XAJAX_FUNCTION,"sendRequest");
	$xajax->register(XAJAX_FUNCTION,"findGeneralResponse");
	$xajax->register(XAJAX_FUNCTION,"guardarDatosE");
	$xajax->register(XAJAX_FUNCTION,"mostrar_correo");
	$xajax->register(XAJAX_FUNCTION,"mostrar_select");
	$xajax->register(XAJAX_FUNCTION,"mostrar_nuevo");
	$xajax->register(XAJAX_FUNCTION,"guarda_folio");
	$xajax->register(XAJAX_FUNCTION,"guarda_vel");
	$xajax->register(XAJAX_FUNCTION,"agrega_correo");
	$xajax->register(XAJAX_FUNCTION,"motor_correo");
	$xajax->register(XAJAX_FUNCTION,"obten_motor");
	$xajax->register(XAJAX_FUNCTION,"obten_fuerza");
	$xajax->register(XAJAX_FUNCTION,"remol_correo");
	$xajax->register(XAJAX_FUNCTION,"impacto_correo");
	$xajax->register(XAJAX_FUNCTION,"sa_correo");
	$xajax->register(XAJAX_FUNCTION,"mov_correo");
	$xajax->register(XAJAX_FUNCTION,"fatiga_correo");
	$xajax->register(XAJAX_FUNCTION,"fuerza_correo");
	$xajax->register(XAJAX_FUNCTION,"terminal_correo");
	$xajax->register(XAJAX_FUNCTION,"obten_terminal");
	$xajax->register(XAJAX_FUNCTION,"horas_motor");
	$xajax->register(XAJAX_FUNCTION,"g_horas_motor");
/*
function horas_motor($veh){
	$objResponse = new xajaxResponse();
	$fin=date("Y-m-d H:i:s");
	$query=mysql_query("SELECT fecha FROM veh_estatusign where num_veh=$veh and id_pos=0 and id_mxc=249");//apagado
	if(mysql_num_rows($query)>0){
		$dat_f=mysql_fetch_array($query);
		$query_i=mysql_query("SELECT fecha FROM veh_estatusign where num_veh=$veh and id_pos=0 and id_mxc=248");//encendido
		$dat_i=mysql_fetch_array($query_i);
		$tiempo_i = strtotime($dat_f[0])-strtotime($dat_i[0]);//horas iniciales
		$q="SELECT p.id_mxc,p.fecha 
		from veh_estatusign p 
		where p.num_veh=$veh 
		and p.id_mxc in(248,249)
		and p.fecha between '$dat_f[0]' and '".$fin."'
		order by p.fecha";
		//$objResponse->alert($q);
		$horai=$dat_f[0];
		$query_t=mysql_query($q);
		if(mysql_num_rows($query_t)>0){//si tengo mas eventos los agrego
			while($row=mysql_fetch_array($query_t)){
				$ant=strtotime($horai);
				$act=strtotime($row[1]);
				$dif=$act-$ant;
				//$objResponse->alert($dif." ->".$row[0]);
				if($row[0]==248){
					$tiempo_apagado=$tiempo_apagado+$dif;
				}
				else{
					$tiempo_encendido=$tiempo_encendido+$dif;
				}
				list($diai,$hi)=explode(" ",$horai); 
				list($diaf,$hf)=explode(" ",$row[1]); 
				$horai=$row[1];
				$ev1=$row[0];
			}
		}
		if(strtotime($horai)!=strtotime($fin)){
			$query=mysql_query("SELECT fecha FROM ultimapos u where num_veh=$veh");
			$ultima=mysql_fetch_array($query);
			if($ev1==248){//vehiculo encendido
				$ant=strtotime($horai);
				$act=strtotime($ultima[0]);
				$dif=$act-$ant;
				$tiempo_encendido=$tiempo_encendido+$dif;
			}
		}
		
		$tiempo_encendido=$tiempo_i+$tiempo_encendido;
		$horas_e = floor($tiempo_encendido/3600);
		$minutos_e = floor(($tiempo_encendido-($horas_e*3600))/60);
		$segundos_e = $tiempo_encendido-($horas_e*3600)-($minutos_e*60);
		$tiempo_e= $horas_e."h: ".$minutos_e."m: ".$segundos_e."s";
		
		//$tiempo=floor($tiempo_i/3600);
		$objResponse->assign("tiempo_motor","value",$tiempo_e);
		$objResponse->assign("f_inicio","value",$fin);
	}
	else{
		//$objResponse->script("$('#tiempo_motor').val('Aun no configurado')");
		$objResponse->assign("tiempo_motor","value",'Aun no configurado');
		$objResponse->assign("f_inicio","value",'Aun no configurado');
	}
	return $objResponse;
}
*/
/*
function g_horas_motor($veh,$inicio,$horas){
	$objResponse = new xajaxResponse();
	$query=mysql_query("SELECT fecha FROM veh_estatusign where num_veh=$veh and id_mxc=248 and id_pos=0");
	if(mysql_num_rows($query)>0){
		//actualizo los registros
		$dat=mysql_fetch_array($query);
		if($inicio!=$dat[0]){ //si la fecha inicial del motor no es la misma
			
		}
		else{
		
		}
	}
	else{
		//calculamos las horas hacia atras
		$atras=strtotime($inicio." - $horas hours");
		mysql_query("INSERT INTO veh_estatusign values($veh,'".date("Y-m-d H:s:i",$atras)."',248,0)");//encendemos
		mysql_query("INSERT INTO veh_estatusign values($veh,'".$inicio."',249,0)");//apagamos
	}
	return $objResponse;
}
*/
function remol_correo($tipo,$correos,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=309 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,309,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=309 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	//$objResponse->alert(mysql_error());
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',46,'Asigna parametros para remolque al equipo',13,".$sess->get('Ide').")");
	return $objResponse;
}
function fatiga_correo($tipo,$correos,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=299 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,299,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=299 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update2="UPDATE gpscondicionalerta set activo=1 where folio=$folio";
		mysql_query($update2);
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',47,'Asigna parametros para fatiga al equipo',13,".$sess->get('Ide').")");
	//$objResponse->alert(mysql_error());
	return $objResponse;
}
function fuerza_correo($tipo,$correos,$on,$off,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		if(mysql_error()){
			//$objResponse->alert($insert);
		}
		else{
			$folio=mysql_insert_id();
			//$objResponse->alert(mysql_insert_id());
		}
	}
	else{
		$folios=mysql_fetch_array($ver);
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folios[0]);
		//$objResponse->alert($folio[0]);
		$folio=$folios[0];
	}
	
	if($on==0 && $off==0){
		$desactivar1="UPDATE SET gpscondicionalerta activo=0 where folio=$folio";
		$desactivar2="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=40 and folio=$folio and num_veh=$veh";
		$desactivar3="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=41 and folio=$folio and num_veh=$veh";
		mysql_query($desactivar1);
		mysql_query($desactivar2);
		mysql_query($desactivar3);
	}
	if($on==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=40 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,40,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert1);
		}
		else{
			$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=40 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=41 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert2="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,41,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert2);
		}
		else{
			$update2="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=41 and folio=$folio and num_veh=$veh";
			mysql_query($update2);
		}
	}
	if($on==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=40 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=40 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=41 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=41 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	//$objResponse->alert($tipo."--".$correos."--".$on."--".$off."--".$veh);
	$objResponse->assign('toma','innerHTML',"<img src='img/apply.png' width='16' height='16' />Cambio aplicado");
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',48,'Selecciona notificacion para toma de fuerza',13,".$sess->get('Ide').")");
	return $objResponse;
}
function obten_fuerza($veh){
	$objResponse = new xajaxResponse();
	$query1=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=40 and activo=1");
	$query2=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=41 and activo=1");
	$on=0;
	$off=0;
	if(mysql_num_rows($query1)==1){
		$on=1;
	}
	if(mysql_num_rows($query2)==1){
		$off=1;
	}
	$objResponse->script("obten_fuerza($on,$off)");
	return $objResponse;
}
function mov_correo($tipo,$correos,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=16 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,16,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=16 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	//$objResponse->alert(mysql_error());
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',49,'Asigna parametros para vehiculo en movimiento al equipo',13,".$sess->get('Ide').")");
	return $objResponse;
}
function impacto_correo($tipo,$correos,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=306 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,306,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=306 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	//$objResponse->alert(mysql_error());
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',50,'Asigna parametros para impacto al equipo',13,".$sess->get('Ide').")");
	return $objResponse;
}
function sa_correo($tipo,$correos,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=15 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,15,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=15 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	//$objResponse->alert(mysql_error());
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',51,'Asigna parametros para vehiculo sin actividad al equipo',13,".$sess->get('Ide').")");
	return $objResponse;
}	
function obten_motor($veh){
	$objResponse = new xajaxResponse();
	$query1=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=248 and activo=1");
	$query2=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=249 and activo=1");
	$on=0;
	$off=0;
	if(mysql_num_rows($query1)==1){
		$on=1;
	}
	if(mysql_num_rows($query2)==1){
		$off=1;
	}
	//$objResponse->alert(mysql_error());
	$objResponse->script("obten_motor($on,$off)");
	
	return $objResponse;
}
function motor_correo($tipo,$correos,$on,$off,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		if(mysql_error()){
			//$objResponse->alert($insert);
		}
		else{
			$folio=mysql_insert_id();
			//$objResponse->alert(mysql_insert_id());
		}
	}
	else{
		$folios=mysql_fetch_array($ver);
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folios[0]);
		//$objResponse->alert($folio[0]);
		$folio=$folios[0];
	}
	
	if($on==0 && $off==0){
		$desactivar1="UPDATE SET gpscondicionalerta activo=0 where folio=$folio";
		$desactivar2="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=248 and folio=$folio and num_veh=$veh";
		$desactivar3="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=249 and folio=$folio and num_veh=$veh";
		mysql_query($desactivar1);
		mysql_query($desactivar2);
		mysql_query($desactivar3);
	}
	if($on==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=248 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,248,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert1);
		}
		else{
			$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=248 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=249 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert2="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,249,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert2);
		}
		else{
			$update2="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=249 and folio=$folio and num_veh=$veh";
			mysql_query($update2);
		}
	}
	if($on==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=248 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=248 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=249 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=249 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	//$objResponse->alert($tipo."--".$correos."--".$on."--".$off."--".$veh);
	$objResponse->assign('motor','innerHTML',"<img src='img/apply.png' width='16' height='16' />Cambio aplicado");
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',52,'Selecciona notificacion para motor apagado/encendido',13,".$sess->get('Ide').")");
	return $objResponse;
}
function terminal_correo($tipo,$correos,$on,$off,$veh){
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		if(mysql_error()){
			//$objResponse->alert($insert);
		}
		else{
			$folio=mysql_insert_id();
			//$objResponse->alert(mysql_insert_id());
		}
	}
	else{
		$folios=mysql_fetch_array($ver);
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folios[0]);
		//$objResponse->alert($folio[0]);
		$folio=$folios[0];
	}
	
	if($on==0 && $off==0){
		$desactivar1="UPDATE SET gpscondicionalerta activo=0 where folio=$folio";
		$desactivar2="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=238 and folio=$folio and num_veh=$veh";
		$desactivar3="UPDATE gpscondicionalertadet SET activo=0 where id_msjxclave=237 and folio=$folio and num_veh=$veh";
		mysql_query($desactivar1);
		mysql_query($desactivar2);
		mysql_query($desactivar3);
	}
	if($on==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=238 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,238,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert1);
		}
		else{
			$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=238 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=237 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)==0){
			$insert2="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,237,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
			mysql_query($insert2);
		}
		else{
			$update2="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=237 and folio=$folio and num_veh=$veh";
			mysql_query($update2);
		}
	}
	if($on==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=238 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=238 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	if($off==0){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=237 and folio=$folio and num_veh=$veh");
		if(mysql_num_rows($query)){
			$update1="UPDATE gpscondicionalertadet set activo=0 where id_msjxclave=237 and folio=$folio and num_veh=$veh";
			mysql_query($update1);
		}
	}
	//$objResponse->alert($tipo."--".$correos."--".$on."--".$off."--".$veh);
	$objResponse->assign('terminal','innerHTML',"<img src='img/apply.png' width='16' height='16' />Cambio aplicado");
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',76,'Selecciona notificacion para Terminal conectada/desconectada',13,".$sess->get('Ide').")");
	return $objResponse;
}
function obten_terminal($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get('Ide');
	$query1=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=238 and activo=1 and id_empresa=$ide");
	$query2=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=237 and activo=1 and id_empresa=$ide");
	$on=0;
	$off=0;
	if(mysql_num_rows($query1)==1){
		$on=1;
	}
	if(mysql_num_rows($query2)==1){
		$off=1;
	}
	//$objResponse->alert(mysql_error());
	$objResponse->script("obten_terminal($on,$off)");
	
	return $objResponse;
}
function getIdUsuario(){
	$sess =& patSession::singleton('egw', 'Native', $options );
	return $sess->get('Idu');
}
function vehiculos(){
$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	//$firephp= FirePhp::getInstance(true);
	$idu=$sess->get("Idu");
	$query="select v.id_veh, v.num_veh,v.id_sistema
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
				AND SC.seccion='otros' 
			)
			AND vu.activo=1
			order by v.id_veh asc";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
			</tr>";
			$i=0;
	while($row=mysql_fetch_array($rows)){
	
		$cont.="<tr>
					<td colspan='2'><input onclick='mostrar(".$row[2].",\"".$row[0]."\",".$row[1].");' type='radio' name='vehiculo[]' value='".$row[1]."'>".$row[0]."</td>
				</tr>
		";
		$i++;
	}
	$objResponse->assign("vehiculos_config","innerHTML",$cont);
return $objResponse;
}

function mostrar_config($modelo,$idVeh,$veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$equipoGps = CONFIGSIS::getObjectFromSistem($modelo);
	$equipoGps->setNumVeh($veh);
	$equipoGps->createJsonFromDB();
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
	#query para mostrar el sistema y el vehiculo seleccionado
	$query="SELECT TE.descripcion,V.id_veh FROM vehiculos AS V
			INNER JOIN sistemas as S ON V.id_sistema=S.id_sistema
			INNER JOIN tipo_equipo AS TE ON S.tipo_equipo=TE.id_tipo_equipo
			WHERE V.num_veh=$veh";
	$rows=mysql_query($query);
	//$objResponse->assign("contenido","innerHTML",$query);
	//return $objResponse;
	//$objResponse->alert($modelo);
	$objResponse->assign("config_equipo","innerHTML",$equipoGps->getFormulario());
	$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." and activo=1 and descripcion like '%Acciones del motor encendido/apagado%'";
	$res=mysql_query($correos);
	$box="";
	if(mysql_num_rows($res)>0){
		if(mysql_num_rows($res)==1){
			$folios=mysql_fetch_array($res);
			$box="<input type='radio' id='enviar_motor' onclick='xajax_mostrar_correo($folios[0])'>Notificar por correo";
		}
		if(mysql_num_rows($res)>1){
			$box="<input type='radio' id='enviar_motor' onclick='xajax_mostrar_select(".$sess->get('Ide').")'>Notificar por correo";
		}
	}
	else{
		$box="<input type='radio' id='enviar_motor' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').")'>Notificar por correo";
	}
	//$objResponse->alert($modelo);
	if($modelo==36 || $modelo==38){
		$objResponse->assign("correo","innerHTML",'');
	}
	else{
		$objResponse->assign("correo","innerHTML",$box);
	}
	return $objResponse;
}

function mostrar_correo($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("SELECT enviaremail from gpscondicionalerta where folio=$folio and activo=1");
	$correo=mysql_fetch_array($query);
	$ver=str_replace(";","<br>",$correo[0]);
	$correos="
	<table id='newspaper-a1'>
		<tr>
			<th>
				Se notificara a los siguientes correos
			</th>
		</tr>
		<tr>
			<td>$ver</td>
		</tr>
	</table>";
	
	$enviar="<input type='hidden' id='correos' value='$correo[0]'><input type='hidden' id='ide' value='".$sess->get("Ide")."' />";
	$objResponse->assign("correos_hidden","innerHTML",$enviar);
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->call("xajax_guarda_folio",$folio);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function mostrar_select($ide){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("SELECT enviaremail,folio from gpscondicionalerta where id_empresa=$ide and activo=1 and descripcion like '%Exceso de Velocidad desde Equipo%'");
	$correos="<table id='newspaper-a1'>
			<tr>
				<th>Seleccione que configuraci&oacute;n usara</th>
			</tr>";
	while($row=mysql_fetch_array($query)){
		$correos.="
		<tr>
			<td style='word-wrap:break-word;'>
				<input type='radio' name='config' onclick='xajax_guarda_folio(".$row[1].")' value='".$row[1]."'/>".$row[0]." 
			</td>
		</tr>
		";
	}
	$correos.="</table>";
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function mostrar_nuevo($ide){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$data="
	<table id='newspaper-a1'>
		<tr>
			<th>Seleccione los Correos a los que se enviaran los Excesos de Velocidad</th>
		</tr>";
	$query=mysql_query("SELECT * FROM correos_empresa where id_empresa=$ide and activo=1 order by nombre");
	while($row=mysql_fetch_array($query)){
	$data.="
			<tr>
				<td><input type='checkbox' name='id_correo' id='id_correo' onclick='agrega_correo(".$row[1].")' value='".$row[1]."'>".$row[3]."</td>
			</tr>
		";
	}
	$data.="
	</table>";
	$objResponse->assign("mostrados","innerHTML",$data);
	$objResponse->script("mostrar_dialog()");
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
		$correos.=$add[0];
	}
	$mostrar.="<input type='hidden' id='correos' value='$correos'>
	<input type='hidden' id='ide' value='".$sess->get("Ide")."' />";
	$objResponse->assign("correos_hidden","innerHTML",$mostrar);
	return $objResponse;
}
function guarda_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sess->set('config_folio',$folio);
	//$objResponse->alert($sess->get('config_folio'));
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest){
	$objResponse = new xajaxResponse();
	$query = "select num_veh from notificaweb where id = $idRequest";
	$ve=mysql_query($query);
	$veh=mysql_fetch_array($ve);
	$sistemas=mysql_query("SELECT veh_x1,id_sistema FROM vehiculos v where v.num_veh=$veh[0]");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($sistema[1]);
	}
	
	$result = $equipoGps->getStatusResponse($idRequest);
	//$objResponse->alert($result);
	if($sistema[1]==10 || $sistema[1]==27 || $sistema[1]==14 || $sistema[1]==22 || $sistema[1]==23 || $sistema[1]==26 ){
		$result="CONECTADO";
	}
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfig());
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConected()");
	}else $objResponse->script("setUpTimerOnline()");
	return $objResponse;
}
function sendRequest($idsistema,$numveh,$jsonString,$request,$datos){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$numveh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$equipoGps->setNumVeh($numveh);
	$equipoGps->sendRequest(trim($jsonString),trim($request),getIdUsuario(),trim($datos));
	$sess->set("ACTIVO",trim($jsonString));
	$objResponse->script($equipoGps->callGeneralTimer($request));
	//$objResponse->alert($jsonString."**".$request."--".getIdUsuario()."&&".$datos);
	//$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
	return $objResponse;		
}
function findGeneralResponse($idsistema,$idRequest,$request){
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$objResponse = new xajaxResponse();
	$query = "select num_veh from notificaweb where id = $idRequest";
	$ve=mysql_query($query);
	$veh=mysql_fetch_array($ve);
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh[0] AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	//$objResponse->alert($idRequest."////".$request);
	$activo=$sess->get("ACTIVO");
	if($sess->get("config_folio")==''){
		$equipoGps->inserta_nueva($idRequest,$activo);
	}
	else{
		$equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"));
	}
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
	//$objResponse->alert($result);
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
	}else if($result == null){
		$objResponse->script($equipoGps->goGeneralTimer($request));
	}
	return $objResponse;
}
function guardarDatosE($datosJson){
	$objResponse = new xajaxResponse();
	$datosDecoded = json_decode($datosJson);
	$equipoGps = CONFIGSIS::getObjectFromSistem($datosDecoded->{'id_sistema'});
	$equipoGps->setJsonString($datosJson);
	if($equipoGps->actualizaDatosE()){
		$objResponse->alert("Datos Guardados");
		$objResponse->script("cancelaActEquipo(".$equipoGps->getNumVeh().")");
	}else $objResponse->alert("Error encontrado");
	return $objResponse;		
}
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Otras Alertas</title>
	<!--<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />-->
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>
<script type="text/javascript" language="javascript" src="librerias/json2.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<script language="JavaScript">
	$(document).ready(function () {
		//Zero the idle timer on mouse movement.
		$(this).mousemove(function (e) {
			opener.idleTime = 0;
		});
		$(this).keypress(function (e) {
			opener.idleTime = 0;
		});
	});
	
	function mostrar(idSis,idVeh,numVeh){
		cancelActualTimer();
		//ajax mediante el cual cargaremos "dinamicamente" el script necesario para el tipo de equipo
		$.ajax({
			type: 'GET',
			url: 'includes/buscar_equipo.php?id='+idSis+'&num_veh='+numVeh,//archivo que "busca" la descripcion del equipo
			timeout: 500,
			success: function(data) {
			  //alert(data);
			  //'librerias/SistemasConfigurables/'+data+'.js'
			  $.ajax({
					url: 'librerias/SistemasConfigurables/'+data+'.js',
				  dataType: "script"
				  });
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  alert("Hubo un error de conexion, seleccione nuevamente el vehiculo.");
			}
		});
		xajax_mostrar_config(idSis,idVeh,numVeh);
		setTimeout('calendario(\"f_inicio\")',500);
	}
function mostrar_dialog(){
	if($("#enviar_motor").is(':checked')){
		$("#mostrados").dialog({
		modal: true,
		dialogClass:'dialog_style',
		width: 300,
		height: 300,
		title: "Correos"
		/*buttons: {
		"Cancelar": function() {
			jQuery(this).dialog("close");
			},
		"Guardar":function() {
			//xajax_cambioPass(xajax.getFormValues('cambiar'));
			//jQuery(this).dialog("close");
			}
		}*/
		}).dialog('open');
	}
}
function agrega_correo(correo){
	var T_correos = Array();
	var checkboxes2 = document.getElementsByName("id_correo");
	for(var i=0; i<checkboxes2.length; i++){
		if(checkboxes2[i].checked==true){
			T_correos.push(checkboxes2[i].value);
		}
	}
	//alert(T_correos);
	xajax_agrega_correo(T_correos);
}
function notifica_motor(){
	if($("#enviar_motor").is(':checked')){
		var on=0;
		var off=0;
		if($("#encendido").is(':checked')){
			on=1;
		}
		if($("#apagado").is(':checked')){
			off=1;
		}
		var correos=$("#correos").val();
		var tipo=$("#tipo").val();
		var veh=$("#id_veh").val();
		
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			xajax_motor_correo(tipo,correos,on,off,veh);
		}
	}
	else{
		alert("Necesita tener seleccionada la opcion de 'Notificar por correo'");
	}
}
function notifica_terminal(){
	if($("#enviar_motor").is(':checked')){
		var on=0;
		var off=0;
		if($("#conectada").is(':checked')){
			on=1;
		}
		if($("#desconectada").is(':checked')){
			off=1;
		}
		var correos=$("#correos").val();
		var tipo=$("#tipo8").val();
		var veh=$("#id_veh").val();
		
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			xajax_terminal_correo(tipo,correos,on,off,veh);
		}
	}
	else{
		alert("Necesita tener seleccionada la opcion de 'Notificar por correo'");
	}
}
function obten_terminal(on,off){
	if(on==1){
		$("#conectada").attr('checked',true);
	}
	else{
		$("#conectada").removeAttr('checked');
	}
	if(off==1){
		$("#desconectada").attr('checked',true);
	}
	else{
		$("#desconectada").removeAttr('checked');
	}
	var mensaje ='Informaci\u00f3n recivida';
	$("#terminal").html("<img src='img/apply.png' width='16' height='16' /> "+mensaje);
}
function obten_motor(on,off){
	if(on==1){
		$("#encendido").attr('checked',true);
	}
	else{
		$("#encendido").removeAttr('checked');
	}
	if(off==1){
		$("#apagado").attr('checked',true);
	}
	else{
		$("#apagado").removeAttr('checked');
	}
	var mensaje ='Informaci\u00f3n recivida';
	$("#motor").html("<img src='img/apply.png' width='16' height='16' /> "+mensaje);
}
function obten_fuerza(on,off){
	if(on==1){
		$("#encendido1").attr('checked',true);
	}
	else{
		$("#encendido1").removeAttr('checked');
	}
	if(off==1){
		$("#apagado1").attr('checked',true);
	}
	else{
		$("#apagado1").removeAttr('checked');
	}
	var mensaje ='Informaci\u00f3n recivida';
	$("#toma").html("<img src='img/apply.png' width='16' height='16' /> "+mensaje);
}
function asignar_correo(){
	if($("#enviar_motor").is(':checked')){
		var tipo=$("#tipo2").val();
		var veh=$("#id_veh").val();
		var correos=$("#correos").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_remol_correo(tipo,correos,veh);
		}
	}
}
function impacto_correo(){
	if($("#enviar_motor").is(':checked')){
		var tipo=$("#tipo3").val();
		var veh=$("#id_veh").val();
		var correos=$("#correos").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_impacto_correo(tipo,correos,veh);
		}
	}
}
function sa_correo(){
	if($("#enviar_motor").is(':checked')){
		var tipo=$("#tipo4").val();
		var veh=$("#id_veh").val();
		var correos=$("#correos").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_sa_correo(tipo,correos,veh);
		}
	}
}
function mov_correo(){
	if($("#enviar_motor").is(':checked')){
		var tipo=$("#tipo5").val();
		var veh=$("#id_veh").val();
		var correos=$("#correos").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_mov_correo(tipo,correos,veh);
		}
	}
}
function fatiga(){
	if($("#enviar_motor").is(':checked')){
		var tipo=$("#tipo6").val();
		var veh=$("#id_veh").val();
		var correos=$("#correos").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_fatiga_correo(tipo,correos,veh);
		}
	}
}
function notifica_fuerza(){
	if($("#enviar_motor").is(':checked')){
		var on=0;
		var off=0;
		if($("#encendido1").is(':checked')){
			on=1;
		}
		if($("#apagado1").is(':checked')){
			off=1;
		}
		var correos=$("#correos").val();
		var tipo=$("#tipo7").val();
		var veh=$("#id_veh").val();
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert("manda");
			xajax_fuerza_correo(tipo,correos,on,off,veh);
		}
	}
}
function ver_modo(){
	var dis=$("#distFA").val();
	var tmp=$("#tiemFA").val();
	if((dis=='' && tmp=='') || (dis==0 && tmp==0)){
		$("#fatigue0").prop('checked', true);
		dis=$("#distFA").val(1);
		tmp=$("#tiemFA").val(1);
	}
	if(dis>0 && tmp==''){
		$("#fatigue2").prop('checked', true);
	}
	if(tmp>0 && dis==''){
		$("#fatigue1").prop('checked', true);
	}
	if(tmp>0 && dis>0){
		$("#fatigue4").prop('checked', true);
	}
	if(tmp!='' || dis!='' || tmp!=0 || dis!=0){
		U1PRO("fatigue","set","tiemFA@distFA");
	}
	else{
		dis=$("#distFA").val(1);
		tmp=$("#tiemFA").val(1);
		$("#fatigue0").attr('checked', true);
		U1PRO("fatigue","set","tiemFA@distFA");
	}
}
	</script>
<style type="text/css">
 #ui-datepicker-div{ font-size: 70%; }
  /* css for timepicker */
 .ui-timepicker-div .ui-widget-header{ margin-bottom: 8px; }
 .ui-timepicker-div dl{ text-align: left; }
 .ui-timepicker-div dl dt{ height: 25px; }
 .ui-timepicker-div dl dd{ margin: -25px 10px 10px 65px; }
 .ui-timepicker-div td { font-size: 70%; } 
</style>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script>
function calendario(id){
	jQuery("#"+id).datetimepicker({
		yearRange: '1900:2050',
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Juv','Vie','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sab'],
		weekHeader: 'Sm',
		//changeMonth: true,
		//changeYear: true,
		timeFormat: 'hh:mm:ss',
		dateFormat: "yy-mm-dd"
	});
}
function g_horas_motor(veh){
	//xajax_g_horas_motor(veh,$("#f_inicio").val(),$("#tiempo_motor").val());
}
</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();xajax_guarda_folio('')" style="width:700px;overflow:hidden;height:440px;" >
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" style="width:700px;height:440px;">
<div id="fondo2" style="width:700px;height:440px;">
<div id="fondo3" style="width:700px;height:440px;">
<center>
<div id="cuerpo2" width="700px" height="156">
	<div id="cuerpoSuphead" style="width:200px;">
	<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
<form id="form1"  name="form1" action="g_config.php" method="post">
<div id="cuerpo_head"style='top:80px;width:700px;height:300px;'>
	<div id='vehiculos_config'></div>
	<div id='onlineAviso' style='text-align:left;position:absolute;left:220px;top:0px;'></div>
	<div id='contenido'><? if(isset($_GET['bien'])){ echo "Se guardaron sus configuraciones correctamente";}?></div>
	<div id="config_equipo"></div>
	<div id='correo' style='position:absolute;top:0px;width:300px;left:350px;'></div>
	<input type="hidden" id='tipo' value='Acciones del motor encendido/apagado'>
	<input type="hidden" id='tipo2' value='Accion de remolcado'>
	<input type="hidden" id='tipo3' value='Accion de impacto'>
	<input type="hidden" id='tipo4' value='Sin actividad'>
	<input type="hidden" id='tipo5' value='Vehículo en movimiento'>
	<input type="hidden" id='tipo6' value='Fatiga'>
	<input type="hidden" id='tipo7' value='Modulo de toma de fuerza'>
	<input type="hidden" id='tipo8' value='Terminal Conectada/Desconectada'>
	<div id='mostrados' title="Correos para la regla de : " style=''></div>
	<div id='correos_hidden'></div>
</div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>