<?php   
include_once('../patError/patErrorManager.php');
patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
include_once('../patSession/patSession.php');
$sess =& patSession::singleton('egw', 'Native', $options );
$estses = $sess->getState();
if (isset($_GET["Logout"])) {
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
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
	$queryString = $sess->getQueryString();	
	$idu = $sess->get("Idu");
	$ide = $sess->get("Ide");
    $usn = $sess->get("Usn");
	$pol = $sess->get("Pol");
	$reg = $sess->get('Registrado');
	$prm = $sess->get('per');
	$est = $sess->get('sta');
	$nom = $sess->get("nom");
	$eve = $sess->get("eve");
	$dis = $sess->get('dis');
	$pan = $sess->get('pan');
	if (!$reg) {
	    $sess->set('Registrado',1);	
	}	
  }	else {
	    $web = $sess->get("web"); 
		$sess->Destroy();
		if($web == 1 )
			header("Location: indexApa.php?$web");
		else header("Location: index.php?$web"); 
}          
require("librerias/conexion.php");
require("librerias/SistemasConfigurables/Configsis.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"asignarGeo");
$xajax->register(XAJAX_FUNCTION,"datosRegistro");
$xajax->register(XAJAX_FUNCTION,"salidasDig");
$xajax->register(XAJAX_FUNCTION,"solicitud");
$xajax->register(XAJAX_FUNCTION,"odometro");
$xajax->register(XAJAX_FUNCTION,"fijarOdometro");
$xajax->register(XAJAX_FUNCTION,"configEquipo");
$xajax->register(XAJAX_FUNCTION,"getFormulario");
$xajax->register(XAJAX_FUNCTION,"guardarDatosE");
$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
$xajax->register(XAJAX_FUNCTION,"sendRequest");
$xajax->register(XAJAX_FUNCTION,"findGeneralResponse");


function getIdUsuario(){
	$sess =& patSession::singleton('egw', 'Native', $options );
	return $sess->get('Idu');
}

function alertas($idu,$fecha){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');	
	$cad_pos = "select count(*) as suma ";
	$cad_pos .= " from veh_usr v ";
	$cad_pos .= " left outer join mon_alarmas p on (v.num_veh = p.num_veh)";
	$cad_pos .= " where v.id_usuario = $idu";
	$cad_pos .= " and p.fecha >'".$evento."' and p.entradas = 252";
	$res_pos = mysql_query($cad_pos);
	$row_pos = mysql_fetch_row($res_pos);
	sleep(3);
	if($row_pos[0] == 0 && $ban == 0){ //no hay registros no puede dar click
		$objResponse->assign("num_msj","innerHTML","");
	}
	if($row_pos[0] > 0 && $ban == 0){ //hay registros no a dado click
		$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
							  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	if($row_pos[0] > 0 && $ban == 1){ // hay registros y dio click
	$objResponse->assign("num_msj","innerHTML","<a href='principal.php'title='Click para mostrar'>
						  Usted Tiene <u>".$row_pos[0]."</u> msj de Alerta</a> ");
	}
	
	if($row_pos[0] == 0 && $ban == 1){ //no hay registros ya dio click
		$objResponse->assign("num_msj","innerHTML","");
	}
return $objResponse;
}

function asignarGeo(){
	$objResponse = new xajaxResponse();
	$dsn  = "<form name='asignar' id='asignar' action='javascript:void(null);' method='post' onsubmit='enviarDatos();'>";
	$dsn .= "<div id='tituloveh' class='fuente_siete'>VEHÍCULOS</div>";
	$dsn .= "<div id='impgeocer' class='fuente_siete'>GEOCERCAS</div>";
	$dsn .= "<div id='cont_autos3' class='fuente'>"; 
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get('Idu');
	$cad_veh  = "select v.id_veh, v.num_veh,ev.publicapos
						from veh_usr as vu
						inner join vehiculos v on vu.num_veh = v.num_veh
						inner join estveh ev on (v.estatus = ev.estatus)
						where vu.id_usuario = $idu and ev.publicapos=1
						order by v.id_veh asc";
	$res_veh = mysql_query($cad_veh);
	while($rowVeh=mysql_fetch_row($res_veh)){ 
		$dsn .= "<input type='checkbox' name='vehiculos' value='".$rowVeh[1]."'>".utf8_encode($rowVeh[0])."<br />"; 
	}              
	$dsn .="</div>";
	$dsn .="<div id='espgeocer' class='fuente'>";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide = $sess->get('Ide');
	$cad_geo  = "Select nombre,num_geo from geo_time where id_empresa='$ide'";
	$res_geo = mysql_query($cad_geo);
	while($rowGeo=mysql_fetch_row($res_geo)){ 
		$dsn .="<input type='checkbox' name='geocercas' value='".$rowGeo[1]."'>".$rowGeo[0]."<br />"; 
	} 
	$dsn .="</div>";
	$dsn .="<div id='tareaEven' class='fuente'>";
	$dsn .="<table border='0'>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr>";
	$dsn .="<td width='20'>";
	$dsn .="<img src='img/apply.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='marcarVeh(this);'/></td>";
	$dsn .="<td>Todos los Vehículos </td>";
	$dsn .="</tr>";
	$dsn .="<tr>";
	$dsn .="<td><img src='img/apply.png' title='Selecciona todas las geocercas' width='17' height='16' onclick='marcarGeo(this);'/></td>";
	$dsn .="<td>Todas las Geocercas</td>";
	$dsn .="</tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='panico' value='2' checked='checked'></td><td>Aviso de Pánico a Monitoreo</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='sale' value='1' checked='checked'></td><td>Avisar al Salir</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='entra' value='1' checked='checked'></td><td>Avisar al Entrar</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>";
	$dsn .="<input type='submit' value='Asignar Geocerca' class='boton_poleo2' />";
	$dsn .="</td></tr>";
	$dsn .="</table>";
	$dsn .="</div>";
	$dsn .="</form>";
	$objResponse->assign("contEventos","innerHTML",$dsn);
	$objResponse->script("resLinea(1)");
return $objResponse;
}

function configEquipo(){
	$objResponse = new xajaxResponse();
	$dsn  = "<form name='asignar' id='asignar' action='javascript:void(null);' method='post' onsubmit='enviarDatos();'>";
	$dsn .= "<div id='tituloveh' class='fuente_siete'>VEHÍCULOS</div>";
	$dsn .= "<div id='cont_autosB' class='fuente'>"; 
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get('Idu');
	$cad_veh  = "select v.id_veh, v.num_veh,v.id_sistema
						from veh_usr as vu
						inner join vehiculos v on vu.num_veh = v.num_veh
						inner join estveh ev on (v.estatus = ev.estatus)
						where vu.id_usuario = $idu and publicapos=1
						order by v.id_veh asc";
	$res_veh = mysql_query($cad_veh);
	while($rowVeh=mysql_fetch_row($res_veh)){
		$idSistema = intval($rowVeh[2]);
		$indice=array_search($idSistema,CONFIGSIS::$sistemas_config);
		if(!($indice===false))
			$dsn .= "<input type='radio' name='vehiculos' value='".$rowVeh[1].",".$idSistema."' onclick='checkSistema($idSistema,\"".utf8_encode($rowVeh[0])."\",".$rowVeh[1].",this.checked);'><b>".utf8_encode($rowVeh[0])."</b><br />";
		else
			$dsn .= "<input type='radio' name='vehiculos' value='".$rowVeh[1].",".$idSistema."' onclick='checkSistema($idSistema,\"".utf8_encode($rowVeh[0])."\",".$rowVeh[1].",this.checked);'>".utf8_encode($rowVeh[0])."<br />";
	}              
	$dsn .="</div>";
	$dsn .="</form>";
	$dsn .="<div id='tituloConfig' class='fuente_siete'>CONFIGURACION</div><div id='configEquipos' class='fuente_diez'></div>";
	$dsn .="<div id='onlineAviso' ></div>";
	$objResponse->assign("contEventos","innerHTML",$dsn);
	$objResponse->script("resLinea(3)");
	return $objResponse;
}

function sendRequest($idSistema,$numveh,$jsonString,$request){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idSistema);
	$equipoGps->setNumVeh($numveh);
	$equipoGps->sendRequest($jsonString,$request,getIdUsuario());
	$objResponse->script($equipoGps->callGeneralTimer($request));
	//$objResponse->alert($equipoGps->sendRequest($jsonString,$request,getIdUsuario()));
	//$objResponse->alert($equipoGps->getNumVeh());
	//$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
	return $objResponse;		
}

function getFormulario($idSistema,$idVeh,$numVeh){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idSistema);
	$equipoGps->setNumVeh($numVeh);
	$equipoGps->createJsonFromDB();
	$objResponse->assign("configEquipos","innerHTML",$equipoGps->getFormulario());
	//$objResponse->alert($equipoGps->getJsonString());
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit(getIdUsuario()));
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

function findGeneralResponse($idsistema,$idRequest,$request){
	$objResponse = new xajaxResponse();
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
	}else $objResponse->script($equipoGps->goGeneralTimer($request));
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

function datosRegistro($formAsg,$vehi,$geo){
	$objResponse = new xajaxResponse();
	$panico = (int)$formAsg['panico'];
	$sale	= (int)$formAsg['sale'];
	$entra	= (int)$formAsg['entra'];
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get('Idu');
	$fecha = date("Y-m-d H:i:s");
	$cad_asg = "insert into geo_veh (num_veh,num_geo,dentro,ingreso,salida,fecha,id_usuario) values ";
	for($i=0; $i<count($vehi); $i++){
		for($j=0; $j<count($geo); $j++){
			$cad = "delete from geo_veh where num_veh = $vehi[$i] and num_geo = $geo[$j]";
			mysql_query($cad);
			$cad_asg .="('$vehi[$i]','$geo[$j]','$panico','$entra','$sale','$fecha','$idu'),";
		}
	}
	$cons = substr($cad_asg,0,strlen($cad_asg)-1);
	if(mysql_query($cons)){
		$objResponse->alert("Se realizó la asignación con exito");
	}
	else $objResponse->alert("Falló la asignación");
	return $objResponse;
}

function salidasDig(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get('Idu');
	$dsn  = "<form action='javascript:void(null);' method='post' name='salDig' id='salDig' onsubmit='sendForm(".(int)$idu.")'>";
	$dsn .= "<div id='contAutoSalida'>";
	$dsn .= "<table border='0'>";
	$dsn .= "<tr style='background:#002B5C' class='fuente_siete'><td>Vehículos</td></tr>";
	$dsn .= "<tr><td></td></tr>";
	$dsn .= "<tr><td>";
	$dsn .= "<select multiple name='vehiculos' size='30' class='vehiculos' onchange='xajax_odometro(this.value);' >";
	$cad_veh = "select v.id_veh, v.num_veh
						from veh_usr as vu
						inner join vehiculos as v on vu.num_veh = v.num_veh
						inner join estveh ev on (v.estatus=ev.estatus)
						where vu.id_usuario = $idu and ev.publicapos=1
						order by v.id_veh asc"; 
	$resp_veh = mysql_query($cad_veh);
		if($resp_veh != 0 ){
			while($row = mysql_fetch_array($resp_veh)){
				$dsn .= "<option value='$row[1]'>".utf8_encode($row[0])."</option>";	
			}
		}
	$dsn .= "</select></td>";
	$dsn .= "</tr>";
	$dsn .= "</table>";
	$dsn .= "</div>";
	$dsn .= "<div id='contSalida'>";
	$dsn .= "<table border='0' class='fuente' width='500'>";
	$dsn .= "<tr style='background:#002B5C' class='fuente_siete'><td colspan='2'>Salidas Digitales</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='1' checked='checked'/> Salida 1</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='2' /> Salida 2</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='3' /> Salida 3</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='4' /> Salida 4</td></tr>";
	$dsn .= "<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .= "<tr>";
	$dsn .= "<td><input type='radio' name='tipo' id='tipo' value='1' checked='checked'/> Activar</td>";
	$dsn .= "<td><input type='radio' name='tipo' id='tipo' value='0' /> Desactivar</td>";
	$dsn .= "</tr>";
	$dsn .= "<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .= "<tr>";
	$dsn .= "<td id='conf'><input type='button' class='boton_x' value='Confirmar' onclick='confirmar();'/></td>";
	$dsn .= "<td id='canc'><input type='button' class='boton_x' value='Cancelar' onclick='cancelar();'/></td>";
	$dsn .= "</tr>";
	$dsn .= "<tr><td colspan='2' id='leyen'></td></tr>";
	$dsn .= "<tr><td colspan='2' id='psw'></td></tr>";
	$dsn .= "</table>";
	$dsn .= "</div>";
	$dsn .= "<div id='contOdometro'></div>";
	$dsn .= "</form>";
	$objResponse->assign("contEventos","innerHTML",$dsn);
	return $objResponse;
}

function solicitud($formSalida,$idu){
	$objResponse = new xajaxResponse();
	$pass = $formSalida['passw'];
	if($pass==''){
		$objResponse->alert("Inserte su contraseña de acceso a la EGWeb");	
	}else{
		$cad_emp = "select username from usuarios where id_usuario='$idu' and password='$pass'";
		$res_car = mysql_query($cad_emp);
		$row = mysql_fetch_array($res_car);
		if($row[0]){
			foreach ($formSalida['vehiculos'] as $veh);
			if($veh == ''){
				$objResponse->alert("Seleccione un vehículos");
			}else{
			//las salidas digitales pueden tener x actividad programada
			//pero el comando solo las activa o las desactiva
				if($formSalida['tipo'] == 1){//activar
					if($formSalida['salida'] == 1){
						$com = "$idu;$veh;A0,0C63"; //paro de motor
					}
					if($formSalida['salida'] == 2){
						$com = "$idu;$veh;A0,0C127"; //cierre de chapa
					}
					if($formSalida['salida'] == 3){ //generalmente no se usa
						$com = "$idu;$veh;A0,0C191";
					}
					if($formSalida['salida'] == 4){ //generalmente no se usa
						$com = "$idu;$veh;A0,0C255";
					}
				}
				if($formSalida['tipo'] == 0){//desactivar
					if($formSalida['salida'] == 1){
						$com = "$idu;$veh;A0,0C0";   //paro de motor
					}
					if($formSalida['salida'] == 2){
						$com = "$idu;$veh;A0,0C64";  //abrir de chapa
					}
					if($formSalida['salida'] == 3){   //generalmente no se usan
						$com = "$idu;$veh;A0,0C128";
					}
					if($formSalida['salida'] == 4){  //generalmente no se usa
						//$com = "$veh;A0,0C192";
						$com = "$idu;$veh;A0,0C192";
					}
				}
				$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
				$cere = socket_connect($socket,"10.0.2.8",'6668'); //depende de la ip en que se encuentre el cerebro modificado por rikardo rojas
				$paq = "EMAIL:".$com;
				$cere2 = socket_send($socket, $paq, strlen($paq), 0);  //hasta tener un vehiculo asignado
				if($cere2){
					$objResponse->alert("Se realizó su solicitud con exito");
				}else $objResponse->alert("Su solicitud falló, intente nuevamente");
		    	socket_close($socket);
			}//fin de si exixste vehiculo
		}
		else{
			$objResponse->alert("Contraseña Incorrecta");
		}
	}
	return $objResponse;
}
function odometro($idv){
	$objResponse = new xajaxResponse();
	$cad_veh = "select id_sistema,id_veh from vehiculos where num_veh = $idv";
	$res_veh = mysql_query($cad_veh);
	$row = mysql_fetch_array($res_veh);
	if( $row[0] == 20 ){
		$dsn = "<table border='0' class='fuente' width='500'>";
    	$dsn .= "<tr style='background:#002B5C' class='fuente_siete'>";
    	$dsn .= "<td colspan='2'>Actualizar Odómetro</td></tr>";
		$dsn .= "<tr><td colspan='2'>&nbsp;</td></tr>";
		$dsn .= "<tr><td width='100'>Vehículo:</td><td><u>$row[1]</u></td></tr>";
		$dsn .= "<tr><td>Fijar KM:</td><td><input type='text' name='odo' name='odo' size='3' value='0'/></td></tr>";
		$dsn .= "<tr><td colspan='2'>&nbsp;</td></tr>";
		$dsn .= "<tr><td colspan='2'>";
		$dsn .= "<input type='button' name='boton' class='boton_reporte' size='3' value='Fijar Valor' ";
		$dsn .= "onclick='xajax_fijarOdometro($idv,document.salDig.odo.value)'/>";
		$dsn .= "</td></tr>";
    	$dsn .= "</table>";
		$objResponse->assign('contOdometro','innerHTML',$dsn);	
	}
	else $objResponse->assign('contOdometro','innerHTML','');	
	return $objResponse;
}

function fijarOdometro($idv,$valor){
	$objResponse = new xajaxResponse();
	if($valor < 0 || $valor > 4294967 || $valor == ''){
		$objResponse->alert("Caracter no permitido");
	}else{
		$valor = number_format($valor,1,'.','');
		if($valor == 0){
			$comando = "0".(string)$idv.",i";//poner el odometro en cero
		}
		if($valor > 0){
			$comando = "0".(string)$idv.",K".$valor; //Asignarle un valor x
		}
		$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
		$cere = socket_connect($socket,"10.0.2.8",'6664'); // depende de la ip en que se encuentre el colaborador del odometro
		$cere2 = socket_send($socket, $comando, strlen($comando), 0);  //hasta tener un vehiculo asignado
		if($cere2){
			$objResponse->alert("Su solicitud se realizó con exito");
		}
		else $objResponse->alert("Su solicitud falló, intente nuevamente");
		socket_close($socket);
	}	
	return $objResponse;
}


$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<title>Eventos Para Usuario</title>
 <?php if($dis == 1){ ?>
	<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
    <?php }
	if($dis == 2){
	?>
    <link href="librerias/dsn1.css" rel="stylesheet" type="text/css" />
    <?php } 
	if($dis == 3){
	?>
    <link href="librerias/dsn2.css" rel="stylesheet" type="text/css" />
    <?php }?>
<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>
<script type="text/javascript" language="javascript" src="librerias/json2.js"></script>
<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_P12.js"></script>
<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
<script language="JavaScript" type="text/javascript">
function checkSistema(idSis,idVeh,numVeh,checkado){
	cancelActualTimer();
	xajax_getFormulario(idSis,idVeh,numVeh);
	/*if(checkado){
		var mismoSis = new Array();
		var  veh = document.getElementById("asignar").vehiculos;
		if( veh.length > 0 ){
			for(var i=0; i<veh.length; i++){
				var datos = veh[i].value.split(",");
				if( parseInt(datos[1]) != idSis)
					veh[i].checked = false;
				else {
					if( veh[i].checked )
						mismoSis[mismoSis.length] = datos[0];
				}
			}
		}
		if( mismoSis.length == 1 ){
			xajax_getFormulario(idSis,idVeh,numVeh);
		}
	}*/
}

function cat(per6){
    if(per6==0){
	  alert("Usted no tiene permitido realizar esta función");	
	}
}

function ayuda(){
    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
}
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}

var todoVeh = new Array();
var todoGeo = new Array();
function enviarDatos(){
	var veh = document.getElementById("asignar").vehiculos;
	var geo = document.getElementById("asignar").geocercas;
	if(geo){
		if(veh.length > 1){
			for(var i=0; i<veh.length; i++){
				if(veh[i].checked == true){
					todoVeh.push(veh[i].value);
				}
			}
		}
		else{
			if(document.asignar.vehiculos.checked==true){
				todoVeh.push(document.asignar.vehiculos.value);
			}
		}
		if(geo.length > 1){
			for(var j=0; j<geo.length; j++){
				if(geo[j].checked == true){
					todoGeo.push(geo[j].value);
				}
			}
		}
		else{
			if(document.asignar.geocercas.checked==true){
				todoGeo.push(document.asignar.geocercas.value);
			}
		}
		if(todoGeo.length == 0 || todoVeh.length == 0){
			alert('Seleccione al menos una geocercas o un vehículo');
			todoGeo = todoGeo.slice(todoGeo.length);
			todoVeh = todoVeh.slice(todoVeh.length);
		}
		if(todoGeo.length > 0 && todoVeh.length > 0 ){
			xajax_datosRegistro(xajax.getFormValues("asignar"),todoVeh,todoGeo);
			todoVeh = todoVeh.slice(todoVeh.length);
			todoGeo = todoGeo.slice(todoGeo.length);
		}
	}else alert("Usted no ha creado geocercas");
}

function marcarVeh(obj){
	var o = obj.parentNode;
	var veh = document.getElementById("asignar").vehiculos;
	if(veh.length > 1){
		for(var i=0; i<veh.length; i++){
			veh[i].checked= true;
		}
	}else{
		document.asignar.vehiculos.checked = true;	
	}
	o.innerHTML = "<img src='img/cancel.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='desmarcarVeh(this);'/>";
}
function marcarGeo(obj){
	var o = obj.parentNode;
	var geo = document.getElementById("asignar").geocercas;
	if(geo){
		if(geo.length > 1){
			for(var i=0; i<geo.length; i++){
				geo[i].checked= true;
			}
		}
		else{
			document.asignar.geocercas.checked = true;	
		}
		o.innerHTML = "<img src='img/cancel.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='desmarcarGeo(this);'/>";
	}else alert("No hay geocercas para seleccionar");
}
function desmarcarVeh(obj){
	var o = obj.parentNode;
	var veh = document.getElementById("asignar").vehiculos;
	if(veh.length > 1){
		for(var i=0; i<veh.length; i++){
			veh[i].checked= false;
		}
	}else{
		document.asignar.vehiculos.checked = false;	
	}
	o.innerHTML = "<img src='img/apply.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='marcarVeh(this);'/>";
}
function desmarcarGeo(obj){
	var o = obj.parentNode;
	var geo = document.getElementById("asignar").geocercas;
	if(geo.length > 1){
		for(var i=0; i<geo.length; i++){
			geo[i].checked= false;
		}
	}
	else{
		document.asignar.geocercas.checked = false;	
	}
	o.innerHTML = "<img src='img/apply.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='marcarGeo(this);'/>";
}

function confirmar(){
	document.getElementById("leyen").innerHTML="Inserte su password...";
	document.getElementById("psw").innerHTML="<input type='password' name='passw' size='10'/>";
	document.getElementById("conf").innerHTML="<input type='submit' class='boton_x' value='Enviar'/>";
}

function cancelar(){
	document.getElementById("leyen").innerHTML="";
	document.getElementById("psw").innerHTML="";
	document.getElementById("conf").innerHTML="<input type='button' class='boton_x' value='Confirmar' onclick='confirmar();'/>";
	document.salDig.reset();
}

function sendForm(idu){
	xajax_solicitud(xajax.getFormValues("salDig"),idu);
	document.getElementById("leyen").innerHTML="";
	document.getElementById("psw").innerHTML="";
	document.getElementById("conf").innerHTML="<input type='button' class='boton_x' value='Confirmar' onclick='confirmar();'/>";
}

function resLinea(n){
	if(n==1){
	 $("#ligaAsig").addClass("lineaBajo");
	 $("#ligaConfig").removeClass("lineaBajo");
	 $("#ligaAct").removeClass("lineaBajo");
	}
	if(n==2){
	 $("#ligaAct").addClass("lineaBajo");
	 $("#ligaAsig").removeClass("lineaBajo");
	 $("#ligaConfig").removeClass("lineaBajo");
	}
	if(n==3){
	 $("#ligaAct").removeClass("lineaBajo");
	 $("#ligaAsig").removeClass("lineaBajo");
	 $("#ligaConfig").addClass("lineaBajo");	
	}
}

</script>
<?php 
	$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<center>
<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>,<?php echo $pan ?>);xajax_asignarGeo();">
	<div id="fondo_principal">
		<div id="cuerpo2">
			<div id="psw_session" class="fuente_cinco">
			<a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesión</a></div>
            <div id="num_msj" class="fuente_once"></div>
			<div id="msg_bvnd" class="fuente">Bienvenido, <label class="fuente_dos"><?php echo htmlentities($nom); ?></label></div>
			<div id="menu">
				<ul id="lista_menu">
				<li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
            	<!--<li><a href="descargas.php">Descargas</a></li>-->
        		<li id="current"><a href="Eventos.php">Eventos</a></li>
				<?php 
                $si = strstr($prm,"5");
                if(($est != 3) ||($est == 3 && !empty($si))){?>
                <li><a href="recorrido_nuevo.php">Reportes</a></li>
                <?php }?>
                <li><a href="usuarios.php">Usuarios</a></li>
                <?php 
                $si = strstr($prm,"6");
                if(($est != 3) ||($est == 3 && !empty($si))){?>
                <li><a href="catalogos.php">Catálogo</a></li>
                <?php }?>
                <li><a href="empresa.php">Mi Empresa</a></li>
                <li><a href="principal.php">Localización</a></li>
				</ul>
			</div>
            
            <div id="parametros" class="fuente_diez">            
            <ul id="lista_menu">	
      			<li id="ligaAsig" ><a href="javascript:void(null);" onclick="xajax_asignarGeo();resLinea(1)">
                	Asignar Geocercas</a>
                </li>
                <?php if($est != 3){?>
      			<li id="ligaAct"><a href="javascript:void(null);" onclick="xajax_salidasDig();resLinea(2)" >
                	Activación de salidas digitales
                </a></li>
                 <?php }?>
				<li id="ligaConfig"><a href="javascript:void(null);" onclick="xajax_configEquipo();resLinea(3)" >
					Configuración
				</a></li>
    		</ul>
            </div>
			<div id="contEventos"></div>   
		<div id="contactoEvento" >Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u></div>
		</div>
	</div>
</body>
</center>
</html>
