<?
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"vext\")'>";
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='1'>Voltaje Externo</th>
		<th><div id='vext'></div>$btn_info</th>
	</tr>
	<tr>
		<td width='150px'>Voltaje</td>
		<td >
			<input type='text' id='v_externo' size='3' readonly='readonly' >Milivolts
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(98,$veh);UCAN(\"vext\",\"get\",\"\")'>
		</td>
	</tr>
</table><hr>";
$btn_info="<img style='float:right;cursor:pointer;' src='img/info.png' onclick='xajax_info(\"vbat\")'>";
$formu.="
<table id='rounded-corner' >
	<tr>
		<th colspan='1'>Voltaje de la Bateria</th>
		<th><div id='vbat'></div>$btn_info</th>
	</tr>
	<tr>
		<td width='150px'>Voltaje</td>
		<td >
			<input type='text' id='v_interno' size='3' readonly='readonly' >Milivolts
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<input type='button' value='Obtener' class='agregar1' onclick='xajax_auditabilidad(99,$veh);UCAN(\"vbat\",\"get\",\"\")'>
		</td>
	</tr>
</table><hr>";
?>