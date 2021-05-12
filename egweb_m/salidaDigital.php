<?php
 include_once('../patError/patErrorManager.php');
  patErrorManager::setErrorHandling( E_ERROR, 'ignore' );
  patErrorManager::setErrorHandling( E_WARNING, 'ignore' );
  patErrorManager::setErrorHandling( E_NOTICE, 'ignore' );
  include_once('../patSession/patSession.php');
  $sess =& patSession::singleton('egw', 'Native', $options );
  $estses = $sess->getState();
  if (isset($_GET["Logout"])){
	$sess->Destroy();
    header("Location: index.php");
  }
  if ($estses == empty_referer) {
  	header("Location: index.php");
  } 
  $result = $sess->get( 'expire-test' );
  if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))) {
		$queryString = $sess->getQueryString();	
		$idu = $sess->get("Idu");
		$ide = $sess->get("Ide");
    	$usn = $sess->get("Usn");
		$pol = $sess->get("Pol");
		$reg = $sess->get("Registrado");
		$nom = $sess->get("nom");
		$prm = $sess->get("per");
		$est = $sess->get("sta");
		$eve = $sess->get("eve");
		if(!$reg)
			$sess->set('Registrado',1);
	}
	else{
      	$sess->Destroy();
      	header("Location: index.php");
}          
//se registran variables
require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax(); 
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"alertas");
$xajax->register(XAJAX_FUNCTION,"solicitud");
$xajax->register(XAJAX_FUNCTION,"odometro");
$xajax->register(XAJAX_FUNCTION,"fijarOdometro");

function alertas($idu){
	$objResponse = new xajaxResponse();
	$sess =& patSession::singleton('egw', 'Native', $options );
	$evento = $sess->get('evf');
	$ban = $sess->get('ban');	
	$cad_pos = "select count(*) as suma ";
	$cad_pos .= " from veh_usr v ";
	$cad_pos .= " left outer join posiciones p on (v.num_veh = p.num_veh)";
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
				if($formSalida['tipo'] == 1){//activar
					if($formSalida['salida'] == 1){
						$com = "$idu;$veh;A0,0C63";
					}
					if($formSalida['salida'] == 2){
						$com = "$idu;$veh;A0,0C127";
					}
					if($formSalida['salida'] == 3){
						$com = "$idu;$veh;A0,0C191";
					}
					if($formSalida['salida'] == 4){
						$com = "$idu;$veh;A0,0C255";
					}
				}
				if($formSalida['tipo'] == 0){//desactivar
					if($formSalida['salida'] == 1){
						$com = "$idu;$veh;A0,0C0";
					}
					if($formSalida['salida'] == 2){
						$com = "$idu;$veh;A0,0C64";
					}
					if($formSalida['salida'] == 3){
						$com = "$idu;$veh;A0,0C128";
					}
					if($formSalida['salida'] == 4){
						//$com = "$veh;A0,0C192";
						$com = "$idu;$veh;A0,0C192";
					}
				}
				$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
				$cere = socket_connect($socket,"10.0.2.8",'6668'); //depende de la ip en que se encuentre el cerebro modificado por rikardo rojas
				$paq = "EMAIL:".$com;
				$cere2 = socket_send($socket, $paq, strlen($paq), 0);  //hasta tener un vehiculo asignado
				if($cere2){
					$objResponse->alert("Hay conexión con el EGCenter ".$paq);
				}else $objResponse->alert("No hay conexión");
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
			$comando = "0".(string)$idv.",i";
		}
		if($valor > 0){
			$comando = "0".(string)$idv.",K".$valor;
		}
		$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
		$cere = socket_connect($socket,"10.0.2.8",'6664'); // depende de la ip en que se encuentre el colaborador del odometro
		$cere2 = socket_send($socket, $comando, strlen($comando), 0);  //hasta tener un vehiculo asignado
		if($cere2){
			$objResponse->alert("Su solicitud fue procesada");
		}
		else $objResponse->alert("Su solicitud falló, intente nuevamente");
		socket_close($socket);
	}	
	return $objResponse;
}

$xajax->processRequest(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>EGWEB 3.0</title>
<link href="librerias/dsn.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
function tiempo(idu){
		setTimeout('tiempo('+idu+')',50000);
		document.getElementById('num_msj').innerHTML='<img src="img/loader.gif" width="15px" height="15px" />';
		xajax_alertas(idu);
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
</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<center>
<body id="fondo" onload="tiempo(<?php echo (int)$idu ?>);">
  	<div id="fondo_principal">
  	<div id="cuerpo">
    <form action="javascript:void(null);" method="post" name="salDig" id='salDig' onsubmit="sendForm(<?php echo (int)$idu ?>);">
  		<div id="psw_session" class="fuente_cinco">
        <a href="<?php echo $_SERVER['PHP_SELF']."?Logout=true&".$queryString; ?>">Cerrar Sesi&oacute;n</a>
    </div>
    <div id="msg_bvnd" class="fuente">
    <strong>Bienvenido</strong> <label class="fuente_dos"><?php echo htmlentities($nom); ?></label>
    </div>
    <div id="num_msj" class="fuente_once"></div>
    <div id="menu">
    	<ul id="lista_menu">
         <li><a href="javascript:void(null);" onclick="ayuda();">Ayuda</a></li>
            <li><a href="descargas.php">Descargas</a></li>
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
            <li><a href="catalogos.php">Cátalogo</a></li>
            <?php }?>
            <li><a href="empresa.php">Mi Empresa</a></li>
            <li><a href="principal.php">Localización</a></li>
        </ul>
    </div>
    <div id="contAutoSalida">
    <table border="0">
     <tr style="background:#002B5C" class="fuente_siete"><td>Vehículos</td></tr>
     <tr><td></td></tr>
     <tr><td>
    <select multiple name="vehiculos" size="30" class="vehiculos" onchange="xajax_odometro(this.value);" >
    <?php
	$cad_veh = "select v.id_veh, v.num_veh from veh_usr as vu inner join vehiculos as v on vu.num_veh = v.num_veh ";
	$cad_veh .= "where vu.id_usuario = $idu order by v.id_veh asc"; 
	$resp_veh = mysql_query($cad_veh);
	if($resp_veh != 0 ){
		while($row = mysql_fetch_array($resp_veh)){
			echo  "<option value='$row[1]'>$row[0]</option>";	
		}
	}
	?>
    </select>
    </td></tr>
    </table>
    </div>
    <div id="contSalida">
    <table border="0" class="fuente" width="500">
    <tr style="background:#002B5C" class="fuente_siete"><td colspan="2">Salidas Digitales</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><input type="radio" name="salida" id="salida" value='1' checked="checked"/> Salida 1</td></tr>
    <tr><td colspan="2"><input type="radio" name="salida" id="salida" value='2' /> Salida 2</td></tr>
    <tr><td colspan="2"><input type="radio" name="salida" id="salida" value='3' /> Salida 3</td></tr>
    <tr><td colspan="2"><input type="radio" name="salida" id="salida" value='4' /> Salida 4</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    	<td><input type="radio" name="tipo" id="tipo" value='1' checked="checked"/> Activar</td>
    	<td><input type="radio" name="tipo" id="tipo" value='0' /> Desactivar</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
     <td id="conf"><input type='button' class='boton_x' value='Confirmar' onclick="confirmar();"/></td>
     <td id="canc"><input type='button' class='boton_x' value='Cancelar' onclick="cancelar();"/></td>
     </tr>
     <tr><td colspan="2" id='leyen'></td></tr>
     <tr><td colspan="2" id='psw'></td></tr>
    </table>
    </div>
    <div id="contOdometro"></div>
	<div id="contacto" class="fuente_cinco">Contactenos al Teléfono 38255200 ext. 117 o envíe un email a <u>aclientes@sepromex.com.mx</u></div>
    </form>
  </div>
</div> 
</body>
</center>
</html>