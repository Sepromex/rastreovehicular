<?
require("librerias/conexion.php");
$ayer=strtotime($fecha_ini."-1 day");
$fecha_ini='2013-11-12 13:00:00';
$fecha_fin='2013-11-12 13:30:00';
$id_emp=1170;
$veh=67912 ;
$query="SELECT id from id_pos where fechahora>'".date("Y-m-d H:i:s",$ayer)."' order by id limit 1";
$ultimas=mysql_query($query);
$ultima=mysql_fetch_array($ultimas);
$max_pos='';
if($ultima[0]>0){
	$max_pos="and p.id_pos>$ultima[0]";
}
$datos_rec="select p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,
(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,
pm.descripcion,cm.mensaje,v.id_sistema 
from posiciones p 
left outer join vehiculos v on (p.num_veh = v.num_veh) 
left outer join postmens pm on (pm.t_mensaje = p.t_mensaje)
left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = $id_emp and p.t_mensaje=3) 
where p.num_veh = '$veh' and p.fecha between '$fecha_ini' and '$fecha_fin' $max_pos";	
$rows=mysql_query($datos_rec);
//echo mysql_error();
//echo $datos_rec;
while($row=mysql_fetch_array($rows)){
	echo $row[0]."".$row[1]."".$row[6]."".$row[7]."<br>";
}
echo "<br><br><br><br>Sin operaciones <br><br><br><br>";
$datos_rec="select p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,
p.lat,p.long,v.id_veh,v.tipoveh,p.id_pos,p.odometro,p.id_tipo,
pm.descripcion,cm.mensaje,v.id_sistema 
from posiciones p 
left outer join vehiculos v on (p.num_veh = v.num_veh) 
left outer join postmens pm on (pm.t_mensaje = p.t_mensaje)
left outer join c_mensajes cm on (cm.id_mensaje = p.entradas and cm.id_empresa = $id_emp and p.t_mensaje=3) 
where p.num_veh = '$veh' and p.fecha between '$fecha_ini' and '$fecha_fin' $max_pos";	
$rows=mysql_query($datos_rec);
while($row=mysql_fetch_array($rows)){
	$lat=($row[6]/3600/16);
	$lon=($row[7]/3600/12)*-1;
	echo $row[0]."".$row[1]."".$lat."".$lon."<br>";
}
?>