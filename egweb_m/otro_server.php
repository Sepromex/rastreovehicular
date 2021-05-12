<?php
function otro_server($lat,$lon){
	//$conec2 = @mysql_connect("localhost","root","admin");
	$conec2 = mysql_connect("10.0.2.13","usercruce","server") or die ("¡No hay conexión con el servidor cruce! <br />" . mysql_error());
	
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
		$calle = strtolower($calle);
		$cadena = ucwords($calle).",".ucwords($cercano).$estado;
		return nl2br($cadena);
	}
	mysql_close($conec2);
}
?>