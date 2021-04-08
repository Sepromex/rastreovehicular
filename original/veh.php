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
		$reg = $sess->get('Registrado');
		$nom = $sess->get('nom');
		$est = $sess->get('sta');
		$eve = $sess->get('eve');
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
$xajax->register(XAJAX_FUNCTION,"eliminar");
$xajax->register(XAJAX_FUNCTION,"inicio");

function inicio($idu,$est){
$objResponse = new xajaxResponse();
$cad_asn  = "select v.id_veh, v.num_veh";
$cad_asn .= " from veh_usr vu";
$cad_asn .= " inner Join vehiculos v on vu.num_veh = v.num_veh";
$cad_asn .= " where vu.id_usuario =  $idu and vu.activo=1";
$cad_asn .= " order by v.id_veh asc";
$res_asn = mysql_query($cad_asn);
if(mysql_num_rows($res_asn)){
	$dsn = "<div style='position:absolute;top:20px;left:55px;'><center><table id='newspaper-a1' style='margin-top: 0px;'>";
	$dsn .= "<tr>";
	$dsn .= "<th>Vehículo</th><th>&nbsp;</th>";
	$dsn .= "</tr>";
		while($row = mysql_fetch_array($res_asn)){
		  $dsn .= "<tr><td>$row[0] $row[2]</td><td>";
		  if($est!=3){
			$dsn .= "<a href='javascript:void(null);' onclick='elimina_asg($row[1],".$_GET['idu'].")'><img src='img/ico_delete.png' border='0' ></a>";
		  }
		  $dsn .= "</td>";
		  $dsn .= "</tr>";
		}
	$dsn .= "</table></center></div>";
	$objResponse->assign('cuerpo1','innerHTML',$dsn);
}else
$objResponse->assign('cuerpo1','innerHTML','No hay vehículos asignados');
return $objResponse;
}

function eliminar($idv,$idu){
$objResponse = new xajaxResponse();
	$cad_asg = "UPDATE veh_usr set activo=0 where id_usuario='$idu' and num_veh='$idv' ";
	$sess =& patSession::singleton('egw', 'Native', $options );
	$consulta = "insert into auditabilidad values (0,'".$sess->get('Idu')."','".date("Y-m-d H:i:s")."',18,'Eliminar vehiculo asignado',13,".$sess->get('Ide').")";
	mysql_query($consulta);
	//$objResponse->alert(mysql_error());
	$res_asg = mysql_query($cad_asg);
	if($res_asg){
		$objResponse->alert('Se eliminó la asignación');
		$objResponse->call("xajax_inicio",$idu);
	}
	else $objResponse->alert('Falló la solicitud');
return $objResponse;
}


$xajax->processRequest();     
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vehiculos Asignados</title>
</head>
<link href="css/black.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function elimina_asg(idv,idu){
var c = confirm("¿Está usted seguro de eliminar la asignación?");
	if(c)
		xajax_eliminar(idv,idu);
}
</script>
<?php 
$xajax->printJavascript(); //genera el codigo necesario de js que se muestra
?>
</head>
<body id='fondo1' onload="xajax_inicio(<?php echo $_GET['idu']; ?>,<?php echo $est; ?>)" style="width:220px;height:220px;" >
<div id="fondo1">
<div id="fondo2">
<div id="fondo3">
	<div id='cuerpo1' style="width:250px;height:220px;"></div>
</div>
</div>
</div>
</body>
</html>
