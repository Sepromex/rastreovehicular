<?
require_once("../librerias/conexion.php");
include_once('../../patSession/patSession.php');
$options = array('expire'=>40);
$sess =& patSession::singleton('egw', 'Native', $options );
$ide=$sess->get("Ide");  
$cons_Tsitios = "select id_tipo,descripcion from tipo_sitios where id_empresa = $ide or id_empresa = 15";
	$resp_Tsitios = mysql_query($cons_Tsitios);
	$opc="'"; 
	while($row_Tsitios = mysql_fetch_row($resp_Tsitios)){
		$opc .="<option value=".$row_Tsitios[0].">".htmlentities($row_Tsitios[1])."</option>";			
	}
	$opc.="'";
mysql_close();
echo $opc;
?>