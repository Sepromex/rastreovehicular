<?
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Acciones del motor encendido/apagado%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_correo($folios[0],\"e_motor\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"e_motor\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_mot' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"e_motor\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"e_motor\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th>Acciones del motor </th>
		<th><div id='motor'></div> $btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='encendido' id='encendido'>Motor encendido
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='apagado' id='apagado'>Motor apagado
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' onclick='xajax_auditabilidad(92,$veh);xajax_obten_motor(".$veh.")' value='Obtener' class='agregar1'>
		</td>
		<td>
			<input type='button' onclick='xajax_auditabilidad(93,$veh);notifica_correo(\"mot\",$veh);' value='Guardar' class='agregar1'>
		</td>
		<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
	</tr>
</table><hr>";
$query=mysql_query("SELECT * FROM veh_accesorio AS V_A
		INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
		WHERE V_A.num_veh='".$veh."'
		AND C_A.descripcion like '%voz%' and V_A.activo=1");
if(mysql_num_rows($query)!=0){
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"llamar\")'>";
$formu.="
<table id='rounded-corner'>
	<tr>
		<th ><input type='radio' id='llamar1' checked>Ingrese el tel&eacute;fono </th>
		<th><div id='llamar'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Recibir llamada al n&uacute;mero:</td>
		<td><input type='text' id='numero'></td>
	</tr>
	<tr>
		<td colspan='2'><input type='button' class='agregar1' onclick='xajax_auditabilidad(124,$veh);X1(\"llamar\",\"set\",\"numero\")' value='Enviar'></td>
	</tr>
</table><hr>";
}
/*
	Agregamos una validacion para ver si el vehiculo cuenta con el sensor de TOMA DE FUERZA (gruas)
*/
$query=mysql_query("SELECT * FROM veh_accesorio AS V_A
		INNER JOIN cat_accesorios AS C_A ON V_A.id_accesorio=C_A.id_accesorio
		WHERE V_A.num_veh='".$veh."'
		AND C_A.descripcion like '%toma de fuerza%' and V_A.activo=1");
if(mysql_num_rows($query)!=0){
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Modulo de toma de fuerza%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_correo($folios[0],\"t_fuerza\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"t_fuerza\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_fza' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"t_fuerza\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"t_fuerza\")'>";
$formu.="
$box
<table id='rounded-corner'>
	<tr>
		<th>Toma de Fuerza </th>
		<th><div id='toma'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='encendido1' id='encendido1'>Sensor activado
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='apagado1' id='apagado1'>Sensor apagado
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' onclick='xajax_auditabilidad(94,$veh);xajax_obten_fuerza(".$veh.")' value='Obtener' class='agregar1'>
		</td>
		<td>
			<input type='button' onclick='xajax_auditabilidad(95,$veh);notifica_correo(\"fza\",$veh);' value='Guardar' class='agregar1'>
		</td>
	</tr>
</table><hr>";
}
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Sabotajes%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_correo($folios[0],\"sab\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"sab\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_sab' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"sab\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"sab\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th colspan='1'><input type='radio' name='sabo' id='sabo1' checked>Sabotajes</th>
		<th colspan='1' align='center'><div id='sab'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' id='sabotaje'>Sabotaje de antena
		</td>
		<tr>
		<td colspan='2'>
			<input type='checkbox' id='voltaje'>Falla de voltaje en la alimentacion principal
		</td>
	</tr>
	</tr>
	<tr>
		<td id='los_botones' colspan='2'>
		<input type='button' class='guardar1' value='Obtener' onclick='xajax_auditabilidad(96,$veh);xajax_obten_sabotaje(".$veh.");'>
		<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(97,$veh);notifica_correo(\"sab\",$veh);'>
		</td>
	</tr>
</table><hr>
";
?>