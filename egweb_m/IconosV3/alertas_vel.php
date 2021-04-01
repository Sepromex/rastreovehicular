<?
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
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
	$xajax->register(XAJAX_FUNCTION,"acelera_correo");

function acelera_correo($tipo,$correos,$veh,$activo){
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
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where id_msjxclave=307 and folio=$folio and num_veh=$veh");
	if(mysql_num_rows($query)==0){
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,307,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,330,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,331,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,332,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
		$insert1="INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,333,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)";
		mysql_query($insert1);
	}
	else{
		$update1="UPDATE gpscondicionalertadet set activo=$activo where id_msjxclave=307 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=$activo where id_msjxclave=330 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=$activo where id_msjxclave=331 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=$activo where id_msjxclave=332 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=$activo where id_msjxclave=333 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',45,'Asigna limite de aceleracion al equipo',13,".$sess->get('Ide').")");
	$objResponse->alert(mysql_error());
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
				AND SC.seccion='velocidades' 
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
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$modelo");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($modelo);
	}
	$equipoGps->setNumVeh($veh);
	$equipoGps->createJsonFromDB();
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
	//$objResponse->alert($equipoGps->callTimerInit(getIdUsuario()));
	#query para mostrar el sistema y el vehiculo seleccionado
	$query="SELECT TE.descripcion,V.id_veh FROM vehiculos AS V
			INNER JOIN sistemas as S ON V.id_sistema=S.id_sistema
			INNER JOIN tipo_equipo AS TE ON S.tipo_equipo=TE.id_tipo_equipo
			WHERE V.num_veh=$veh";
	$rows=mysql_query($query);
	//$objResponse->assign("contenido","innerHTML",$query);
	
	$cont="
	<table id='newspaper-a1'>
		<tr>
			<th>Veh&iacute;culo</th>
			<th>Equipo</th>
		</tr>";
	while($row=mysql_fetch_array($rows)){
	$modelo=strtoupper(str_replace(' ','',$row[0]));
		$cont.="
			<tr>
				<td align='center'>".$row[1]."</td>
				<td align='center'>".$row[0]."</td>
			</tr>
		";
	}
	$cont.="</table>";
	//$objResponse->assign("config_equipo","innerHTML",$cont);
	$objResponse->assign("config_equipo","innerHTML",$equipoGps->getFormulario());
	$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." and activo=1 and descripcion like '%Exceso de Velocidad desde Equipo%'";
	$res=mysql_query($correos);
	if(mysql_num_rows($res)>0){
		if(mysql_num_rows($res)==1){
			$folios=mysql_fetch_array($res);
			$box="<input type='radio' id='enviar' onclick='xajax_mostrar_correo($folios[0])'>Notificar por correo";
		}
		if(mysql_num_rows($res)>1){
			$box="<input type='radio' id='enviar' onclick='xajax_mostrar_select(".$sess->get('Ide').")'>Notificar por correo";
		}
	}
	else{
		$box="<input type='radio' id='enviar' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').")'>Notificar por correo";
	}
	$objResponse->assign("correo","innerHTML",$box);
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
	$mostrar.="<input type='hidden' id='correos' value='$correos'><input type='hidden' id='ide' value='".$sess->get("Ide")."' />";
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
function guarda_vel($vel){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sess->set('config_vel',$vel);
	/*
		insertamos en auditabilidad
	*/
	mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',44,'Asigna limite de velocidad al equipo',13,".$sess->get('Ide').")");
	//$objResponse->alert($sess->get('config_folio'));
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest){
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
	$result = $equipoGps->getStatusResponse($idRequest);
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
	if($sess->get("config_vel")!=''){
		$equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"),$sess->get("config_vel"));
		
		//$objResponse->alert($equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"),$sess->get("config_vel")));
	}/*
	else{
		$equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"),$sess->get("config_vel"));
	}*/
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
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
	<title>Alertas de velocidad</title>
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
		xajax_mostrar_config(idSis,idVeh,numVeh);
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
	}
function mostrar_dialog(){
	if($("#enviar").is(':checked')){
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
function vel_correo(){
	if($("#enviar").is(':checked')){
		var tipo=$("#tipo").val();
		var veh=$("#id_veh").val();
		var activo=0;
		var correos=$("#correos").val();
		if($("#idvel1").is(':checked')){
			activo=1;
		}
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert(activo);
			xajax_vel_correo(tipo,correos,veh,activo);
		}
	}
	
}
function acelera_correo(){
	if($("#enviar").is(':checked')){
		var tipo=$("#tipo2").val();
		var veh=$("#id_veh").val();
		var activo=0;
		var correos=$("#correos").val();
		if($("#acel1").is(':checked')){
			activo=1;
		}
		if(correos==''){
			alert("Es necesario que seleccione al menos un correo");
		}
		else{
			//alert(activo);
			xajax_acelera_correo(tipo,correos,veh,activo);
		}
	}
	
}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();xajax_guarda_folio('');xajax_guarda_vel('')" style="width:700px;overflow:hidden;height:440px;" >
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
	<div id='mostrados' style=''></div>
	<input type="hidden" id='tipo' value='Exceso de Velocidad desde Equipo'>
	<input type="hidden" id='tipo2' value='Exceso de Aceleracion'>
	<div id='correos_hidden'></div>
</div>
</form>
</div>
</center>
</div>
</div>
</div>
</body>