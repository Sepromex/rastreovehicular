<?
include("./librerias/conexion.php");//incluye el archivo de la conexion a la base de datos

function otro_server($lat,$lon,$ide)//calcula el cruce de las calles
{
	//$conec2 = @mysql_connect("10.0.0.2","usercruce","server");
	//$conec2 = @mysql_connect("localhost","root","admin");
	//$conec2 = @mysql_connect("localhost","usercruce","server");
	$conec2 = @mysql_connect("10.0.2.13","usercruce","server");
	//$conec2 = @mysql_connect("localhost:3306","usercruce","server");
	if(!$conec2)
	{
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
	$res_sit = mysql_query($cad_sit,$conec);
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
	case 'login': //Control de acceso al sistema 
		$user=$_GET['usuario'];
		$pass=$_GET['password'];
		$ver_usuario=mysql_query("SELECT * from usuarios where username='".$user."'",$conec);
		if(mysql_num_rows($ver_usuario)>0){
			$ver_pass=mysql_query("SELECT * from usuarios where username='$user' and password='$pass'",$conec);
			if(mysql_num_rows($ver_pass)>0){
				$fechas=mysql_query("SELECT * from usuarios where username='$user' and password='$pass' 
				and f_termino>'".date("Y-m-d H:i:s")."'",$conec);
				if(mysql_num_rows($fechas)>0){
					echo "OK";
				}
				else{
					echo "Usuario caducado";
				}
			}
			else{
				echo "Password invalido";
			}
		}
		else{
			echo "Usuario invalido";
		}
	break;
	case 'poleog': //Poleo de Vehiculos 
		//id_veh, fecha de ultima posición, latitud, longitud,ubicacion
		$user=$_GET['id_usuario'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$conec);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$q_v="SELECT distinct(v.num_veh),v.id_veh,v.placas,(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
		from vehiculos v
		inner join ultimapos u on v.num_veh=u.num_veh
		left outer join veh_usr vu on vu.num_veh=v.num_veh
		where vu.id_usuario=$idu
		and vu.activo=1
		group by v.num_veh";
		$vehiculos=mysql_query($q_v,$conec);
		if(mysql_num_rows($vehiculos)>0){
			$calle="";
			while($row=mysql_fetch_array($vehiculos))
			{
				$calle=otro_server($row[3],$row[4],$ide);
				//echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."|".$calle.'%';
				echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5].'%';
			}
		}	
	break;
	case 'posiciones': //Envio de Posiciones
		//id_veh, fecha de ultima posición, latitud, longitud,ubicacion
		$user=$_GET['id_vehiculo'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$conec);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		/*$q_v="SELECT distinct(v.num_veh),v.id_veh,v.placas,(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
		from vehiculos v
		inner join ultimapos u on v.num_veh=u.num_veh
		left outer join veh_usr vu on vu.num_veh=v.num_veh
		where vu.id_usuario=$idu
		and vu.activo=1
		group by v.num_veh";*/		
		$q_v="select p.lat,p.long, p.fecha, p.mensaje from posiciones p where p.num_veh=$idu 
			  and p.id_pos>= (select id from id_pos where date(fechahora) = (select date(fecha)-1 from ultimapos where num_veh=$idu))
			  and p.t_mensaje>=1 order by fecha desc limit 5 "; 		
		$vehiculos=mysql_query($q_v,$conec);
		if(mysql_num_rows($vehiculos)>0)
		{
			$calle="";
			while($row=mysql_fetch_array($vehiculos))
			{
				//$calle=otro_server($row[3],$row[4],$ide);
				//echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."|".$calle.'%';
				echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5].'%';
			}
		}
	break;
case 'Ubicacion': //Envio de Posiciones
		//id_veh, fecha de ultima posición, latitud, longitud,ubicacion
		$user=$_GET['id_usuario'];
		$vehiculo=$_GET['id_vehiculo'];		
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$conec);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$q_v="SELECT  v.num_veh,v.id_veh,(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
				from vehiculos v
				inner join ultimapos u on v.num_veh=u.num_veh
				where  v.num_veh=$vehiculo ";
		$vehiculos=mysql_query($q_v,$conec);
		if(mysql_num_rows($vehiculos)>0){
			$calle="";
			while($row=mysql_fetch_array($vehiculos))
			{
				$calle=otro_server($row[2],$row[3],$ide);
				echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$calle.'%';
				//echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5].'%';
			}
		}
	break;
	case 'modolive': //Modo Live de Vehiculos 
		//id_veh, fecha de ultima posición, latitud, longitud,ubicacion
		$user=$_GET['id_usuario'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$conec);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$q_v="SELECT distinct(v.num_veh),v.id_veh,v.placas,(u.lat/3600/16),((u.long & 8388607)/3600/12*-1),u.fecha
		from vehiculos v
		inner join ultimapos u on v.num_veh=u.num_veh
		left outer join veh_usr vu on vu.num_veh=v.num_veh
		where vu.id_usuario=$idu
		and vu.activo=1
		group by v.num_veh";
		$vehiculos=mysql_query($q_v,$conec);
		if(mysql_num_rows($vehiculos)>0)
		{
			$calle="";
			while($row=mysql_fetch_array($vehiculos))
			{
				$calle=otro_server($row[3],$row[4],$ide);
				//echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."|".$calle.'%';
				echo $row[0]."|".$row[1]."|".$row[2]."|".$row[3]."|".$row[4]."|".$row[5].'%';
			}
		}
	break;
	case 'panicos': //Envio de Panicos pendietes del usuarios
		$user=$_GET['usuario'];
		$b_idu=mysql_query("SELECT id_usuario,id_empresa from usuarios where username='$user'",$conec);
		$ids=mysql_fetch_array($b_idu);
		$idu=$ids[0];
		$ide=$ids[1];
		$query=mysql_query("SELECT distinct(v.num_veh),v.id_veh,v.placas,(a.lat/3600/16),((a.lon & 8388607)/3600/12*-1),a.fecha_pos,
		a.id_pos
		from vehiculos v
		inner join veh_usr vu on vu.num_veh=v.num_veh
		inner join alertas_leido a on a.num_veh=v.num_veh 
		where vu.id_usuario=$idu
		and vu.activo=1
		and id_mensaje=252
		and a.fecha_pos>='".date("Y-m-d")."'
		and a.atendido=0
		group by v.num_veh
		limit 10");
		if(mysql_num_rows($query)>0)
		{
			while($row=mysql_fetch_array($query))
			{
				echo $row[6]."|".$row[1]."|".$row[3]."|".$row[4]."|".$row[5]."%";
			}
		}
		else{
			echo "No hay panicos";
		}
	break;
	case 'panicosr':
		$id_pos=$_GET['idpos'];
		mysql_query("update alertas_leido set atendido=1 where id_pos=$id_pos");
		if(!mysql_error())
		{
			echo "OK";
		}
		else
		{
			echo mysql_error();
		}
	break;
}
?>