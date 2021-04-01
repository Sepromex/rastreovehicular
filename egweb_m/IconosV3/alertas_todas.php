<?
  include('../adodb/adodb.inc.php');
  include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $options="";
  $sess =& patSession::singleton('egw', 'Native', $options );
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
	$xajax->register(XAJAX_FUNCTION,"findResponseStatus");
	$xajax->register(XAJAX_FUNCTION,"sendRequest");
	$xajax->register(XAJAX_FUNCTION,"findGeneralResponse");
	$xajax->register(XAJAX_FUNCTION,"config_folio");
	$xajax->register(XAJAX_FUNCTION,"mostrar_correos");
	$xajax->register(XAJAX_FUNCTION,"agrega_correo");
	$xajax->register(XAJAX_FUNCTION,"update_correos");
	$xajax->register(XAJAX_FUNCTION,"mostrar_config");
	$xajax->register(XAJAX_FUNCTION,"mostrar_comando");
	/* ALERTAS OTROS*/
	$xajax->register(XAJAX_FUNCTION,"guarda_vel");
	$xajax->register(XAJAX_FUNCTION,"obten_motor");
	$xajax->register(XAJAX_FUNCTION,"obten_fuerza");
	$xajax->register(XAJAX_FUNCTION,"obten_terminal");
	$xajax->register(XAJAX_FUNCTION,"mostrar_correo");
	$xajax->register(XAJAX_FUNCTION,"mostrar_select");
	$xajax->register(XAJAX_FUNCTION,"mostrar_nuevo");
	$xajax->register(XAJAX_FUNCTION,"auditabilidad");
	$xajax->register(XAJAX_FUNCTION,"temperatura");
	$xajax->register(XAJAX_FUNCTION,"obten_sabotaje");
	$xajax->register(XAJAX_FUNCTION,"obten_voltaje");
	/* CORREOS*/
	$xajax->register(XAJAX_FUNCTION,"vel_correo");
	$xajax->register(XAJAX_FUNCTION,"ace_correo");
	$xajax->register(XAJAX_FUNCTION,"rem_correo");
	$xajax->register(XAJAX_FUNCTION,"sin_correo");
	$xajax->register(XAJAX_FUNCTION,"mov_correo");
	$xajax->register(XAJAX_FUNCTION,"imp_correo");
	$xajax->register(XAJAX_FUNCTION,"fza_correo");
	$xajax->register(XAJAX_FUNCTION,"fat_correo");
	$xajax->register(XAJAX_FUNCTION,"mot_correo");
	$xajax->register(XAJAX_FUNCTION,"ter_correo");
	$xajax->register(XAJAX_FUNCTION,"rpm_correo");
	$xajax->register(XAJAX_FUNCTION,"ost_correo");
	$xajax->register(XAJAX_FUNCTION,"pds_correo");
	$xajax->register(XAJAX_FUNCTION,"tmp_correo");
	$xajax->register(XAJAX_FUNCTION,"gas_correo");
	$xajax->register(XAJAX_FUNCTION,"sab_correo");
	//informacion
	$xajax->register(XAJAX_FUNCTION,"info");
	
/* PARTE 'INTERNA'*/	
function auditabilidad($accion,$veh){
	require_once("librerias/conexion.php");
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('ham', 'Native', $options );
	$idu = $sess->get("Idu");
	$app=13;
	$query=mysql_query("select detalle from sepromex.catalogo_auditabilidad where id_app=$app and accion=".$accion);
	$detalles=mysql_fetch_array($query);
	$detalle=$detalles[0];
	$empresa=$sess->get("Ide");
	$consulta = "insert into sepromex.auditabilidad values (0,$idu,'".date("Y-m-d H:i:s")."',$accion,'$veh: $detalle',
	$app,$empresa,'".get_real_ip()."')";
	mysql_query($consulta);
	mysql_close($conec);
	return $objResponse;
}
function info($modulo){
	$objResponse = new xajaxResponse();
	$info="";
	switch($modulo){
		case 'monitorista':
		$info="
			<h2>Monitor de eventos.</h1>
			<p align='justify'>
				Esta herramienta le ayudara a supervisar su veh&iacute;culo de forma sencilla y autom&aacute;tica.<br> 
				Con una sencilla configuraci&oacute;n, podr&aacute; estar al tanto de cuando su 
				veh&iacute;culo entra a una zona de baja cobertura o entra en algun resguardo.<br>
				Si desea ver las instrucciones de clic <a href='#' onclick='jQuery(\"#instrucciones\").show()'>aqu&iacute;</a>
			</p>
			<p id='instrucciones' style='display:none;' align='justify'>
				1.-Indique los minutos m&aacute;ximos que el veh&iacute;culo debe permanecer sin reportar
				(Se recomienda un m&iacute;nimo de 120 minutos).<br>
				2.-Seleccione el intervalo entre los correos de notificaci&oacute;n que le llegaran posteriormente al desfase 
				del tiempo de reporte de su veh&iacute;culo.<br>
				3.-Selecciones si las notificaciones por correo estaran activas o solo se creara un registro interno
				(estos registros se pueden consultar en el bot&oacute;n \"Ver Eventos\" en caso de que el veh&iacute;culo
				tenga eventos registrados).<br>
				4.-Seleccione los dias de la semana en que desea que se monitorie el veh&iacute;culo 
				5.-Seleccione la fecha inicial y final de este monitoreo (un m&aacute;ximo de 15 d&iacute;as), tambien seleccione
				el horario en que se monitoreara el veh&iacute;culo.<br>
				6.-Seleccione los correos a los que se enviaran las notificaciones.<br>
				7.-De clic en guardar o modificar seg&uacute;n sea el caso.<br>
			</p>
		";
		$title="Monitor de eventos";
		break;
		case 'tel_autorizado':
		$info="
			<h2>Tel&eacute;fonos Autorizados</h2>
			<p align='justify'>
				Con esta herramienta usted puede configurar a cuales tel&eacute;fonos celulares puede llamar el equipo P1
			</p>
			<p id='instrucciones' style='display:none;' align='justify'>
			</p>";
		break;
		case 'alertas-p1':
		$info="
			<h2>Aviso de Alertas</h2>
			<p align='justify'>
				Con esta herramienta puede programar su equipo de tal forma que este le notifique al instante en cualquiera de los
				casos que se mencionan al tel&eacute;fono o los tel&eacute;fonos que usted indique.
			</p>";
		break;
		case 'geo_personal':
		$info="
			<h2>Geocerca Personal</h2>
			<p align='justify'>
				Con esta herramienta puede delimitar un perimetro circular teniendo como centro la posicion actual de su equipo GPS,
				esto le permitira configurar una alarma en caso de que su equipo salga de este perimetro en particular.
			</p>";
		break;
		case 'buzzer':
		$info="
			<h2>Alerta Buzzer</h2>
			<p align='justify'>
				Esta herramienta le permite enviar un comando al equipo GPS, el cual al recibirlo, comenzara a emitir 
				sonidos de alertas para localizar al equipo. Al localizar el equipo, basta con presionar el bot&oacute;n frontal para
				confirmar que el equipo ah sido localizado.
			</p>";
		break;
		case 'mov_p1':
		$info="
			<h2>Sensor de movimiento</h2>
			<p align='justify'>
				Esta herramienta, usa el acelerometro interno del equipo, lo cual le permite saber si el equipo esta en movimiento o no
			</p>
			";
		break;
		case 'impacto_p1':
		$info="
			<h2>Alerta de Impacto</h2>
			<p align='justify'>
				Esta herramienta sirve para notificar cuando el equipo detecta un golpe o un cambio precipitado en el movimiento
				del equipo GPS (usando el acelerometro interno).
			</p>";
		break;
		case 'terminal':
		$info="
			<h2>Equipos portatiles</h2>
			<p align='justify'>
				Con esta herramienta podemos saber si nuestro equipo GPS portatil fue conectado o desconectado, tambien podemos indicar 
				si queremos que nos llegue una notificaci&oacute;n si esto llega a suceder.
			</p>";
		break;
		case 't_fuerza':
		$info="
			<h2>Modulo de toma de fuerza</h2>
			<p align='justify'>
				Esta herramienta lo ayudara a estar enterado a cuando es activado el modulo de toma de fuerza y a su vez
				puede ser notificado por correo.
			</p>";
		break;
		case 'e_motor':
		$info="
			<h2>Acciones del motor</h2>
			<p align='justify'>
				Con esta herramienta, puede estar enterado de cuantas veces es encendido o apagado su veh&iacute;culo.
			</p>";
		break;
		case 'odo':
		$info="
			<h2>Od&oacute;metro</h2>
			<p align='justify' style='max-width:250px;'>
				Con esta herramienta puede saber cuantos kilometros a recorrido su veh&iacute;culo sin necesidad de tenerlo fisicamente,
				con ello puede medir rendimientos, distancias y/o consumos en combustible.<br>
				<!--Si desea ver las instrucciones de clic <a href='#' onclick='jQuery(\"#instrucciones\").show()'>aqu&iacute;</a>-->
			</p>
			<p id='instrucciones' style='display:none;max-width:250px;' align='justify' >
				1.-Debe de indicar si desea que cada el odometro sea o no reiniciado cada vez que el veh&iacute;culo se enciende<br>
			</p>
			";
		break;
		case 'remol':
		$info="
			<h2>Veh&iacute;culo remolcado</h2>
			<p align='justify'>
				Esta herramienta le ayudara a saber cuando se mueve su veh&iacute;culo sin estar encendido.
			</p>
			";
		break;
		case 'sin_act':
		$info="
			<h2>Sin Actividad</h2>
			<p align='justify'>
				Con esta Herramienta puede saber cuando su veh&iacute;culo estubo por determinado tiempo detenido
			</p>";
		break;
		case 'en_mov':
		$info="
			<h2>En Movimiento</h2>
			<p align='justify'>
				Esta herramienta le auydar&aacute; a saber cuando su veh&iacute;culo se puso en movimiento despu&eacute;s de estar detenido
			</p>";
		break;
		case 'impact':
		$info="
			<h2>Sensor de Impacto</h2>
			<p align='justify'>
				Con esta herramienta puede determinar cuando su veh&iacute;culo sufre algun tipo de impacto
			</p>";
		break;
		case 'gas':
		$info="
			<h2>Sensor de Gasolina</h2>
			<p align='justify'>
				Con el Sensor de Gasolina, podr&aacute; tener controlado los consumos y los niveles de gasolina
			</p>";
		break;
		case 'pdsr':
		$info="
			<h2>Cambio de tipo de reporte</h2>
			<p align='justify'>
				Esta herramienta le permitira Cambiar el tipo de reporte que tiene su veh&iacute;culo, ya sea, por tiempo, distancia,
				grados de giro y algunas de estas combinaciones.
			</p>
			<p align='justify'>
				Al modificar el tipo de reporte, se puede ver reflejado en su estado de cuenta, ya que puede aumentar o disminuir 
				las veces que reporta el veh&iacute;culo.
			</p>
			<p align='justify'>
				Para mayor informaci&oacute;n, puede contactar al personal de monitoreo o al personal de atencio&oacute;n a clientes
			</p>
			";
		break;
		case 'e_vel':
		$info="
			<h2>Exceso de velocidad</h2>
			<p align='justify'>
				Con esta herramienta podr&aacute; saber con presici&oacute;n cuando su veh&iacute;culo sobrepaso alg&uacute;n limite de velocidad preestablecido
				por usted
			</p>";
		break;
		case 'e_acc':
		$info="
			<h2>Exceso de aceleraci&oacute;n</h2>
			<p align='justify'>
				Esta herramienta le indicara cuando un veh&iacute;culo acelera excesivamente en un lapso de tiempo, con esto podra
				cuidar mas la vida del motor de su unidad y el estado de sus llantas
			</p>";
		break;
		case 'vext':
		$info="
			<h2>Voltaje Externo</h2>
			<p align='justify'>
				Con esta herramienta podr&aacute; conocer el voltaje que posee el acumulador de su vehiculo, esto le ayudara a llevar un control
				en el mantenimiento general de la bater&iacute;a
			</p>";
		break;
		case 'vbat':
		$info="
			<h2>Voltaje Interno</h2>
			<p align='justify'>
				Con esta herramienta podr&aacute; conocer el voltaje que posee la bater&iacute;a de respaldo(interna del equipo)
			</p>";
		break;
		case 'fatiga':
		$info="
			<h2>Fatigas</h2>
			<p align='justify'>
				Esta herramienta le permitir&aacute; establecer un periodo de tiempo o distancia para que su conductor descanse.
			</p>";
		break;
		case 'llamar':
		$info="
			<h2>Modulo Esp&iacute;a</h2>
			<p align='justify'>
				Con esta herramienta podr&aacute; estar en contacto en todo momento con su conductor, ya que le puede indicar al equipo
				que realice llamadas a cualquier celular o tel&eacute;fono fijo.
			</p>";
		break;
		case 'a_temp':
		$info="
			<h2>Sensor de temperatura</h2>
			<p align='justify'>
				Esta herramienta le permitira establecer un margen en la temperatura interna de la caja
			</p>";
		break;
		case 'ost':
		$info="
			<h2></h2>
			<p align='justify'>
			</p>";;
		break;
		case 'dtc':
		$info="
			<h2></h2>
			<p align='justify'>
			</p>";
		break;
		case 'sobre_c':
		$info="
			<h2></h2>
			<p align='justify'>
			</p>";
		break;
		case 'e_rpm':
		$info="
			<h2></h2>
			<p align='justify'>
			</p>";
		break;
		case 'over_s':
		$info="
			<h2></h2>
			<p align='justify'>
			</p>";
		break;
		case 'sab':
		$info="
			<h2>Sabotajes</h2>
			<p align='justify'>
				Con esta herramienta podr&aacute; estar enterado por correo de si su veh&iacute;culo sufre de alguno de estos tipos de sabotaje
			</p>";
		break;
	}
	$objResponse->assign("info",'innerHTML',$info);
	return $objResponse;
}
function findResponseStatus($idsistema,$idRequest,$veh){
	$objResponse = new xajaxResponse();
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$idsistema=43;
	}
	$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	//$objResponse->alert($idRequest);
	$result = $equipoGps->getStatusResponse($idRequest);
	//$objResponse->alert($result);
	if($idsistema==23 || $idsistema==26){
		$result="CONECTADO";
	}
	if( $result == "CONECTADO" ){
		//$objResponse->alert($equipoGps->activaConfig());
		$objResponse->script($equipoGps->activaConfig());
	}
	else if ( $result == "DESCONECTADO" ) {

		$objResponse->script("cancelTimerNotConected($veh)");
		$objResponse->script("$('.links').attr('onclick','alert(\"Su vehiculo esta OFFLINE\")');");
	}
	else {
		$objResponse->script("setUpTimerOnline($veh,'".$idRequest."')");
	}
	return $objResponse;
}
function sendRequest($idsistema,$numveh,$jsonString,$request,$datos){
	$objResponse = new xajaxResponse();
	$options="";
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
	$equipoGps->sendRequest(trim($jsonString),trim($request),$sess->get("Idu"),trim($datos));
	$sess->set("ACTIVO",trim($jsonString));
	$objResponse->script($equipoGps->callGeneralTimer($request));
	//$objResponse->alert($equipoGps->callGeneralTimer($request));
	//$objResponse->alert($jsonString."**".$request."--".getIdUsuario()."&&".$datos);
	return $objResponse;		
}
function findGeneralResponse($idsistema,$idRequest,$request){
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	//$objResponse->alert($idRequest."////".$request." @ ".$idsistema);
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
	//quitar y adaptar desde xajax
	//$objResponse->alert($idRequest."////".$request);
	/*$activo=$sess->get("ACTIVO");
	if($sess->get("config_folio")==''){
		$equipoGps->inserta_nueva($idRequest,$activo);
	}
	if($sess->get("config_vel")!=''){
		$equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"),$sess->get("config_vel"));
		//$objResponse->alert($equipoGps->inserta_nueva2($idRequest,$activo,$sess->get("config_folio"),$sess->get("config_vel")));
	}*/
	$result = $equipoGps->getGeneralResponse($idRequest,$request);
	if ( $result == "Response" ){
		$objResponse->script($equipoGps->noticeResponse($request));
	}else if ( $result == "CancelTimer" ){
		$objResponse->script($equipoGps->cancelGeneralTimer($request));
		$objResponse->script("$('.links').attr('onclick','alert(\"Su vehiculo esta OFFLINE\")');");
	}else if($result == null){
		$objResponse->script($equipoGps->goGeneralTimer($request));
	}
	return $objResponse;
}
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
/* PARTE DE MOSTRAR DATOS*/
function mostrar_config($idsistema,$idVeh,$veh,$tipo){
	$objResponse = new xajaxResponse();
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$sistemas=mysql_query("SELECT veh_x1 FROM vehiculos v where v.num_veh=$veh AND v.id_sistema=$idsistema");
	$sistema=mysql_fetch_array($sistemas);
	if(preg_match("/axps/i",$sistema[0])){
		$equipoGps = CONFIGSIS::getObjectFromSistem(43);
	}
	else{
		$equipoGps = CONFIGSIS::getObjectFromSistem($idsistema);
	}
	$equipoGps->setNumVeh($veh);
	$equipoGps->createJsonFromDB();
	$objResponse->script("setJsonObjectEquipos('".$equipoGps->getJsonString()."')");
	$objResponse->script($equipoGps->callTimerInit($sess->get("Idu"),$veh));

	switch($tipo){
		case 'U1':
		$categorias="
		<th>Velocidad</th>
		<th>Distancias</th>
		<th>Voltajes</th>
		<th>Extras/accesorios</th>";
		$query_e=mysql_query("select clave from veh_accesorio a
			inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
			where a.num_veh=".$veh."
			and clave like '%paroseg%' and a.activo=1");
		$query_g=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%combustible%' and V_A.activo=1");
		$exceso="";
		$gas="";
		$t_fuerza="";
		$temperatura="";
		$espia="";
		if(mysql_num_rows($query_g)>0){
			$gas="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"gas\")}else{ alert($(\"#onlineAviso\").text());}'>Sensor de gasolina</a><br>";
		}
		if(mysql_num_rows($query_e)==0){
			$exceso="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Exceso de velocidad</a><br>";
		}
		$query_f=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
		if(mysql_num_rows($query_f)!=0){
			$t_fuerza="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"encendido\")}else{ alert($(\"#onlineAviso\").text());}'>Toma de fuerza</a>";
		}
		$query_t=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%temperatura%' and V_A.activo=1");
		if(mysql_num_rows($query_t)!=0){
			$temperatura="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"temp\")}else{ alert($(\"#onlineAviso\").text());}'>Temperatura</a><br>";
		}
		$query_es=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%voz%' and V_A.activo=1");
		if(mysql_num_rows($query_es)!=0){
			$espia="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"llamar\")}else{ alert($(\"#onlineAviso\").text());}'>M&oacute;dulo espia</a><br>";
		}
		$comandos="
		<td>
			$exceso
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Aceleraci&oacute;n/desaceleraci&oacute;n</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"fatigue\")}else{ alert($(\"#onlineAviso\").text());}'>Alerta de Fatiga</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"remolcar\")}else{ alert($(\"#onlineAviso\").text());}'>Remolque</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"inactivo\")}else{ alert($(\"#onlineAviso\").text());}'>Sin actividad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"motion\")}else{ alert($(\"#onlineAviso\").text());}'>Veh&iacute;culo en movimiento</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje interno</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje externo</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"impact\")}else{ alert($(\"#onlineAviso\").text());}'>Impacto</a><br>
			$espia
			$gas
			$temperatura
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"pdsr\")}else{ alert($(\"#onlineAviso\").text());}'>Tipo de reporte</a><br>
			$t_fuerza
		</td>
		";
		break;
		case 'U1CP':break;
		case 'U1L':
		$categorias="
		<th>Velocidad</th>
		<th>Distancias</th>
		<th>Voltajes</th>
		<th>Extras/accesorios</th>";
		$query_e=mysql_query("select clave from veh_accesorio a
		inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
		where a.num_veh=".$veh."
		and clave like '%paroseg%' and a.activo=1");
		$exceso="";
		$t_fuerza="";
		$temperatura="";
		if(mysql_num_rows($query_e)==0){
			$exceso="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Exceso de Velocidad</a><br>";
		}
		$query_f=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
		if(mysql_num_rows($query_f)!=0){
			$t_fuerza="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"encendido\")}else{ alert($(\"#onlineAviso\").text());}'>Toma de fuerza</a>";
		}
		$query_t=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%temperatura%' and V_A.activo=1");
		if(mysql_num_rows($query_t)!=0){
			$temperatura="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"temp\")}else{ alert($(\"#onlineAviso\").text());}'>Temperatura</a><br>";
		}
		$comandos="
		<td>
			$exceso
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Aceleraci&oacute;n/desaceleraci&oacute;n</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"remolcar\")}else{ alert($(\"#onlineAviso\").text());}'>Remolque</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"inactivo\")}else{ alert($(\"#onlineAviso\").text());}'>Sin actividad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"motion\")}else{ alert($(\"#onlineAviso\").text());}'>Veh&iacute;culo en movimiento</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje interno</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje externo</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"impact\")}else{ alert($(\"#onlineAviso\").text());}'>Impacto</a><br>
			$temperatura
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"pdsr\")}else{ alert($(\"#onlineAviso\").text());}'>Tipo de reporte</a><br>
			$t_fuerza
		</td>";
		break;
		case 'UC':
		$categorias="
		<th>Velocidad</th>
		<th>Distancias</th>
		<th>Voltajes</th>
		<th>Extras/accesorios</th>";
		$comandos="
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"idvel\")}else{ alert($(\"#onlineAviso\").text());}'>Alerta de Velocidad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"acel\")}else{ alert($(\"#onlineAviso\").text());}'>Aceleraci&oacute;n/desaceleraci&oacute;n</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"rpm\")}else{ alert($(\"#onlineAviso\").text());}'>RPM</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"stepping\")}else{ alert($(\"#onlineAviso\").text());}'>Over stepping</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"inactivo\")}else{ alert($(\"#onlineAviso\").text());}'>Sin actividad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"motion\")}else{ alert($(\"#onlineAviso\").text());}'>Veh&iacute;culo en movimiento</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje interno</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje externo</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"impact\")}else{ alert($(\"#onlineAviso\").text());}'>Impacto</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>DTC</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"fallas\")}else{ alert($(\"#onlineAviso\").text());}'>Fallas</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"calentamiento\")}else{ alert($(\"#onlineAviso\").text());}'>Sobrecalentamiento</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"pdsr\")}else{ alert($(\"#onlineAviso\").text());}'>Tipo de reporte</a>
		</td>";
		break;
		case 'UG':
		$categorias="
		<th>Velocidad</th>
		<th>Distancias</th>
		<th>Voltajes</th>
		<th>Extras/accesorios</th>";
		$comandos="
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"idvel\")}else{ alert($(\"#onlineAviso\").text());}'>Alerta de Velocidad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"acel\")}else{ alert($(\"#onlineAviso\").text());}'>Aceleraci&oacute;n/desaceleraci&oacute;n</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"inactivo\")}else{ alert($(\"#onlineAviso\").text());}'>Sin actividad</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"motion\")}else{ alert($(\"#onlineAviso\").text());}'>Veh&iacute;culo en movimiento</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje interno</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",2,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Voltaje externo</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"impact\")}else{ alert($(\"#onlineAviso\").text());}'>Impacto</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"pdsr\")}else{ alert($(\"#onlineAviso\").text());}'>Tipo de reporte</a>
		</td>";
		break;
		case 'X1P':
		$query_e=mysql_query("select clave from veh_accesorio a
		inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
		where a.num_veh=".$veh."
		and clave like '%paroseg%' and a.activo=1");
		$query_f=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
		$t_fuerza="";
		if(mysql_num_rows($query_f)!=0){
			$t_fuerza="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"encendido\")}else{ alert($(\"#onlineAviso\").text());}'>Toma de fuerza</a>";
		}
		$espia="";
		$query_es=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%voz%' and V_A.activo=1");
		if(mysql_num_rows($query_es)!=0){
			$espia="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"llamar\")}else{ alert($(\"#onlineAviso\").text());}'>M&oacute;dulo espia</a><br>";
		}
		$th="";
		$td="";
		if(mysql_num_rows($query_e)>0){
			$th="<th>Velocidad</th>";
			$td="<td>
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"idvel\")}else{ alert($(\"#onlineAviso\").text());}'>Alerta de Velocidad</a>
			</td>";
		}
		$categorias="
		$th
		<th>Distancias</th>
		<th>Extras/accesorios</th>";
		$comandos="
		$td
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Remolque</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"inactivo\")}else{ alert($(\"#onlineAviso\").text());}'>Sin actividad</a>
		</td>
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			$espia
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
			$t_fuerza
		</td>";
		break;
		case 'X1':

			$query_f=mysql_query("SELECT * FROM veh_accesorio AS V_A
				INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
				WHERE V_A.num_veh='".$veh."'
				AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
			$t_fuerza="";
			if(mysql_num_rows($query_f)!=0){
				$t_fuerza="
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"encendido\")}else{ alert($(\"#onlineAviso\").text());}'>Toma de fuerza</a>";
			}
			$espia="";
			$query_es=mysql_query("SELECT * FROM veh_accesorio AS V_A
				INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
				WHERE V_A.num_veh='".$veh."'
				AND C_A.descripcion like '%voz%' and V_A.activo=1");
			if(mysql_num_rows($query_es)!=0){
				$espia="
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"llamar\")}else{ alert($(\"#onlineAviso\").text());}'>M&oacute;dulo espia</a><br>";
			}
			$query_e=mysql_query("select clave from veh_accesorio a
			inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
			where a.num_veh=".$veh."
			and clave like '%paroseg%' and a.activo=1");
			$th="";
			$td="";
			if(mysql_num_rows($query_e)==0){
				$th="<th>Velocidad</th>";
				$td="<td>
					<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",0,$veh,\"idvel\")}else{ alert($(\"#onlineAviso\").text());}'>Alerta de Velocidad</a>
				</td>";
			}
			$categorias="
			$th
			<th>Distancias</th>
			<th>Extras/accesorios</th>";
			$comandos="
			$td
			<td>
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"odo\")}else{ alert($(\"#onlineAviso\").text());}'>Od&oacute;metro</a><br>
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",1,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Remolque</a>
			</td>
			<td>
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
				$espia
				<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
				$t_fuerza
			</td>";
			break;
		case 'X8':
		$espia="";
		$query_es=mysql_query("SELECT * FROM veh_accesorio AS V_A
			INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
			WHERE V_A.num_veh='".$veh."'
			AND C_A.descripcion like '%voz%' and V_A.activo=1");
		if(mysql_num_rows($query_es)!=0){
			$espia="
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"llamar\")}else{ alert($(\"#onlineAviso\").text());}'>M&oacute;dulo espia</a><br>";
		}
		$categorias="
		<th>Extras/accesorios</th>";
		$comandos="
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones del motor</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"impact\")}else{ alert($(\"#onlineAviso\").text());}'>Impacto</a>
			$espia
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"sabo\")}else{ alert($(\"#onlineAviso\").text());}'>Sabotajes</a><br>
		</td>";
		break;
		case 'P1':
		$categorias="
		<th>Extras/accesorios</th>";
		$comandos="
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"tel\")}else{ alert($(\"#onlineAviso\").text());}'>Registro de Telefonos</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"pan0\")}else{ alert($(\"#onlineAviso\").text());}'>Alertas autorizadas</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"radioP\")}else{ alert($(\"#onlineAviso\").text());}'>Radio de la geocerca</a><br>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"buzz\")}else{ alert($(\"#onlineAviso\").text());}'>Buzzer</a>
		</td>";
		break;
		case 'PORTMAN':
		$categorias="
		<th>Extras/accesorios</th>";
		$comandos="
		<td>
			<a href='#' class='links' onclick='if($(\"#onlineAviso\").text()==\"Estatus actual online\"){ $(\"#config_equipo\").hide();xajax_mostrar_comando(\"$tipo\",3,$veh,\"\")}else{ alert($(\"#onlineAviso\").text());}'>Acciones de la terminal</a>
		</td>";
		break;
	}
	$formu="<table id='newspaper-a1' style='width:100%;'>
		<tr>
			$categorias
		</tr>
		<tr>
			$comandos
		</tr>
	<table>";
	if($tipo=='X1P'){
		$tipo="X1PLUS";
	}
	$datos="Equipo: ".$tipo;
	$datos.="<div style='float:right;display:none;cursor:pointer;' id='m_comandos'>
		<a onclick='mostrar($idsistema,\"$idVeh\",$veh,\"$tipo\")'>Comandos</a></div>";
	$objResponse->assign("config_equipo","innerHTML","Configuraciones posibles: <br>$formu");
	$objResponse->assign("equipo","innerHTML",$datos);
	$objResponse->script("$('#t1').hide()");
	$objResponse->script("$('#t2').hide()");
	$objResponse->script("$('#t3').hide()");
	$objResponse->script("$('#t4').hide()");
	$objResponse->script("$('#m_comandos').hide()");
	$formu="";
	$objResponse->assign("tabs-1","innerHTML",$formu);
	$objResponse->assign("tabs-2","innerHTML",$formu);
	$objResponse->assign("tabs-3","innerHTML",$formu);
	$objResponse->assign("tabs-4","innerHTML",$formu);
	return $objResponse;
}
/*
function mostrar_correo($folio,$tipo){
	$objResponse = new xajaxResponse();

	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("SELECT enviaremail from gpscondicionalerta where folio=$folio and activo=1");
	$correo=mysql_fetch_array($query);
	$ver=str_replace(";","<br><input type='checkbox' >",$correo[0]);
	$correos="
	<table id='newspaper-a1'>
		<tr>
			<th>
				Se notificara a los siguientes correos
			</th>
		</tr>
		<tr>
			<td><input type='checkbox'>$ver</td>
		</tr>
	</table>";

	
	$title= titulo_dialog($tipo);
	//$enviar="<input type='hidden' id='correos' value='$correo[0]'><input type='hidden' id='ide' value='".$sess->get("Ide")."' />";
	//$objResponse->assign("correos_hidden","innerHTML",$enviar);
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->call("xajax_guarda_folio",$folio);
	$objResponse->assign("mostrar_correos","innerHTML",'');
	$objResponse->script("mostrar_dialog('$title')");
	return $objResponse;
}
*/
function mostrar_correo($folio,$tipo){
	
	$objResponse = new xajaxResponse();
	$options="";
	$correos = "";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$query=mysql_query("SELECT enviaremail from gpscondicionalerta where folio=$folio and activo=1");
	$correo=mysql_fetch_array($query);
	$ver2 = explode(";", $correo[0]);
	$correos="
	<table id='newspaper-a1' width=100%>
		<tr>
			<th>
				Se notificara a los siguientes correos
			</th>";

	for($x = 0; $x<count($ver2); $x++){
		$correos.= "
			<tr>
				<td><input type='checkbox'  value='".$ver2[$x]."' onclick='correo_notifica(this.value,this)' >".$ver2[$x]."</td>
			</tr>
		";
	}
	$correos.="</table>";
		
	$title= titulo_dialog($tipo);
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->call("xajax_guarda_folio",$folio);
	$objResponse->assign("mostrar_correos","innerHTML",'');
	$objResponse->script("mostrar_dialog('$title')");
	return $objResponse;
}



function mostrar_select($ide,$tipo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get("Ide");
	$descripcion=ver_descripcion($tipo);
	$query=mysql_query("SELECT enviaremail,folio from gpscondicionalerta where id_empresa=$ide 
	and activo=1 
	and descripcion ='$descripcion'");
	
	$correos="<table id='newspaper-a1'>
			<tr>
				<th>Seleccione que configuraci&oacute;n de correos usara</th>
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
	$title= titulo_dialog($tipo);
	$correos.="</table>";
	$objResponse->assign("mostrados","innerHTML",$correos);
	$objResponse->assign("mostrar_correos","innerHTML",'');
	$objResponse->script("mostrar_dialog('$title')");
	return $objResponse;
}
function mostrar_nuevo($ide,$tipo){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$data="
	<table id='newspaper-a1'>
		<tr>
			<th>Seleccione los Correos a los que se enviaran las notificaciones</th>
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
	$title= titulo_dialog($tipo);
	$objResponse->assign("mostrados","innerHTML",$data);
	$objResponse->assign("mostrar_correos","innerHTML",'');
	$objResponse->script("mostrar_dialog('$title')");
	return $objResponse;
}
function ver_descripcion($tipo){
	switch($tipo){
		case 'e_vel':$descripcion="Exceso de Velocidad desde Equipo";break;
		case 'e_acc':$descripcion="Exceso de Aceleracion";break;
		case 'remol':$descripcion="Accion de remolcado";break;
		case 'e_motor':$descripcion="Acciones del motor encendido/apagado";break;
		case 't_fuerza':$descripcion="Modulo de toma de fuerza";break;
		case 'sin_act':$descripcion="Sin actividad";break;
		case 'impact':$descripcion="Accion de impacto";break;
		case 'en_mov':$descripcion="Vehículo en movimiento";break;
		case 'terminal':$descripcion="Terminal Conectada/Desconectada";break;
		case 'fatiga':$descripcion="Alerta de Fatiga";break;
		case 'e_rpm':$descripcion="Exceso de RPM";break;
		case 'sobre_c':$descripcion="Alerta de temperatura";break;
		case 'pdsr':$descripcion="Cambio PDSR";break;
		case 'over_s':$descripcion="Alerta de Over Steppin";break;
		//falta las reglas para GAS
		case 'gas':$descripcion="Cambios de Gasolina";break;
	}
	return $descripcion;
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
	$mostrar.="<input type='hidden' id='correos' value='$correos' ><input type='hidden' id='ide' value='".$sess->get("Ide")."' />";
	$objResponse->assign("correos_hidden","innerHTML",$mostrar);
	return $objResponse;
}//agregar correo
function mostrar_comando($tipo,$tab,$veh,$cmd){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	switch($tipo){
		case 'U1':
		include("includes/U1PRO/vel.php");
		$objResponse->assign("tabs-1","innerHTML",$formu);
		$objResponse->script("$('#t1').show()");
		$formu="";
		include("includes/U1PRO/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");
		$formu="";
		include("includes/U1PRO/voltaje.php");
		$objResponse->assign("tabs-3","innerHTML",$formu);
		$objResponse->script("$('#t3').show()");
		$formu="";
		include("includes/U1PRO/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'U1CP':break;
		case 'U1L':
		include("includes/U1LITE/vel.php");
		$objResponse->assign("tabs-1","innerHTML",$formu);
		$objResponse->script("$('#t1').show()");
		$formu="";
		include("includes/U1LITE/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");
		$formu="";
		include("includes/U1LITE/voltaje.php");
		$objResponse->assign("tabs-3","innerHTML",$formu);
		$objResponse->script("$('#t3').show()");
		$formu="";
		include("includes/U1LITE/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'UC':
		include("includes/UCAN/vel.php");
		$objResponse->assign("tabs-1","innerHTML",$formu);
		$objResponse->script("$('#t1').show()");
		$formu="";
		include("includes/UCAN/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");
		$formu="";
		include("includes/UCAN/voltaje.php");
		$objResponse->assign("tabs-3","innerHTML",$formu);
		$objResponse->script("$('#t3').show()");
		$formu="";
		include("includes/UCAN/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'UG':
		include("includes/UGO/vel.php");
		$objResponse->assign("tabs-1","innerHTML",$formu);
		$objResponse->script("$('#t1').show()");
		$formu="";
		include("includes/UGO/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");
		$formu="";
		include("includes/UGO/voltaje.php");
		$objResponse->assign("tabs-3","innerHTML",$formu);
		$objResponse->script("$('#t3').show()");
		$formu="";
		include("includes/UGO/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'X1':
		include("includes/X1/vel.php");
		if($formu!=''){
			$objResponse->assign("tabs-1","innerHTML",$formu);
			$objResponse->script("$('#t1').show()");
		}
		$formu="";
		include("includes/X1/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");		
		$formu="";
		include("includes/X1/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'X1P':
		include("includes/X1PLUS/vel.php");
		if($formu!=''){
			$objResponse->assign("tabs-1","innerHTML",$formu);
			$objResponse->script("$('#t1').show()");
		}
		$formu="";
		include("includes/X1PLUS/movs.php");
		$objResponse->assign("tabs-2","innerHTML",$formu);
		$objResponse->script("$('#t2').show()");
		$formu="";
		include("includes/X1PLUS/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'X8':
		include("includes/X8/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'P1':
		include("includes/P1/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
		case 'PORTMAN':
		include("includes/PORTMAN/otros.php");
		$objResponse->assign("tabs-4","innerHTML",$formu);
		$objResponse->script("$('#t4').show()");
		$formu="";
		break;
	}
	$objResponse->script("$('#tabs').show()");
	$objResponse->script("$('#tabs').tabs({active:$tab})");
	$cmd=$cmd."1";
	$objResponse->script("$('#$cmd').focus();$('#$cmd').scroll()");
	$objResponse->script("$('#m_comandos').show();");
	return $objResponse;
}//mostrar comando
function titulo_dialog($tipo){
	switch($tipo){
		case 'e_vel':$title=" para exceso velocidad";break;
		case 'remol':$title=" para remolcado del vehículo";break;
		case 'e_motor':$title=" para encedido/apagado del motor";break;
		case 't_fuerza':$title=" para toma de fuerza";break;
		case 'sin_act':$title=" para vehículo sin actividad";break;
		case 'e_acc':$title=" para exceso de aceleración";break;
		case 'impact':$title=" para sensor de impacto";break;
		case 'en_mov':$title=" para vehiculo en movimiento";break;
		case 'terminal':$title=" para terminal conectada/desconectada";break;
		case 'fatiga':$title=" para fatiga del vehículo/conductor";break;
		case 'e_rpm':$title=" para exceso de rpm";break;
		case 'sobre_c':$title=" para sobrecalentamiento";break;
		case 'gas':$title=" para Gasolina";break;
		case 'pdsr':$title=" para Cambio de reporte";break;
		case 'over_s':$title=" para Over Stepping";break;
	}
	return $title;
}//titulo dialog
function vehiculos(){
	$objResponse = new xajaxResponse();
	$options="";
    $sess =& patSession::singleton('egw', 'Native', $options );
	$idu=$sess->get("Idu");
	$query="select DISTINCT(v.id_veh),v.num_veh,v.id_sistema,s.tipo_equipo,v.veh_x1
			from veh_usr as vu
			inner join vehiculos v on vu.num_veh = v.num_veh
			inner join estveh ev on v.estatus = ev.estatus
			inner join sistemas S ON v.id_sistema=S.id_sistema
			where vu.id_usuario = $idu 
			AND ev.publicapos=1
			AND vu.activo=1
			AND exists(
				SELECT * FROM equipos_configurables AS EC
				INNER JOIN secciones_configurables AS SC on EC.id_tipo_equipo=SC.id_tipo_equipo
				WHERE S.tipo_equipo=EC.id_tipo_equipo
				AND EC.activo=1
				AND SC.seccion in ('accesorios','can','errores','espia','movimientos','otros','reportes','velocidades')
			)
			and S.id_sistema not in(14,22)
			order by v.id_veh asc";
	$rows=mysql_query($query);
	$cont= "<table id='newspaper-a1' width='175px' style='padding:0px;margin:0px;' name='checador'>
			<tr>
				<th colspan='1' style='font-size:14px;width:150px;'>Vehiculo</th>
				<th></th>
			</tr>";
			$i=0;
	$int="";
	$tipo="";
	while($row=mysql_fetch_array($rows)){
		if(mysql_num_rows($rows)==1){
			$int=1;
		}
		$tipo=$row[3];
		if(preg_match("/axps/i",$row[4])){
			$tipo='X1P';
		}
		$cont.="<tr>
					<td colspan='2'><input onclick='mostrar(".$row[2].",\"".$row[0]."\",".$row[1].",\"".$tipo."\");' type='radio' name='vehiculo[]' value='".$row[1]."'>".$row[0]."</td>
				</tr>";
		$i++;
	}
	$cont.= "</table>";	
		
	$objResponse->assign("vehiculos_alertas_todas","innerHTML",$cont);
return $objResponse;
}//vehiculos
/*PARTE DE CORREOS*/
function vel_correo($correos,$veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$tipo="Exceso de Velocidad desde Equipo";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta 
		values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	$query=mysql_query("SELECT * FROM gpscondicionalertadet where folio=$folio and num_veh=$veh and id_msjxclave=27");
	if(mysql_num_rows($query)==0){
		/*
			pendiente mensaje por clave
		*/
		mysql_query("INSERT INTO gpscondicionalertadet 
		values($folio,0,".$sess->get("Ide").",$veh,27,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
		'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and num_veh=$veh");
	}
	return $objResponse;
}//exceso vel

function sab_correo($correos,$veh,$sab,$vol){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$tipo="Sabotajes o fallas";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta 
		values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	if($sab==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where folio=$folio and num_veh=$veh and id_msjxclave=295");
		if(mysql_num_rows($query)==0){
			/*
				pendiente mensaje por clave
			*/
			mysql_query("INSERT INTO gpscondicionalertadet 
			values($folio,0,".$sess->get("Ide").",$veh,295,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
		}
		else{
			mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and num_veh=$veh");
		}
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio and num_veh=$veh");
	}
	if($vol==1){
		$query=mysql_query("SELECT * FROM gpscondicionalertadet where folio=$folio and num_veh=$veh and id_msjxclave=192");
		if(mysql_num_rows($query)==0){
			mysql_query("INSERT INTO gpscondicionalertadet 
			values($folio,0,".$sess->get("Ide").",$veh,192,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
		}
		else{
			mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and num_veh=$veh");
		}
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=0 where folio=$folio and num_veh=$veh");
	}
	
	$objResponse->assign('sab','innerHTML',"<img src='img/apply.png' width='16' height='16' />Cambio aplicado");
	//$objResponse->alert(mysql_error());
	return $objResponse;
}//sabotaje
function ace_correo($correos,$veh){
	$options="";
	$tipo="Exceso de Aceleracion";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta 
		values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=307 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=330 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=331 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=332 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
		$update1="UPDATE gpscondicionalertadet set activo=1 where id_msjxclave=333 and folio=$folio and num_veh=$veh";
		mysql_query($update1);
	}
	/*
		insertamos en auditabilidad
	*/
	auditabilidad(45,$veh);
	//mysql_query("INSERT INTO auditabilidad values(0,".$sess->get('Idu').",'".date("Y-m-d H:i:s")."',45,'Asigna limite de aceleracion al equipo',13,".$sess->get('Ide').")");
	//$objResponse->alert(mysql_error());
	return $objResponse;
}//exceso ace
function rem_correo($correos,$veh){
	$options="";
	$tipo="Accion de remolcado";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta 
		values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,15,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1 where folio=$folio");
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
	return $objResponse;
}//remolcado
function fat_correo($correos,$veh){
	$options="";
	$tipo="Alerta de Fatiga";
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
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
}//fatiga
function fza_correo($correos,$on,$off,$veh){
	$options="";
	$tipo='Modulo de toma de fuerza';
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
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,)";
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
}//toma de fuerza
function mov_correo($correos,$veh){
	$options="";
	$tipo="Vehículo en movimiento";
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
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
}//en movimientoi
function imp_correo($correos,$veh){
	$options="";
	$tipo="Accion de impacto";
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
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
}//impacto
function sin_correo($correos,$veh){
	$options="";
	$tipo="Sin actividad";
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
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
		
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
}//sin actividad	
function mot_correo($correos,$on,$off,$veh){
	$options="";
	$tipo="Acciones del motor encendido/apagado";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
}//motor
function ter_correo($correos,$on,$off,$veh){
	$options="";
	$tipo="Terminal Conectada/Desconectada";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
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
}//terminal
function pds_correo($correos,$veh){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$tipo="Cambio PDSR";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	$query=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,335,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,336,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,337,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=335");
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=336");
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=337");
	}
	return $objResponse;
}//pdsr
function rpm_correo($correos,$veh){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$tipo="Exceso de RPM";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	$query=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,273,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=273");
	}
	return $objResponse;
}//rpm
function tmp_correo($correos,$veh){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$tipo="Alerta de temperatura";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	$query=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,201,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,202,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=201");
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=202");
	}
	return $objResponse;
}//temperatura
function ost_correo($correos,$veh){
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$objResponse = new xajaxResponse();
	$tipo="Alerta de Over Steppin";
	$ide=$sess->get("Ide");
	$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
	if(mysql_num_rows($ver)==0){
		$insert="insert into gpscondicionalerta values(0,'$tipo',0,$ide,'".date("Y-m-d H:i:s")."','$correos',0,0,0,1,-1,0,0,0,-1)";
		mysql_query($insert);
		$folio=mysql_insert_id();
	}
	else{
		$folios=mysql_fetch_array($ver);
		$folio=$folios[0];
		mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$correos' where folio=".$folio);
	}
	$query=mysql_query("SELECT * from gpscondicionalertadet where folio=$folio");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO gpscondicionalertadet values($folio,0,".$sess->get("Ide").",$veh,334,-1,-1,0,0,0,'".date("Y-m-d 00:00:00")."',
			'".date("Y-m-d 00:00:00")."',0,0,1,1,'T','".date("Y-m-d H:i:s")."','-1',0,0,0)");
	}
	else{
		mysql_query("UPDATE gpscondicionalertadet set activo=1 where folio=$folio and  num_veh=$veh and id_msjxclave=334");
	}
	return $objResponse;
}//over stepping
/* PARTE PARA OBTENER DATOS DEL SERVER*/
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

function obten_sabotaje($veh){
	$objResponse = new xajaxResponse();
	$options="";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$ide=$sess->get('Ide');
	$query1=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=295 and activo=1 and id_empresa=$ide");
	$ons=0;
	if(mysql_num_rows($query1)>0){
		$ons=1;
	}
	$query2=mysql_query("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=192 and activo=1 and id_empresa=$ide");
	//$objResponse->alert("select * from gpscondicionalertadet where num_veh=$veh and id_msjxclave=192 and activo=1 and id_empresa=$ide");
	$onv=0;
	if(mysql_num_rows($query2)>0){
		$onv=1;
	}
	//$objResponse->alert("obten_sabotaje($ons,$onv)".mysql_error());
	$objResponse->script("obten_sabotaje($ons,$onv)");
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
$xajax->processRequest();//procesa los datos de "xajax"
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Comandos Online</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="librerias/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="librerias/SistemasConfigurables/func_Equipos.js"></script>	
	<script type="text/javascript" src="jQuery1.9/js/jquery-1.8.2.js"></script>
	<link href="principal/css/ui-darkness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="principal/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/alertas_todas.js"></script>
	<script type="text/javascript">

		var correo="";
		function correo_notifica(correoE,este){
			if($(este).is(":checked")){
		  		correo+= correoE+";";
		  		$("#correos_hidden").html("<input type='hidden' id='correos' value='"+correo+"'><input type='hidden' id='ide' value='<?php echo $sess->get("Ide");?>' />");
		    }
		    else{
		    	correo = correo.replace(correoE+";","");
		    	$("#correos_hidden").html("<input type='hidden' id='correos' value='"+correo+"'><input type='hidden' id='ide' value='<?php echo $sess->get("Ide");?>' />");
		    }

		}
	</script>
	<style>
		#tabs .ui-widget-header{border: 0px solid #333333;background: none;color: #ffffff;font-weight: bold;}
		#tabs .ui-tabs {border: 0px;}
		.ui-widget-content {border: 0px ;background: none;color: #ffffff;}
		#config_equipo #newspaper-a1 tbody tr:hover td{background: none;}
		#config_equipo a:hover{color: #ffffff;}
	</style>
</head>
<body id="fondo1" onload="xajax_vehiculos();" style="overflow:hidden;width:1100px;background:url(img2/main-bkg-00.png) transparent repeat;" >
<!--<div id="logo"></div><!--Nos muestra el logo de la pagina "oficial"-->
<!-- Estos divs son para el fondo-->
<div id="fondo1" style="overflow:hidden;width:1200px;height:650px;">
<div id="fondo2" style="overflow:hidden;width:1200px;height:650px;">
<div id="fondo3" style="overflow:hidden;width:1200px;height:650px;">
<center>
<div id="cuerpo2" width="225" height="156">
            <div id="cuerpoSuphead" style="width:1200px;">
			<div id="logo"><img src='img2/logo1.png'></div><!--Nos muestra el logo de la pagina "oficial"-->
    		</div>
<form id="form1"  name="form1" action="g_config.php" method="post">
 <div id="cuerpo_head" style='top:80px;width:1200px;height:95%;' >
	<div id='onlineAviso' style='text-align:left;position:absolute;left:220px;top:0px;'></div>
	<div id='equipo' style='text-align:left;position:absolute;left:450px;top:0px;width:255px;z-index:100;'></div>
	<div id='vehiculos_alertas_todas' style="height:450px;"></div>
	<div id='mostrar_correos_dialog' style='display:none;'></div>
	<div id='reglas' style='position:absolute;top:280px;left:220px;width:850px;overflow-x:hidden;height:145px;'></div>
	<div id='contenido'></div>
	<div id='correo' style='position:absolute;top:0px;width:300px;left:500px;'></div>
	<div id="config_equipo" style='height:90%px;top:30px;width:550px;'></div>
	<div id='correos_hidden'></div>
	<div id='mostrar_correos' style='position:absolute;top:0px;width:200px;left:745px;' align='left'></div>
	<div id="tabs" style='font-size:12px;width:510px;position:absolute;top:30px;left:220px;height:32px;display:none;'>
		<ul>
			<li id='t1'><a href="#tabs-1">Velocidad</a></li>
			<li id='t2'><a href="#tabs-2">Distancia</a></li>
			<li id='t3'><a href="#tabs-3">Voltaje</a></li>
			<li id='t4'><a href="#tabs-4">Extras</a></li>
		</ul>
		<div id="tabs-1" style='padding:0;position:absolute;top:40px;left:5px;'></div>
		<div id="tabs-2" style='padding:0;position:absolute;top:40px;left:5px;'></div>
		<div id="tabs-3" style='padding:0;position:absolute;top:40px;left:5px;'></div>
		<div id="tabs-4" style='padding:0;position:absolute;top:40px;left:5px;'></div>
	</div>
	<div id='mostrados' style='background: #000000 url(images/ui-bg_inset-soft_25_000000_1x100.png) 50% bottom repeat-x;'></div>
	<div id="info" style="position:absolute;top:40px;left:755px;max-width:250px;max-height:450px;overflow-y:auto;"></div>
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