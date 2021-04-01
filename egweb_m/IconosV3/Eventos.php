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
require("librerias/SistemasConfigurables/Configsis_nuevo.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
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
$xajax->register(XAJAX_FUNCTION,'matarSesion');
$xajax->register(XAJAX_FUNCTION,'mostrar_salidas');
   
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
function getIdUsuario(){
	$sess =& patSession::singleton('egw', 'Native', $options );
	return $sess->get('Idu');
}

function asignarGeo(){
	$objResponse = new xajaxResponse();
	$dsn  = "<form name='asignar' id='asignar' action='javascript:void(null);' method='post' onsubmit='enviarDatos();'>";
	$dsn .= "<div id='tituloveh'>VEHÍCULOS</div>";
	$dsn .= "<div id='impgeocer'>GEOCERCAS</div>";
	$dsn .= "<div id='cont_autos3'>
			<table id='newspaper-a1' style='width:200px;'>"; 
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
		$dsn .= "<tr><td><input type='checkbox' name='vehiculos' value='".$rowVeh[1]."'>".utf8_encode($rowVeh[0])."</td></tr>"; 
	}              
	$dsn .="</table></div>";
	$dsn .="<div id='espgeocer' class='fuente'>
			<table id='newspaper-a1' style='width:200px;'>";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide = $sess->get('Ide');
	$cad_geo  = "Select nombre,num_geo from geo_time where id_empresa='$ide'";
	$res_geo = mysql_query($cad_geo);
	while($rowGeo=mysql_fetch_row($res_geo)){ 
		$dsn .="<tr><td><input type='checkbox' name='geocercas' value='".$rowGeo[1]."'>".$rowGeo[0]."</td></tr>"; 
	} 
	$dsn .="</table></div>";
	$dsn .="<div id='tareaEven' class='fuente'>";
	$dsn .="<table id='rounded-corner' style='width:200px;'>";
	//$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	//$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr>";
	$dsn .="<td width='20'>";
	$dsn .="<img src='img/apply.png' title='Selecciona todos los vehículos' width='17' height='16' onclick='marcarVeh(this);'/></td>";
	$dsn .="<td>Todos los Vehículos </td>";
	$dsn .="</tr>";
	$dsn .="<tr>";
	$dsn .="<td><img src='img/apply.png' title='Selecciona todas las geocercas' width='17' height='16' onclick='marcarGeo(this);'/></td>";
	$dsn .="<td>Todas las Geocercas</td>";
	$dsn .="</tr>";
	//$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	//$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='panico' value='2' checked='checked'></td><td>Aviso de Pánico a Monitoreo</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='sale' value='1' checked='checked'></td><td>Avisar al Salir</td></tr>";
	$dsn .="<tr><td><input type='checkbox' name='entra' value='1' checked='checked'></td><td>Avisar al Entrar</td></tr>";
	$dsn .="<tr><td colspan='2'>&nbsp;</td></tr>";
	$dsn .="<tr><td colspan='2'>";
	$dsn .="<input type='submit' value='Asignar Geocerca' class='guardar1' />";
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
	$dsn .= "<div id='cont_autosB' class='fuente'>
			<table id='newspaper-a1' style='width:200px;'>"; 
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
			$dsn .= "<tr><td><input type='radio' name='vehiculos' value='".$rowVeh[1].",".$idSistema."' onclick='checkSistema($idSistema,\"".utf8_encode($rowVeh[0])."\",".$rowVeh[1].",this.checked);'><b>".utf8_encode($rowVeh[0])."</b></td></tr>";
		else
			$dsn .= "<tr><td><input type='radio' name='vehiculos' value='".$rowVeh[1].",".$idSistema."' onclick='checkSistema($idSistema,\"".utf8_encode($rowVeh[0])."\",".$rowVeh[1].",this.checked);'>".utf8_encode($rowVeh[0])."</td></tr>";
	}              
	$dsn .="</table></div>";
	$dsn .="</form>";
	$dsn .="<div id='tituloConfig' class='fuente_siete'>CONFIGURACION</div><div id='configEquipos' class='fuente_diez'></div>";
	$dsn .="<div id='onlineAviso' ></div>";
	$objResponse->assign("contEventos","innerHTML",$dsn);
	$objResponse->script("resLinea(3)");
	return $objResponse;
}
/*
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
*/
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
	if($sistema[1]==10 || $sistema[1]==27 || $sistema[1]==14 || $sistema[1]==22){
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
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
	}else if($result == null){
		$objResponse->script($equipoGps->goGeneralTimer($request));
	}
	return $objResponse;
}
function salidasDig(){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$idu = $sess->get('Idu');
	
	$dsn .= "<div id='contAutoSalida'>";
	$dsn .= "<table id='newspaper-a1' style='width:200px'>";
	$dsn .= "<tr><th>Vehículos</th></tr>";
	//$dsn .= "<tr><td></td></tr>";
	//$dsn .= "<select multiple name='vehiculos' size='30' class='select2' onchange='xajax_odometro(this.value);' >";
	$cad_veh = "select v.id_veh, v.num_veh,v.id_sistema
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
			)
			AND ev.publicapos=1	
			and vu.activo=1
			order by v.id_veh asc"; 
	$resp_veh = mysql_query($cad_veh);
		if($resp_veh != 0 ){
			while($row = mysql_fetch_array($resp_veh)){
				$dsn .= "<tr>
					<td>
						<input type='radio' name='vehiculo' onclick='mostrar_salidas(".$row[2].",".$row[1].")'>".utf8_encode($row[0])."
						
					</td>
					</tr>";	
			}
		}
	//$dsn .= "</select></td>";
	$dsn .= "</td>";
	$dsn .= "</tr>";
	$dsn .= "</table>";
	$dsn .= "</div>";
	//$dsn .= "</form>";
	$objResponse->assign("contEventos","innerHTML",$dsn);
	return $objResponse;
}

function mostrar_salidas($modelo,$veh){
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
	$idu = $sess->get('Idu');
	$query="SELECT C_A.descripcion,V_A.id_accesorio, V_A.salida FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh=$veh
			AND V_A.SALIDA!='NA' group by C_A.descripcion order by V_A.salida ";
	$rows=mysql_query($query);
	$dsn  = "<form action='javascript:void(null);' method='post' name='salDig' id='salDig' onsubmit='sendForm(".(int)$idu.",$veh)'>";
	$dsn .= "<table border='0' id='rounded-corner' style='width:350px'>";
	$dsn .= "<tr >
			<th>Salidas Digitales</th>
			<th id='onlineAviso'></th>
		</tr>";
	
	/*$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='1' checked='checked'/> Salida 1</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='2' /> Salida 2</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='3' /> Salida 3</td></tr>";
	$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='4' /> Salida 4</td></tr>";
	$dsn .= "<tr><td colspan='2'>&nbsp;</td></tr>";*/
	if(mysql_num_rows($rows)>0){
		while($row=mysql_fetch_array($rows)){
			$salida=str_replace("D","",$row[2]);
			if(preg_match("/Seguro/i",$row[0])){
				$q_sis=mysql_query("select * from sistemas where id_sistema=$modelo and descripcion like '%-U%'");
				if(mysql_num_rows($q_sis)>0){
					$salida=4;
				}
			}
			$dsn .= "<tr>
				<td colspan='2'>
					<input type='radio' name='salida' value='$salida' />".utf8_encode($row[0])."
				</td>
				</tr>
			";
		}
		$dsn .= "<tr>";
		$dsn .= "<td><input type='radio' name='tipo' id='tipo' value='1' checked='checked'/> Activar</td>";
		$dsn .= "<td><input type='radio' name='tipo' id='tipo' value='0' /> Desactivar</td>";
		$dsn .= "</tr>";
		$dsn .= "<tr>";
		$dsn .= "<td id='conf'><input type='button' class='guardar1' value='Confirmar' onclick='confirmar();'/></td>";
		$dsn .= "<td id='canc'><input type='button' class='cancelar1' value='Cancelar' onclick='cancelar();'/></td>";
		$dsn .= "</tr>";
	}else{
		$dsn .= "<tr><td colspan='2'>Su veh&iacute;culo no cuenta con dispositivos de salida pre-configurados</td></tr>";
		$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='1' checked='checked'/> Salida 1</td></tr>";
		$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='2' /> Salida 2</td></tr>";
		$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='3' /> Salida 3</td></tr>";
		$dsn .= "<tr><td colspan='2'><input type='radio' name='salida' id='salida' value='4' /> Salida 4</td></tr>";
		$dsn .= "<tr>";
		$dsn .= "<td id='conf'><input type='button' class='guardar1' value='Confirmar' onclick='confirmar();'/></td>";
		$dsn .= "<td id='canc'><input type='button' class='cancelar1' value='Cancelar' onclick='cancelar();'/></td>";
		$dsn .= "</tr>";
	}
	$dsn .= "<tr><td colspan='2' id='leyen'></td></tr>";
	$dsn .= "<tr><td colspan='2' id='psw'></td></tr>";
	$dsn .= "</table></form>";

	
	$objResponse->assign("contSalida","innerHTML",$dsn);
	return $objResponse;
}

function solicitud($formSalida,$idu,$veh){
	$objResponse = new xajaxResponse();
	//$objResponse->alert($veh);
	$pass = $formSalida['passw'];
	if($pass==''){
		$objResponse->alert("Inserte su contraseña de acceso a la EGWeb");	
	}
	else{
		$cad_emp = "select username,id_empresa from usuarios where id_usuario='$idu' and password='$pass'";
		$res_car = mysql_query($cad_emp);
		$row = mysql_fetch_array($res_car);
		if($row[0]){
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
					$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',57,'Activacion de salida digital ($veh)',
					13,$row[1],'".get_real_ip()."')";
					mysql_query($consulta);
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
					$consulta = "insert into auditabilidad values (0,'$idu','".date("Y-m-d H:i:s")."',58,'Desactivaccion de salida digital ($veh)',
					13,$row[1],'".get_real_ip()."')";
					mysql_query($consulta);
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

$xajax->processRequest();
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salidas Digitales</title>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>
<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript">
idleTime = 0;
$(document).ready(function () {
  
    $(this).mousemove(function (e) {
       opener.idleTime = 0;
    });
    $(this).keypress(function (e) {
        opener.idleTime = 0;
    });
});

function mostrar_salidas(idSis,numVeh){
		cancelActualTimer();
		xajax_mostrar_salidas(idSis,numVeh);
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
</script>

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
/*
function tiempo(idu,p){
	if(p==1){
		setTimeout('tiempo('+idu+','+p+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
	}
}
*/
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
	document.getElementById("conf").innerHTML="<input type='submit' class='guardar1' value='Enviar'/>";
}

function cancelar(){
	document.getElementById("leyen").innerHTML="";
	document.getElementById("psw").innerHTML="";
	document.getElementById("conf").innerHTML="<input type='button' class='guardar1' value='Confirmar' onclick='confirmar();'/>";
	document.salDig.reset();
}

function sendForm(idu,veh){
	//alert("entra");
	xajax_solicitud(xajax.getFormValues("salDig"),idu,veh);
	document.getElementById("leyen").innerHTML="";
	document.getElementById("psw").innerHTML="";
	document.getElementById("conf").innerHTML="<input type='button' class='guardar1' value='Confirmar' onclick='confirmar();'/>";
}
</script>
</head>
<body id="fondo" style="width:700px;overflow:hidden;height:540px;" onload="xajax_salidasDig();">
<div id="fondo1" style="width:700px;height:540px;">
<div id="fondo2" style="width:700px;height:540px;">
<div id="fondo3" style="width:700px;height:540px;">
<center>
<div id="cuerpo2" width="700px" height="156">
	<div id="cuerpoSuphead" style="width:200px;">
		<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
	</div>
	<div id="cuerpo_head"style='top:80px;width:700px;height:400px;'>
	<div id="contEventos"></div>   
	<div id='contSalida'></div>	
</div>
</div>
</center>
</div>
</div>
</div>
</body>