<?php
  $site = '160.16.18.8';
  //$usr = 'supervisor';
  $usr = 'egweb';
  //$pass = 'supervisor';
  $pass = 'egW@b2009';
  $dbc = 'sepromex';
  $ipcerebro = '160.16.18.5';
  $ipcerEquipo = '10.0.2.8';
  $ipwebservice = '160.16.18.8';
  $ipmapacalles = '160.16.18.8';
  
/*Elimina algunos caracteres que afecten a la impresion
  (i.e,'Toluca_1' quedaria así Toluca_1)
*/  
function QuitaCaracteres($string)
{
	$chars = array("'");
	return str_replace($chars, "", $string);
}
?>