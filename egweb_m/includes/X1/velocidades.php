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
				<input type='button' id='' value='Obtener Velocidad' class='agregar1' onclick='X1(\"idvel\",\"get\",\"\")'/>
				<input type='button' class='guardar1' id='' value='Enviar Velocidad' onclick='X1(\"idvel\",\"set\",\"E_vel\")'/>
			</td>
		</tr>
	</table><hr>";
}
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>
			Od&oacute;metro
			<div id='odo'>Solo acumula kilometraje cuando est&aacute; encendido</div>
		</th>
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
			Desactivado:<input type='radio' name='odometro' id='odo0'>
		</td>
	</tr>
	<tr>
		<td>
			<input type='button' value='Obtener Od&oacute;metro' class='agregar1' onclick='X1(\"odo\",\"get\",\"\")'>
		</td>
		<td>
			<input type='button' value='Guardar Od&oacute;metro' class='guardar1' onclick='X1(\"odo\",\"set\",\"odometro\")'>
		</td>
	</tr>

</table>
<hr>";
?>