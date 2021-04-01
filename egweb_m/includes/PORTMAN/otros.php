<?
/*
	agregamos el formulario para el aviso por correo del motor encendido
	Este formulario se validara desde el archivo alertas_otros.php
*/
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Terminal Conectada/Desconectada%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_terminal' onclick='xajax_mostrar_correo($folios[0],\"terminal\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_terminal' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"terminal\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_terminal' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"terminal\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"terminal\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th>Acciones de la terminal </th>
		<th><div id='terminal'></div>$btn_info</th>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='conectada' id='conectada'>Terminal Conectada
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='checkbox' name='desconectada' id='desconectada'>Terminal Desconectada
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' onclick='xajax_auditabilidad(113,$veh);xajax_obten_terminal(".$veh.")' value='Obtener' class='agregar1'>
		</td>
		<td>
			<input type='button' onclick='xajax_auditabilidad(114,$veh);notifica_terminal($veh)' value='Guardar' class='agregar1'>
		</td>
		<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
	</tr>
</table><hr>";
?>