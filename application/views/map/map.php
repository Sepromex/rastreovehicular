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
    #map { width: 100%; height: 690px; }
    html, body{ height: 100%; margin: 0; padding: 0; }
    .text-orange{ color: orange; }
    .cursor-pointer{ cursor:pointer; }

 
</style>

<script>
    let map;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 20.721827087454802, lng:  -103.37155710393355 },
            zoom: 10,
        });
    }

/*
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

 }*/

</script>

<div class="container-fluid "> 
    <!-- START: Card Data-->
    <div class="row">
        <div class="col-2 mt-3"> 
                
            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-2 mt-3"> 
            <div class="card"><?php //print_array($site_type);?>
                <!-- ##### TABS ##### -->
                
                    <div class="card-header" id="maincontrols">
                        <div class="row m-auto">
                            <div class="col-12 col-lg-12 col-xl-12 pr-lg-0 flip-menu">
                                <ul class="list-unstyled nav inbox-nav  mb-0 mail-menu" style="margin-top:0px !important;">
                                    <li class="nav-item" style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab active  toltip" data-list="vehicle_list"  data-placement="top" title="Vehículos"> 
                                            <i class="mdi mdi-car font-tab"></i> 
                                            <span class="ml-auto badge badge-pill badge-success bg-success car-num"><?=(isset($vehicle_list))?count($vehicle_list):0;?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item" style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab toltip"  data-list="site_list" data-placement="top" title="Sitios de interéz">
                                            <i class="mdi mdi-home-map-marker font-tab"></i> 
                                            <span class="ml-auto badge badge-pill badge-success bg-success car-num">9</span>
                                        </a>
                                    </li> 
                                    <li class="nav-item"  style="padding: 5px 2px !important;">
                                        <a href="#" class="nav-link padding-tab toltip"  data-list="geoc_list"  data-placement="top" title="Geo-cerca">
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
        


        <!-- 
            <div class="col-9 mt-3">
                <div class="row">                
                    <div id="map"></div>
                </div>
                <div class="row" id="ubicacion"></div>
                <div class="row" id="sitios"></div>
            </div> 
        -->
                    
                    
    </div>
</div>           
<!--
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGi-KpwkfLDT4fRXuVTRxAyUsClhTIPBI&callback=initMap&libraries=&v=weekly" async></script>
-->
<script> 
 $('.toltip').tooltip();
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


function  new_mainsite(){
    //colocar punto en el mapa
    $.ajax({ 
        type: "POST", 
         url: "/Config/Sites/new_site",
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


function savenew_site(){    
    $.ajax({ 
        type: "POST", 
        data: $("#edit_mainsite").serialize(),
        url: "/Config/Sites/insert_site",
        success: function (response) {  
            if(response > 0){
                
                var idsite = response;
                var icon  = $("#edit_sitetype option:selected").data("icon");
                var desc  = $("#edit_sitetype option:selected").text();
                var name  = $("#edit_sitename").val();
                var type  = $("#edit_sitetype option:selected").val();

                var baseUrl  = "/dist/images/map/site_type/";               
                var icon     = baseUrl+icon.substr(14);
            
               var template = "<li class='py-1 px-2 mail-item inbox sitetype-"+type+"' id='sitelist_"+type+"'><div class='d-flex align-self-center align-middle'><label class='chkbox'><input type='checkbox'><span class='checkmark small'></span></label><div class='mail-content d-md-flex w-100'><span class='car-name' id='sitename_"+idsite+"' onclick='show_site("+idsite+")'>"+name+"</span><div class='d-flex mt-3 mt-md-0 ml-auto'><div id='siteicon_"+idsite+"'><img src='"+icon+"' width='25px' height='22px' class='toltip' data-placement='top' title='"+desc+"'></div><a href='#' class='ml-3 mark-list' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='icon-options-vertical'></i></a><div class='dropdown-menu p-0 m-0 dropdown-menu-right'><a class='dropdown-item' href='#' onclick='edit_sitelist("+idsite+")'><i class='mdi mdi-playlist-edit'></i> Editar </a> <a class='dropdown-item single-delete' href='#' onclick='delete_mainsite("+idsite+")'><i class='icon-trash'></i> Eliminar </a>  </div></div></div></div></li>";
               console.log(icon);
               $("#sites_list").prepend(template);
               $('#settings').removeClass('active');  

                console.log(desc);
            }
             
        }
    });
}


function edit_site(){    
    $.ajax({ 
        type: "POST", 
        data: $("#edit_mainsite").serialize(),
        url: "/Config/Sites/site_update",
        success: function (response) {  
             if (response == "true") {
                var id      = $("#edit_siteid").val();
                var name    = $("#edit_sitename").val();

                var icon    = $("#edit_sitetype option:selected").data("icon");
                var title   = $("#edit_sitetype option:selected").val();                
                var baseUrl = "/dist/images/map/site_type/"; 

                var icon = baseUrl+icon.substr(14);                
                var src  = '<img src="'+icon+'" width="25px" height="22px" class="toltip" data-placement="top" title="'+title+'">';

                $("#sites_list li #sitename_"+id).html(name);
                $("#sites_list li #siteicon_"+id).html(src);

                $('#settings').removeClass('active');  
            } else {                            
                alert(response); 
                //console.log("error");
            }
        }
    });
} 


function delete_mainsite(id){    
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "/Config/Sites/delete_mainsite",
        success: function (response) {             
            var idsite = "#sitelist_"+id;
            $(idsite).addClass('bg-danger');
            $(idsite).slideUp(550, function () {
                $(idsite).remove();
            });
        }
    });
}


function edit_sitelist(id){    
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "/Config/Sites/site_edit",
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
            $('.toltip').tooltip();
        }
    });  
}

$('.checkall-veh').on('click', function () {
        $('#vehicles_list input:checkbox').not(this).prop('checked', this.checked);
});



function mark_list(e){

    //console.log(  );  
    $(e).css("background","#d4f8b1");
}

function vehicle_realtime(e){  
    if($(e).is(":checked")) {

        console.log("checo");

    }else{

        console.log("no checo");

    } 
    console.log(e);
}


function edit_vehicle(){
    $.ajax({
        type: "POST", 
        data: $("#vehedit_configform").serialize(),
            url: "/Config/Vehicles/vehicle_update",
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
        url: "/Config/Vehicles/vehicle_edit",
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
        url: "/MainMap/vehicle_detail",
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
    $.ajax({ 
        type: "POST", 
        url: "/MainMap/mostrar_vehiculos_act",
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
                    $("#vehiclelist_"+item.idveh).addClass(motor).removeClass(old_motorclass);
                    $("#vehiclelist_"+item.idveh).addClass(speed).removeClass(old_speedclass);

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
							'<div class="speed-icon mr-1"><img class="toltip" style="width:100%;" src="/dist/images/config/vehicles/speed_'+item.speed+'.png" data-placement="top" title="'+item.speed_tooltip+'" ></div>';
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


$(".back-to-vlist").on("click", function () {
    $('#idss').show();
    $('#idsx').fadeOut();
});

//load_sites(); 
load_vehicles();

/*$(document).ready(function(){
    "use strict";     
    setInterval(load_vehicles(),8000);  
});*/
//var load_v = setInterval( function() { load_vehicles(); }, 10000);
console.log(localStorage);
</script> 