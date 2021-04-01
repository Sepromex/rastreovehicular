<?
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
				<input type='button' id='' value='Obtener Velocidad' class='agregar1' onclick='UGO(\"idvel\",\"get\",\"\")'/>
				<input type='button' class='guardar1' id='' value='Enviar Velocidad' onclick='UGO(\"idvel\",\"set\",\"E_vel\")'/>
			</td>
		</tr>
	</table><hr>";
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>
			Aceleracion/desaceleracion
			<div id='acel'></div>
		</th>
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
			<input type='button' value='Obtener Aceleracion' class='agregar1' onclick='UGO(\"acel\",\"get\",\"\")'/>
			<input type='button' class='guardar1' value='Enviar Aceleracion' onclick='UGO(\"acel\",\"set\",\"aceleracion@desaceleracion\")'/>
		</td>
	</tr>
</table>
<hr>";
?>