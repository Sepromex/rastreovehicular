<?php
require("librerias/conexion.php");
//print_r($_POST);
$idu=$_POST['usuario'];
$vehiculo=$_POST['vehiculo'];
$vel1=$_POST['vel1'];
$vel2=$_POST['vel2'];
$vel3=$_POST['vel3'];
$vel4=$_POST['vel4'];
$todos=0;
if($_POST['todos']){//envia el form con todos los vehiculos seleccionados
	$todos=1;
}
if($_POST['avisar']){
	#Enviara un correo de los vehiculos seleccionados al seleccionar un "limite" de velocidad
	#insertaremos en otra tabla el(los) vehiculo(s) que se hayan seleccionado para enviar mensaje
	
}
for($i=0;$i<count($vehiculo);$i++){
	$veh=$vehiculo[$i];
	#comprobamos que sean regiustros nuevos
	if($veh!=''){
		$verif=mysql_query("SELECT * FROM config_vel WHERE num_veh=".$veh);
		if(mysql_num_rows($verif)==0){#si no hay ninguna coincidencia insertamos uno nuevo
			$query="INSERT INTO config_vel VALUES($idu,$veh,$vel1,$vel2,$vel3,$vel4);" ;
			mysql_query($query);
			//echo $query."<br>";
			echo mysql_error();
		}
		else{
			$query="UPDATE config_vel SET vel1=$vel1,vel2=$vel2,vel3=$vel3,vel4=$vel4 WHERE num_veh=$veh and id_usuario=$idu";
			mysql_query($query);
			//echo $query."<br>";
			echo mysql_error();
		}
	}
}
if(!mysql_error()){
	header("Location: config_vel.php?bien");
}
 ?>
 <body style='background-color:#000;color:#FFF;'>
 </body>