<?php
	$con = mysql_connect("10.0.1.3","egweb","53g53pr0") or die ("¡No hay conexión con el servidor! <br />" . mysql_error());
	mysql_select_db("sepromex", $con) or die ("¡No se selecciono BD! <br />" . mysql_error() );
	mysql_query ("SET NAMES 'utf8'");
	/*
	mysql_connect
	10.0.0.2

	egweb
	53g53pr0
	sepromex

	usercruce
	server
	crucev2
	*/
	// Se declaro mas NUNCA se utilizo esta variable
	//$base = mysql_select_db("sepromex", $conec);
	
	//$conec = mysql_connect("localhost","root","53g53pr0") or die ("No hay conexión con el servidor");
	//mysql_select_db("sepromex", $conec);

	/* Tratar de mantener conexion a 2 bases de datos no funciona muy bien usando la antigua libreria mysql_ de pphp
	$conec2 = mysql_connect("localhost","root","53g53pr0") or die ("No hay conexión con el servidor");
	mysql_select_db("crucev", $conec2);
	*/

	/*
	$server="10.0.0.2";
	$conec2 = mysql_connect($server,"usercruce","server");
	mysql_select_db("crucev2", $conec2);
	*/
?>
