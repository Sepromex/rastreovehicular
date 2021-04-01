<?
require("librerias/conexion.php");
	$query=mysql_query("select s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,t.descripcion,s.id_sitio,s.id_tipo,t.descripcion
				from sitios s 
				left outer join tipo_sitios t on (t.id_tipo = s.id_tipo) 
				where s.id_empresa = ".$_GET['ide']." 
				and s.activo=1
				order by s.nombre ASC");
	$datos="Tipo,Nombre,Categoria,Permitido,Contacto,Telefonos,Latitud,Longitud,\n";
	while($row=mysql_fetch_array($query)){
		$datos.=$row[8].",".str_replace(","," ",$row[0]).","
		.$row[9].",VERDADERO,".str_replace(","," ",$row[3]).",".
		str_replace(","," ",$row[4])." ".str_replace(","," ",$row[5]).",".$row[1].",".$row[2].",\n";
	}
	$empresa=mysql_query("SELECT Nombre from empresas where id_empresa=".$_GET['ide']);
	$nombre=mysql_fetch_array($empresa);
mysql_close();

header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=Sitios ".$nombre[0].".csv");
print $datos;
?>