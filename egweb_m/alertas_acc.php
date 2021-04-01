<?
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('../adodb/adodb.inc.php');
include_once('../patError/patErrorManager.php');
patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
include_once('../patSession/patSession.php');
$sess =& patSession::singleton('egw', 'Native', $options );
$estses = $sess->getState();
if (isset($_GET["Logout"])){
	$web = $sess->get("web");
	$sess->Destroy();
	if($web == 1)
		header("Location: indexApa.php?$web");
	else 
		header("Location: index.php?$web");
}
if ($estses == empty_referer) {
	if($web == 1)
		header("Location: indexApa.php?$web");
	else 
		header("Location: index.php?$web");		
} 

$result = $sess->get( 'expire-test' );
if((!patErrorManager::isError($result)) && ($sess->get('Idu'))){
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
}else{
    $web = $sess->get("web"); 
	$sess->Destroy();
	if($web == 1 )
		header("Location: indexApa.php?$web");
	else 
		header("Location: index.php?$web");
}
require("librerias/conexion.php");
require("librerias/SistemasConfigurables/Configsis_nuevo.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
if(preg_match('/seprosat/',curPageURL())){
	$xajax->configure('javascript URI', 'http://www.sepromex.com.mx:81/'.'xajaxs/');
}else{
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

function getIdUsuario(){
	$sess =& patSession::singleton('egw', 'Native', $options );
	return $sess->get('Idu');
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get("Idu");
	$query="SELECT v.id_veh, v.num_veh,v.id_sistema FROM veh_usr as vu INNER JOIN vehiculos v ON vu.num_veh = v.num_veh
			INNER JOIN estveh ev ON (v.estatus = ev.estatus) INNER JOIN sistemas AS S ON v.id_sistema=S.id_sistema
			WHERE vu.id_usuario = $idu AND ev.publicapos = 1 AND 
			exists(
				SELECT * FROM equipos_configurables AS EC INNER JOIN secciones_configurables AS SC ON EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo = EC.id_tipo_equipo AND EC.activo = 1 AND SC.seccion='accesorios' 
			) AND vu.activo = 1 ORDER BY v.id_veh ASC";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
			</tr>";
	$i=0;
	while($row=mysql_fetch_array($rows)){	
		$cont.="<tr>
					<td colspan='2'>
						<input onclick='mostrar(".$row[2].",\"".$row[0]."\",".$row[1].");' type='radio' name='vehiculo[]' value='".$row[1]."'>".$row[0]."
					</td>
				</tr>";
		$i++;
	}
	$objResponse->assign("vehiculos_config","innerHTML",$cont);
	return $objResponse;
}
function mostrar_config($modelo,$idVeh,$veh){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$equipoGps = CONFIGSIS::getObjectFromSistem($modelo);
	$equipoGps->setNumVeh($veh);
	$equipoGps->createJsonFromDB();
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
	$query="SELECT TE.descripcion,V.id_veh FROM vehiculos AS V
			INNER JOIN sistemas as S ON V.id_sistema=S.id_sistema
			INNER JOIN tipo_equipo AS TE ON S.tipo_equipo=TE.id_tipo_equipo
			WHERE V.num_veh=$veh";
	$rows=mysql_query($query);
	$cont="<table id='newspaper-a1'>
			<tr>
				<th>Veh&iacute;culo</th>
				<th>Equipo</th>
			</tr>";
	while($row=mysql_fetch_array($rows)){
		$modelo=strtoupper(str_replace(' ','',$row[0]));
		$cont.="<tr>
					<td align='center'>".$row[1]."</td>
					<td align='center'>".$row[0]."</td>
				</tr>";
	}
	$cont.="</table>";
	$objResponse->assign("config_equipo","innerHTML",$equipoGps->getFormulario());
	$correos="SELECT folio FROM gpscondicionalerta WHERE id_empresa=".$sess->get('Ide');
	$res=mysql_query($correos);
	if(mysql_num_rows($res)>0){
		if(mysql_num_rows($res)==1){
			$folios=mysql_fetch_array($res);
			$box="<input type='checkbox' id='enviar' onclick='xajax_mostrar_correo($folios[0])'>Notificar por correo";
		}
		if(mysql_num_rows($res)>1){
			$box="<input type='checkbox' id='enviar' onclick='xajax_mostrar_select(".$sess->get('Ide').")'>Notificar por correo";
		}
	}else{
		$box="<input type='checkbox' id='enviar' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').")'>Notificar por correo";
	}
	$objResponse->assign("correo","innerHTML",$box);
	return $objResponse;
}
function mostrar_correo($folio){
	$objResponse = new xajaxResponse();
	$query=mysql_query("SELECT enviaremail from gpscondicionalerta where folio=$folio");
	$correo=mysql_fetch_array($query);
	$correos="Se notificara a los siguientes correos:<br> <textarea id='correos' rows='5' cols='30' readonly='readonly'>".$correo[0]."</textarea>";
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function mostrar_select($ide){
	$objResponse = new xajaxResponse();
	$query=mysql_query("SELECT enviaremail,folio from gpscondicionalerta where id_empresa=$ide");
	$correos="Seleccione que configuraci&oacute;n usara:<br>";
	while($row=mysql_fetch_array($query)){
		$correos.="<input type='radio' name='config' onclick='xajax_guarda_folio(".$row[1].")' value='".$row[1]."'/>".$row[0]." <br>";
	}
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function mostrar_nuevo($ide){
	$objResponse = new xajaxResponse();
	$data="Ingrese el o los correos a los que se enviaran las notificaciones separados por un punto y coma ';':<br>
	<textarea id='correos' rows='5' cols='30'></textarea><input type='hidden' id='ide' value='".$ide."' />";
	$objResponse->assign("mostrados","innerHTML",$data);
	$objResponse->script("mostrar_dialog()");
	return $objResponse;
}
function guarda_folio($folio){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sess->set('config_folio',$folio);
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
	}else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$result = $equipoGps->getStatusResponse($idRequest);
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfig());
	}else if($result == "DESCONECTADO"){
		$objResponse->script("cancelTimerNotConected()");
	}else{
		$objResponse->script("setUpTimerOnline()");
	}
	return $objResponse;		
}
function sendRequest($idsistema,$numveh,$jsonString,$request,$datos){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$numveh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$equipoGps->setNumVeh($numveh);
	$equipoGps->sendRequest(trim($jsonString),trim($request),getIdUsuario(),trim($datos));
	$sess->set("ACTIVO",trim($jsonString));
	$objResponse->script($equipoGps->callGeneralTimer($request));return $objResponse;		
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
	}else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$activo=$sess->get("ACTIVO");
	if($sess->get("config_folio")==''){
		$equipoGps->inserta_nueva($idRequest,$activo);
	}else{
		$equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"));
	}
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
	}else{
		$objResponse->alert("Error encontrado");
	}
	return $objResponse;		
}
$xajax->processRequest();
$xajax->printJavascript();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Alertas de Accesorios</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<script language="JavaScript">
	$(document).ready(function () {
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
		$.ajax({
			type: 'GET',
			url: 'includes/buscar_equipo.php?id='+idSis+'&num_veh='+numVeh,
			timeout: 500,
			success: function(data) {
			  	$.ajax({
					url: 'librerias/SistemasConfigurables/'+data+'.js',
				  	dataType: "script"
				});
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
			  	alert("error retrieving content");
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
			}).dialog('open');
		}
	}
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();xajax_guarda_folio('')" style="width:700px;overflow:hidden;height:440px;" >
	<div id="fondo1" style="width:700px;height:440px;">
		<div id="fondo2" style="width:700px;height:440px;">
			<div id="fondo3" style="width:700px;height:440px;">
				<center>
					<div id="cuerpo2" width="700px" height="156">
						<div id="cuerpoSuphead" style="width:200px;">
							<div id="logo"><img src='img2/logo1.png'></div>
						</div>
						<form id="form1"  name="form1" action="g_config.php" method="post">
							<div id="cuerpo_head"style='top:80px;width:700px;height:300px;'>
								<div id='vehiculos_config'></div>
								<div id='onlineAviso' style='text-align:left;position:absolute;left:220px;top:0px;'></div>
								<div id='contenido'><? if(isset($_GET['bien'])){ echo "Se guardaron sus configuraciones correctamente";}?></div>
								<div id="config_equipo"></div>
								<div id='correo' style='position:absolute;top:0px;width:300px;left:350px;'></div>
								<div id='mostrados' style=''></div>
							</div>
						</form>
					</div>
				</center>
			</div>
		</div>
	</div>
</body>