<?
function otro_server($lat,$lon){
	$conec2 = mysql_connect("10.0.2.13","usercruce","server") or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
	if(!$conec2){
		$error = mysql_error()."error conec2";
		return $error;
	}else{
		mysql_select_db("crucev2", $conec2) or die ("¡No se selecciono BD! <br />" . mysql_error() );	

		$estados = "SELECT nombre FROM municipios WHERE Crosses(area,GeomFromText('POINT($lat $lon)')) LIMIT 1";
		//echo $estados;		exit();
		$est = mysql_query($estados);
		$estad = mysql_fetch_array($est);
		$estado = $estad[0];
		list($mun,$est) = explode("(",$estado);
		$estadoy = str_replace("(","",$est);
		$esta = str_replace(")","",$estadoy);
		$w = strtolower($mun);
		$y = strtolower($esta);
		$estado = ucwords($w)." (".ucwords($y).")";
		$procedure = "SELECT cast(e.idesquina AS char(20)) AS ID, ca.nombre as NOM, (GLength(LineString((PointFromWKB( POINT($lat, $lon))), 
					  (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST FROM esquinas e
					  INNER JOIN calles_esquinas ce ON e.idesquina=ce.idesquina INNER JOIN calles ca ON ce.idcalle=ca.idcalle
	    			  WHERE MBRContains(GeomFromText(
	                    concat('Polygon((',
	                                      $lat+0.01001,' ',$lon-0.01001,', ',
	                                      $lat+0.01001,' ',$lon+0.01001,', ',
	                                      $lat-0.01001,' ',$lon-0.01001,', ',
	                                      $lat-0.01001,' ',$lon+0.01001,', ',
	                                      $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas) ORDER BY DIST ASC limit 4";
	    //echo $procedure;		exit();
		$r = mysql_query($procedure);
		$calle = "";
		$distancia = 99999;
		$dist = 0;
		while( $calles = mysql_fetch_array($r) ){
			if($calles['DIST'] <= $distancia){
				if($dist <= 1){
					if($calle != ''){
						if($calles['NOM'][0] == "I" || ($calles['NOM'][0].$calles['NOM'][1] == 'Hi')){
							$calle .= ' e ';
						}else{
							$calle .= ' y ';
						}
					}
					$calle .= $calles['NOM'];
					$dist++;
				}			
				$distancia = $calles['DIST'];
			}
		}

		include("librerias/conexion.php");
		include_once('../patError/patErrorManager.php');
		include_once('../patSession/patSession.php');
		
		$options = "";
		$sess =& patSession::singleton('egw', 'Native', $options );
		$ide = $sess->get("Ide");
		$cercano = "";
		$cad_sit = "SELECT id_sitio, latitud, longitud, nombre FROM sitios WHERE id_empresa = $ide AND activo = 1";
		$res_sit = mysql_query($cad_sit);
		$num = mysql_num_rows($res_sit);
		if($num > 0){
			$degtorad = 0.01745329;
			$radtodeg = 57.29577951;
			$distancia = 1000;
			while($row = mysql_fetch_array($res_sit)){
				$dlong = ($lon - $row[2]); 
				$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
				$dd = acos($dvalue) * $radtodeg; 
				$km = ($dd * 111.302)*1000;
				$km = number_format($km,1,'.','');
				if($distancia > $km){
					$cercano = " a ".(int)$km." Mts de ".$row[3]." ,";
					$distancia = $km;
				}
			}
		}
		

		//$cercano = "";
		$calle = strtolower($calle);
		$cadena = ucwords($calle).",".ucwords($cercano).$estado;
		return nl2br($cadena);
	}
	mysql_close($conec2);
}

$idu=$_GET['idu'];
require_once("librerias/conexion.php");
$cad .= "SELECT DISTINCT(v.num_veh),v.id_veh,
		(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),
		u.mensaje,u.velocidad,u.fecha,
		v.tipoveh,u.t_mensaje,v.id_empresa,
		u.entradas
		FROM vehiculos AS V
		INNER JOIN ultimapos AS u ON v.num_veh=u.num_veh
		INNER JOIN veh_usr AS vu ON v.num_veh=vu.num_veh
		INNER JOIN estveh ev on v.estatus = ev.estatus
		WHERE vu.id_usuario= $idu
		and vu.activo=1
		and ev.publicapos=1
		order by v.id_veh";
$res_rep = mysql_query($cad);
echo mysql_error();
$datos="Vehiculo,Fecha/Hora,Vel. km,Latitud,Longitud,Ubicacion,Msj,\n";
while($row = mysql_fetch_array($res_rep)){
	$clv = $row[10];
	if($row[8] == 2 || $row[8] == 1)
		$men = $row[4];
	if($row[8] == 3)
	{
		$conec=@mysql_connect("10.0.1.3","egweb","53g53pr0");
		$c_mensa = mysql_query("select mensaje from c_mensajes where id_empresa = $row[9] and id_mensaje = '$clv'",$conec);
		$row1 = mysql_fetch_array($c_mensa);
		$men = $row1[0];
		if($men == '')
		{
			$conec=@mysql_connect("10.0.1.3","egweb","53g53pr0");
			$c_mensa = mysql_query("select mensaje from c_mensajes where id_empresa = 15 and id_mensaje = '$clv'",$conec);
			$row1 = mysql_fetch_array($c_mensa);
			$men = $row1[0];
		}
	}
	$datos.=$row[1].",".$row[6].",".$row[5].",".$row[2].",".$row[3].",".str_replace(","," ",otro_server($row[2],$row[3])).",".$men.",\n";
}
mysql_close();
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=Ultima Pos ".date("Y_m_d_H_i_s").".csv");
print $datos;
?>