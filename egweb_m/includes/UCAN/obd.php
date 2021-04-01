<?
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='2'>
			Fallas
			<div id='fallas'></div>
		</th>
	</tr>
	<tr>
		<td>Reportar Fallas</td>
		<td>
			Activado:<input type='radio' id='fallas1' name='fallas' value='activo'><br>
			Desactivado:<input type='radio' id='fallas0' name='fallas' value='desactivado'>
		</td>
	</tr>
	<tr>
		<td><input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"fallas\",\"get\",\"\")'></td>
		<td><input type='button' value='Enviar' class='guardar1' onclick='UCAN(\"fallas\",\"set\",\"\")'></td>
	</tr>
</table><hr>
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>
			DTC
			<div id='dtc'></div>
			<input type='hidden' id='dtc1'>
		</th>
	</tr>
	<tr>
		<td colspan='2'><div id='datos'></div></td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"dtc\",\"get\",\"\")'>
		</td>
	</tr>
</table><hr>";
$formu.="
<table id='rounded-corner'>
	<tr>
		<th colspan='2'>
			Sobrecalentamiento
			<div id='calentamiento'>
		</th>
	</tr>
	<tr>
		<td>Activar:<input type='radio' name='sobrec' id='calentamiento1'/></td>
		<td colspan='2'>Desactivar:<input type='radio' name='sobrec' id='calentamiento0' /></td>
	</tr>
	<tr>
		<td colspan='1'>Temperatura:</td>
		<td colspan='2'>
			<div id='slider'>
				<input class='bar' type='range' id='s_temp' value='20' max='215' min='-40' onchange='range.value=value'/>
				<span class='highlight'></span>
				<output id='range'>20</output> 
			</div>
		</td>
	</tr>
	<tr>
		<td colspan='1'>Minutos:</td>
		<td colspan='2'>
			<input type='text' id='s_tiempo' size='4' value='1'
			onkeypress='return event.charCode >= 48 && event.charCode <= 57;'
			onblur='
			var tiempo = document.getElementById(\"s_tiempo\");
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
			<input type='button' value='Obtener' class='agregar1' onclick='UCAN(\"calentamiento\",\"get\",\"\")'>
			<input type='button' value='Enviar' class='agregar1' onclick='UCAN(\"calentamiento\",\"set\",\"s_temp@s_tiempo\")'>
		</td>
	</tr>
</table><hr>
";
?>