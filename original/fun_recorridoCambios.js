//founcion de incio de mapas de google.
var punto;
var punto2;
var map;
var marca;
var smov;
var tipoV;
var marcaStart,marcaEnd;
var visitedPages = new  Array();
var linea = new Array();
var optSelected = 1;
var flightPath;
var arregloDeRecorridos= new Array();

/**
 * Carga el mapa de google, esto deber�a llamarse una sola vez al cargar la pagina, sin embargo
 * se carga por cada busqueda que se realiza, lo que puede causar el baneo de google por realizar tantas cargas.
 */
function load() { // API V3
   var myOptions = {
		zoom:5,
		center: new google.maps.LatLng(21.9518,-100.9397),
		streetViewControl: true,//true= "monito"
		disableDoubleClickZoom:true,
		overviewMapControl:true,
		panControl: true,
		zoomControl: true,
		zoomControlOptions: {
		  style: google.maps.ZoomControlStyle.SMALL
		},
		scaleControl: true,
		scaleControlOptions: {
			position: google.maps.ControlPosition.LEFT_CENTER
		},
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	map=new google.maps.Map(document.getElementById('cont_mapita'),myOptions);
}

function timerEngine(value,time,pos) 
{
	setTimeout("buscaEngine("+value+","+time+",'timer',"+pos+")", 2500);	
}

function avisoVehiculos()
{
	if( document.getElementById("avisoVeh") )
	{
		document.getElementById("avisoVeh").style.visibility ='visible';
	}
	else 
	{
		aviso = "Solo los equipos que cuenten con el sistema adecuado para hacer peticiones a la computadora del vehiculo podran hacer uso del servicio, pregunte si su equipo";
		aviso  += " cuenta con el sistema adecuando, comuniquese con atencion a clientes";
		document.getElementById("contAutoSalida").innerHTML += "<div id='avisoVeh'><table border='0' width='200'><tr class='fuente_doce_r'><td ><a href='javascript:void(null)' onclick='closeA();'>cerrar</a></td></tr><tr><td>"+aviso+"</td></tr></table></div>";
	}
}

function closeA()
{
	document.getElementById("avisoVeh").style.visibility ='hidden';
}
 
function buscaEngine(value,time,opc,pos)
{
	if( opc != "timer" )
		document.getElementById("notifica").innerHTML = '<img src="img2/loader.gif" />&nbsp;&nbsp;&nbsp;<b>Buscando datos dentro de la ultima posicion...</b>';
	else document.getElementById("notifica").innerHTML = '<img src="img2/loader.gif" />&nbsp;&nbsp;&nbsp;<b>Procesando intento '+time+'...</b>'; 
	document.getElementById("cgas").value = document.getElementById("dtc").value = document.getElementById("viaje").value = 
	document.getElementById("odo").value = document.getElementById("gs").value = document.getElementById("vel").value =
	document.getElementById("rpm").value = document.getElementById("pre").value = document.getElementById("temp").value = "";
	xajax_getLastEngine(value,time,pos);
} 

function solicitar()
{
	xajax_EngineData(document.getElementById("vehiculos").value,document.getElementById("pos").value);
} 
//DAVID
function elimR(){
	var flightPath = arregloDeRecorridos[0];
	flightPath.setMap(null);
	arregloDeRecorridos.length=0;
}
function crea_recorrido(lat,lon,t,pag){
	var encontrado = false;
	for(i = 0; i < visitedPages.length; i++){
		if(visitedPages[i] == pag){
			encontrado= true;
			break;
		}
	}
	if(!encontrado){
		tipoV = t;
		linea.push(new google.maps.LatLng(lat,lon));		
	}
}
function crea_recorrido2(lat,lon,t,pag,pos){
	var encontrado = false;
	for(i = 0; i < visitedPages.length; i++){
		if(visitedPages[i] == pag){
			encontrado= true;
			break;
		}
	}
	if(!encontrado){
		/*
		tipoV = t;
		linea.push(new google.maps.LatLng(lat,lon));
		*/
		tipoV = t;
		var posicion=new google.maps.LatLng(lat,lon);
		map.setOptions({
			center:posicion
		});
		var image = new google.maps.MarkerImage('IconosV3/location.png',
			new google.maps.Size(50,50),
			new google.maps.Point(0,0),
			new google.maps.Point(0,32));
		marcaAlerta= new google.maps.Marker({
			position:posicion,
			map:map,
			icon:image
		});	
		linea.push(posicion);
		marcaAlerta.setOptions({
			position:new google.maps.LatLng(lat,lon)
		});

		google.maps.event.addListener(marcaAlerta,'click',function(event){
			pause(pos);
		});	
	}
}

function mostrarLinea2(pag){
	flightPath = new google.maps.Polyline({
		path: linea,
		strokeColor: "#cd4224",
		strokeOpacity: 1.0,
		strokeWeight: 3,
		geodesic:true
	});
	arregloDeRecorridos.push(flightPath);
	flightPath.setMap(map);
	linea = linea.splice(linea.length);
}
//DAVID
function mostrarLinea(pag){ // API V3
   /* var encontrado = false;
	for(i = 0 ; i < visitedPages.length; i++)
	{
		if( visitedPages[i] == pag)
		{
			encontrado = true;
			break;
		}
	}
	if(!encontrado)
	{*/
		//var polyline = new GPolyline(linea, colorRecorrido,3,0.8,{geodesic:true});
		//map.addOverlay(new GPolyline(linea, colorRecorrido,3,0.8,{geodesic:true}));
		
		flightPath = new google.maps.Polyline({
		path: linea,
		strokeColor: "#000000",
		strokeOpacity: 1.0,
		strokeWeight: 2,
		geodesic:true
		});
		arregloDeRecorridos.push(flightPath);
		flightPath.setMap(map);
		verVehiculo(linea[0].lat(),linea[0].lng(),tipoV,13,"fech0");

		linea = linea.splice(linea.length);
		//linea = linea.length=0;
		visitedPages.push(pag);		
		//alert("entra");
		
		
		
		
	//}
}

var marcadores=Array();
var markersArrays=Array();
var conjunto;
function StartPoint(lat,lon){ //API V3
	//	alert(linea[0]);
	//if(!marcaStart)
	//{
		var posicion=new google.maps.LatLng(lat,lon);
		map.setOptions({
			center:posicion
			
		});
		var image=new google.maps.MarkerImage('Iconos/iconoinicio.png',
			new google.maps.Size(32,66),
			new google.maps.Point(0,0),
			new google.maps.Point(0,66));
		marcaStart= new google.maps.Marker({
			position:linea[0],
			map:map,
			icon:image
		});	
		google.maps.event.addListener(marcaStart,'rightclick',function(event){
			alert(marcaStart.getPosition());
		});
		marcadores.push(marcaStart);
	//}
	marcaStart.setOptions({
		position:new google.maps.LatLng(lat,lon)
	});
}
function EndPoint(lat,lon){ // API V3
	//if(!marcaEnd)
	//{
	//alert(lat+"--"+lon);
		var posicion=new google.maps.LatLng(lat,lon);
		map.setOptions({
		center:posicion,
		
	});
	var image=new google.maps.MarkerImage('Iconos/iconofin.png',
		new google.maps.Size(32,73),
		new google.maps.Point(0,0),
		new google.maps.Point(0,73));
	marcaEnd= new google.maps.Marker({
		position:posicion,
		map:map,
		icon:image
		
	});	
	google.maps.event.addListener(marcaEnd,'rightclick',function(event){
		alert(event.latLng);
	});
	google.maps.event.addListener(marcaEnd,'dblclick',function(event){
		 conjunto=flightPath.getPath();
		var coordenadas="";
		for (var i=0;i<conjunto.getLength();i++){
			coordenadas+=conjunto.getAt(i)+"|";
		}
		alert(coordenadas);
	});
	//marcadores.push(marcaEnd);
	//}
	marcaEnd.setOptions({
		position:new google.maps.LatLng(lat,lon)
	});
}

function verVehiculo(lat,lon,t,zoom,id){ // API V3
	if(markersArrays.length!=0){
		if(zoom==0) {
			zoom=map.getZoom();
		}
		var elim=elimMarcador();
	}
		var miPosicion=new google.maps.LatLng(lat,lon);
		map.setOptions({
			center:miPosicion,
			zoom:zoom,
			zIndex:1
		});
		var image = new google.maps.MarkerImage('IconosV3/'+t+'.png',
			new google.maps.Size(50, 20),
			new google.maps.Point(0,0),
			new google.maps.Point(0, 20));
		marcador = new google.maps.Marker({
			position: miPosicion,
			map: map,
			icon: image
		});
		markersArrays.push(marcador);	
}
function elimMarcador(){ // API V3
		var marker = markersArrays[0]; // find the marker by given id
		marker.setMap(null);
		markersArrays.length=0;
}
function muestra_posicion(lat,lon,tipo){ // API V3
		//markersArrays.setMap(null);	
		if(map.getZoom()>0 && map.getZoom()<15) zoom=15;
		else zoom=map.getZoom();
	if(smov)	 smov.setMap(null);
	var image = new google.maps.MarkerImage('IconosV3/'+tipo+'.png',
		new google.maps.Size(50, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 20));
	
	smov=new google.maps.Marker({
		position: new google.maps.LatLng(lat,lon),
		map:map,
		icon:image
	});
	map.setOptions({
		center:new google.maps.LatLng(lat,lon),
		zoom:zoom
		});
}
	
function tipo(a,ide,idu){

	var rep = document.getElementById('cont_reporte');
	$('#paginacionDiv').css({"visibility":"hidden"});
	$('#panelinfo').css({"visibility":"hidden"});
	if(a==1){
        optSelected = 1;	
		rep.style.top = '536px';
		//rep.style.height = '270px';
		rep.style.left = '';
		rep.innerHTML = '';
		document.getElementById('cont_mapita').style.visibility = 'visible';
		document.getElementById('cont_autos2').style.visibility ='visible';
		$('#paginacionDiv').html('');
		$('#panelinfo').html('');
	    $('#paginacionDiv').css({"visibility":"visible"});
		$('#panelinfo').css({"visibility":"visible"});		
		$("#liga_rec").addClass("current");
	 	$("#liga_ult").removeClass("current");
	 	$("#tiempo_sin").removeClass("current");
		$("#engine").removeClass("current");
		$("#sensor_gas").removeClass("current");
		$("#sensor_temp").removeClass("current");
		$("#cont_reporte").hide();
		xajax_estilo(a,ide,idu);
	}

	if(a==2){
	    optSelected = 2;
	    $('#divColorPicker').css({"visibility":"hidden","width":"400px"});
		rep.style.top = '0px';
		rep.style.top = '445px';
		rep.style.left = '27px';
		rep.innerHTML = '';
		document.getElementById('panel').innerHTML = '';
		document.getElementById('cont_mapita').style.visibility = 'visible';
		document.getElementById('cont_autos2').style.visibility ='visible';
		$("#liga_rec").removeClass("current");
	 	$("#liga_ult").removeClass("current");
	 	$("#tiempo_sin").addClass("current");
		$("#engine").removeClass("current");
		$("#sensor_gas").removeClass("current");
		$("#sensor_temp").removeClass("current");
		$("#cont_reporte").hide();
		xajax_estilo(a,ide,idu);
	}
	
	if(a==5){
		optSelected = 5;
	    $('#divColorPicker').css({"visibility":"hidden","width":"400px"});
		document.getElementById('cont_mapita').style.visibility = 'hidden';
		rep.style.top = '125px';
		rep.style.left = '';
		//rep.innerHTML = '<img src="img2/loader.gif" width="24px" />';
		rep.innerHTML = '';
		document.getElementById('cont_autos2').style.visibility = 'hidden';
		document.getElementById('panel').innerHTML = '';
		$("#liga_rec").removeClass("current");
	 	$("#liga_ult").addClass("current");
	 	$("#tiempo_sin").removeClass("current");
		$("#engine").removeClass("current");		
		$("#sensor_gas").removeClass("current");
		$("#sensor_temp").removeClass("current");
		$("#cont_reporte").show();
		xajax_estilo(a,ide,idu);		
	}
	if(a==3){ // Vehicle Engine
	    document.getElementById('cont_mapita').style.visibility = 'hidden';
		rep.style.top = '100px';
		rep.style.height = '670px';		
		rep.innerHTML = '';
		rep.style.left = '';
		document.getElementById('cont_autos2').style.visibility = 'hidden';
		//document.getElementById('cont_autos2').innerHTML = '';
		document.getElementById('panel').innerHTML = '';
		$("#liga_rec").removeClass("current");
	 	$("#engine").addClass("current");
		$("#liga_ult").removeClass("current");
	 	$("#tiempo_sin").removeClass("current");
		$("#sensor_gas").removeClass("current");
		$("#sensor_temp").removeClass("current");
		xajax_estilo(a,ide,idu);		
	}
	if(a==4){ // sensor gasolina
		document.getElementById('cont_mapita').style.visibility = 'visible';
		rep.style.top = '536px';
		rep.innerHTML = '';
		rep.style.left = '';
		//rep.style.height = '670px';	
		$('#paginacionDiv').html('');
		$('#panelinfo').html('');
	    $('#paginacionDiv').css({"visibility":"visible"});
		$('#panelinfo').css({"visibility":"visible"});				
		document.getElementById('cont_autos2').style.visibility = 'visible';
		//document.getElementById('cont_autos2').innerHTML = '';
		document.getElementById('panel').innerHTML = '';
		$("#liga_rec").removeClass("current");
		$("#engine").removeClass("current");
		$("#liga_ult").removeClass("current");
		$("#tiempo_sin").removeClass("current");
		$("#sensor_temp").removeClass("current");
		$("#sensor_gas").addClass("current");
		$("#cont_reporte").show();
		xajax_estilo(a,ide,idu);		
	}
	if(a==6){ // sensor temperatura
		document.getElementById('cont_mapita').style.visibility = 'visible';
		rep.style.top = '536px';
		rep.innerHTML = '';
		rep.style.left = '';
		//rep.style.height = '670px';	
		$('#paginacionDiv').html('');
		$('#panelinfo').html('');
	    $('#paginacionDiv').css({"visibility":"visible"});
		$('#panelinfo').css({"visibility":"visible"});			
		document.getElementById('cont_autos2').style.visibility = 'visible';
		//document.getElementById('cont_autos2').innerHTML = '';
		document.getElementById('panel').innerHTML = '';
		$("#liga_rec").removeClass("current");
		$("#engine").removeClass("current");
		$("#liga_ult").removeClass("current");
		$("#tiempo_sin").removeClass("current");
		$("#sensor_gas").removeClass("current");
		$("#sensor_temp").addClass("current");
		$("#cont_reporte").show();
		xajax_estilo(a,ide,idu);		
	}
}

// TODO: El boton des-habilitado jamas se re-habilita, arreglar esto.
function getReport()
{
	// des-habilita el boton	
	$("#button").prop('disabled', true);
	$('input[class*="agregar1"]').addClass("desactivado");
	$('input[class*="agregar1"]').removeClass("agregar1");

	var result = isValidPeriod(); // Devuelve Cadena de texto "OK" o errores en una String
	console.info("Resultado de isValidPeriod(): "+result)
	
	$('#cont_reporte').show();

	// Muestra el spinner
	$("#cont_reporte").html('<img src="img2/loader.gif" width="24px" />');
	
	if(result == "OK")
	{	
		//alert("sii result OK");
		var marcaStart=null;
		var marcaEnd=null;
		$("#warming").html("");
		visitedPages = new Array();
		// arregloDeRecorridos se obtiene por medio de mostrarLinea(pag), en que momento se ejecuta esto?
		/*console.debug("arregloDeRecorridos:");
		console.debug(arregloDeRecorridos);
		  if(arregloDeRecorridos.length>=1){
			for(var i=0;i<arregloDeRecorridos.length;i++){
				arregloDeRecorridos[i].setMap(null);
			}
		} else {
			console.info("No se encontraron recorridos en el auto y fecha especificados.");
		} */	
		linea = new Array();
		// TODO: Esta linea no deberia llamarse con argumentos "hardcodeados"
		trayecto(0,50,1,0,0);

		// Re-habilitamos el boton de busqueda
		$("#button").prop('disabled', false);
		$('input[class*="agregar1"]').addClass("agregar1");
		$('input[class*="agregar1"]').removeClass("desactivado");
	} else {
		// Este warMing me hizo reir lol
		$("#warming").html("<img src='img/cancel2.png'> "+result);
	}
}
function alertas_recorrido(lat,lon,tipo,pos){
	var posicion=new google.maps.LatLng(lat,lon);
	map.setOptions({
		center:posicion
		
	});
	var image=new google.maps.MarkerImage('img_alertas/'+tipo+'.png',
		new google.maps.Size(32,32),
		new google.maps.Point(0,0),
		new google.maps.Point(0,32));
	marcaAlerta= new google.maps.Marker({
		position:linea[0],
		map:map,
		icon:image
	});	
	marcadores.push(marcaAlerta);
	marcaAlerta.setOptions({
		position:new google.maps.LatLng(lat,lon)
	});

	google.maps.event.addListener(marcaAlerta,'click',function(event){
		pause(pos);
		alert(tipo);//ddddd
	});
}

function trayecto(inicio,fin,pag,reg,geos){
	//document.getElementById('cont_reporte').innerHTML = '<img src="img2/loader.gif" width="24p" />';
	// Carga el mapa, deberia dibujar solamente.
	load();
	$("#cont_reporte").html("");
	$("#cont_reporte").html("Espere un momento...");
	//alert("Form:"+xajax.getFormValues("myform")+" ini:"  +inicio+" fin:"+fin+" pag:"+pag+" reg:"+reg+" geo:"+geos);


	// Llama la funcion recorrido (php) en reportes_recorrido.php... Que hace con el valor devuelto ???
	// XAJAX devuelve un script para ser ejecutado cuando se recibe la respuesta, no hay datos para trabajar.
	//var resultadoRecorrido = xajax_recorrido(xajax.getFormValues("myform"),inicio,fin,pag,reg,geos);
	xajax_recorrido(xajax.getFormValues("myform"),inicio,fin,pag,reg,geos);
}
function tray(id_pos,total)
{

	xajax_recorrido_masivo(xajax.getFormValues("myform"),id_pos,total);
}
 
function fecha() {
	var cal2 = new calendar3(document.forms["myform"].elements["fecha_ini"]);
	cal2.year_scroll = true;
	cal2.time_comp = true; 	 	 
	document.forms['myform'].elements['fecha_ini'].value = "";
	javascript:cal2.popup();
};

function fechaFin() {
	var cal2 = new calendar3(document.forms["myform"].elements["fecha_fin"]);
	cal2.year_scroll = true;
	cal2.time_comp = true; 	 	 
	document.forms['myform'].elements['fecha_fin'].value = "";
	javascript:cal2.popup();
}
	 
function fecha2() {
	var fechaIni =  document.getElementById("fecha_ini");
	var result = isValidFormat(fechaIni);
	if( result == "OK")
	{
		var cal3 = new calendar4(document.forms["myform"].elements["fecha_fin"],verificaDiferencia);
		cal3.year_scroll = true;
		cal3.time_comp = true;	 
		document.forms['myform'].elements['fecha_fin'].value = "";  
		javascript:cal3.popup();
	}else 
	{
		document.getElementById("warming").innerHTML = "<img src='img/cancel2.png'> "+result;
		fechaIni.style.background = "#E46C6E";
	}
}
 
function ayuda(){
    window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
}
function cont_checks(){
	var vehrtsm = new Array();
	document.getElementById('cont_reporte').innerHTML = '<img src="img2/loader.gif" width="24" />';
	var vehrsm = document.getElementById("myform").reptsm;
	var result = isValidPeriod2();
	$("#warming").html('');
	if(result == 'OK'){
		if(vehrsm.length > 1){
			for(var i = 0; i < vehrsm.length; i++ ){
				if(vehrsm[i].checked == true)
					vehrtsm.push(vehrsm[i].value);
			}
			if(vehrtsm.length<=3){
				xajax_rep_tiemposm(xajax.getFormValues("myform"),vehrtsm);
			}
			else{
				alert("No puede seleccionar mas de 3 vehiculos");
			}
		}
		else{
			if(vehrsm.checked == true){
				vehrtsm.push(vehrsm.value);
				xajax_rep_tiemposm(xajax.getFormValues("myform"),vehrtsm);
			}
		}
	}
	else 
	{
		$("#warming").html("<img src='img/cancel2.png'> "+result);
	}
}
function cont_checks_gas(){
	var vehrtsm = new Array();
	document.getElementById('cont_reporte').innerHTML = '<img src="img2/loader.gif" width="24" />';
	var vehrsm = document.getElementById("myform").rep_gas;
	if(vehrsm.length > 1){
		for(var i = 0; i < vehrsm.length; i++ ){
			if(vehrsm[i].checked == true)
				vehrtsm.push(vehrsm[i].value);
		}
	xajax_rep_gas(xajax.getFormValues("myform"),vehrtsm);
	}
	else{
		if(vehrsm.checked == true){
			vehrtsm.push(vehrsm.value);
			xajax_rep_gas(xajax.getFormValues("myform"),vehrtsm[0]);
		}
		else{
			alert("Debe seleccionar un vehiculo");
		}
	}
}
function cont_checks_temp(){
	var vehrtsm = new Array();
	document.getElementById('cont_reporte').innerHTML = '<img src="img2/loader.gif" width="24" />';
	var vehrsm = document.getElementById("myform").rep_temp;
	if(vehrsm.length > 1){
		for(var i = 0; i < vehrsm.length; i++ ){
			if(vehrsm[i].checked == true)
				vehrtsm.push(vehrsm[i].value);
		}
		if(vehrtsm.length>0){
			xajax_rep_temp(xajax.getFormValues("myform"),vehrtsm[0]);
		}
		else{
			alert("seleccionar vehiculo");
		}
	}
	else{
		if(vehrsm.checked == true){
			vehrtsm.push(vehrsm.value);
			xajax_rep_temp(xajax.getFormValues("myform"),vehrtsm[0]);
		}
		else{
			alert("Debe seleccionar un vehiculo");
		}
	}
}
	
function grande(obj){
	var o = obj.parentNode;
	$("#cont_reporte").animate({top: "100px", opacity: 1}, { duration: 5.0, queue: true });
	$("#cont_reporte").animate({left: "0px", opacity: 1}, { duration: 0, queue: true });
	$("#cont_reporte").animate({height: "670px", opacity: 1}, { duration: 0, queue: true });
	$("#cont_reporte").animate({width: "868px", opacity: 1}, { duration: 0, queue: true });
	o.innerHTML = "<a href='javascript:void(null)' onclick='form_pdf.submit()'title='Exportar PDF' >"
	              + "<img src='img/pdf.png' border='0' width='20' height='20'/></a>"
				  + " <a href='javascript:void(null)' onclick='form_xls.submit()' title='Exportar XLS' >"
				  + "<img src='img/xls.png' border='0' width='20' height='20'/></a>"
				  + " <a href='javascript:void(null)' onclick='chico(this);' title='Mostrar Reporte Grande'>"
				  + "<img src='img/rmin.png' width='20px' hight='16px' border='0' ></a>";
	$("#colorSelector2").hide();
}	

function chico(obj){
	var o = obj.parentNode;
	$("#cont_reporte").animate({top: "550px", opacity: 1}, { duration: 0, queue: true });
	$("#cont_reporte").animate({left: "0px", opacity: 1}, { duration: 0, queue: true });
	$("#cont_reporte").animate({height: "270px", opacity: 1}, { duration: 0, queue: true });
	$("#cont_reporte").animate({width: "868px", opacity: 1}, { duration: 0, queue: true });
	o.innerHTML = "<a href='javascript:void(null)' onclick='form_pdf.submit()'title='Exportar PDF' >"
	              + "<img src='img/pdf.png' border='0' width='20' height='20'/></a>"
				  + " <a href='javascript:void(null)' onclick='form_xls.submit()' title='Exportar XLS' >"
				  + "<img src='img/xls.png' border='0' width='20' height='20'/></a>"
				  + " <a href='javascript:void(null)' onclick='grande(this);' title='ostrar Reporte Grande'>"
				  + "<img src='img/rmas.png' width='20px' hight='16px' border='0' ></a>";
	$("#colorSelector2").show();
}
	
	
function grandesm(obj,n){
var o = obj.parentNode;
	if(n==1){
		$("#cont_reporte").animate({top: "100px", opacity: 1}, { duration: 5.0, queue: true });
		$("#cont_reporte").animate({left: "0px", opacity: 1}, { duration: 0, queue: true });
		$("#cont_reporte").animate({height: "670px", opacity: 1}, { duration: 0, queue: true });
		$("#cont_reporte").animate({width: "868px", opacity: 1}, { duration: 0, queue: true });
		o.innerHTML =   " <a href='javascript:void(null)' onclick='grandesm(this,0);' title='Mostrar Reporte Peque�o'>"
				  + "<img src='img/rmin.png' width='20px' hight='16px' border='0' ></a>";
	}
	if(n==0){
		$("#cont_reporte").animate({top: "500px", opacity: 1}, { duration: 0, queue: true });
		$("#cont_reporte").animate({left: "0px", opacity: 1}, { duration: 0, queue: true });
		$("#cont_reporte").animate({height: "270px", opacity: 1}, { duration: 0, queue: true });
		$("#cont_reporte").animate({width: "868px", opacity: 1}, { duration: 0, queue: true });
		o.innerHTML =   " <a href='javascript:void(null)' onclick='grandesm(this,1);' title='Mostrar Reporte Peque�o'>"
				  + "<img src='img/rmas.png' width='20px' hight='16px' border='0' ></a>";
	}
	
}

/*PARA EL COLORPICKER*/
var colorRecorrido = '#000000';

$(document).ready(function ()
{
	$('#tabTabdhtmlgoodies_tabView1_1').bind('click', function() {
		if(optSelected == 1){
			$('#divColorPicker').css({"visibility":"visible","width":"10px"});
		}
	});	
	$('#tabTabdhtmlgoodies_tabView1_0').bind('click', function() {
		$('#divColorPicker').css({"visibility":"hidden","width":"400px"});
	});
    
	//if($.browser.safari)	$('#divColorPicker').css({'top': '362px', 'left': '189px'});
	//if($.browser.msie)		$('#divColorPicker').css({'top': '360px', 'left': '168px'});     		
});

function cargaColorAndDatePicker()
{
	$('#fecha_ini').datetimepicker({
		timeFormat: 'hh:mm:ss',
		dateFormat: 'yy-mm-dd'
	});
	$('#fecha_fin').datetimepicker({
		timeFormat: 'hh:mm:ss',
		dateFormat: 'yy-mm-dd'
	});	
	$('#divColorPicker').html("<div id=\"customWidget\"><div id=\"colorSelector2\"><div style=\"background-color: #000000\"></div></div><div id=\"colorpickerHolder2\"></div></div>");
	$('#colorpickerHolder2').ColorPicker({
			flat: true,
			color: colorRecorrido,
			onSubmit: function(hsb, hex, rgb) {
				$('#colorSelector2 div').css('backgroundColor', '#' + hex);
				colorRecorrido= "#"+hex;
				//alert(colorRecorrido);
			}
		});
	var widt = false;
	$('#colorSelector2').bind('click', function() {
			$('#colorpickerHolder2').stop().animate({height: widt ? 0 : 173}, 500);
			widt = !widt;
		});
//var colorRecorrido	= "#"+hex;	
}

/*CALCULAMOS DIFERENCIA ENTRE FECHAS*/
function isValidPeriod()
{
	var fechaI = $("#fecha_ini").val();
	var fechaF = $("#fecha_fin").val();
	var arrayFechaI = fechaI.split(" ");
	var arrayFechaF = fechaF.split(" ");
	arrayFechaI = arrayFechaI[0].split("-");
	arrayFechaF = arrayFechaF[0].split("-");
	var dateI = new Date(arrayFechaI[0] , arrayFechaI[1] , arrayFechaI[2]);
	var dateF = new Date(arrayFechaF[0] , arrayFechaF[1] , arrayFechaF[2]);	
	if( dateI <= dateF)
	{
		var one_day=1000*60*60*24;		
	    if(Math.ceil((dateF.getTime()-dateI.getTime())/(one_day)) <= 7 )
		{
			return "OK";
		}else return "No soporta consultas mayores de 7 dias";
	}else return "Fecha de inicio mayor que fin";	
}
function isValidPeriod2()
{
	var fechaI = $("#fecha_ini2").val();
	var fechaF = $("#fecha_fin2").val();
	var arrayFechaI = fechaI.split(" ");
	var arrayFechaF = fechaF.split(" ");
	arrayFechaI = arrayFechaI[0].split("-");
	arrayFechaF = arrayFechaF[0].split("-");
	var dateI = new Date(arrayFechaI[0] , arrayFechaI[1] , arrayFechaI[2]);
	var dateF = new Date(arrayFechaF[0] , arrayFechaF[1] , arrayFechaF[2]);	
	if( dateI <= dateF)
	{
		var one_day=1000*60*60*24;		
	    if(Math.ceil((dateF.getTime()-dateI.getTime())/(one_day)) <= 2 )
		{
			return "OK";
		}else return "No soporta consultas mayores de 2 dias";
	}else return "Fecha de inicio mayor que fin";	
}

function clearWarming()
{
	document.getElementById("warming").innerHTML = "";
}

function verificaDiferencia()
{
	var fechaIni = document.getElementById().value;
}

function mostrar_img(){
	if(jQuery("#imagenes").is(":checked")){
		//jQuery("#id_imagenes").val('');
		jQuery("#las_imagenes").dialog("open");
	}
}
function enviar_img(){
	xajax_add_img(jQuery("#id_imagenes").val(),jQuery("#c_all_img").val());
}
function add_img(){
	var checkboxes = jQuery("[name=img_recorrido]");
	var anteriores=jQuery("#id_imagenes").val();
	var T_img=Array();
	for(var i=0; i<checkboxes.length; i++){
		if(checkboxes[i].checked==true){//si esta check se agrega
			T_img.push(checkboxes[i].value);
		}
	}
	var cadena="";
	for(i=0;i<T_img.length;i++){
		cadena=cadena+T_img[i];
		if(i<T_img.length-1){
			cadena=cadena+";";
		}
	}
	jQuery("#id_imagenes").val(cadena);
}
function all_img(){
	if(jQuery("#all_img").is(":checked")){
		var checkboxes = jQuery("[name=img_recorrido]");
		var T_msj=Array();
		var cadena="";
		jQuery("[name=img_recorrido]").prop('checked', true);
		for(var i=0; i<checkboxes.length; i++){
			T_msj.push(checkboxes[i].value);
		}
		for(i=0;i<T_msj.length;i++){
			cadena=cadena+T_msj[i];
			if(i<T_msj.length-1){
				cadena=cadena+";";
			}
		}
		jQuery("#id_imagenes").val(cadena);
		jQuery("#c_all_img").val(1);
	}
	else{
		jQuery("[name=img_recorrido]").prop('checked', false);
		jQuery("#id_imagenes").val('');
		jQuery("#c_all_img").val(0);
	}
}
function mostrar_msj(opcion){
	if(opcion==3){
		//jQuery("#id_imagenes").val('');
		jQuery("#los_mensajes").dialog("open");
	}
	else{
		jQuery("#id_mensajes").val('')
	}
}
function enviar_msj(){
	xajax_add_msj(jQuery("#id_mensajes").val(),jQuery("#c_all_msj").val());
}
function add_msj(){
	var checkboxes = jQuery("[name=msj_recorrido]");
	var anteriores=jQuery("#id_mensajes").val();
	var T_msj=Array();
	for(var i=0; i<checkboxes.length; i++){
		if(checkboxes[i].checked==true){//si esta check se agrega
			T_msj.push(checkboxes[i].value);
		}
	}
	var cadena="";
	for(i=0;i<T_msj.length;i++){
		cadena=cadena+T_msj[i];
		if(i<T_msj.length-1){
			cadena=cadena+";";
		}
	}
	jQuery("#id_mensajes").val(cadena);
}
function all_msj(){
	if(jQuery("#all_msj").is(":checked")){
		var checkboxes = jQuery("[name=msj_recorrido]");
		var T_msj=Array();
		var cadena="";
		jQuery("[name=msj_recorrido]").prop('checked', true);
		for(var i=0; i<checkboxes.length; i++){
			T_msj.push(checkboxes[i].value);
		}
		for(i=0;i<T_msj.length;i++){
			cadena=cadena+T_msj[i];
			if(i<T_msj.length-1){
				cadena=cadena+";";
			}
		}
		jQuery("#id_mensajes").val(cadena);
		jQuery("#c_all_msj").val(1);
	}
	else{
		jQuery("[name=msj_recorrido]").prop('checked', false);
		jQuery("#id_mensajes").val('');
		jQuery("#c_all_msj").val(0);
	}
}
