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
if ((!patErrorManager::isError($result)) && ($sess->get('Idu'))){
	$queryString = $sess->getQueryString();	
	$idu = $sess->get("Idu");
	$ide = $sess->get("Ide");
	$usn = $sess->get("Usn");
	$pol = $sess->get("Pol");
	$reg = $sess->get('Registrado');
	$nom = $sess->get('nom');
	$prm = $sess->get('per');
	$est = $sess->get('sta');
	$eve = $sess->get('eve');
	if(!$reg)
		$sess->set('Registrado',1);
}else{
  	$sess->Destroy();
  	header("Location: index.php");
}

require("librerias/conexion.php");
require('../xajaxs/xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../xajaxs/');
$xajax->register(XAJAX_FUNCTION,"updContacto");
$xajax->register(XAJAX_FUNCTION,"insContacto");

function updContacto($formCont,$idc){
	$objResponse = new xajaxResponse();
	$nombre  = 	$formCont['nombre']; 
	$puesto  = 	$formCont['puesto']; 
	$tel	 = 	$formCont['telefono'];
	$correo  =	$formCont['correo'];
	$horario =	$formCont['horario'];
	if($nombre=="" || $puesto=="" || $tel==""){
		$objResponse->alert("Revise los campos con marcados *, Son obligatorios");
		return $objResponse;
	}else{
		$sess =& patSession::singleton('egw', 'Native', $options );
		$cad_con = "update contactos set nombre='$nombre', puesto='$puesto', telefonos='$tel', correo='$correo', horario='$horario'";
		$cad_con .= " where id_contacto = $idc";
		$res_con = mysql_query($cad_con);
		if($res_con){
			$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',8,'Modificar Contacto',13,".$sess->get('Ide').")";
			mysql_query($consulta);
			$objResponse->alert("Se actualizó el contacto");
			$objResponse->script("salirActualizar();");
		}
		else{
			$objResponse->alert("Falló el envio, intente nuevamente");
		}
		return $objResponse;
	}
}
function insContacto($formCont,$idc){
	$objResponse = new xajaxResponse();
	$nombre  = 	$formCont['nombre']; 
	$puesto  = 	$formCont['puesto']; 
	$tel	 = 	$formCont['telefono'];
	$correo  =	$formCont['correo'];
	$horario =	$formCont['horario'];
	$prioridad = $formCont['prioridad'];
	$comen = $formCont['comentario'];
	if($nombre=="" || $puesto=="" || $tel==""){
		$objResponse->alert("Revise los campos con marcados *, Son obligatorios");
		return $objResponse;
	}else{
		$sess =& patSession::singleton('egw', 'Native', $options );
		$ide = $sess->get('Ide');
		$cad_con  = "insert into contactos (id_empresa,nombre,puesto,telefonos,correo,horario,prioridad,t_tel,comentario)";
		$cad_con .= " values ('$ide','$nombre','$puesto','$tel','$correo','$horario','$prioridad','L','$comen')";
		$res_con = mysql_query($cad_con);
		if($res_con != 0){
			$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',7,'Agregar contacto',13,".$sess->get('Ide').")";
			mysql_query($consulta);
			$objResponse->alert("Se creó el contacto");
			$objResponse->script("salirActualizar();");
		}else{
			$objResponse->alert("Falló el envio, intente nuevamente");
		}
		return $objResponse;
	}
}

$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Contacto</title>
	<link href="css/black.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		function cancelCont(){
			this.window.close();
		}
		function cancelCont(){
			this.window.close();
		}
		function enviaDatos(idc,tipo){
			if(tipo == 1){
				xajax_updContacto(xajax.getFormValues("contacto"),idc);
			}
			if(tipo == 0){
				xajax_insContacto(xajax.getFormValues("contacto"));
			}
		}
		function salirActualizar(){
			this.window.close();
			opener.document.location.href='http://www.sepromex.com.mx:81/egweb/catalogos.php?tipo=5';
		}
	</script>
<?php $xajax->printJavascript(); ?>
</head>
<body id="fondo" style='overflow:hidden;'>
	<center>
		<div id="fondo1">
			<div id="fondo2">
				<div id="fondo3">
					<div style='position:absolute;top:0px;left:40px;'>
						<?php if($_GET['tipo']==1){
							$cad_con = "select nombre, puesto, telefonos, correo, horario ,comentario from contactos where id_contacto = ".$_GET['idc']; 
							$res_con = mysql_query($cad_con);
							$row = mysql_fetch_array($res_con);
							$dsn = "<form name='contacto' id='contacto' action='javascrip:void(null);' method='post' >";
							$dsn .= "<table border='0' class='fuente' width='300' id='newspaper-a1'>";
							$dsn .= "<tr><td colspan='2'>Datos del contacto</td></tr>";
							$dsn .= "<tr><td>Nombre:*</td><td><input type='text' name='nombre' value='".$row[0]."' size='30' /></td></tr>";
							$dsn .= "<tr><td>Puesto:*</td><td><input type='text' name='puesto' value='".$row[1]."' size='30' /></td></tr>";
							$dsn .= "<tr><td>Teléfono:*</td><td><input type='text' name='telefono' value='$row[2]' size='30' /></td></tr>";
							$dsn .= "<tr><td>Correo:</td><td><input type='text' name='correo' value='$row[3]' size='30' /></td></tr>";
							$dsn .= "<tr><td>Horario:</td><td><input type='text' name='horario' value='$row[4]' size='30' /></td></tr>";
							$dsn .= "<tr><td colspan='2'>Comentarios:</td></tr><tr><td colspan='2'><textarea name='comentario' cols='33' rows='2'>".$row[5]."</textarea></td></tr>";
							$dsn .= "<tr>";
							$dsn .= "<td>";
							$dsn .= "<a href='javascript:void(null);' onclick='cancelCont();'>";
							$dsn .= "<img src='img/cancel.png' width='40' height='40' border='0'></a></td>";
							$dsn .= "<td>";
							$dsn .= "<a href='javascript:void(null);' onclick='enviaDatos(".$_GET['idc'].",1);'>";
							$dsn .= "<img src='img/filesaveas.png' width='40' height='40' border='0'></a></td>";
							$dsn .= "</tr>";
							$dsn .= "</table>";
							echo $dsn .= "</form>";
						}else{
							$dsn = "<form name='contacto' id='contacto' action='javascrip:void(null);' method='post' >";
							$dsn .= "<table border='0' class='fuente' width='300' id='newspaper-a1'>";
							$dsn .= "<tr><td colspan='2'>Datos del contacto</td></tr>";
							$dsn .= "<tr><td>Nombre:*</td><td><input type='text' name='nombre' size='30' /></td></tr>";
							$dsn .= "<tr><td>Puesto:*</td><td><input type='text' name='puesto' size='30' /></td></tr>";
							$dsn .= "<tr><td>Teléfono:*</td><td><input type='text' name='telefono' size='30' /></td></tr>";
							$dsn .= "<tr><td>Correo:</td><td><input type='text' name='correo' size='30' /></td></tr>";
							$dsn .= "<tr><td>Horario:</td><td><input type='text' name='horario' size='30' /></td></tr>";
							$dsn .= "<tr><td>Prioridad:</td><td><select name='prioridad'>";
							$dsn .= "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>";
							$dsn .= "<option value='4'>4</option><option value='5'>5</option><option value='6'>6</option>";
							$dsn .= "<option value='7'>7</option><option value='8'>8</option><option value='9'>9</option>";
							$dsn .= "<option value='10'>10</option></select></td></tr>";
							$dsn .= "<tr><td colspan='2' align='center'>Comentarios:</td></tr>";
							$dsn .= "<tr><td colspan='2'><textarea name='comentario' cols='33' rows='2'></textarea></td></tr>";
							$dsn .= "<tr>";
							$dsn .= "<td>";
							$dsn .= "<a href='javascript:void(null);' onclick='cancelCont();'>";
							$dsn .= "<img src='img/cancel.png' width='40' height='40' border='0'></a></td>";
							$dsn .= "<td>";
							$dsn .= "<a href='javascript:void(null);' onclick='enviaDatos(0,0);'>";
							$dsn .= "<img src='img/filesaveas.png' width='40' height='40' border='0'></a></td>";
							$dsn .= "</tr>";
							$dsn .= "</table>";
							echo $dsn .= "</form>";
						} ?>			
					</div>
				</div>
			</div>
		</div>
	</center>
</body>
</html>
