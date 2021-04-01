<?php
$site = '10.0.1.3';//160.16.18.8
$usr = 'egweb';
$pass = '53g53pr0';

$dbc = 'sepromex';
$ipcerebro = '10.0.2.8';//160.16.18.5
$ipcerEquipo = '10.0.2.8';
$ipwebservice = '10.0.1.3';//160.16.18.8
$ipmapacalles = '10.0.1.3';  //160.16.18.8

function QuitaCaracteres($string){
  $chars = array("'");
  return str_replace($chars, "", $string);
}
?>