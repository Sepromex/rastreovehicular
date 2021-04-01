<?php
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Accion de Odometro%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_rem' onclick='xajax_mostrar_correo($folios[0],\"remol\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_rem' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"remol\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_rem' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"remol\")'>Notificar por correo</th>
	</tr>";
}

$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"odo\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th colspan='2'>Od&oacute;metro</th>
		<th><div id='odo'></div>$btn_info</th>
	</tr>
	<tr>
		<td>Kilometraje</td>
		<td>
			<input type='text' size='10' maxlength='10'
			id='odometro'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var odometro = document.getElementById(\"odometro1\");
			var s = odometro.value;
			if(s>4294967295){alert(\"No puede ser mayor a 4294967295 \"); odometro.value=4294967295; odometro.focus();}
			'
			>
			<br>
			(0-4294967295 km)
		</td>
	</tr>
	<tr>
		<td width='210px'>
			Reiniciar al Encender:
		</td>
		<td>
			Activado:<input type='radio' name='odometro' id='odo1'><br>
			Desactivado:<input type='radio' name='odometro' id='odo2'>
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(80,$veh);UGO(\"odo\",\"get\",\"\")'>
		</td>
		<td>
			<input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(81,$veh);UGO(\"odo\",\"set\",\"odometro\")'>
		</td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Sin actividad%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_sin' onclick='xajax_mostrar_correo($folios[0],\"sin_act\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_sin' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"sin_act\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"sin_act\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"sin_act\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th>Sin Actividad</th> 
		<th><div id='inactivo'></div>$btn_info</th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='inactividad' id='inactivo1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='inactividad' id='inactivo0'>
		</td>
	</tr>
	<tr>
		<td>Distancia M&iacute;nima</td>
		<td>
			<input type='text' id='distSA' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var dm = document.getElementById(\"distSA\");
			var x = parseFloat(dm.value);
			var max = 65535;
			if(x < 1){alert(\"No puede ser menor a 1 Metro \");dm.value=1; dm.focus();}
			if(x > 65535){alert(\"No puede ser mayor a 65.5 Kms \"); dm.value=max; dm.focus();}
			'
			>
			Metros
		</td>
	</tr>
	<tr>
		<td>Tiempo M&aacute;ximo</td>
		<td>
			<input type='text' id='tiemSA' size='4'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tm = document.getElementById(\"tiemSA\");
			var x = parseFloat(tm.value);
			var max = 255;
			if(x < 1){alert(\"No puede ser menor a 1 Minuto \");tm.value=1; tm.focus();}
			if(x > max){alert(\"No puede ser mayor a 255 Minutos \"); tm.value=max; tm.focus();}
			'
			>
			Segundos
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(84,$veh);UGO(\"inactivo\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(85,$veh);notifica_correo(\"sin\",$veh);UGO(\"inactivo\",\"set\",\"distSA@tiemSA\")'></td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Vehículo en movimiento%'";
$res=mysql_query($correos);
if(mysql_num_rows($res)>0){
	if(mysql_num_rows($res)==1){
		$folios=mysql_fetch_array($res);
		$box="
		<tr>
			<th colspan='2' align='right'>
			<input type='radio' id='enviar_correo_mov' onclick='xajax_mostrar_correo($folios[0],\"en_mov\")'>Notificar por correo
			</th>
		</tr>";
	}
	if(mysql_num_rows($res)>1){		
		$box="
		<tr>
			<th colspan='2' align='right'>
				<input type='radio' id='enviar_correo_mov' onclick='xajax_mostrar_select(".$sess->get('Ide').",\"en_mov\")'>Notificar por correo
			</th>
		</tr>";		
	}
}
else{
	$box="
	<tr>
		<th colspan='2' align='right'>
		<input type='radio' id='enviar_correo_mov' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"en_mov\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"en_mov\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th>Veh&iacuteculo en Movimiento</th>
		<th><div id='motion'></div>$btn_info</th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='movs' id='motion1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='movs' id='motion0'>
		</td>
	</tr>
	<tr>
		<td>Fuerza del movimiento</td>
		<td>
			<div id='slider'>
				<input class='bar' type='range' id='mfuer' value='5' max='15' min='1' onchange='rangeFM.value=value'/>
				<span class='highlight'></span>
				<output id='rangeFM'>5</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener'  class='agregar1' onclick='xajax_auditabilidad(86,$veh);UGO(\"motion\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar'  class='guardar1' onclick='xajax_auditabilidad(87,$veh);notifica_correo(\"mov\",$veh);UGO(\"motion\",\"set\",\"mfuer\");mov_correo()'></td>
	</tr>
</table><hr>";
?>