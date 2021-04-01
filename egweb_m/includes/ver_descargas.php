<?
require_once("../librerias/conexion.php");
include_once('../../patSession/patSession.php');
$options = array('expire'=>40);
$sess =& patSession::singleton('egw', 'Native', $options );
$idu=$sess->get("Idu");
// TODO. Esta query devuelve FALSE en lugar de un recurso, por lo tanto tiene error
exit();
$query = mysql_query("SELECT usuario_web from usuarios where id_usuario=".$idu);
$egstation=mysql_fetch_array($query);
$d_egstation=1;
if($egstation[0]==0){
	$d_egstation=0;
}
mysql_close();

echo $d_egstation;
?>