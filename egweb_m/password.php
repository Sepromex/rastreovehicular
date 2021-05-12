<div id="d" style="margin-left:0px">
<form name="cambiar" id="cambiar" method="post" action="javascript:void(null);" onsubmit="xajax_cambioPass(xajax.getFormValues('cambiar'));">
<table id='newspaper-a1' width="250px" style="border:none;">
 <tr><td colspan="2">&nbsp;</td></tr>
     <tr><td width="200">Contraseña actual: </td>
     <td width="100"><label>
	 <input id="psw0" name="psw0" type="password" size="7" maxlength="10" /></label></td>
 </tr>
<tr><td>Nueva contraseña:</td>
<td>
	<input id="psw1" name="psw1" type="password" size="7" maxlength="10"/></td>
</tr>
<tr><td>Confirme contraseña:</td>
<td>
	<input id="psw1" name="psw2" type="password" size="7" maxlength="10"/></td>
</tr>
<tr><td colspan="2" style="font-size:9px; font-style:italic"> La contraseña debe contener entre 5 y 10 caracteres</td></tr>
<tr>
    <td><label>	<input type="hidden" name="usr" value="<?php echo $_GET['usr'] ?>" ></label></td>
	<td><!--<input type="submit" name="cambio" align="right" value="Guardar" />--></td>
</tr>
</table>
</form>
</div>