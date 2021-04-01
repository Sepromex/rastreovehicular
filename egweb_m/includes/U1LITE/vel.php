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
			<th>Alerta de Velocidad</th>
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
				<input type='button' id='' value='Obtener' 
				class='agregar1' onclick='xajax_auditabilidad(100,$veh);U1LITE(\"idvel\",\"get\",\"\");'/>
				<input type='button' class='guardar1' id='' 
				value='Guardar' onclick='xajax_auditabilidad(101,$veh);notifica_correo(\"vel\",$veh);U1LITE(\"idvel\",\"set\",\"E_vel\")'/>
			</td>
		</tr>
	</table><hr>";
}
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Exceso de Aceleracion%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_acel' onclick='xajax_mostrar_correo($folios[0],\"e_acc\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_acel' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"e_acc\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_acel' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"e_acc\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"e_acc\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th colspan='1'>Aceleracion/desaceleracion</th>
		<th><div id='acel'></div>$btn_info</th>
	</tr>
	<tr>
		<td width='210px'>
			Activado:<input type='radio' name='aceleracion' id='acel1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='aceleracion' id='acel0'>
		</td>
	</tr>
	<tr>
		<td>
			Limite Aceleracion:
			<input type='text' size='5' maxlength='7' 
			id='aceleracion' name='aceleracion' 
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var aceleracion = document.getElementById(\"aceleracion\");
			var s = aceleracion.value;
			var botonA= document.getElementById(\"acel1\");
			if(s<1 && botonA.checked ){alert(\"No puede ser menor a 1 \"); aceleracion.value=1;aceleracion.focus();}
			if(s>65535){alert(\"No puede ser mayor a 65535 \"); aceleracion.value=65535; aceleracion.focus();}
			'
			>
			(m/s)
		</td>
		<td>
			Limite Desaceleracion:
			<input type='text' size='5' maxlength='7' 
			id='desaceleracion' name='desaceleracion' 
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var desaceleracion = document.getElementById(\"desaceleracion\");
			var s = desaceleracion.value;
			var botonA= document.getElementById(\"acel1\");
			if(s<1 && botonA.checked ){alert(\"No puede ser menor a 1 \"); desaceleracion.value=1; desaceleracion.focus();}
			if(s>65535){alert(\"No puede ser mayor a 65535 \"); desaceleracion.value=65535; desaceleracion.focus();}
			'
			>
			(m/s)<br>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(102,$veh);U1LITE(\"acel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(103,$veh);notifica_correo(\"acel\",$veh);U1LITE(\"acel\",\"set\",\"aceleracion@desaceleracion\");'/>
		</td>
	</tr>
</table><hr>";
?>