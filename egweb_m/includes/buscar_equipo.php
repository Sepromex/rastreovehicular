<?
	require('../librerias/conexion.php');
	$query="SELECT T_E.descripcion,v.veh_x1
		FROM tipo_equipo T_E
		INNER JOIN sistemas S on T_E.id_tipo_equipo=S.tipo_equipo
		inner join vehiculos v on v.id_sistema=s.id_sistema
		WHERE S.id_sistema=".$_GET['id']."
		AND v.num_veh=".$_GET['num_veh'];
	$result=mysql_query($query);
	$sistema=mysql_fetch_array($result);
	echo mysql_error();
	if(preg_match("/AXP/i",$sistema[1])){
		echo 'X1PLUS';
	}
	else{
		echo strtoupper(str_replace(" ","",$sistema[0]));
	}
	//echo $query;
	
?>