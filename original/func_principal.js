// JavaScript Document
//variables globales
var timerID = 0;
var map,marca,marker,sitios;
var elim_sitio = new Array();
var makingQuery = false;
var markersArrays=new Array();
var directionsService;
var directionsDisplay;
var childwindows = new Array();
//funcion de inicio de mapas de google.
function load() { 
directionsService = new google.maps.DirectionsService();
directionsDisplay = new google.maps.DirectionsRenderer();
//alert(directionsService);
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
	map=new google.maps.Map(document.getElementById('cont_mapa'),myOptions);
	 directionsDisplay.setMap(map);
}
function load_cliente() {
directionsService = new google.maps.DirectionsService();
directionsDisplay = new google.maps.DirectionsRenderer();
//alert(directionsService);
 var myOptions = {
		zoom:12,
		center: new google.maps.LatLng(20.6737919,-103.3364431),
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
	map=new google.maps.Map(document.getElementById('cont_mapa'),myOptions);
	 directionsDisplay.setMap(map);
}

//funcion que recibe los datos de la ubicacion y los envia a createMarker
function MapaCord(la, lo, tv, v) { 
	if(markersArrays.length!=0){
	var elim=elimMarcador();}
	if(al.length!=0){
	al.splice(al.length);}
	var miPosicion=new google.maps.LatLng(la,lo);
	map.setOptions({
		overviewMapControl:true,
		center:miPosicion,
		//overviewMapControl:true,
		zoom:15
	});
	var image = new google.maps.MarkerImage('IconosV3/'+tv+'.png',
		new google.maps.Size(50, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 20));
	marcador = new google.maps.Marker({
		position: miPosicion,
		map: map,
		icon: image,
		title: v
	});
	markersArrays.push(marcador);
}
function elimMarcador(){
		var marker = markersArrays[0]; // find the marker by given id
		marker.setMap(null);
		markersArrays.length=0;
}

//funcion js que ejecuta posicion(funcion de php)
function ubicacion(id) {
	//document.getElementById("cont_mapa_sepro").style.visibility = "hidden";
	document.getElementById('cuerpo_medio').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
	xajax_posicion(id);
}
function borroDatosPosicion(){
	document.getElementById('cuerpo_medio').innerHTML="" ;
}	
//funcion js que ejecuta poleo(funcion de php)
function polear(veh) {
//alert(veh);
	xajax_poleo(veh);
}
//funcion para determinar el tiempo de poleo
function UpdateTimer() {
	veh=document.getElementById('veh_actual1').value;
   if(timerID) {
	  clearTimeout(timerID);
	  clockID  = 0;
   }
   setTimeout("ubicacion("+veh+")", 6000);
   timerID = setTimeout("UpdateTimer()",1000);
}
//funcion para determinar el tiempo de poleo	
function UpdateTimer2() {
	veh=document.getElementById('veh_actual1').value;
   if(timerID) {
	  clearTimeout(timerID);
	  clockID  = 0;
   }	   
   setTimeout("ubicacion("+veh+")", 6000);
}	 
//funcion para determinar el tiempo de poleo utiliza las dos funciones anteriores	
	function times2() {
	 	var val = document.forms['form1'].elements['monitoreo'].value;
		if (val == 1) {
			alert("Se solicitó la posición al vehículo, enseguida se actualizará la posición automáticamente.");
			document.forms['form1'].elements['monitoreo'].value = 1;
			timerID  = setTimeout("UpdateTimer()", 1000);						
		} else {
			alert("Se solicitó la posición al vehículo, enseguida se actualizará la posición automáticamente.");
			timerID  = setTimeout("UpdateTimer2()", 1000);											
		}
	}	
//funcion para crear la ventana de login
function init() {
	var tag = jQuery("#d");
	var url='password.php?usr='+jQuery("#idusuario").val();
	jQuery.ajax({
		url:url,
		success: function(data) {
		  tag.html(data).dialog({
			modal: true,
			dialogClass:'dialog_style',
			width: 300,
			height: 300,
			title: "Cambiar de contraseña",
			buttons: {
			"Cancelar": function() {
				jQuery(this).dialog("close");
				},
			"Guardar":function() {
				xajax_cambioPass(xajax.getFormValues('cambiar'));
				//jQuery(this).dialog("close");
				}
			}
			}).dialog('open');
		}
	});
}
//función para crear sitios de interes
function sitiointeres(id_empresa) {	
	var request = confirm("Desea crear un sitio de interes");
	if(request == true){
		alert("Seleccione un punto en el mapa");
		jQuery.post('includes/carga_sitios.php','',function(response){ 
			var opcion=response; 
			google.maps.event.addListener(map, 'click', function(event) {
			var myLatLng = event.latLng;
			addMarker(myLatLng);
			var lat = myLatLng.lat();
			var lng = myLatLng.lng();
			xajax_carga_form_sitio(lat,lng);
		  });
		});
	}
	else{

	}
}
function addMarker(location) {
    marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markersArrays.push(marker);
  google.maps.event.clearListeners(map, 'click');
}

//muesta la configuracion que guardo el cliente.
function config_sitios(){
	var s = document.getElementById("form1").cs;
	s.checked = "checked";
	xajax_sitios_interes(xajax.getFormValues("form1"));
}

//ejecuta los sitios de interes para cada empresa desde una funcion de php
function exe_crea_sitios(){
	if(document.form1.cs.checked == true){
		xajax_sitios_interes(xajax.getFormValues("form1"));
		nC('[name=sitio]').prop('checked', true);
	}
	else{
		for(var i=0; i<elim_sitio.length;i++){
			var marker = elim_sitio[i];
			marker.setMap(null);
		}
		nC('[name=sitio]').prop('checked', false);
	}
}
function ver_sitio(id){
	if(nC("#"+id).is(':checked')){
		xajax_ver_sitio(id);
	}
	else{
		for(var i=0; i<elim_sitio.length;i++){
			var marker = elim_sitio[i];
			marker.setMap(null);
		}
		sitios_seleccionados();
	}
}
function sitios_seleccionados(){
	var los_sitios=document.getElementsByName("sitio");
	for(var i=0; i<los_sitios.length; i++){
		if(los_sitios[i].checked==true){
			ver_sitio(los_sitios[i].value);
		}
	}
}
//muestra en el mapa los sitios de interes que le envia la funcion php sitios interes
function crea_sitios(nombre,lat,lon,contacto,tel1,tel2,imagenes,tipoGeo){
	if(imagenes != ""){
		var image = new google.maps.MarkerImage(imagenes,
		new google.maps.Size(20, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 20));
	}
	tipoGeo = tipoGeo.toUpperCase();
	var datosSitio="<u>Sitio de Interes</u><br/>"+
	"Nombre: "+nombre+"<br/>Contacto: "+contacto+"<br /> Tel: "+tel1+"<br /> Tel: "+tel2+"<br /> Lat: "+lat+"<br /> Long: "+lon+
	"<br /><img src='"+imagenes+"'  width='20' height='20' /> - "+tipoGeo+" - <img src='"+imagenes+"'  width='18' height='18' />";
	var infowindow = new google.maps.InfoWindow({
		content: datosSitio
	});

	var point = new google.maps.LatLng(lat,lon);
	marcador = new google.maps.Marker({
		position: point,
		map: map,
		icon: image,
		title:nombre
	});
	google.maps.event.addListener(marcador, 'click', function() {
		infowindow.open(map,this);
	});
	elim_sitio.push(marcador);
}

var colores = ["#FE9A2E","#4B8A08","#084B8A","#DF0101","#01DF01","#8181F7","#FFFF00","#58FAF4","#F78181","#8A0886"];



function ejecutar_geocercas(ide,idu){
	var request = confirm("Deseas agregar una geocerca cirular");
	if(request==true){
		alert("Seleccione un punto en el mapa");
		quitar();
		//limpiar_mapa();
		var bounds = map.getBounds();
		//alert();
		var lat=bounds.getCenter().lat().toPrecision(7);
		var lng=bounds.getCenter().lng().toPrecision(7);
		//alert(lat+","+lng+","+map.getZoom());
		
		google.maps.event.addListenerOnce(map, 'click', function(event) {
			dibujaGeoCircular(event.latLng,ide,idu);
		});		
	}
			
}
function quitar(){
	google.maps.event.clearListeners(map,'click');
	//google.maps.event.clearInstanceListeners(map);
}
function dibujaGeoCircular(centro,ide,idu){
	//alert(centro);
	var citymap = {
	center:new google.maps.LatLng(41.878113, -87.629798),
	population: 2842518
};
	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var populationOptions = {
		strokeColor: color,
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: color,
		fillOpacity: 0.35,
		map: map,
		center: centro,
		radius: 5000 / 20,
		editable: true
	};
    cityCircle = new google.maps.Circle(populationOptions);
	google.maps.event.addListener(cityCircle, 'click', function(event) {
		resp = confirm("Desea registrar su Geocerca");
		if(resp == true){
		//alert(cityCircle.getCenter());
		radio=cityCircle.getRadius();
		cerrandoModificacion={editable:false};
		//window.open('registrar_geocerca_rebe.php?lat='+centro.lat()+'&lon='+centro.lng()+'&rad='+radio+'&ide='+ide+'&idu='+idu,'Geocercas','left=200, top=200,width=300,height=200,scrollbars=NO');
		var tag = jQuery("#g-geo-pol");
		var url='registrar_geocerca_rebe.php?lat='+centro.lat()+'&lon='+centro.lng()+'&rad='+radio+'&ide='+ide+'&idu='+idu;
		  jQuery.ajax({
			url: url,
			success: function(data) {
			  tag.html(data).dialog({
				modal: true,
				dialogClass:'dialog_style',
				width: 300,
                height: 300,
				title: "Guardar Geocerca Circular ",
				buttons: {
				"Cancelar": function() {
					cityCircle.setMap(null);
					jQuery(this).dialog("close");
					},
				"Guardar":function() {
					var nombre=jQuery("#nombre").val();
					var latitud=jQuery("#latitud").val();
					var longitud=jQuery("#longitud").val();
					var radioMuestra=jQuery("#radioMuestra").val();
					xajax_guardar_circular(nombre,latitud,longitud,radioMuestra);
					jQuery(this).dialog("close");
					}
				}
				}).dialog('open');
			}
		  });
		cityCircle.setOptions(cerrandoModificacion);
		//google.maps.event.clearListeners(map, 'click');
		}
		else cityCircle.setMap(null);
	});	
	google.maps.event.addListener(cityCircle, 'rightclick', function(event) {
		//alert(cityCircle.getCenter());
		cityCircle.setMap(null);
		google.maps.event.clearListeners(map, 'click');
	});
	
}
function ver_geo(id_geo){
	xajax_ver_geocercas(id_geo);
}

/*****************************************************/
var infowindow;
var nombreGeo;
var impresos = Array();
var arrayInfo = Array();
function mostrar_circular(latit,longi,radio,nombre){
	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var centro= new google.maps.LatLng(latit,longi);
	var populationOptions = {
      strokeColor: color,
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: color,
      fillOpacity: 0.35,
      map: map,
      center: centro,
      radius: radio / 1
    };
    cityCircle = new google.maps.Circle(populationOptions);
	impresos.push(cityCircle);
	infowindow = new google.maps.InfoWindow();
	var string="<div style='min-width:100px;height:20px;max-width:250px;'>"+nombre+"</div>";
	infowindow.setContent(string);
	infowindow.setPosition(centro);
	infowindow.open(map);
	arrayInfo.push(infowindow);
	google.maps.event.addListener(cityCircle,'click',function(event) {
	//alert(cityCircle.getRadius());
	});
}
function mostrar_circular_reporte(latit,longi,radio,nombre){
	//alert("entra circ");
	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var centro= new google.maps.LatLng(latit,longi);
	var populationOptions = {
      strokeColor: color,
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: color,
      fillOpacity: 0.35,
      map: map,
      center: centro,
      radius: radio / 1
    };
    cityCircle = new google.maps.Circle(populationOptions);
	impresos.push(cityCircle);
	var infowindow = new google.maps.InfoWindow({
        'content': nombre,
		 'position':new google.maps.LatLng(latit,longi)
      });
	
	arrayInfo.push(infowindow);
	google.maps.event.addListener(cityCircle,'click',function(event) {
	//alert(cityCircle.getRadius());
	//infowindow.open(map,this);
	//alert(infowindow['content']);
	});
}
var p=0;
function mostrar_poligonal(arregloLt,arregloLo,nombre){
	var geoPoligonal;
	var punto;
	var  numeroPuntos=arregloLt.length;
	var lt,lo;
	var coordenadasPoligono = [];
	for(i=0;i<numeroPuntos;i++){
		lt=parseFloat(arregloLt[i]);
		lo=parseFloat(arregloLo[i]);
		punto=new google.maps.LatLng(lt,lo)
		coordenadasPoligono.push(punto);
    }
	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var puntoinfo=new google.maps.LatLng(arregloLt[0],arregloLo[0]);
	var opcionesPoligono={
    paths: coordenadasPoligono,
    strokeColor: color,
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: color,
    fillOpacity: 0.35
  };
	geoPoligonal = new google.maps.Polygon(opcionesPoligono);
	nombreGeo=nombre;
	geoPoligonal.setMap(map);
	impresos.push(geoPoligonal);
	infowindow = new google.maps.InfoWindow();
	var string="<div style='min-width:100px;height:20px;max-width:250px;'>"+nombre+"</div>";
	infowindow.setContent(string);
	infowindow.setPosition(puntoinfo);
	infowindow.open(map);
	arrayInfo.push(infowindow);
	}
function mostrar_poligonal_reporte(arregloLt,arregloLo,nombre){
	//alert("entra poli");
	var geoPoligonal;
	var punto;
	var  numeroPuntos=arregloLt.length;
	var lt,lo;
	var coordenadasPoligono = [];
	for(i=0;i<numeroPuntos;i++){
		lt=parseFloat(arregloLt[i]);
		lo=parseFloat(arregloLo[i]);
		punto=new google.maps.LatLng(lt,lo)
		coordenadasPoligono.push(punto);
    }
	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var puntoinfo=new google.maps.LatLng(arregloLt[0],arregloLo[0]);
	var opcionesPoligono={
    paths: coordenadasPoligono,
    strokeColor: color,
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: color,
    fillOpacity: 0.35
  };
	geoPoligonal = new google.maps.Polygon(opcionesPoligono);
	nombreGeo=nombre;
	geoPoligonal.setMap(map);
	nombreGeo=nombre;
	
	impresos.push(geoPoligonal);
	infowindow = new google.maps.InfoWindow();
	infowindow.setContent(nombre);
	infowindow.setPosition(puntoinfo);
	//infowindow.open(map);
		arrayInfo.push(infowindow);
	}
var ultimo = Array();
function contar(){
	//alert(impresos.length);
	for(var j=0; j < impresos.length; j++){
		var geoCer = impresos[j]; // find the marker by given id
		geoCer.setMap(null);
		
		//markersArrays.length=0;
	}
	for(var f=0; f < impresos.length; f++){
		var info = arrayInfo[f]; // find the marker by given id
		info.setMap(null);
	}
	impresos = impresos.splice(impresos.length);
	arrayInfo = arrayInfo.splice(arrayInfo.length);

	var checkboxes = document.getElementById("form1").ejec;
	if(checkboxes.length >1){
		for(var i=0; i<checkboxes.length; i++){
			if(checkboxes[i].checked==true){
				ultimo.push(checkboxes[i].value);
				ver_geo(checkboxes[i].value);
			}
		}
	ultimo = ultimo.splice(ultimo.length);	
	}
	else{
		if(checkboxes.checked==true){
			ver_geo(checkboxes.value);
		}
	}
}
function limpiar_mapa(){
	if(vertice.length>1){
		poly.setMap(null);
		for(var i=0;i<vertice.length;i++){
			vertice[i].setMap(null);
		}
	}
	if(impresos.length>1){
		cityCircle.setMap(null);
	}
}
//geocercas poligonales
var poly;
var vertice = new Array();
var id_empresa;
var puntosPol;
function ejecutar_geo_pol(ide){
	var request = confirm("Desea crear una geocerca poligonal");
	if(request == true){
		alert("Selecciona los puntos en el mapa");
		//limpiar_mapa();
		quitar();
		var bounds = map.getBounds();
		//alert();
		var lat=bounds.getCenter().lat().toPrecision(7);
		var lng=bounds.getCenter().lng().toPrecision(7);
		//alert(lat+","+lng+","+map.getZoom());
		//alert("Dibuje la figura que desee sobre el mapa");
		id_empresa=ide;
		var polyOptions = {
	    strokeColor: '#0000FF',
	    strokeOpacity: 0.7,
	    strokeWeight: 2
	  }
	  poly = new google.maps.Polyline(polyOptions);
	  poly.setMap(map);
	   // Add a listener for the click event
	  google.maps.event.addListener(map, 'click', addLatLng);
	}	
}
 
function addLatLng(event) {
/**
 * Handles click events on a map, and adds a new point to the Polyline.
 * @param {MouseEvent} mouseEvent
 */
  var path = poly.getPath();
  var i;
  // Because path is an MVCArray, we can simply append a new coordinate
  // and it will automatically appear
  path.push(event.latLng);

  // Add a new marker at the new plotted point on the polyline.
  var marker = new google.maps.Marker({
    position: event.latLng,
    title: '#' + path.getLength(),
    map: map
  });
  vertice.push(marker);
 
  google.maps.event.addListener(marker, 'rightclick',function(event){
			if(resp=confirm("Desea guardar esta geocerca?"))
			{
				//alert(marker.getPosition());
				dibujaPoligonal();
			}else{
				poly.setMap(null);
				for(var i=0;i<vertice.length;i++){
				vertice[i].setMap(null);}
			}
	google.maps.event.clearListeners(map, 'click');
  });
  
}

function dibujaPoligonal() {
	var lat_lon = "";
	var prio, puntosPol;
	//alert(vertice.length);
	for(var j = 0; j < vertice.length; j++){
		 prio = j+1;
		 puntosPol=vertice[j].getPosition();
		lat_lon +="("+ puntosPol.lat()+","+puntosPol.lng()+","+ prio +",num_geo)";
	}
	lat_lon +=":";
	//window.open('registra_geo_pol.php?ide='+id_empresa+'&cons='+lat_lon,'Poligonal','left=300,top=300,width=400,height=300,scrollbars=NO');
	//jQuery('#g-geo-pol').load('registra_geo_pol.php?ide='+id_empresa+'&cons='+lat_lon).dialog();
	var tag = jQuery("#g-geo-pol");
	var url='registra_geo_pol.php?ide='+id_empresa+'&cons='+lat_lon+'&idu='+jQuery("#idusuario").val();
	  jQuery.ajax({
			url: url,
			success: function(data) {
			  tag.html(data).dialog({
				modal: true,
				dialogClass:'dialog_style',
				width: 300,
                height: 300,
				title: "Guardar Geocerca Poligonal ",
				buttons: {
				"Cancelar": function() {
					poly.setMap(null);
					for(var i=0;i<vertice.length;i++){
						vertice[i].setMap(null);
					}
					jQuery(this).dialog("close");
					},
				"Guardar":function() {
					//document.form1.submit();
					var nombre=jQuery("#nombre").val()
					var consulta=jQuery("#consulta").val()
					xajax_guardar_poly(nombre,consulta);
					poly.setMap(null);
					for(var i=0;i<vertice.length;i++){
						vertice[i].setMap(null);
						}
					jQuery(this).dialog("close");
					
					}
				}
				}).dialog('open');
			}
		  });
}

 /*  primera prueba*/
 var vertice_ruta = new Array();
 
function ejecutar_ruta(ide,idu){
	var rendererOptions = {
		draggable: true
	};
	directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

	var bounds = map.getBounds();
	//alert();
	var lat=bounds.getCenter().lat().toPrecision(7);
	var lng=bounds.getCenter().lng().toPrecision(7);
	//alert(lat+","+lng+","+map.getZoom());
	var myOptions = {
		zoom: map.getZoom(),
		center: new google.maps.LatLng(lat,lng),
		//streetViewControl: true,//true= "monito"
		disableDoubleClickZoom:true,
		overviewMapControl:true,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	map=new google.maps.Map(document.getElementById('cont_mapa'),myOptions);
	directionsDisplay.setMap(map);
	//alert("Cuenta con un maximo de 8 puntos");
	id_empresa=ide;
	var polyOptions = {
    strokeColor: '#FF0000',
    strokeOpacity: 0.7,
    strokeWeight: 2
	}
  Ruta = new google.maps.Polyline(polyOptions);
  Ruta.setMap(map);
   // Add a listener for the click event
  google.maps.event.addListener(map, 'click', addLatLngRuta);
  }
function addLatLngRuta(event) {
/**
 * Handles click events on a map, and adds a new point to the Polyline.
 * @param {MouseEvent} mouseEvent
 */
	var lat = new Array();
	var lon = new Array();
	var waypts = new Array();
	
	var path_ruta = Ruta.getPath();
	var i;
	if(vertice_ruta.length<6){
		 path_ruta.push(event.latLng);
		 
	  var marker = new google.maps.Marker({
		position: event.latLng,
		title: '#' + path_ruta.getLength(),
		map: map
	  });
		vertice_ruta.push(marker);
		google.maps.event.addListener(marker, 'rightclick',function(event){
			if(resp=confirm("Desea Guardar la ruta?"))
			{
				//alert(marker.getPosition());
				GuardaRuta();
			}else{
				Ruta.setMap(null);
				for(var i=0;i<vertice_ruta.length;i++){
				vertice_ruta[i].setMap(null);}
			}
				google.maps.event.clearListeners(map, 'click');
		});
		
		google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
			computeTotalDistance(directionsDisplay.directions);
		});
		if(vertice_ruta.length>=2){
			for(var j = 0; j < vertice_ruta.length; j++){
				 prio = j+1;
				 puntosPol=vertice_ruta[j].getPosition();
				//lat_lon +="("+ puntosPol.lat()+","+puntosPol.lng()+","+ prio +",num_geo)";
				lat[j]=puntosPol.lat();
				lon[j]=puntosPol.lng();
				 waypts.push({
					  location:new google.maps.LatLng(lat[j],lon[j]),
					  stopover:true
				  });
			}
			var start=new google.maps.LatLng(lat[0],lon[0]);//primer punto que "dibuja"
			var end=new google.maps.LatLng(lat[(vertice_ruta.length)-1],lon[(vertice_ruta.length)-1]);//ultimo punto que "dibuja"
			
			//alert(start+"/"+end);
			var request = {
			  origin:start,
			  destination:end,
			  waypoints: waypts,
			  durationInTraffic: true,			  
			  optimizeWaypoints: true,
			  provideRouteAlternatives: true,
			  travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			directionsService.route(request, function(response, status) {
				//alert(response);
				if (status == google.maps.DirectionsStatus.OK) {
					//vertice_ruta.setMap(null);
					//load();
					directionsDisplay.setDirections(response);
				}
			});
		}
	}
	else{
		alert("No puede tener mas de 8 puntos");
	}
} 
function computeTotalDistance(result) {
  var total = 0;
  var total_d = 0;
  var myroute = result.routes[0];
  var duracion= result.routes[0];
  //console.log(result.routes[0].legs[1].duration);
  for (var i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
	total_d +=duracion.legs[i].duration.value;
  }
  total = total / 1000;
  total_d= segundos_a_horas(total_d);
  document.getElementById('distancia').innerHTML ='Distancia: '+ total + ' km Tiempo: '+ total_d;
}
function segundos_a_horas(sec)
{
	var hrs = Math.floor(sec/3600);
	var min = Math.floor((sec%3600)/60);
	sec = sec % 60;
	if(sec<10) sec = "0" + sec;
	if(min<10) min = "0" + min;
	return hrs + ":" + min + ":" + sec;
}

var myAddress=new Array();
function GuardaRuta() {
	var lat = new Array();
	var lon = new Array();
	var prio, puntosPol;
	//alert(vertice.length);
	for(var j = 0; j < vertice_ruta.length; j++){
		 prio = j+1;
		 puntosPol=vertice_ruta[j].getPosition();
		//lat_lon +="("+ puntosPol.lat()+","+puntosPol.lng()+","+ prio +",num_geo)";
		lat[j]=puntosPol.lat();
		lon[j]=puntosPol.lng();
	}
	//var start=lat[0]+","+lon[0];
	//var end=lat[vertice_ruta.length]+","+lon[vertice_ruta.length];
	//var results= "http://maps.googleapis.com/maps/api/directions/json?"+origen+destino+"&sensor=true";
	
	//directionsDisplay = new google.maps.DirectionsRenderer();
	
	//var start = document.getElementById('start').value;
	//var end = document.getElementById('end').value;
	var start=new google.maps.LatLng(lat[0],lon[0]);
	var end=new google.maps.LatLng(lat[(vertice_ruta.length)-1],lon[(vertice_ruta.length)-1]);
	//alert(start+"/"+end);
	var request = {
	  origin:start,
	  destination:end,
	  travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsService.route(request, function(response, status) {
		alert(response);
	if (status == google.maps.DirectionsStatus.OK) {
		vertice_ruta.setMap(null);
		directionsDisplay.setDirections(response);
	}
	});

}
/* 	******************************			******************************			******************************		*/
function hide_menu(){
	document.getElementById('menu_emerge').style.visibility = 'hidden';
}
function show_menu(){
	document.getElementById('menu_emerge').style.visibility = 'visible';
}
function crear_mapas(){
	if(document.form1.mc.checked == true){
		document.getElementById('cuerpo_medio').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
		document.getElementById("cont_mapa2").style.visibility = "hidden";
		document.getElementById("cont_mapa_sepro").style.visibility = "visible";
		document.getElementById('cont_mapa_sepro').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
		document.form1.zoom.value = 3000;
		xajax_crear_mapa_sepro(xajax.getFormValues("form1"));
	}
	else{ 
		document.getElementById("cont_mapa_sepro").style.visibility = "hidden";
		document.getElementById("cont_mapa2").style.visibility = "visible";
		}
}

function menos_zoom(){
	document.getElementById('cont_mapa_sepro').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
	var z = document.form1.zoom.value;
	var total = z/2;
	document.form1.zoom.value = total;
	xajax_crear_mapa_sepro(xajax.getFormValues("form1"));
}

function mas_zoom(){
	var z = document.form1.zoom.value;
	var total = z*2;
	if(total <= 3000){
		document.form1.zoom.value = total;
		xajax_crear_mapa_sepro(xajax.getFormValues("form1"));
	}
	else alert("Sobrepasó el nivel de acercamiento");
}

function ayuda(){
    var ayuda=window.open("Ayuda/Ayuda.php","ayuda","width=400,height=350,left=500,top=200");
	childwindows[childwindows.length]=ayuda;
}

function ejecutar_config(idu){
	var cad="-";
	var checkboxes="";
	var sit = document.getElementById("form1").cs;
	if(sit.checked==true){
			var num = sit.value;
	}
	else num = 0;
	checkboxes = document.getElementById("form1").ejec;
	if(checkboxes == null)
		cad="-";
	else{
		if(checkboxes.length >= 2){
			for(var i=0; i<checkboxes.length; i++){
				if(checkboxes[i].checked==true){
					cad += new String(checkboxes[i].value)+".";
				}
			}
		}
		else{
			if(checkboxes.checked == true)
				cad += new String(checkboxes.value)+".";
		}
   	}
	var b = confirm("Desea Guardar su configuración ");
		if(b)
			xajax_reg_config(idu,num,cad);
}

var no_win = 0;
	var time_live;
	var time_pan;
	var ml = new Array();
	var lis = new Array();

function finishQuery()
{
	makingQuery = false;
}
	
function tiempo(idu,p,not){	    
	if(p==1 /*&& !makingQuery*/){
		//document.form1.pncs.checked = true;				
		if(not==1){//estoy viendo las noticias
			//setTimeout('tiempo('+idu+','+p+',1)',1000);
			document.getElementById('num_msj1').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
			xajax_mostrar_otros(0);
		}
		else
		{
			//setTimeout('tiempo('+idu+','+p+',0)',50000);
			document.getElementById('num_msj').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
			makingQuery = true;
			xajax_alertas(idu);
		}				
	}
}
	
function crear(){
	no_win++;
	if(no_win==1)
		createNewTab("dhtmlgoodies_tabView1","Alertas","<div id='alarmas' style='text-align:left;'></div>");
}
	
	function veh_seleccion(lat,lon){
		// API VERSION 3
		var posicion=new google.maps.LatLng(lat,lon);
		map.setOptions({
		center:posicion,
		zoom:17
	});
	}
	function grande(){
		var j = jQuery.noConflict();
		var center1 = map.getCenter();
		j("#cont_mapa").animate({left: "10px", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").animate({width: "100%", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").animate({height: "810px", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").parent().css('z-index', 2000);/* agregamos el z-index para el IE de lo contrario el bottom oculta parte del mapa*/
		document.getElementById('imagen').innerHTML = '<label onclick="peque();"><img src="img2/contraer.png" height="18px" width="18px" border="0" title="Mostrar mapa chico"/></label>';
	//map.checkResize();
	map.setCenter(center1);

	}
	
	function peque(){
		 var j = jQuery.noConflict();
		var center1 = map.getCenter();
		j("#cont_mapa").animate({width: "80%", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").animate({left: "235px", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").animate({height: "100%", opacity: 1}, { duration: 0, queue: true });
		j("#cont_mapa").parent().css('z-index', 2000);/* agregamos el z-index para el IE de lo contrario el bottom oculta parte del mapa*/
		document.getElementById('imagen').innerHTML = '<label onclick="grande();"><img src="img2/expandir.png" height="18px" width="18px" border="0" title="Mostrar mapa grande" /></label>';
		//map.checkResize();
		map.setCenter(center1);
	}
var pos_Array = new Array();
var veh_Array = new Array();
function muestra_alerta(num)
{
	xajax_muestra_alerta(pos_Array,veh_Array,num);
}	
/*--------------------------------------------------------------------------------------------------------------------------*/
var al = new Array();
var nl = new Array();
function MapaCordLive(la, lo, tv, nom) {   //$calle, $men, $vel, $fe,  calle, msg, vel, fec, 
	if(markersArrays.length!=0){
		elimMarcador();
	}
	var etiqueta=nom+" esta aqui";
	var mizoom=map.getZoom();
	var miPosicion=new google.maps.LatLng(la,lo);
	map.setOptions({
		center:miPosicion,
		zoom:mizoom
	});
	var image = new google.maps.MarkerImage('IconosV3/'+tv+'.png',
		new google.maps.Size(50, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 20));
	marcador = new google.maps.Marker({
		position: miPosicion,
		map: map,
		icon: image,
		title: etiqueta
	});
	al.push(marcador);
}
function crear_live(idu){
	var infor =  document.getElementById("cuerpo_medio");
	var	infor1 = document.getElementById("cont_autos_tabs");
	 
		//if(document.form1.live.checked == true){
			//marca.setMap(null);
			infor.innerHTML='';
			//infor1.style.width='350px';
			infor1.css=("position","absolute");
		 	//createNewTab("dhtmlgoodies_tabView1","Live","<div id='m_live' style='text-align:left;'></div>");
			xajax_modo_live(idu);
		//}
		/*
		else{
			for(var l=0; l<al.length; l++){
				var elemento=al[l];
				elemento.setMap(null);
			}
		//alert("no live");
		// map.addOverlay(marca);
		 infor.innerHTML='';
		 window.clearTimeout(time_live);
		 deleteTab("Live");
		}*/

}
function genera_arreglo(){	
	var ml = document.getElementById("form1").mark_live;
	var selec=0;
	var max=50;
	for(var i=0; i<ml.length; i++){
		if(ml[i].checked==true){
			selec++;
		}
	}
	if(selec>=max){
		alert("No puede agregar mas de 50 vehiculos al mismo tiempo");
	}
	else{
		if(selec>0){
			if(!time_live)
				time_live = window.setTimeout('genera_arreglo()',(1000*60*1));
			if(time_live){
				window.clearInterval(time_live);
				time_live = window.setTimeout('genera_arreglo()',(1000*60*1));
			}
			
			if(ml.length >=2){
				if(al.length > 0){
					for(var l=0; l<al.length; l++){
						/*map.removeOverlay(al[l]);
						map.removeOverlay(nl[l]);*/
						var al1=al[l];
						al1.setMap(null);
						
					}
				}
				for(var i=0; i<ml.length; i++){
					if(ml[i].checked == true)
						lis.push(ml[i].value);
				}
				xajax_arreglo(lis);
				lis =lis.splice(lis.length);
				al = al.splice(al.length);
				
				if(lis.length == 0){
					document.getElementById("cuerpo_medio").innerHTML='';
				}
			}else{
				if(ml.checked==true){
					lis.push(ml.value); //inserta en arreglo el elemento
					xajax_arreglo(lis); //envia arreglo para ser procesado en funcion xajax
				}
				else{
				alert("no check");
					window.clearTimeout(time_live); //limpia el evento del timeout
					var nl1=nl[nl.length-1]; var al1=al[al.length-1];
					al1.setMap(null);
						
					//map.removeOverlay(al[al.length-1]); //elimina la marca del vehiculo, solo cuando es uno
					//map.removeOverlay(nl[nl.length-1]); //Elimina la marca del nombre solo cuando es uno
					lis = lis.splice(lis.length); //limpia el arreglo
					al = al.splice(al.length);
					document.getElementById("cuerpo_medio").innerHTML='';
				}
			}
		}
		else{
			window.clearTimeout(time_live);
			document.getElementById("cuerpo_medio").innerHTML='';
		}
	}
}
function checandoEstatus(numVeh){
	console.log(numVeh);
	xajax_checandoEstatus(numVeh);
}

	
function cerrar_ventanas(){
	for(var i=0; i<childwindows.length; i++){
		try{
			childwindows[i].close()
		}catch(e){
			alert(e);
		}	
	}
}
function ocultar_veh(){
	jQuery("#cuerpo_medio").hide();
}
function muestra_cuerpo(){
	jQuery("#cuerpo_medio").show();
}
function abreILSP(){
	xajax_cargaVehsILSP();
	jQuery("#dialog-ilsp").dialog("open");
}
function abreFEMSA(){
	xajax_cargaVehsFEMSA();
	jQuery("#dialog-femsa").dialog("open");
}

function htmlspecialchars_decode(string, quote_style) {
  //       discuss at: http://phpjs.org/functions/htmlspecialchars_decode/
  //      original by: Mirek Slugen
  //      improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //      bugfixed by: Mateusz "loonquawl" Zalega
  //      bugfixed by: Onno Marsman
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //      bugfixed by: Brett Zamir (http://brett-zamir.me)
  //         input by: ReverseSyntax
  //         input by: Slawomir Kaniecki
  //         input by: Scott Cariss
  //         input by: Francois
  //         input by: Ratheous
  //         input by: Mailfaker (http://www.weedem.fr/)
  //       revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //        example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
  //        returns 1: '<p>this -> &quot;</p>'
  //        example 2: htmlspecialchars_decode("&amp;quot;");
  //        returns 2: '&quot;'

  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined') {
    quote_style = 2;
  }
  string = string.toString()
    .replace(/&lt;/g, '<')
    .replace(/&gt;/g, '>');
  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
  }
  if (!noquotes) {
    string = string.replace(/&quot;/g, '"');
  }
  // Put this in last place to avoid escape being double-decoded
  string = string.replace(/&amp;/g, '&');

  return string;
}