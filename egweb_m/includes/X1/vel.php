<?
$query=mysql_query("select clave from veh_accesorio a
inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
where a.num_veh=".$veh."
and clave like '%paroseg%' and a.activo=1");
if(mysql_num_rows($query)==0){
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Exceso de Velocidad desde Equipo%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_vel' onclick='xajax_mostrar_correo($folios[0],\"e_vel\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_vel' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"e_vel\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_vel' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"e_vel\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"e_vel\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th>Alerta de Velocidad </th>
		<th><div id='idvel'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activado:<input type='radio' name='exceso' id='idvel1'></td>
		<td>Desactivado<input type='radio' name='exceso' id='idvel0'></td>
	</tr>
	<tr>
		<td width='200px'>Exceso de Velocidad</td>
		<td><input type='text' id='E_vel' name='E_vel' onkeypress='return event.charCode >= 48 && event.charCode <= 57;'><br>(km/h)</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' id='' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(100,$veh);X1(\"idvel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' id='' value='Guardar' onclick='xajax_auditabilidad(101,$veh);notifica_correo(\"vel\",$veh);X1(\"idvel\",\"set\",\"E_vel\")'/>
		</td>
	</tr>
</table><hr>";
}
?>