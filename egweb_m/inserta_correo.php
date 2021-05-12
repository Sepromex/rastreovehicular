<?
include("librerias/conexion.php");
$dat=$_GET['data'];
$ide=$_GET['ide'];
$tipo="Exceso de Velocidad desde Equipo";
$ver=mysql_query("select folio from gpscondicionalerta where id_empresa=$ide and descripcion ='$tipo'");
//echo mysql_error();
if(mysql_num_rows($ver)==0){
	$insert="insert into gpscondicionalerta values(0,'Exceso de Velocidad desde Equipo',0,$ide,'".date("Y-m-d H:i:s")."','$dat',0,0,15,1,-1,0,0,0,-1)";
	mysql_query($insert);
	if(mysql_error()){
		echo $insert;
	}
	else{
		echo mysql_insert_id();
	}
}
else{
	$folio=mysql_fetch_array($ver);
	mysql_query("UPDATE gpscondicionalerta set activo=1,enviaremail='$dat' where folio=".$folio[0]);
	echo $folio[0];
}
?>