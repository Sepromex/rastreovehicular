<style>
    .mail-app li .car-name{
        min-width:120px;
        font-size: .55rem;
    }
    .car-num{
        position: relative;
        top: 10px;
        left: -12px !important;
    }
    .font-tab{ font-size: 1.55rem !important; }
    .padding-tab{ padding: .5rem .6rem !important; }
    .speed-icon{ margin-bottom: .5rem; font-weight: 500; line-height: 1.2; width:20px; }
.bg-orange{ background-color: orange; }
  #map {    
    width: 100%;
    height: 690px;
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
</style>

<script>
    let map;

    function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 20.721827087454802, lng:  -103.37155710393355 },
        zoom: 10,
    });
    }
</script>

<div class="container-fluid "> 
    <!-- START: Card Data-->
    <div class="row">

<!--  <li class="nav-item" style="padding: 5px 2px !important;">
                                    <a href="#" data-mailtype="inbox" class="nav-link padding-tab active"> 
                                        <i class="mdi mdi-car font-tab"></i> 
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num"><?=(isset($vehicle_list))?count($vehicle_list):0;?></span>
                                    </a>
                                </li>-->

        <div class="col-2 mt-3"> 
            <div class="card">
                <!-- ##### TABS ##### -->
                <div class="card-header">                                   
                    <div class="row m-auto">
                        <div class="col-12 col-lg-12 col-xl-12 pr-lg-0 flip-menu ">                                                    
                            <ul class="list-unstyled nav inbox-nav  mb-0 mail-menu" style="margin-top:0px !important;">
                                <li class="nav-item" style="padding: 5px 2px !important;">
                                    <a href="#" class="nav-link padding-tab active" data-list="vehicle_list"> 
                                        <i class="mdi mdi-car font-tab"></i> 
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num"><?=(isset($vehicle_list))?count($vehicle_list):0;?></span>
                                    </a>
                                </li>
                                <li class="nav-item" style="padding: 5px 2px !important;">
                                    <a href="#" class="nav-link padding-tab"  data-list="site_list">
                                        <i class="mdi mdi-map-marker font-tab"></i> 
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num">9</span>
                                    </a>
                                </li> 
                                <li class="nav-item"  style="padding: 5px 2px !important;">
                                    <a href="#" class="nav-link padding-tab"  data-list="geoc_list">
                                        <i class="mdi mdi-map-marker-circle font-tab"></i>
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num">10</span>
                                    </a>
                                </li>                                
                            </ul> 
                        </div>
                    </div>
                </div>
                <!-- END TABS -->

                <!-- ####### VEHICULOS LIST##############  -->
                <div class="card-body p-0">                          
                    <div id="vehicle_list" class="mainmap_list">
                        <?php $this->load->view("map/vehicle_list"); ?>
                    </div>
                    <div id="site_list" class="mainmap_list" style=" display: none;">
                        <?php $this->load->view("map/sites_list"); ?> 
                    </div>
                    <div id="geoc_list" class="mainmap_list"  style=" display: none;">
                        <?php $this->load->view("map/geo_list"); ?> 
                    </div>
                </div>
                <!-- ####### END VEHICULOS LIST ##############  -->

            </div>  <!-- End card-->              
        </div> <!-- END col-2 -->
        


        <div class="col-10 mt-3">
            <div class="row">                
                <div id="map"></div>
            </div>
            <div class="row" id="ubicacion"></div>
            <div class="row" id="sitios"></div>
        </div>        
                    
                    
    </div>
</div>           

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGi-KpwkfLDT4fRXuVTRxAyUsClhTIPBI&callback=initMap&libraries=&v=weekly" async></script>
<script> 

var timerID = 0;
var marca,marker,sitios;
var elim_sitio = new Array();
//var makingQuery = false;
var markersArrays=new Array();
var directionsService;
var directionsDisplay;
var childwindows = new Array();
var al = new Array();
var nl = new Array();

//founcion de incio de mapas de google.
var punto;
var punto2;
var marca;
var smov;
var tipoV;
var marcaStart,marcaEnd;
var visitedPages = new  Array();
var linea = new Array();
var optSelected = 1;
var flightPath;
var arregloDeRecorridos= new Array();


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

function elimR(){
	var flightPath = arregloDeRecorridos[0];
	flightPath.setMap(null);
	arregloDeRecorridos.length=0;
}

function crea_recorrido(lat,lon,t,pag){
	var encontrado = false;

    console.log(visitedPages.length);

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
	var image = new google.maps.MarkerImage('/dist/images/map/vehicle.png',
		new google.maps.Size(80, 40),
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

function vehicle_ubication(id,company) {
	/*document.getElementById("cont_mapa_sepro").style.visibility = "hidden";
	document.getElementById('cuerpo_medio').innerHTML='<img src="img2/loader.gif" width="15px" height="15px" />';
	xajax_posicion(id);*/ 
    $.ajax({ 
        type: "POST",
        data: {id:id,company:company},
        url: "/MainMap/get_ubication",
        success: function (response) {  
            //console.log();
            var last = response.last;                        
            $("#ubicacion").html(response.table);
            //console.log(response.route);
            MapaCord(last.lat, last.lon, last.tipov, response.veh);            
            $.each(response.route, function(i, item) {
                crea_recorrido(item.lat,item.lon,item.tipoveh,0);
            });   
            mostrarLinea2(0);
        }
    }); 
}


function crea_sitios(nombre,lat,lon,contacto,tel1,tel2,imagenes,tipoGeo,zoom = 0){
    imagenes = '/dist/images/map/vehicle.png';
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
    if(zoom == 1){
        var posicion=new google.maps.LatLng(lat,lon);
                map.setOptions({
                center:posicion,
                zoom:17
        });
    }
}

function ver_sitio(id){
	if($("#check"+id).is(':checked')){
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

function show_site(id){
    $.ajax({ 
        type: "POST",
        data: {id:id}, 
        url: "/MainMap/show_sites",
        success: function (response) {             
            var s = response;
            //if(s.nombre){
              crea_sitios(s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,s.imagen,s.descripcion,1);
              //console.log(s.nombre+' '+s.latitud+' '+s.longitud+' '+s.contacto+' '+s.tel1+' '+s.tel2+' '+s.imagen+' '+s.descripcion);
           // }
        }
    });  
}

function load_geo(){ 
    $.ajax({ 
        type: "POST", 
        url: "/MainMap/load_geo",
        success: function (response) {             
            $("#geo_list").html(response);
        }
    });  
}


function load_vehicles(){ 
    $.ajax({ 
        type: "POST", 
        url: "/MainMap/mostrar_vehiculos_act",
        success: function (response) {             
            $("#vehicles_list").html(response);
        }
    });  
}

function load_sites(){ 
    $.ajax({ 
        type: "POST",         
        url: "/MainMap/load_sites",
        success: function (response) {             
            $("#sites_list").html(response);
        } 
    });  

}

load_vehicles();
load_sites(); 
load_geo();

/*$(document).ready(function(){
    "use strict";     
    setInterval(load_vehicles(),8000);  
});*/
//var load_v = setInterval( function() { load_vehicles(); }, 30000);
</script> 