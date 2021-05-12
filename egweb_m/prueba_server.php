<?
//$conec = mysql_connect("160.16.18.20:3305","root","1234") or die ("No hay conexión con el servidor");
//mysql_select_db("cruce", $conec);
//-104.365084,-103.365084
include("librerias/conexion.php");
//$lat='21.92886267';
//$lon='-102.33335787';
$veh=68700;
$inicio='2013-08-29 00:00:00';
$fin='2013-08-29 14:13:09';
$query="select p.fecha,p.num_veh,p.velocidad,p.mensaje,p.t_mensaje,p.entradas,
(p.lat/3600/16),((p.long & 8388607)/3600/12*-1),v.id_veh,v.tipoveh,cv.cruce,p.id_pos,p.odometro,p.id_tipo,
pm.descripcion,cm.mensaje,v.id_sistema from posiciones p left outer join vehiculos v on (p.num_veh = v.num_veh)
left outer join cruce_pos cc on (cc.id_pos = p.id_pos)
left outer join cruce_veh cv on (cc.id_cruce = cv.id_cruce)
left outer join postmens pm on (pm.t_mensaje = p.t_mensaje)
left outer join c_mensajes cm on (cm.id_mensaje = p.entradas
and cm.id_empresa = 1170 and p.t_mensaje=3)
where p.num_veh =$veh
and p.fecha between '".$inicio."' and '".$fin."'
group by p.lat order by p.fecha limit 1000";
//echo nl2br($query);
$muchos=mysql_query($query);
$i=0;
while($todos=mysql_fetch_array($muchos)){
	$latitudes[$i]=$todos[6];
	$longitudes[$i]=$todos[7];
	$i++;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>TEST</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>
</head>
<body>
<div id="result" style='position:absolute;top:10px;left:20px;'>
<iframe src='http://160.16.18.20:89/mapas/index.php?lat=<? echo json_encode($latitudes);?>&lon=<? echo json_encode($longitudes);?>' width='900px' height='700px'></iframe>
</div>
<script>
</script>
</body>
</html>