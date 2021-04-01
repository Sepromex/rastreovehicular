<?
$query=mysql_query("select clave from veh_accesorio a
inner join cat_accesorios c on c.id_accesorio=a.id_accesorio
where a.num_veh=".$veh."
and clave like '%paroseg%'");
if(mysql_num_rows($query)==0){
$formu.="
	<table id='rounded-corner' >
		<tr>
			<th>Alerta de Velocidad</th>
			<th id='idvel'></th>
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
				<input type='button' id='' value='Obtener Velocidad' class='agregar1' onclick='U1PRO(\"idvel\",\"get\",\"\")'/>
				<input type='button' class='guardar1' id='' value='Enviar Velocidad' onclick='U1PRO(\"idvel\",\"set\",\"E_vel\")'/>
			</td>
		</tr>
	</table><hr>";
}
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='1'>
			Aceleracion/desaceleracion
		</th>
		<th><div id='acel'></div></th>
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
			<input type='button' value='Obtener Aceleracion' class='agregar1' onclick='U1PRO(\"acel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Enviar Aceleracion' onclick='U1PRO(\"acel\",\"set\",\"aceleracion@desaceleracion\")'/>
		</td>
	</tr>
</table>
<hr>

<table id='rounded-corner' >
	<tr>
		<th colspan='1'>
			Od&oacute;metro
		</th>
		<th><div id='odo'></div></th>
		
	</tr>
	<tr>
		<td width='210px'>
			Reiniciar al Encender:
		</td>
		<td>
			Activado:<input type='radio' name='odometro' id='odo1'><br>
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
		<td>
			<input type='button' value='Obtener Od&oacute;metro' class='agregar1' onclick='U1PRO(\"odo\",\"get\",\"\")'>
		</td>
		<td>
			<input type='button' value='Guardar Od&oacute;metro' class='guardar1' onclick='U1PRO(\"odo\",\"set\",\"odometro\")'>
		</td>
	</tr>
	<input type='hidden' name='id_veh' id='id_veh' value='".$veh."' >
</table><hr>";
?>