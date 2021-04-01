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
		<th>Od&oacute;metro</th>
		<th><div id='odo'></div>$btn_info</th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='odometro' id='odo1'>
		</td>
		<td>
			
			Desactivado:<input type='radio' name='odometro' id='odo0'>
		</td>
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
			Activado:<input type='radio' name='odometro_r' id='odo_r1'><br>
			Desactivado:<input type='radio' name='odometro_r' id='odo_r0'>
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(80,$veh);X1PLUS(\"odo\",\"get\",\"\")'>
		</td>
		<td>
			<input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(81,$veh);X1PLUS(\"odo\",\"set\",\"odometro@odo_r1\")'>
		</td>
	</tr>
</table><hr>";
$box='';
$correos="SELECT folio FROM gpscondicionalerta where id_empresa=".$sess->get('Ide')." 
and activo=1 and descripcion like '%Accion de remolcado%'";
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
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"remol\")'>";
$formu.="
<table id='rounded-corner'>
	$box
	<tr>
		<th width='150px'>Remolcado</th>
		<th>  <div id='remolcar'></div>$btn_info</th>
	</tr>
	<tr>
		<td>
			Activado:<input type='radio' name='remolque' id='remolcar1'>
		</td>
		<td>
			Desactivado:<input type='radio' name='remolque' id='remolcar0'>
		</td>
	</tr>
	<tr>
		<td>
			Distancia (Mts)
		</td>
		<td>
			<input type='text' size='4' id='rvel' onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var dist = document.getElementById(\"rvel\");
			var x = parseFloat(dist.value);
			var max = 100;
			if(x < 6){alert(\"No puede ser menor a 6 Mts \");dist.value=6; dist.focus();}
			if(x > max){alert(\"No puede ser mayor a 100 Km/h. \"); dist.value=max; dist.focus();}
			'
			>
		</td>
	</tr>
	<tr>
		<td>
			Tiempo (Seg)
		</td>
		<td>
			<input type='text' size='4' id='rtiempo' 
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var rtm = document.getElementById(\"rtiempo\");
			var x = parseFloat(rtm.value);
			var max = 3600;
			if(x < 5){alert(\"No puede ser menor a 5 Segundos \");rtm.value=5; rtm.focus();}
			if(x > max){alert(\"No puede ser mayor a 1 hora \"); rtm.value=max; rtm.focus();}
			'
			>
		</td>
	</tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(92,$veh);X1PLUS(\"remolcar\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(93,$veh);notifica_correo(\"rem\",$veh);X1PLUS(\"remolcar\",\"set\",\"rvel@rtiempo\");asignar_correo();'></td>
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
		<input type='radio' id='enviar_correo_sin' onclick='xajax_mostrar_nuevo(".$sess->get('Ide').",\"sin_act\")'>Notificar por correo</th>
	</tr>";
}
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"sin_act\")'>";
$formu.="
<table id='rounded-corner' >
	$box
	<tr>
		<th>Sin Actividad</th>
		<th> <div id='inactivo'></div>$btn_info</th>
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
		<td><input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(84,$veh);X1PLUS(\"inactivo\",\"get\",\"\")'></td>
		<td><input type='button' value='Guardar' class='guardar1' onclick='xajax_auditabilidad(85,$veh);notifica_correo(\"sin\",$veh);X1PLUS(\"inactivo\",\"set\",\"tiemSA\")'></td>
	</tr>
</table><hr>";
?>