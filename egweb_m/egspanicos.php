<?
//include("/librerias/conexion.php");
include("conexion.php");

function otro_server($lat,$lon,$ide){//calcula el cruce de las calles
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	if(!$conec2){
		//$error=mysql_error()."error conec2";
		return $error;
	}
	else{
	mysql_select_db("crucev2", $conec2);
	/*
		obtenemos el estado/municipio del vehiculo
	*/
	$estados="SELECT nombre
	FROM `municipios`
	where Crosses(area,GeomFromText('POINT($lat $lon)')) limit 1";
	$est=mysql_query($estados,$conec2);
	$estado=mysql_fetch_array($est);
	$estado=$estado[0];
	
	list($mun,$est)=explode("(",$estado);
	$estadoy=str_replace("(","",$est);
	$esta=str_replace(")","",$estadoy);
	$w=strtolower($mun);
	$y=strtolower($esta);
	$estado=ucwords($w)." (".ucwords($y).")";
	
	/*
		procedure
	*/
	$procedure="SELECT
      cast(e.idesquina as char(20)) AS ID,
      ca.nombre as NOM,
      (GLength(LineString((PointFromWKB( POINT($lat, $lon))), (PointFromWKB(POINT(X(e.Coordenadas),Y(e.Coordenadas) ) ))))) * 100 AS DIST
    FROM esquinas e
      inner join calles_esquinas ce on e.idesquina=ce.idesquina
      inner join calles ca on ce.idcalle=ca.idcalle
    where MBRContains(GeomFromText(
                    concat('Polygon((',
                                      $lat+0.01001,' ',$lon-0.01001,', ',
                                      $lat+0.01001,' ',$lon+0.01001,', ',
                                      $lat-0.01001,' ',$lon-0.01001,', ',
                                      $lat-0.01001,' ',$lon+0.01001,', ',
                                      $lat+0.01001,' ',$lon-0.01001,'))')),coordenadas)
    ORDER BY DIST ASC limit 4;";
	//$call="CALL crucecalles($lat,$lon,false)";
	$r=mysql_query($procedure,$conec2);
	$calle="";
	$distancia=99999;
	$dist=0;
	while($calles=mysql_fetch_array($r)){
		if($calles['DIST']<=$distancia){
			if($dist<=1){
				if($calle!=''){
					if($calles['NOM'][0]=="I" || ($calles['NOM'][0].$calles['NOM'][1]=='Hi'))
					{
						$calle.=' e ';
					}
					else{
						$calle.=' y ';
					}
				}
				$calle.=$calles['NOM'];
				$dist++;
			}
			
			$distancia=$calles['DIST'];
		}
	}
	/*
		Calculamos el sitio cercano a nuestro vehiculo
	*/
	$cercano="";
	$cad_sit = "select id_sitio,latitud,longitud,nombre from sitios where id_empresa = $ide and activo=1";
	$res_sit = mysql_query($cad_sit,$con);
	$num = mysql_num_rows($res_sit);
	if($num > 0){
		$degtorad = 0.01745329; 
		$radtodeg = 57.29577951; 
		//$resp = "Aprox. a ";
		$distancia=1000;
		while($row = mysql_fetch_array($res_sit)){
			$dlong = ($lon - $row[2]); 
			$dvalue = (sin($lat * $degtorad) * sin($row[1] * $degtorad)) + (cos($lat * $degtorad) * cos($row[1] * $degtorad) * cos($dlong * $degtorad)); 
			$dd = acos($dvalue) * $radtodeg; 
			$km = ($dd * 111.302)*1000;
			$km = number_format($km,1,'.','');
			if($distancia>$km){
				$cercano= " a ".(int)$km." Mts de ".$row[3]." ,";
				$distancia=$km;
			}
		}
	}
	//return $calle."<br>".mysql_error()."<br>".nl2br($procedure);
	$calle=strtolower($calle);
	//$municipio=strtolower($municipio);
	//$estado=strtolower($estado);
	$cadena=ucwords($calle).",".ucwords($cercano).$estado;
	//return ucwords($calle).",".ucwords($municipio)." ".ucwords($estado);
	return $cadena;
	}
	//mysql_close($conec2);
}

$accion=$_GET['accion'];
switch($accion){
	case 'ins_posicion': //inserta posicion actual 
		$imei=$_GET['imei'];		
		$id_us=mysql_query("SELECT num_veh, id_veh from sepromex.vehiculos where veh_x7=$imei",$con);		
		$ids=mysql_fetch_array($id_us);
		$idtipo_pos=$_GET['tipo_pos'];		
		$idu=$ids[0];
		$idv=$ids[1];
		if($idu!='')
		{		    
	        echo "IMEI Registrado";
			$lat=$_GET['lat'];
			$lon=$_GET['long'];
			$fecha=$_GET['fecha'];	
			switch($idtipo_pos){
				case '1': 
				   $Entradas=0;
				break;
				case '3':
					$Entradas=252;		
				break;		
			}
			$nombre=str_replace("_"," ",$_GET['Nombre']);						
			$insert= "INSERT INTO posiciones (`NUM_VEH`, `FECHA`, `ORIGEN`, `LAT`,`LONG`, `MENSAJE`,`T_MENSAJE`,`ID_TIPO`,`ENTRADAS`,`ENTRADAS_A`,`VELOCIDAD`,
					`DIRECCION`,`OBSOLETO`,`ODOMETRO`,`MINENCENDIDO`,`IGNITION_ST`,`ENT1_ST`,`ENT2_ST`,`ENT3_ST`,`ENT4_ST`,`SATELITES`,`HDOP` ) 
					VALUES 
					($idu,$fecha,'N',$lat,$lon,'',$idtipo_pos,1,$Entradas,0,0,0,0,0,0,0,0,0,0,0,12,8)";			
			mysql_query($insert,$con);
			$folio=mysql_insert_id();			
			
			if(!mysql_error())
			{
				echo "OK";
				/*echo "Insercion de Posicion %".$folio."% Correcto. del Cliente".$idv; */
				/*echo mysql_insert_id();    //respondo que se realizo bien el proceso y retorno el folio capturado */
			}
			else
			{
				echo "INSERT%N/A%ERROR";    
				echo "ERROR%".mysql_error(); //envio el error de que no se inserto la REGLA
			}											

			$insert_ultimapos= "UPDATE ultimapos SET `fecha` = $fecha, `lat`= $lat, `long`= $lon, `velocidad`=0, `direccion`=209,
					`obsoleto`=0, `t_mensaje`=$idtipo_pos, `id_tipo`=1, `entradas`=$Entradas, `entradas_a`= 0, `odometro`=0,
					`id_pos`=$folio, `mensaje`='', `minencendido`=0, `IGNITION_ST`=0, `ENT1_ST`=0,
					`ENT2_ST`=0,`ENT3_ST`=0, `ENT4_ST`=0, `SATELITES`=12, `HDOP`=8 WHERE `NUM_VEH`	=$idu ";
			mysql_query($insert_ultimapos,$con);			
			if(!mysql_error())
			{			
				echo "OK";
				/*echo "Ultima posicion actualizada de manera correcta. ".$idv;   */
				/*echo mysql_insert_id();    //respondo que se realizo bien el proceso y retorno el folio capturado */
			}
			else
			{
				echo "INSERT%N/A%ERROR";
				echo "ERROR%".mysql_error(); //envio el error de que no se inserto la REGLA
			}											


		}
		else
		{
			echo "IMEI NO Registrado";
		}
	break;	
}
?>