<?
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
	else header("Location: index.php?$web");      	      	
}
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

function getIdUsuario(){
	$sess =& patSession::singleton('egw', 'Native', $options );
	return $sess->get('Idu');
}
function vehiculos(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$idu=$sess->get("Idu");
	$query="SELECT v.id_veh, v.num_veh,v.id_sistema FROM veh_usr AS vu
			INNER JOIN vehiculos v ON vu.num_veh = v.num_veh INNER JOIN estveh ev ON (v.estatus = ev.estatus)
			INNER JOIN sistemas as S ON v.id_sistema = S.id_sistema WHERE vu.id_usuario = $idu AND ev.publicapos=1
			AND exists(
				SELECT * FROM equipos_configurables AS EC
				INNER JOIN secciones_configurables AS SC ON EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo=EC.id_tipo_equipo
				AND EC.activo=1
				AND SC.seccion='errores' 
			)
			AND vu.activo = 1 ORDER BY v.id_veh ASC";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='2' style='font-size:14px;width:150px;'>Vehiculo</th>
			</tr>";
			$i=0;
	while($row=mysql_fetch_array($rows)){
		$cont.="<tr>
					<td colspan='2'><input onclick='mostrar(".$row[2].",\"".$row[0]."\",".$row[1].");' type='radio' name='vehiculo[]' value='".$row[1]."'>".$row[0]."</td>
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
	$cont="<table id='newspaper-a1'><tr><th>Veh&iacute;culo</th><th>Equipo</th></tr>";
	while($row=mysql_fetch_array($rows)){
	$modelo=strtoupper(str_replace(' ','',$row[0]));
		$cont.="
			<tr>
				<td align='center'>".$row[1]."</td>
				<td align='center'>".$row[0]."</td>
			</tr>";
	}
	$cont.="</table>";
	$objResponse->assign("config_equipo","innerHTML",$equipoGps->getFormulario());
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	$result = $equipoGps->getStatusResponse($idRequest);
	if( $result == "CONECTADO" ){
		$objResponse->script($equipoGps->activaConfig());
	}else if ( $result == "DESCONECTADO" ) {
		$objResponse->script("cancelTimerNotConected()");
	}else $objResponse->script("setUpTimerOnline()");
	return $objResponse;		
}
function sendRequest($idSistema,$numveh,$jsonString,$request,$datos){
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idSistema);
	$equipoGps->setNumVeh($numveh);
	$equipoGps->sendRequest($jsonString,$request,getIdUsuario(),$datos);
	$sess->set("ACTIVO",trim($jsonString));
	$objResponse->script($equipoGps->callGeneralTimer($request));
	return $objResponse;		
}
function findGeneralResponse($idsistema,$idRequest,$request){
	$sess =& patSession::singleton('egw', 'Native', $options );  
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	$activo=$sess->get("ACTIVO");
	$equipoGps->inserta_nueva($idRequest,$activo);
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
	}else $objResponse->script($equipoGps->goGeneralTimer($request));
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

$xajax->processRequest();
$xajax->printJavascript();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Alertas de Errores</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/json2.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
	<script language="JavaScript">	
	$(document).ready(function (){
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
			url: 'includes/buscar_equipo.php?id='+idSis,
			timeout: 500,
			success: function(data) {
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
	</script>
</head>
<body id="fondo1" onload="xajax_vehiculos();" style="width:200px;">
	<div id="fondo1" >
		<div id="fondo2">
			<div id="fondo3">
				<center>
					<form id="form1"  name="form1" action="g_config.php" method="post">
						<div id='vehiculos_config'></div>
						<div id='onlineAviso' style='text-align:left;position:absolute;left:220px;top:0px;'></div>
						<div id='contenido'><? if(isset($_GET['bien'])){ echo "Se guardaron sus configuraciones correctamente";}?></div>
						<div id="config_equipo"></div>
					</form>
				</center>
			</div>
		</div>
	</div>
</body>
</html>