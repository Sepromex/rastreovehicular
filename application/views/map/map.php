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
    #map { width: 97%; height: 690px; margin left:10px; }
    #ubicacion, #sitios {width:99.9%; }
    html, body{ height: 100%; margin: 0; padding: 0; }
    .text-orange{ color: orange; }
    .cursor-pointer{ cursor:pointer; }
    .bg-control{ background-color: #d3f5c9 !important; } 
</style>
 
<div class="container-fluid "> 
    <!-- START: Card Data-->
    <div class="row">
        <div class="col-2 mt-3"> 
                
            </div>
        </div>
    </div>

    <div class="row">


        <div class=" col-sm-12 col-md-4 col-lg-3 col-xl-2  mt-3"> 
            <div class="card"><?php //print_array($site_type);?>
                <!-- ##### TABS ##### -->
                
                    <div class="card-header" id="maincontrols">
                        <div class="row m-auto">
                            <div class=" m-auto ">
                                <ul class="list-unstyled nav inbox-nav  mb-0 mail-menu" style="margin-top:0px !important;">
                                    <li class="nav-item" style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab active  toltip" data-list="vehicle_list"  data-placement="top" title="Vehículos"> 
                                            <i class="mdi mdi-car font-tab"></i> 
                                            <!-- <span class="ml-auto badge badge-pill badge-success bg-success car-num"><?=(isset($vehicle_list))?count($vehicle_list):0;?></span> -->
                                        </a>
                                    </li>
                                    <li class="nav-item" style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab toltip" data-list="site_list" data-placement="top" title="Sitios de interés">
                                            <i class="mdi mdi-home-map-marker font-tab"></i> 
                                            <!-- <span class="ml-auto badge badge-pill badge-success bg-success car-num">9</span> -->
                                        </a>
                                    </li> 
                                    <li class="nav-item"  style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab toltip"  data-list="geoc_list"  data-placement="top" title="Geo-cerca">
                                            <i class="mdi mdi-map-marker-circle font-tab"></i>
                                            <!-- <span class="ml-auto badge badge-pill badge-success bg-success car-num">10</span> -->
                                        </a>
                                    </li>
                                </ul> 
                            </div>
                        </div>
                    </div>
                    <!-- END TABS -->

                    <!-- ####### VEHICULOS LIST##############  -->
                    <div class="card-body p-0">
                        
                        <div class="view-email">
                            <div class="card-body">
                                <a href="#" class="bg-primary float-left mr-3  py-1 px-2 rounded text-white back-to-email">
                                    Regresar
                                </a>                                     
                                <div id="detail-content"></div>  
                            </div>
                        </div>                       


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
        
        <div class="col-sm-12 col-md-8 col-lg-9 col-xl-10  mt-3">
            <div class="row">                
                <div id="map"></div>
            </div>
            <div class="row" id="ubicacion"></div>
            <div class="row" id="sitios"></div>
        </div>      
                    
    </div>
</div>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2ZgtqdFwl6hQomaR295YK0A1XVjcVXl0&callback=initMap&libraries=&v=weekly" async></script>


<script> 

$('.toltip').tooltip();
var timerID = 0;
var marca,marker,sitios;
var elim_sitio = new Array();

var markersArrays = new Array();
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
var flightPath = new Array();
var arregloDeRecorridos = new Array();

var origin = null;
var destination = null;
var inter = null;
var waypoints = [];
var markers = [];
var markers_rutas = [];
var directionsVisible = false;
var currentId = 0;
 var settimeputarray = new Array();


let map;

    function initMap() {
        //directionsService = new google.maps.DirectionsService();
        //directionsDisplay = new google.maps.DirectionsRenderer();

        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 21.9518, lng: -100.9397 },
            zoom: 6,
            streetViewControl: true, //true= "monito"
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
        });
                
        //directionsService = new google.maps.DirectionsService();
        //directionsDisplay = new google.maps.DirectionsRenderer(); 
        //directionsDisplay.setMap(map);
    }

function ejecutar_geocercas(){
	var request = confirm("Deseas agregar una geocerca cirular");
	if(request==true){
       // cancelgeo();
		alert("Seleccione un punto en el mapa");
		quitar();
		//limpiar_mapa();
		var bounds = map.getBounds();		
        //alert();
		var lat=bounds.getCenter().lat().toPrecision(7);
		var lng=bounds.getCenter().lng().toPrecision(7);		
        //alert(lat+","+lng+","+map.getZoom());		
		google.maps.event.addListenerOnce(map, 'click', function(event) {
			dibujaGeoCircular(event.latLng);
		});
	}			
}

var colores = ["#FE9A2E","#4B8A08","#084B8A","#DF0101","#01DF01","#8181F7","#FFFF00","#58FAF4","#F78181","#8A0886"];


function cancelgeo() {
    cityCircle.setMap(null);
    //jQuery(this).dialog("close");
}			


function validate_form_geoside(){
    var geoname = validate_name("#geoside_name","#feedback-geoside_name");
    var band = 1;
    if(geoname == "false"){ band = 0; }    
    if(band == 1){
       return "true";
    }else{
        return "false";
    }
}

function edit_geoside(id){
    if(validate_form_geoside() == "true"){    
        $.ajax({ 
            type: "POST", 
            data: $("#side_maingeo").serialize(),
            url: "<?=base_url()?>/Config/Geo/geo_update",
            success: function (response) {  
                if(response == "true"){ 
                    $("#geo_list li #geoname_"+id).html($("#side_maingeo #geoside_name").val());
                    $('#settings').removeClass('active');

                    $("#geo_list #geolist_"+id).addClass('bg-control');
                    $("#geo_list #geolist_"+id).css('opacity','.1');
                    
                    $("#geo_list #geolist_"+id).animate({opacity: 1}, 700, function() {                        
                        $("#geo_list #geolist_"+id).removeClass('bg-control',700);
                    });                     

                    console.log("true");
                }else{
                    alert("response");
                }            
            }
        });
    }
}

function save_newgeo(){
    if(validate_form_geoside() == "true"){
        $.ajax({ 
            type: "POST", 
            data: $("#side_maingeo").serialize(),
            url: "<?=base_url()?>/Config/Geo/insert_site",
            success: function (response) {            
                if(response > 0){
                    var idgeo = response;
                    var icon  = ($("#maingeo_tipo").val()==0)?'circle':'polig';
                    var icon_usr = "mdi mdi-account-outline text-success"; 
                    var classusr = "user";
                    var nombre   = $("#geoside_name").val();            

                    $('#settings').removeClass('active');
                
                var template = '<li class="py-1 px-2 mail-item inbox bg-control sent g-'+icon+' geo_'+classusr+'"  id="geolist_'+idgeo+'" style="opacity:0;"><div class="d-flex align-self-center align-middle"><label class="chkbox"><input type="checkbox"><span class="checkmark small"></span></label><div class="mail-content d-md-flex w-100"><span class="car-name" id="geoname_'+idgeo+'">'+nombre+'</span><div class="d-flex mt-3 mt-md-0 ml-auto"><div class="'+icon_usr+' h5"></div><img src="<?=base_url()?>/dist/images/map/geo/'+icon+'.png" class="mt-1" width="20px" height="18px"><a href="#" class="ml-3 mark-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a><div class="dropdown-menu p-0 m-0 dropdown-menu-right"><a class="dropdown-item" href="#" onclick="edit_geolist('+idgeo+')"><i class="mdi mdi-playlist-edit"></i> Editar </a><a class="dropdown-item" href="#" onclick="delete_mainsite('+idgeo+')"><i class="icon-trash"></i> Eliminar </a></div></div></div></div></li>';               
                if($("#geo_list").prepend(template)){
                        $("#geolist_"+idgeo).animate({opacity: 1}, 700, function() {                        
                            $("#geolist_"+idgeo).removeClass('bg-control',700);
                        });                    
                }
                
                }else{
                    alert("response");
                }        
            }
        });
    }
}



function edit_geolist(id){        
    $.ajax({ 
        type: "POST", 
        data: {id:id,type:1},
        url: "<?=base_url()?>/Config/Geo/geo_sideform",
        success: function (response) { 
            $("#sidebar-content").html(response);  
            $('#settings').addClass('active');
            $("#geo_lis #geolist_"+id).html($("#side_maingeo #geoside_name").val());  
            
            $('.openside').on('click', function () {
                $('#settings').toggleClass('active');
                return false;
            });
        }
    });
}

function dibujaGeoCircular(centro){	
	var citymap = { 
        center:new google.maps.LatLng(41.878113, -87.629798),
	    population: 2842518 };

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
		radio = cityCircle.getRadius();
		cerrandoModificacion={editable:false};
		
		//var tag = jQuery("#g-geo-pol");
		//var url='registrar_geocerca_rebe.php?lat='+centro.lat()+'&lon='+centro.lng()+'&rad='+radio+'&ide='+ide+'&idu='+idu;
        //console.log(url);

        $.ajax({ 
            type: "POST",             
            data: {type:0, lat:centro.lat(), lon:centro.lng(), radio:radio},
            url: "<?=base_url()?>/Config/Geo/geo_sideform",
            success: function (response) {  
                $("#sidebar-content").html(response);  
                $('#settings').addClass('active');
                $('.openside').on('click', function () {
                    //cityCircle.setMap(null);cancel-geo
                    $('#settings').toggleClass('active');
                    return false;
                });
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




function quitar(){
	google.maps.event.clearListeners(map,'click');
	//google.maps.event.clearInstanceListeners(map);
}


function clearMarkers() {
for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
}
for (var i = 0; i < markers_rutas.length; i++) {
    markers_rutas[i].setMap(null);
}
}

function clearWaypoints() {
markers = [];
origin = null;
destination = null;
waypoints = [];
directionsVisible = false;
}

 
var infowindow;
var nombreGeo;
var impresos = Array();
var arrayInfo = Array();
var ultimo = Array();
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

function mostrar_poligonal(data){
    //arregloLt,arregloLo,nombre

	var geoPoligonal;
	var punto;
	var numeroPuntos = data.length;
	var lt,lo;
	var coordenadasPoligono = [];
	
    $.each(data, function(i, point) {
        console.log(point.latitud+" "+point.longitud);
        lt=parseFloat(point.latitud);
		lo=parseFloat(point.longitud);
		punto = new google.maps.LatLng(lt,lo)
		coordenadasPoligono.push(punto);
    });    

	var num_alt=Math.floor(Math.random()*11);
	var color=colores[num_alt];
	var puntoinfo=new google.maps.LatLng(data[0].latitud,data[0].longitud);
	var opcionesPoligono={
        paths: coordenadasPoligono,
        strokeColor: color,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: color,
        fillOpacity: 0.35
    };

	geoPoligonal = new google.maps.Polygon(opcionesPoligono);
	nombreGeo=data[0].nombre;
	geoPoligonal.setMap(map);
	impresos.push(geoPoligonal);
	infowindow = new google.maps.InfoWindow();
	var string="<div style='min-width:100px;height:20px;max-width:250px;'>"+data[0].nombre+"</div>";
	infowindow.setContent(string);
	infowindow.setPosition(puntoinfo);
	infowindow.open(map);
	arrayInfo.push(infowindow);
}

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

	//var checkboxes = document.getElementById("form1").ejec;
    
    $("#form_geolist input:checkbox:checked").each(function() {
        var check = $(this).val();
            ultimo.push(check);
			//ver_geo(check);  
            if($(this).data("type") == 0 ){

               var lat  = $(this).data("lat");
               var lon  = $(this).data("lon");
               var rad  = $(this).data("radio");
               var name = $(this).data("name");

                console.log("circular");
                mostrar_circular(lat,lon,rad,name);

            }else{
                $.ajax({ 
                type: "POST", 
                data: {id:check},
                url: "<?=base_url()?>/Config/Geo/info_geo",
                success: function (response) {   
                    /*$("#sidebar-content").html(response); 
                    $('#settings').addClass('active');
                    $('.openside').on('click', function () {
                        $('#settings').toggleClass('active');
                        return false;
                    });*/                    
                    console.log(response);
                    mostrar_poligonal(response);

                    }
                });  
            }

    });

	
}


function reset() {

    clearMark();
   /* clearMarkers();
    clearWaypoints(); 
        
    directionsDisplay.setMap(null);
    directionsDisplay.setPanel(null);
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));   
   */
     
}



 
 

function mark_list(e){
//console.log(  );  
    $(e).css("background","#d4f8b1");
}

function vehicle_ubicationwwww(id,company,check) {    
    $.ajax({ 
        type: "POST",
        data: {id:id,company:company,check:check},
        url: "<?=base_url()?>/MainMap/get_ubication",
        success: function (response) {              
            if(response.error){
                alert(response.error);
            }else{

                var last = response.last;                
                $("#ubicacion").html(response.table); 
                
                MapaCord(last.lat, last.lon, last.tipov, response.veh, last.name, last.vel, last.ub);      
                  
 
            }
        }
    }); 
}

function limpiar_veh(){
    if(arrayInfo.length!=0){
        for(var f=0; f < arrayInfo.length; f++){
            var info = arrayInfo[f]; // find the marker by given id
            info.setMap(null);
        }   
    }
    if(markersArrays.length!=0){
        for(var f=0; f < markersArrays.length; f++){
            var marker = markersArrays[f]; // find the marker by given id
            marker.setMap(null);
        }   
    }
    elimR();
    $("#ubicacion").html("");
}

var time_live;
 


function vehicle_realtime(){
    var ids = "";
    var count = 0;
    $("#form_vehlist input[type=checkbox]:checked").each(function(){
        ids = ids + $(this).val() + ",";
        count++;
    });
    ids = ids.slice(0, -1);
    console.log(ids);
    if(count<=50){
            
            if(!time_live)
				time_live = window.setTimeout('vehicle_realtime()',(1000*60*1));
			if(time_live){
				window.clearInterval(time_live);
				time_live = window.setTimeout('vehicle_realtime()',(1000*60*1));
			}


            $.ajax({ 
                type: "POST",
                data: {ids:ids},
                url: "<?=base_url()?>/MainMap/get_ubication_list",
                success: function (responses) {              
                    if(responses.length > 0){
                        //elimR();
                        var temp = "<div id='mostrar_veh' style='margin:0px; width: 100%;'>"+
                                        "<div style='float:right;'></div>"+
                                        "<table border='0' id='box-table-a' class='table' style=' margin:0px;'>"+
                                            "<thead>"+
                                                "<tr class='fuente_siete' style='margin:0px; width: 100%; background-color:#f3f3f3;'>"+
                                                    "<th align='center'>Vehículo</th>"+
                                                    "<th  align='center'>Fecha / Hora</th>"+
                                                    "<th align='center'>Km/H</th>"+
                                                    "<th align='center'>Batería</th>"+
                                                    "<th align='center'>ODO</th>"+
                                                    "<th align='center'>Latitud,Longitud</th>"+
                                                    "<th align='center'>Ubicación</th>"+			
                                                    "<th>Satelites</th>"+		
                                                    "</tr>"+
                                                    "</thead>"+
                                                "<tbody class='tr_vehcontent'></tbody>"+
                                            "</table>"+
                                        "</div>";
                        $("#ubicacion").html(temp);
                        
                                if(arrayInfo.length!=0){
                                    for(var f=0; f < arrayInfo.length; f++){
                                        var info = arrayInfo[f]; // find the marker by given id
                                        info.setMap(null);
                                    }   
                                }

                                if(markersArrays.length!=0){
                                    for(var f=0; f < markersArrays.length; f++){
                                        var marker = markersArrays[f]; // find the marker by given id
                                        marker.setMap(null);
                                    }   
                                }
                                elimR();
            
                    

                        

                    
                        

                    }
                    
                }
            }); 



            


    }else{
        alert("No puede agregar mas de 50 vehiculos al mismo tiempo");
    }

}


function vehicle_ubication_zoom(id,company,check) {    
    $.ajax({ 
        type: "POST",
        data: {id:id,company:company,check:check},
        url: "<?=base_url()?>/MainMap/get_ubication",
        success: function (response) {              
            if(response.error){
                alert(response.error);
            }else{
                
                
                //$('#form_sitelist input:checkbox').prop('checked', false);

                    var last = response.last;                
                    $("#ubicacion").html(response.table);                     
                    
                    elimR();
               
              /****************** */ 
              var la = last.lat; 
              var lo = last.lon;
              var t  = last.tipov; 
              var v  = response.veh;
              var name = last.name;
              var vel = last.vel;
              var ub = last.ub; 

                var miPosicion=new google.maps.LatLng(la,lo);
                map.setOptions({
                    overviewMapControl:true,
                    center:miPosicion,		
                    zoom:15
                }); 
                if(arrayInfo.length!=0){
                    for(var f=0; f < arrayInfo.length; f++){
                        var info = arrayInfo[f]; // find the marker by given id
                        info.setMap(null);
                    }   
                }
                infowindow = new google.maps.InfoWindow();    
                var string="<div style='min-width:100px; max-height:100px; max-width:350px;'>Nombre: "+name+" </br> Velocidad: "+vel+" km/h </br> Ubicación: "+ub+"</div>";
                infowindow.setContent(string);
                infowindow.setPosition(miPosicion);
                infowindow.open(map);
                arrayInfo.push(infowindow);
              /**************** */
            }
        }
    }); 
}

//funcion que recibe los datos de la ubicacion y los envia a createMarker
function MapaCord(la, lo, tv, v, name, vel, ub) { 
	if(markersArrays.length!=0){var elim=elimMarcador(); }
   
	if(al.length!=0){al.splice(al.length);}

	var miPosicion=new google.maps.LatLng(la,lo);
	map.setOptions({
		overviewMapControl:true,
		center:miPosicion,		
		zoom:15
	});
	var image = new google.maps.MarkerImage('<?=base_url()?>/dist/images/map/veh/veh_type/'+tv+'.png',
        new google.maps.Size(50, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 5));
	marcador = new google.maps.Marker({
		position: miPosicion,
		map: map,
		icon: image,
		title: v
	});
    
     
    if(arrayInfo.length!=0){
        for(var f=0; f < arrayInfo.length; f++){
            var info = arrayInfo[f]; // find the marker by given id
            info.setMap(null);
        }   
    }

    infowindow = new google.maps.InfoWindow();    
    var string="<div style='min-width:100px; max-height:100px; max-width:350px;'>Nombre: "+name+" </br> Velocidad: "+vel+" km/h </br> Ubicación: "+ub+"</div>";
    infowindow.setContent(string);
    infowindow.setPosition(miPosicion);
    infowindow.open(map);
    arrayInfo.push(infowindow);
    
    markersArrays.push(marcador);
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

function elimR(){	
    if(arregloDeRecorridos.length != 0 ){
        var flightPath = arregloDeRecorridos[0];    
        flightPath.setMap(null);
        arregloDeRecorridos.length=0;	
    } 
}

function vehicle_ubication(id,company,check){   
    $.ajax({ 
        type: "POST",
        data: {id:id,company:company,check:check},
        url: "<?=base_url()?>/MainMap/get_ubication",
        success: function (response) {              
            if(response.error){
                alert(response.error);
            }else{
                        if(arrayInfo.length!=0){
                            for(var f=0; f < arrayInfo.length; f++){
                                var info = arrayInfo[f]; // find the marker by given id
                                info.setMap(null);
                            }   
                        }

                        if(markersArrays.length!=0){
                            for(var f=0; f < markersArrays.length; f++){
                                var marker = markersArrays[f]; // find the marker by given id
                                marker.setMap(null);
                            }   
                        }
                        elimR();
                        $("#ubicacion").html("");                         
                        $('#form_vehlist input:checkbox').prop('checked', false);
                
                    var last = response.last;                
                    $("#ubicacion").html(response.table);                     
                    MapaCord(last.lat, last.lon, last.tipov, response.veh, last.name, last.vel, last.ub); 
                   
               
                /*if(check == 1){ //Zoom 
                    var last = response.last;                
                    MapaCordZoom(last.lat, last.lon); 
                }*/

                if(check == 2){  //Ruta
                    
                    $.each(response.route, function(i, item) {
                        crea_recorrido(item.lat,item.lon,item.tipoveh,0);
                    });  
                    mostrarLinea2(0); 
                }


            }
        }
    }); 

                
}

function clearveh(){
    if(arrayInfo.length!=0){
        for(var f=0; f < arrayInfo.length; f++){
            var info = arrayInfo[f]; // find the marker by given id
            info.setMap(null);
        }   
    }

    if(markersArrays.length!=0){
        for(var f=0; f < markersArrays.length; f++){
            var marker = markersArrays[f]; // find the marker by given id
            marker.setMap(null);
        }   
    }
    elimR();
    $("#ubicacion").html(""); 
   
}

function elimMarcador(){
		var marker = markersArrays[0]; // find the marker by given id
		marker.setMap(null);
		markersArrays.length=0;
}	 

function cleargeo(){
    for(var j=0; j < impresos.length; j++){
		var geoCer = impresos[j]; // find the marker by given id
		geoCer.setMap(null);
		
		//markersArrays.length=0;
	}
	for(var f=0; f < impresos.length; f++){
		var info = arrayInfo[f]; // find the marker by given id
		info.setMap(null);
	}
    
    $('#form_geolist input:checkbox').prop('checked', false);
}

function geo_go(lat,lon,type,id){ 
    if(type==1){
        $.ajax({ 
            type: "POST",
            data: {id:id}, 
            url: "<?=base_url()?>/Config/Geo/info_geo_po",
            success: function (p) {                    
                veh_seleccion(p.latitud,p.longitud);
            }
        });
    }else{
        veh_seleccion(lat,lon);
    }        
}

function veh_seleccion(lat,lon){ 
    var posicion=new google.maps.LatLng(lat,lon);
    map.setOptions({
        center:posicion,
        zoom:17
    });
}

//crea_sitios(s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,s.imagen,s.descripcion,1);
function crea_sitios(nombre,lat,lon,contacto,tel1,tel2,imagenes,tipoGeo,zoom = 0){    
  //  console.log(imagenes);
    var baseUrl   = "<?=base_url()?>/dist/images/map/site_type/";               
    var imagenes  = baseUrl+imagenes.substr(14);
  //  console.log(imagenes);

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

    /*if(zoom == 1){
        var posicion=new google.maps.LatLng(lat,lon);
                map.setOptions({
                center:posicion,
                zoom:17
        });
    }*/
}


function show_site(e,id){
    if($(e).is(":checked")) {    
        $.ajax({ 
            type: "POST",
            data: {id:id}, 
            url: "<?=base_url()?>/MainMap/show_sites",
            success: function (response) {             
                var s = response;
                if(s.nombre){
                    crea_sitios(s.nombre,s.latitud,s.longitud,s.contacto,s.tel1,s.tel2,s.imagen,s.descripcion,1);
                //console.log(s.nombre+' '+s.latitud+' '+s.longitud+' '+s.contacto+' '+s.tel1+' '+s.tel2+' '+s.imagen+' '+s.descripcion);
                }
            }
        });    
        //console.log("checo");
	}
	else{
		for(var i=0; i<elim_sitio.length;i++){
			var marker = elim_sitio[i];
			marker.setMap(null);
		}
		sitios_seleccionados();
	}    
} 

 
function clearMark() { 
    for(var i=0; i<elim_sitio.length;i++){
			var marker = elim_sitio[i];
			marker.setMap(null);
		}  
    $('#form_sitelist input:checkbox').prop('checked', false);
}


function sitios_seleccionados(){
    $("#form_sitelist input[type=checkbox]:checked").each(function(){
        //cada elemento seleccionado
        //console.log($(this).val());
        show_site(this,$(this).val());
    });
}


function validate_form_newsite(){
    var sitename = validate_name("#edit_sitename","#feedback-edit_sitename");
    var sitetype = validate_sitetype("#edit_sitetype","#feedback-edit_sitetype");
    var contact  = validate_namenotreq("#edit_sitecontact","#feedback-edit_sitecontact");
    var phone    = validate_phonemask("#edit_sitephone","#feedback-edit_sitephone",1);
    var phone2   = validate_phonemask("#edit_sitephone2","#feedback-edit_sitephone2",1);
    var band = 1;
    if(sitename == "false"){ band = 0; }
    if(sitetype == "false"){ band = 0; } 
    if(contact == "false"){ band = 0; } 
    if(phone == "false"){ band = 0; } 
    if(phone2 == "false"){ band = 0; }
    
    if(band == 1){
       return "true";
    }else{
        return "false"; 
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
function clearsite(){
    marker.setMap(null);
}

function  new_mainsite(){
  var request = confirm("Desea crear un sitio de interes");
    if(request == true){
        alert("Seleccione un punto en el mapa");
        google.maps.event.addListener(map, 'click', function(event) {
            var myLatLng = event.latLng;
            addMarker(myLatLng);
            var lat = myLatLng.lat();
            var lng = myLatLng.lng();
           

            $.ajax({ 
                type: "POST", 
                data: {lat: lat, lon: lng},
                url: "<?=base_url()?>/Config/Sites/new_site",
                success: function (response) {   
                    $("#sidebar-content").html(response); 
                    $('#settings').addClass('active');
                    $('.openside').on('click', function () {
                        $('#settings').toggleClass('active');
                        return false;
                    });
                }
            });  

        });        
    } 
}


function savenew_site(){
    if(validate_form_newsite() == "true"){
        $.ajax({ 
            type: "POST", 
            data: $("#edit_mainsite").serialize(),
            url: "<?=base_url()?>/Config/Sites/insert_site",
            success: function (response) {  
                if(response > 0){
                    
                    var idsite = response;
                    var icon  = $("#edit_sitetype option:selected").data("icon");
                    var desc  = $("#edit_sitetype option:selected").text();
                    var name  = $("#edit_sitename").val();
                    var type  = $("#edit_sitetype option:selected").val();

                    var baseUrl  = "<?=base_url()?>/dist/images/map/site_type/";               
                    var icon     = baseUrl+icon.substr(14);
                
                var template = "<li class='py-1 px-2 mail-item inbox sitetype-"+type+" bg-control' id='sitelist_"+type+"'><div class='d-flex align-self-center align-middle'><label class='chkbox'><input type='checkbox'><span class='checkmark small'></span></label><div class='mail-content d-md-flex w-100'><span class='car-name' id='sitename_"+idsite+"' onclick='show_site("+idsite+")'>"+name+"</span><div class='d-flex mt-3 mt-md-0 ml-auto'><div id='siteicon_"+idsite+"'><img src='"+icon+"' width='25px' height='22px' class='toltip' data-placement='top' title='"+desc+"'></div><a href='#' class='ml-3 mark-list' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='icon-options-vertical'></i></a><div class='dropdown-menu p-0 m-0 dropdown-menu-right'><a class='dropdown-item' href='#' onclick='edit_sitelist("+idsite+")'><i class='mdi mdi-playlist-edit'></i> Editar </a> <a class='dropdown-item single-delete' href='#' onclick='delete_mainsite("+idsite+")'><i class='icon-trash'></i> Eliminar </a>  </div></div></div></div></li>";
                if($("#sites_list").prepend(template)){
                        $("#sitelist_"+type).animate({opacity: 1}, 700, function() {                        
                            $("#sitelist_"+type).removeClass('bg-control',1000);                        
                        });                    
                }   
                $('#settings').removeClass('active');   
                marker = [];
                }
                
            }
        });
    }else{
        console.log("no valido");
    }
}


function edit_site(){  
    if(validate_form_newsite() == "true"){  
        $.ajax({ 
            type: "POST", 
            data: $("#edit_mainsite").serialize(),
            url: "<?=base_url()?>/Config/Sites/site_update",
            success: function (response) {  
                if (response == "true") {
                    var id      = $("#edit_siteid").val();
                    var name    = $("#edit_sitename").val();

                    var icon    = $("#edit_sitetype option:selected").data("icon");
                    var title   = $("#edit_sitetype option:selected").val();                
                    var baseUrl = "<?=base_url()?>/dist/images/map/site_type/"; 

                    var icon = baseUrl+icon.substr(14);                
                    var src  = '<img src="'+icon+'" width="25px" height="22px" class="toltip" data-placement="top" title="'+title+'">';

                    $("#sites_list li #sitename_"+id).html(name);
                    $("#sites_list li #siteicon_"+id).html(src);

                    $('#settings').removeClass('active');  


                    $("#sites_list #sitelist_"+id).addClass('bg-control');
                    $("#sites_list #sitelist_"+id).css('opacity','.1');
                        
                    $("#sites_list #sitelist_"+id).animate({opacity: 1}, 700, function() {                        
                        $("#sites_list #sitelist_"+id).removeClass('bg-control',700);
                    }); 

                } else {                            
                    alert(response); 
                    //console.log("error");
                }
            }
        });
    }
} 

function delete_maingeo(id){    
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "<?=base_url()?>/Config/Geo/delete_maingeo",
        success: function (response) {             
            var idgeo = "#geolist_"+id;
            $(idgeo).addClass('bg-danger');
            $(idgeo).slideUp(550, function () {
                $(idgeo).remove();
            });
        }
    });
}

function delete_mainsite(id){    
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "<?=base_url()?>/Config/Sites/delete_mainsite",
        success: function (response) {             
            var idsite = "#sitelist_"+id;
            $(idsite).addClass('bg-danger');
            $(idsite).slideUp(550, function () {
                $(idsite).remove();
            });
        }
    });
}






/*
   

*/






function edit_sitelist(id){    
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "<?=base_url()?>/Config/Sites/site_edit",
        success: function (response) { 
            $("#sidebar-content").html(response);  
            $('#settings').addClass('active');
            $('.openside').on('click', function () {
                $('#settings').toggleClass('active');
                return false;
            });
        }
    });
}



function load_geo(){ 
    $.ajax({ 
        type: "POST", 
        url: "<?=base_url()?>/MainMap/load_geo",
        success: function (response) {             
            $("#geo_list").html(response);
            $('.toltip').tooltip();
        }
    });  
}

$('.checkall-veh').on('click', function () {
        $('#vehicles_list input:checkbox').not(this).prop('checked', this.checked);
});






function edit_vehicle(){
    $.ajax({
        type: "POST", 
        data: $("#vehedit_configform").serialize(),
            url: "<?=base_url()?>/Config/Vehicles/vehicle_update",
        success: function (response) { 
            console.log(response);
            if (response == "true") {
                //location.reload();                     
            } else {                            
                //alert(response); 
            }
        }
    }); 
}



function filtersiteoption(){    
   if($('#vehicles_list .speed-blue').length > 0){ $(".bulk-mail-type .opt-blue").show(); }else{  $(".bulk-mail-type .opt-blue").hide(); }    
   if($('#vehicles_list .speed-green').length > 0){ $(".bulk-mail-type .opt-green").show(); }else{  $(".bulk-mail-type .opt-green").hide(); }
   if($('#vehicles_list .speed-yellow').length > 0){ $(".bulk-mail-type .opt-yellow").show(); }else{  $(".bulk-mail-type .opt-yellow").hide(); }    
   if($('#vehicles_list .speed-orange').length > 0){ $(".bulk-mail-type .opt-orange").show(); }else{  $(".bulk-mail-type .opt-orange").hide(); }    
   if($('#vehicles_list .speed-red').length > 0){ $(".bulk-mail-type .opt-red").show(); }else{  $(".bulk-mail-type .opt-red").hide(); }


   if($('#vehicles_list .engine-off').length > 0){ $(".status-engine .opt-engineof").show(); }else{  $(".status-engine .opt-engineof").hide(); }
   if($('#vehicles_list .engine-on').length > 0){ $(".status-engine .opt-engineon").show(); }else{  $(".status-engine .opt-engineon").hide(); }

   if($('#vehicles_list .term-on').length > 0){ $(".status-engine .opt-termon").show(); }else{  $(".status-engine .opt-termon").hide(); }
   if($('#vehicles_list .term-off').length > 0){ $(".status-engine .opt-termoff").show(); }else{  $(".status-engine .opt-termoff").hide(); }
   if($('#vehicles_list .term-onoff').length > 0){ $(".status-engine .opt-termonoff").show(); }else{  $(".status-engine .opt-termonoff").hide(); }
   if($('#vehicles_list .term-offon').length > 0){ $(".status-engine .opt-termoffon").show(); }else{  $(".status-engine .opt-termoffon").hide(); }
}


function filtervehoption(){    
   if($('#vehicles_list .speed-blue').length > 0){ $(".bulk-mail-type .opt-blue").show(); }else{  $(".bulk-mail-type .opt-blue").hide(); }    
   if($('#vehicles_list .speed-green').length > 0){ $(".bulk-mail-type .opt-green").show(); }else{  $(".bulk-mail-type .opt-green").hide(); }
   if($('#vehicles_list .speed-yellow').length > 0){ $(".bulk-mail-type .opt-yellow").show(); }else{  $(".bulk-mail-type .opt-yellow").hide(); }    
   if($('#vehicles_list .speed-orange').length > 0){ $(".bulk-mail-type .opt-orange").show(); }else{  $(".bulk-mail-type .opt-orange").hide(); }    
   if($('#vehicles_list .speed-red').length > 0){ $(".bulk-mail-type .opt-red").show(); }else{  $(".bulk-mail-type .opt-red").hide(); }


   if($('#vehicles_list .engine-off').length > 0){ $(".status-engine .opt-engineof").show(); }else{  $(".status-engine .opt-engineof").hide(); }
   if($('#vehicles_list .engine-on').length > 0){ $(".status-engine .opt-engineon").show(); }else{  $(".status-engine .opt-engineon").hide(); }

   if($('#vehicles_list .term-on').length > 0){ $(".status-engine .opt-termon").show(); }else{  $(".status-engine .opt-termon").hide(); }
   if($('#vehicles_list .term-off').length > 0){ $(".status-engine .opt-termoff").show(); }else{  $(".status-engine .opt-termoff").hide(); }
   if($('#vehicles_list .term-onoff').length > 0){ $(".status-engine .opt-termonoff").show(); }else{  $(".status-engine .opt-termonoff").hide(); }
   if($('#vehicles_list .term-offon').length > 0){ $(".status-engine .opt-termoffon").show(); }else{  $(".status-engine .opt-termoffon").hide(); }
}


function edit_vehiclelist(id){  
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "<?=base_url()?>/Config/Vehicles/vehicle_edit",
        success: function (response) { 
            $("#sidebar-content").html(response);
            /* $('.view-email').show();  
            $('#mainmap_list').hide();  
            $('#maincontrols').hide();   */
            $('#settings').toggleClass('active');
            $('.openside').on('click', function () {
                $('#settings').toggleClass('active');
                return false;
            });            
        }
    });
}


function vehicle_detail(id){
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "<?=base_url()?>/MainMap/vehicle_detail",
        success: function (response) {
            $("#detail-content").html(response);
            $('.view-email').show();  
            $('#mainmap_list').hide();  
            $('#maincontrols').hide();   
        }
    });     
}


$(".back-to-email").on("click", function () {
    $("#detail-content").html("");
    $('.view-email').hide();  
    $('#mainmap_list').show();  
    $('#maincontrols').show();   
});


var vehicleslist_info = [];


function load_vehicles(){ 
    //console.log("loaddd");
    $.ajax({ 
        type: "POST", 
        url: "<?=base_url()?>/MainMap/mostrar_vehiculos_act",
        success: function (response) { 
            var old_motorclass = "";
            var old_speedclass = "";
            var icons     = "";

            $.each(response, function(i, item) {   
                var speed = "speed-"+item.speed;
                var motor = item.class_motor;
                if(vehicleslist_info[i]){
                    old_motorclass = vehicleslist_info[i].class_motor;
                    old_speedclass = vehicleslist_info[i].class_speed;                                   

                    //Replace old class
                    $("#vehiclelist_"+item.idveh).removeClass(old_motorclass);
                    $("#vehiclelist_"+item.idveh).addClass(motor);                    

                    $("#vehiclelist_"+item.idveh).removeClass(old_speedclass);
                    $("#vehiclelist_"+item.idveh).addClass(speed);                   
                     
                    //Add actual class
                    vehicleslist_info[i].class_motor = motor;
                    vehicleslist_info[i].class_speed = item.speed;
                }else{
                    //console.log("new class: "+old_class);
                    $("#vehiclelist_"+item.idveh).addClass(motor);
                    $("#vehiclelist_"+item.idveh).addClass(speed);
                }

                vehicleslist_info[i] = {"class_motor": motor, "class_speed": speed}; 

                var icons = '<div class="h6 mr-1 '+item.icon_motor+' toltip" data-placement="top" title="'+item.toltip_motor+'"></div>'+
							'<div class="speed-icon mr-1"><img class="toltip" style="width:100%;" src="<?=base_url()?>/dist/images/config/vehicles/speed_'+item.speed+'.png" data-placement="top" title="'+item.speed_tooltip+'" ></div>';
                $("#vehicles_list #vehicle-element"+item.idveh).html(icons);
            });  

            filtervehoption();            
        }
    });  
}


/*
function load_sites(){  
    $.ajax({ 
        type: "POST",         
        url: "/MainMap/load_sites",
        success: function (response) {
            $("#sites_list").html(response);
            load_geo();
        } 
    }); 
}*/

/*
$(".back-to-vlist").on("click", function () {
    $('#idss').show();
    $('#idsx').fadeOut();
});*/

//load_sites(); 
//load_vehicles();

/*
$(document).ready(function(){
    "use strict";     
    setInterval(load_vehicles(),30000);  
});*/
var load_v = setInterval( function() { load_vehicles(); }, 30000);
//console.log(localStorage);
</script> 