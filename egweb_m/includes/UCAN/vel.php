<?
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
			<input type='button' id='' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(100,$veh);UCAN(\"idvel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' id='' value='Guardar' onclick='xajax_auditabilidad(101,$veh);notifica_correo(\"vel\",$veh);UCAN(\"idvel\",\"set\",\"E_vel\")'/>
		</td>
	</tr>
</table><hr>";
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
		<th>Aceleracion/desaceleracion</th>
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
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(102,$veh);UCAN(\"acel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(103,$veh);notifica_correo(\"acel\",$veh);UCAN(\"acel\",\"set\",\"aceleracion@desaceleracion\")'/>
		</td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Exceso de RPM%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_rpm' onclick='xajax_mostrar_correo($folios[0],\"e_rpm\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_rpm' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"e_rpm\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_rpm' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"e_rpm\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"e_rpm\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th width='320' colspan='2'  style='text-align:left'>RPM</th>
		<th><div id='rpm'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='simpacto' id='rpm1'/></td>
		<td colspan='2'>Desactivar:<input type='radio' name='simpacto' id='rpm0' /></td>
	</tr>
	<tr>
		<td colspan='1'>No. RPM:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='n_rpm' value='1' max='16000' min='1' onchange='rangeF.value=value'/>
				<span class='highlight'></span>
				<output id='rangeF'>1</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='1'>Segundos:</td>
		<td colspan='2'>
			<input type='text' id='s_rpm' size='4' value='60'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tiempo = document.getElementById(\"s_rpm\");
			var s = tiempo.value;
			var max = 65000;
			if(s<1){alert(\"No puede ser menor a 1 segundo \");tiempo.value=1; tiempo.focus();}
			if(s>max){alert(\"No puede ser mayor a 65000 Segundos. \"); tiempo.value=max; tiempo.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td colspan='3'>
			<input type='button' class='agregar1' value='Obtener' onclick='xajax_auditabilidad(109,$veh);UCAN(\"rpm\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Guardar' onclick='xajax_auditabilidad(110,$veh);notifica_correo(\"rpm\",$veh);UCAN(\"rpm\",\"set\",\"n_rpm@s_rpm\");'/>
		</td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Over stepping%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_ost' onclick='xajax_mostrar_correo($folios[0],\"over_s\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_ost' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"over_s\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_ost' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"over_s\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"over_s\")'>";
$formu.="
<table id='rounded-corner'>
	<tr>
		$box
		<th>Over stepping</th>
		</th><div id='stepping'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='sobrec' id='stepping1'/></td>
		<td colspan='2'>Desactivar:<input type='radio' name='sobrec' id='stepping0' /></td>
	</tr>
	<tr>
		<td colspan='1'>Porcentaje:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='o_temp' value='0' max='100' min='0' onchange='rangeFP.value=value'/>
				<span class='highlight'></span>
				<output id='rangeFP'>0</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='1'>Minutos:</td>
		<td colspan='2'>
			<input type='text' id='o_tiempo' size='4' value='1'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tiempo = document.getElementById(\"o_tiempo\");
			var s = tiempo.value;
			var max = 65000;
			if(s<1){alert(\"No puede ser menor a 1 minuto \");tiempo.value=1; tiempo.focus();}
			if(s>max){alert(\"No puede ser mayor a 65000 minutos. \"); tiempo.value=max; tiempo.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(111,$veh);UCAN(\"stepping\",\"get\",\"\")'>
			<input type='button' value='Guardar' class='agregar1' onclick='xajax_auditabilidad(112,$veh);notifica_correo(\"ost\",$veh);UCAN(\"stepping\",\"set\",\"o_temp@o_tiempo\")'>
		</td>
	</tr>
</table><hr>";
?>